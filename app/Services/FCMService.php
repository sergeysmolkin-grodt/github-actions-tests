<?php
namespace App\Services;


use App\Exceptions\CouldNotSendPushNotification;
use Google\Auth\CredentialsLoader;
use Illuminate\Support\Facades\Http;
use App\Exceptions\CouldNotCreateZoomMeeting;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\Middleware\AuthTokenMiddleware;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Mockery\Exception;

class FCMService
{
    public function sendPushNotifications(
        array $deviceTokens,
        string $title,
        string $body,
        array $payload = [],
        int $userId): ?CouldNotSendPushNotification
    {
        $path = base_path(config('services.fcm.key_path'));
        $logMessage = $this->formLogMessage($payload, $userId, $title);
        $success = true;

        try {
            $factory = (new Factory())
                ->withServiceAccount($path);
            $messaging = $factory->createMessaging();
            $message = CloudMessage::new()
            ->withNotification([
                'title' => $title,
                'body' => $body
            ])
           ->withDefaultSounds()
           ->withHighestPossiblePriority();

            if (! empty($payload)) {
                $message->withData($payload);
            }

            $response = $messaging->sendMulticast($message, $deviceTokens);
        } catch (Exception $e) {
            $success = false;
            Log::error($logMessage . $e->getMessage());
        }

        if ($response->hasFailures()) {
            $errors = [];
            $success = false;

            foreach ($response->failures()->getItems() as $failure) {
                $errors[] = $failure->error()->getMessage() . PHP_EOL;
            }
            Log::error($logMessage . PHP_EOL . implode(PHP_EOL, $errors));
        }

        if (! empty($response->unknownTokens())) {
            Log::error("These tokens are unknown:" . PHP_EOL . implode(PHP_EOL, $response->unknownTokens()));
        }

        if (! empty($response->invalidTokens())) {
            Log::error("These tokens are invalid:" . PHP_EOL . implode(PHP_EOL, $response->invalidTokens()));
        }

        if (! $success) {
            throw new CouldNotSendPushNotification(__('Push notifications were not sent successfully'));
        }

        return null;
    }

    private function formLogMessage(array $payload, int $userId, string $title): string
    {
        return match($payload['notificationType']) {
            config('app.notifications_types.appointment') => "Push notifications to User ID $userId regarding $title (Appointment ID" . $payload['appointmentId'] . ") did not send successfully due to the following errors: ",
            default => "Push notifications to User ID $userId regarding $title did not send successfully due to the following errors: "
        };
    }
}
