<?php

return [
    'frequencies'  => [
        [
            'label'         => 'Every Minute',
            'value'         =>  'everyMinute',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Five Minutes',
            'value'         =>  'everyFiveMinutes',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Ten Minutes',
            'value'         => 'everyTenMinutes',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Thirty Minutes',
            'value'         => 'everyThirtyMinutes',
            'parameters'    => false,
        ],
        [
            'label'         => 'Hourly',
            'value'         => 'hourly',
            'parameters'    => false,
        ],
        [
            'label'         => 'Hourly at',
            'value'         => 'everyTenMinutes',
            'parameters'    => [
                [
                    'label'     => 'At',
                    'value'     => 'at',
                    'type'      => 'time'
                ]
            ],
        ],
        [
            'label'         => 'Daily',
            'value'         => 'daily',
            'parameters'    => false,
        ],
        [
            'label'         => 'Daily at',
            'value'         => 'dailyAt',
            'parameters'    => [
                [
                    'label'     => 'At',
                    'value'     => 'at',
                    'type'      => 'time'
                ]
            ],
        ],
        [
            'label'         => 'Twice Daily',
            'value'         => 'twiceDaily',
            'parameters'    => [
                [
                    'label'     => 'First',
                    'value'     => 'at',
                    'type'      => 'time'
                ],
                [
                    'label'     => 'Second',
                    'value'     => 'second_at',
                    'type'      => 'time'
                ]
            ],
        ],
        [
            'label'         => 'Weekly',
            'value'         =>  'weekly',
            'parameters'    => false,
        ],
        [
            'label'         => 'Monthly',
            'value'         =>  'monthly',
            'parameters'    => false,
        ],
        [
            'label'         => 'Monthly On',
            'value'         => 'monthlyOn',
            'parameters'    => [
                [
                    'label'     => 'On',
                    'value'     => 'on',
                    'type'      => 'date'
                ],
                [
                    'label'     => 'At',
                    'value'     => 'at',
                    'type'      => 'time'
                ]
            ],
        ],
        [
            'label'         => 'Quarterly',
            'value'         => 'quarterly',
            'parameters'    => false,
        ],
        [
            'label'         => 'Yearly',
            'value'         => 'yearly',
            'parameters'    => false,
        ],
        [
            'label'         => 'Weekdays',
            'value'         => 'weekdays',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Sunday',
            'value'         => 'sundays',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Monday',
            'value'         => 'mondays',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Tuesday',
            'value'         => 'tuesdays',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Wednesday',
            'value'         => 'wednesdays',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Thursday',
            'value'         => 'thursdays',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Friday',
            'value'         => 'fridays',
            'parameters'    => false,
        ],
        [
            'label'         => 'Every Saturday',
            'value'         => 'saturdays',
            'parameters'    => false,
        ],
        [
            'label'         => 'Between',
            'value'         => 'between',
            'parameters'    => [
                [
                    'label'     => 'Start',
                    'value'     => 'start',
                    'type'      => 'time'
                ],
                [
                    'label'     => 'End',
                    'value'     => 'end',
                    'type'      => 'time'
                ]
            ],
        ],
        [
            'label'         => 'Unless Between',
            'value'         => 'unlessBetween',
            'parameters'    => [
                [
                    'label'     => 'Start',
                    'value'     => 'start',
                    'type'      => 'time'
                ],
                [
                    'label'     => 'End',
                    'value'     => 'end',
                    'type'      => 'time'
                ]
            ],
        ],
    ],
];
