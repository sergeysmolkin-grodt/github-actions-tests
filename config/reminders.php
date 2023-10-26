<?php

$services = include('services.php');

return [
    'reminders' => [
        'appointment' => [
            [
                'note' => 'This reminder will be run before 10 minutes of the session start.',
                'type' => 'email',
                'minutes' => 10,
                'message_type' => '10_minutes_zoom_data'
            ],
            [
                'note' => 'This reminder will be run before 2.5 minutes of the session start.',
                'type' => 'ivr',
                'minutes' => 2.5,
                'message_type' => '2_5_minutes'
            ],
            [
                'note' => 'This reminder will be run before 5 minutes of the session start.',
                'type' => 'whatsapp',
                'minutes' => 5,
                'message_type' => '5_minutes'
            ],
            [
                'note' => 'This reminder will be run before 5 minutes of the session start.',
                'type' => 'push',
                'minutes' => 5,
                'message_type' => '5_minutes'
            ],
            [
                'note' => 'This reminder will be run before 30 minutes of the session start.',
                'type' => 'whatsapp',
                'minutes' => 30,
                'message_type' => '30_minutes'
            ],
            [
                'note' => 'This reminder will be run before 3 hours of the session start.',
                'type' => 'whatsapp',
                'minutes' => 180,
                'message_type' => '3_hours'
            ]
        ],
    ],
    'message_types' => [
        'email' => [
            '10_minutes_zoom_data' => [
                'processor' => App\Mail\Appointments\Reminders\ZoomData::class
            ]
        ],
        'ivr' => [
            '2_5_minutes'
        ],
        'whatsapp' => [
            '30_minutes' => [
                'template' => $services['commbox']['templates']['appointment_reminder_30_minutes'],
                'parameters' => ['zoomLink']
            ],
            '3_hours' => [
                'template' => $services['commbox']['templates']['appointment_reminder_3_hours'],
                'parameters' => ['zoomLink']
            ],
            '5_minutes' => [
                'template' => $services['commbox']['templates']['appointment_reminder_5_minutes'],
                'parameters' => ['zoomLink']
            ]
        ],
        'push' => [
            '5_minutes' => [
                'title' => 'Your lesson is about to begin!',
                'messagee' => 'Your class will start in 5 minutes.',
            ]
        ]
    ],
    'channels' => [
        'email' => 'email',
        'whatsapp' => 'whatsapp',
        'ivr' => 'ivr',
        'push' => 'push',
    ]
];
