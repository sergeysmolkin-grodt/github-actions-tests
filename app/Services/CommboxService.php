<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;
use App\Exceptions\CouldNotCreateZoomMeeting;
use Illuminate\Support\Facades\Log;


class CommboxService
{
    public function sendMessage(string $phoneNumber, string $templateName, ?string $language = 'en', array $parameters = [])
    {
        $components = [];
        $subStreamID = config('services.commbox.substream_id.hw');
        if (substr($phoneNumber, 0, 2) == '34' || substr($phoneNumber, 0, 2) == '+3'):
            $subStreamID = config('services.commbox.substream_id.es');
        endif;

        if (! empty($parameters)) {
            $components = [
                [
                    "type" => "body",
                    "parameters" => []
                ]
            ];
            foreach ($parameters as $parameter) {
                $components[0]['parameters'][] = [
                    "type" => "text",
                    "text" => "*' . $parameter . '*"
                ];
            }
        }

        $data = [
            'data' => [
                [
                    'template_data' => [
                        'to' => $phoneNumber,
                        'template' => [
                            'name' => $templateName,
                            'language' => [
                                'code' => $language
                            ],
                            'components' => $components
                        ]
                    ],
                    'object_data' => [
                        'SubStreamId' => $subStreamID,
                        'createChildObject' => true,
                        'StatusId' => (int) config('services.commbox.status_id'),
                    ]
                ]
            ]
        ];

        // ToDo: Find out why requests through the HTTP client do not work

        $url = config('services.commbox.api_url') . "whatsapp/sendtemplatedmessage/" . config('services.commbox.app_id');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . config('services.commbox.api_key')
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if ($response->status !== 200) {
            Log::error(serialize($response));
        }

        return $response;
    }
}
