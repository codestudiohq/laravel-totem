<?php

return [
    'frequencies'  => [
        'everyMinute' => [
            'label'         => 'Every Minute',
            'parameters'    => false,
        ],
        'everyFiveMinutes' => [
            'label'         => 'Every Five Minutes',
            'parameters'    => false,
        ],
        'everyTenMinutes' => [
            'label'         => 'Every Ten Minutes',
            'parameters'    => false,
        ],
        'everyThirtyMinutes' => [
            'label'         => 'Every Thirty Minutes',
            'parameters'    => false,
        ],
        'hourly' => [
            'label'         => 'Hourly',
            'parameters'    => false,
        ],
        'hourlyAt' => [
            'label'         => 'Hourly at',
            'parameters'    => [
                'at',
            ],
        ],
        'daily' => [
            'label'         => 'Daily',
            'parameters'    => false,
        ],
        'dailyAt' => [
            'label'         => 'Daily at',
            'parameters'    => [
                'at' => [
                    'label' => 'At',
                    'type'  => 'time',
                ],
            ],
        ],
        'twiceDaily' => [
            'label'         => 'Twice Daily',
            'parameters'    => [
                'at' => [
                    'label' => 'First At',
                    'type'  => 'time',
                ],
                'second_at' => [
                    'label' => 'Second At',
                    'type'  => 'time',
                ],
            ],
        ],
        'weekly' => [
            'label'         => 'Weekly',
            'parameters'    => false,
        ],
        'monthly' => [
            'label'         => 'Monthly',
            'parameters'    => false,
        ],
        'monthlyOn' => [
            'label'         => 'Monthly On',
            'parameters'    => [
                'on' => [
                    'label' => 'On',
                    'type'  => 'day',
                ],
                'at' => [
                    'label' => 'At',
                    'type'  => 'time',
                ],
            ],
        ],
        'quarterly' => [
            'label'         => 'Quarterly',
            'parameters'    => false,
        ],
        'yearly' => [
            'label'         => 'Yearly',
            'parameters'    => false,
        ],
        'weekdays' => [
            'label'         => 'Weekdays',
            'parameters'    => false,
        ],
        'sundays' => [
            'label'         => 'Every Sunday',
            'parameters'    => false,
        ],
        'mondays' => [
            'label'         => 'Every Monday',
            'parameters'    => false,
        ],
        'tuesdays' => [
            'label'         => 'Every Tuesday',
            'parameters'    => false,
        ],
        'wednesdays' => [
            'label'         => 'Every Wednesday',
            'parameters'    => false,
        ],
        'thursdays' => [
            'label'         => 'Every Thursday',
            'parameters'    => false,
        ],
        'fridays' => [
            'label'         => 'Every Friday',
            'parameters'    => false,
        ],
        'saturdays' => [
            'label'         => 'Every Saturday',
            'parameters'    => false,
        ],
        'between'   => [
            'label'         => 'Between',
            'parameters'    => [
                'start' => [
                    'label' => 'Start Time',
                    'type'  => 'time',
                ],
                'end' => [
                    'label' => 'End Time',
                    'type'  => 'time',
                ],
            ],
        ],
        'unlessBetween'   => [
            'label'         => 'Unless Between',
            'parameters'    => [
                'start' => [
                    'label' => 'Start Time',
                    'type'  => 'time',
                ],
                'end' => [
                    'label' => 'End Time',
                    'type'  => 'time',
                ],
            ],
        ],
    ],
];
