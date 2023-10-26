<?php

namespace Tests\Integration\Services;;

use App\Models\User;
use App\Models\UserDetails;
use App\Services\DataExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DataExportServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DataExportService $dataExportService;

    #[Before]
    protected function setUp() : void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');

        $this->dataExportService = new DataExportService();
        $this->student = User::factory()->create()->assignRole('student');
    }

    #[Test]
    public function testCollectionReturnsWithDetails()
    {
        $result = $this->dataExportService->collection();
        UserDetails::create(['user_id' => $this->student->id]);

        $this->assertCount(1, $result);

        $this->assertInstanceOf(User::class, $this->student);
        $this->assertInstanceOf(UserDetails::class, $this->student->userDetails);
        $this->assertTrue($this->student->relationLoaded('userDetails'));
    }

    #[Test]
    public function testCollectionReturnsCorrectUserCount()
    {
        $user2 = User::factory()->create()->assignRole('student');

        $collection = $this->dataExportService->collection();

        $this->assertCount(2, $collection);
    }

    #[Test]
    public function testMapsUserSuccessfully()
    {
        UserDetails::create(['user_id' => $this->student->id, 'mobile' => Str::random(10)]);

        $result = $this->dataExportService->map($this->student);

        $this->assertEqualsCanonicalizing([
            $this->student->firstname,
            $this->student->lastname,
            $this->student->email,
            implode($this->student->userDetails->pluck('mobile')->toArray()),
            Carbon::parse($this->student->created_at),
        ], $result);
    }

    #[Test]
    public function testHeadings()
    {

        $result = $this->dataExportService->headings();

        $expectedHeadings = [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Date',
        ];

        $this->assertSame($expectedHeadings, $result);
    }

    public function testStyles()
    {
        $styles = $this->dataExportService->styles(new Worksheet());

        $this->assertIsArray($styles);
        $this->assertArrayHasKey(1, $styles);
        $this->assertArrayHasKey('font', $styles[1]);
        $this->assertArrayHasKey('bold', $styles[1]['font']);
        $this->assertTrue($styles[1]['font']['bold']);
    }



}
