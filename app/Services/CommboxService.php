<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;
use App\Exceptions\CouldNotCreateZoomMeeting;
use Illuminate\Support\Facades\Log;


class CommboxService
{
    public function sendMessage(string $phoneNumber, string $language)
    {
        $subStreamID = config('services.commbox.substream_id.hw');
        if (substr($phoneNumber, 0, 2) == '34' || substr($phoneNumber, 0, 2) == '+3'):
            $subStreamID = config('services.commbox.substream_id.es');
        endif;

        $data = [
            'data' => [
                [
                    'template_data' => [
                        'to' => $phoneNumber,
                        'template' => [
                            'name' => config('services.commbox.templates.unbooked_sessions'),
                            'language' => [
                                'code' => $language
                            ],
                            'components' => []
                        ]
                    ],
                    'object_data' => [
                        'SubStreamId' => $subStreamID,
                        'StatusId' => config('services.commbox.status_id'),
                        'Content' => [],
                        "ManagerId" => 23669884,
                        "createChildObject" => true
                    ]
                ]
            ]
        ];

        // ToDo: Find out why requests through the HTTP client do not work
        $response = Http::withHeaders([
            "Authorization" => "Bearer e65b185d54634a87a9a06f929bcf9824",
            "Content-Type" => "application/json",
        ])->post(config('services.commbox.api_url') . "whatsapp/sendtemplatedmessage/" . config('services.commbox.app_id'), json_encode($data));

        if (! $response->successful()) {
            Log::error($response->body());
        }

        return $response;
    }
}
