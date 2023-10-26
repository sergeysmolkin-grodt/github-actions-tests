<?php

namespace Tests\Integration\Services;

use App\Exceptions\CouldNotCreateZoomMeeting;
use App\Exceptions\CouldNotDeleteZoomMeeting;
use App\Models\User;
use App\Services\ZoomService;
use DateTime;
use DateTimeZone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ZoomServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ZoomService $zoomService;

    public function setUp() : void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');

        $this->zoomService = new ZoomService();
    }

    #[Test]
    public function testCreateMeetingSuccessfully()
    {
        $data = $this->meetingData();

        $meetingData = $this->zoomService->createMeeting(
            $data['topic'],
            $data['startTime'],
            $data['duration'],
            $data['zoomUserId'],
            $data['password']
        );

        $this->assertEquals([
            'topic' => config('app.lesson_default_topic'),
            'start_time' => $data['startTime'],
            'timezone' => 'Europe/Kiev',
            'host_id' => env('ZOOM_USER_ID'),
            'duration' => $data['duration']
        ],
        [
            'topic' => $meetingData['topic'],
            'start_time' => $meetingData['start_time'],
            'timezone' => $meetingData['timezone'],
            'host_id' => $meetingData['host_id'],
            'duration' => $meetingData['duration'],
        ]);

        $this->assertNotEmpty($meetingData['start_url']);
        $this->assertNotEmpty($meetingData['join_url']);
        $this->assertNotEmpty($meetingData['password']);

    }

    #[Test]
    public function testCouldNotCreateMeetingWithInvalidUserId()
    {
        $data = array_merge($this->meetingData(),[
            'zoomUserId' => $userId = rand()
        ]);

        $this->expectException( CouldNotCreateZoomMeeting::class);
        $this->expectExceptionMessage("User does not exist: $userId.");

        $this->zoomService->createMeeting(
            $data['topic'],
            $data['startTime'],
            $data['duration'],
            $data['zoomUserId'],
            $data['password']
        );
    }

    #[Test]
    public function testCouldNotCreateMeetingWithNoToken()
    {
        Http::fake();

        $data = $this->meetingData();

        $this->expectException(CouldNotCreateZoomMeeting::class);
        $this->expectExceptionMessage("Could not create zoom meeting due error: Access token not found in the response");

        $this->zoomService->createMeeting(
            $data['topic'],
            $data['startTime'],
            $data['duration'],
            $data['zoomUserId'],
            $data['password']
        );

    }

    #[Test]
    public function testCouldNotDeleteMeetingIfMeetingDoesNotExist()
    {
        $testMeetingId = rand();

        Http::fake([
            config('services.zoom.api_url') . "meetings/{$testMeetingId}" => Http::response([
                'message' => 'Meeting not found'
            ], 404)
        ]);

        $this->expectException(CouldNotDeleteZoomMeeting::class);
        $this->expectExceptionMessage('Meeting not found');

        $this->zoomService->deleteMeeting($testMeetingId);
    }

    #[Test]
    public function testDeleteMeetingSuccessfully()
    {
        $data = $this->meetingData();

        $meeting = $this->zoomService->createMeeting(
            $data['topic'],
            $data['startTime'],
            $data['duration'],
            $data['zoomUserId'],
            $data['password']
        );

        $this->assertTrue($this->zoomService->deleteMeeting($meeting['id']));
    }

    #[Test]
    public function testErrorWhenDeletingNonExistentMeeting()
    {
        $nonExistentMeetingId = rand();

        $this->expectException(CouldNotDeleteZoomMeeting::class);
        $this->expectExceptionMessage('Meeting does not exist: ' . $nonExistentMeetingId . '.');

        $this->zoomService->deleteMeeting($nonExistentMeetingId);
    }

    #[Test]
    public function testErrorWhenDeletingMeetingWithInvalidToken()
    {
        $data = $this->meetingData();

        $meeting = $this->zoomService->createMeeting(
            $data['topic'],
            $data['startTime'],
            $data['duration'],
            $data['zoomUserId'],
            $data['password']
        );


        $this->expectExceptionMessage("Could not create zoom meeting due error: Access token not found in the response");

        Http::fake();
        $this->zoomService->deleteMeeting($meeting['id']);

    }

    private function meetingData(): array
    {
        $dateTime = new DateTime(now()->format('Y-m-d H:i:s'));
        $dateTime->setTimezone(new DateTimeZone('UTC'));
        $dateTime = $dateTime->format('Y-m-d\TH:i:s\Z');

        $data = [
            'topic' => config('app.lesson_default_topic'),
            'startTime' => $dateTime,
            'duration' => config('app.lesson_min_duration'),
            'zoomUserId' => null,
            'password' => null,
        ];


        return $data;
    }


}
