<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID'),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
        'redirect' => env('APPLE_REDIRECT_URI'),
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'zoom' => [
        'is_enable' => env('IS_ZOOM_ENABLE', true),
        'api_key' => env('ZOOM_API_KEY',),
        'api_secret' => env('ZOOM_API_SECRET'),
        'api_url' => env('ZOOM_API_URL'),
        'account_id' => env('ZOOM_ACCOUNT_ID'),
        'user_id' => env('ZOOM_USER_ID'),
        'get_access_token_endpoint' => env('ZOOM_ACCESS_TOKEN_ENDPOINT'),
        'grant_type' => env('ZOOM_GRANT_TYPE'),
        'app_download_link' => env('ZOOM_APP_DOWNLOAD_LINK'),
        'microphone_test_link' => env('ZOOM_MICROPHONE_TEST_LINK')
    ],
    'fcm' => [
        'project_id' => env('FCM_PROJECT_ID'),
        'api_url' => env('FCM_API_URL'),
        'scope' => env('FCM_SCOPE'),
        'key_path' => env('FIREBASE_KEY_PATH')
    ],
    'commbox' => [
        'api_url' => env('COMMBOX_API_URL'),
        'app_id' => env('COMMBOX_APP_ID'),
        'api_key' => env('COMMBOX_API_KEY'),
        'templates' => [
            'unbooked_sessions' => 'wp_message_for_unbooked_auto_schedule_class',
            'appointment_reminder_30_minutes' => 'wp_reminder_before_thirty_minuets_session_start_22_03_01',
            'appointment_reminder_5_minutes' => 'wp_remider_for_before_five_minutes_session_start_2103',
            'appointment_reminder_3_hours' => 'wp_reminder_before_three_hours_session_start',
        ],
        'status_id' => env('COMMBOX_STATUS_ID'),
        'substream_id' => [
            'hw' => (int) env('COMMBOX_HW_SUBSTREAM_ID'),
            'es' => (int) env('COMMBOX_ES_SUBSTREAM_ID'),
        ]
    ],
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'base_url' => env('PAYPAL_BASE_URL'),
        'settings' => [
            'image_url' => 'https://i-fal.com/wp-content/uploads/2020/09/cropped-i-fal-new-widh-1536x439.png',
            'home_url' => 'https://i-fal.com/',
        ],
        'redirect_url' => [
            'return_url' => 'https://ifal-app.com/',
            'cancel_url' => 'https://ifal-app.com/'
        ]
    ],
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'verify_sid' => env('TWILIO_VERIFY_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'phone_number' => env('TWILIO_PHONE_NUMBER'),
        'phone_number_hw' => env('TWILIO_PHONE_NUMBER_HW'),
        'phone_number_pl' => env('TWILIO_PHONE_NUMBER_PL'),
    ]
];
