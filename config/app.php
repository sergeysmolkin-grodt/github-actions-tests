<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en', //The default language

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    |
    | List all locales that your application works with
    |
    */
    'available_locales' => [
        'English' => 'en',
        'Israeli' => 'il',
        'Polish' => 'pl',
    ],

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Spatie\Permission\PermissionServiceProvider::class,
        App\Providers\RepositoryServiceProvider::class,
        \SocialiteProviders\Manager\ServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    ])->toArray(),

    'age_groups' => [
        'adult' => 'Adult',
        'teen' => 'Teen',
        'kid' => 'Kid',
    ],

    'payment_methods' => [
        'paypal' => 'PayPal',
        'icredit' => 'iCredit'
    ],

    'file_extensions' => ["jpg", "JPG", "jpeg", "JPEG", "png", "PNG", "HEIC", "heic"],
    'profile_image' => [
        'path' => 'images/users',
        'disc' => 'public'
    ],

    'oauth_providers' => ['google', 'apple', 'facebook'],
    'appointment_statuses' => [
        'pending' => 'PENDING',
        'completed' => 'COMPLETED',
        'missed' => 'MISSED',
        'cancelled' => 'CANCELLED'
    ],
    'availability_exceptions' => [
        'holidays' => 'HOLIDAY',
        'break_time' => 'BREAK_TIME',
        'availabilities' => 'AVAILABILITIES'
    ],
    'teacher_verification_statuses' => ['pending', 'rejected', 'verified'],
    'default_timezone' => env('APP_DEFAULT_TIMEZONE', 'Asia/Jerusalem'),
    'lesson_min_duration' => 25,
    'lesson_default_topic' => 'i-fal session',
    'push_notification' => env('PUSH_NOTIFICATION', true),
    'whatsapp_notification' => env('WHATSAPP_NOTIFICATION', true),
    'notifications_types' => [
        'appointment' => 'APPOINTMENT',
        'session_notify_users' => 'SESSION_NOTIFY_USERS',
        'reminder' => 'REMINDER',
    ],
    'device_types' => [
        'android' => 'ANDROID',
        'ios' => 'IOS'
    ],
    'admin_email' => env('ADMIN_EMAIL'),
    'reminder_types' => [
        'fcm' => 'FCM',
        'whatsapp' => 'WHATSAPP',
        'ivr' => 'IVR',
        'email' => 'EMAIL'
    ],
    'additional_auto_schedule_booking_days' => 30,
    'ifal_fb_link' => 'https://facebook.com/ifalilil',
    'ifal_instagram_link' => 'https://www.instagram.com/ifal_app/',
    'country_codes' => [
        'es' => '+34',
        'de' => '+49',
        'pl' => '+48',
        'hw' => '+972',
    ]
];
