<?php
namespace App\Services;


use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use App\Exceptions\CouldNotCreateZoomMeeting;
use App\Exceptions\CouldNotGetAccessToken;
use App\Exceptions\CouldNotDeleteZoomMeeting;

class ZoomService
{
    public function createMeeting(string $topic, string $startTime, int $duration, $zoomUserId = null, $password = null): array|CouldNotCreateZoomMeeting
    {
        $settings = $this->getMeetSettings();

        // Construct the API request data
        $data = [
            'topic' => $topic,
            'type' => 2, // Scheduled meeting
            'start_time' => $startTime,
            'duration' => $duration,
            'password' => $password,
            'settings' => $settings
        ];

        try {
            $accessToken = $this->getAccessToken();
        } catch (CouldNotGetAccessToken $e) {
            throw new CouldNotCreateZoomMeeting(__("Could not create zoom meeting due error: " ) . $e->getMessage());
        }

        $zoomUserId = $zoomUserId ?? config('services.zoom.user_id');

        // Make a POST request to the Zoom API to create the meeting
        $createdMeetingResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post(config('services.zoom.api_url') . "users/{$zoomUserId}/meetings", $data);
        dd($createdMeetingResponse->json());
        // Check if the Zoom API call was successful
        if ($createdMeetingResponse->successful()) {
            return $createdMeetingResponse->json();
        } else {
            throw new CouldNotCreateZoomMeeting($createdMeetingResponse->json()['message']);
        }
    }

    public function deleteMeeting(string $meetingId): bool|CouldNotDeleteZoomMeeting
    {
        try {
            $accessToken = $this->getAccessToken();
        } catch (CouldNotGetAccessToken $e) {
            throw new CouldNotCreateZoomMeeting(__("Could not create zoom meeting due error: " ) . $e->getMessage());
        }

        // Make a DELETE request to the Zoom API to delete the meeting
        $deleteMeetingResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->delete(config('services.zoom.api_url') . "meetings/{$meetingId}" );

        // Check if the Zoom API call was successful
        if ($deleteMeetingResponse->clientError()) {
            $responseData = $deleteMeetingResponse->json();

            // Check if there is an error message in the response
            if (isset($responseData['message'])) {
                $errorMessage = $responseData['message'];
            } else {
                $errorMessage = 'Unknown error occurred.';
            }

            throw new CouldNotDeleteZoomMeeting($errorMessage);
        }

        return true;
    }

    private function getAccessToken(): string
    {
        $apiKey = config('services.zoom.api_key');
        $apiSecret = config('services.zoom.api_secret');

        // Obtain the access token using JWT authentication
        $accessTokenResponse = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($apiKey . ':' . $apiSecret),
        ])->asForm()->post(config('services.zoom.get_access_token_endpoint'), [
            'grant_type' => config('services.zoom.grant_type'),
            'account_id' => config('services.zoom.account_id')
        ]);

        if (! isset($accessTokenResponse->json()['access_token'])) {
            throw new CouldNotGetAccessToken('Access token not found in the response.');
        }

        return $accessTokenResponse->json()['access_token'];
    }

    private function getMeetSettings(): array
    {
        return [
            'host_video' => true,
            'participant_video' => true,
            'mute_upon_entry' => false,
            'join_before_host' => false,
            'waiting_room' => true,
            'auto_recording' => 'local',
            'audio' => 'voip'
        ];
    }
}
