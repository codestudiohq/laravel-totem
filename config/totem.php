<?php

return [
    'frequencies'  => [
        [
            'label'             => 'Every Minute',
            'frequency'         => 'everyMinute',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Five Minutes',
            'frequency'         => 'everyFiveMinutes',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Ten Minutes',
            'frequency'         => 'everyTenMinutes',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Thirty Minutes',
            'frequency'         => 'everyThirtyMinutes',
            'parameters'        => false,
        ],
        [
            'label'             => 'Hourly',
            'frequency'         => 'hourly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Hourly at',
            'frequency'         => 'everyTenMinutes',
            'parameters'        => [
                [
                    'label'         => 'At',
                    'frequency'     => 'at',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Daily',
            'frequency'         => 'daily',
            'parameters'        => false,
        ],
        [
            'label'             => 'Daily at',
            'frequency'         => 'dailyAt',
            'parameters'        => [
                [
                    'label'         => 'At',
                    'frequency'     => 'at',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Twice Daily',
            'frequency'         => 'twiceDaily',
            'parameters'        => [
                [
                    'label'         => 'First',
                    'frequency'     => 'at',
                    'type'          => 'time',
                ],
                [
                    'label'         => 'Second',
                    'frequency'     => 'second_at',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Weekly',
            'frequency'         => 'weekly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Monthly',
            'frequency'         => 'monthly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Monthly On',
            'frequency'         => 'monthlyOn',
            'parameters'        => [
                [
                    'label'         => 'On',
                    'frequency'     => 'on',
                    'type'          => 'date',
                ],
                [
                    'label'         => 'At',
                    'frequency'     => 'at',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Quarterly',
            'frequency'         => 'quarterly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Yearly',
            'frequency'         => 'yearly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Weekdays',
            'frequency'         => 'weekdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Sunday',
            'frequency'         => 'sundays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Monday',
            'frequency'         => 'mondays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Tuesday',
            'frequency'         => 'tuesdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Wednesday',
            'frequency'         => 'wednesdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Thursday',
            'frequency'         => 'thursdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Friday',
            'frequency'         => 'fridays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Saturday',
            'frequency'         => 'saturdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Between',
            'frequency'         => 'between',
            'parameters'        => [
                [
                    'label'         => 'Start',
                    'frequency'     => 'start',
                    'type'          => 'time',
                ],
                [
                    'label'         => 'End',
                    'frequency'     => 'end',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Unless Between',
            'frequency'         => 'unlessBetween',
            'parameters'        => [
                [
                    'label'         => 'Start',
                    'frequency'     => 'start',
                    'type'          => 'time',
                ],
                [
                    'label'         => 'End',
                    'frequency'     => 'end',
                    'type'          => 'time',
                ],
            ],
        ],
    ],
];
