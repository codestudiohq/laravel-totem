<?php

return [
    'frequencies'  => [
        [
            'label'             => 'Every Minute',
            'interval'          => 'everyMinute',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Five Minutes',
            'interval'          => 'everyFiveMinutes',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Ten Minutes',
            'interval'          => 'everyTenMinutes',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Thirty Minutes',
            'interval'          => 'everyThirtyMinutes',
            'parameters'        => false,
        ],
        [
            'label'             => 'Hourly',
            'interval'          => 'hourly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Hourly at',
            'interval'          => 'hourlyAt',
            'parameters'        => [
                [
                    'label'         => 'At',
                    'modifier'      => 'at',
                    'type'          => 'number',
                    'min'           => '0',
                    'max'           => '59',
                ],
            ],
        ],
        [
            'label'             => 'Daily',
            'interval'          => 'daily',
            'parameters'        => false,
        ],
        [
            'label'             => 'Daily at',
            'interval'          => 'dailyAt',
            'parameters'        => [
                [
                    'label'         => 'At',
                    'modifier'      => 'at',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Twice Daily',
            'interval'          => 'twiceDaily',
            'parameters'        => [
                [
                    'label'         => 'First',
                    'modifier'      => 'at',
                    'type'          => 'time',
                ],
                [
                    'label'         => 'Second',
                    'modifier'      => 'second_at',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Weekly',
            'interval'          => 'weekly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Weekly On',
            'interval'          => 'weeklyOn',
            'parameters'        => [
                [
                    'label'         => 'On',
                    'modifier'      => 'on',
                    'type'          => 'number',
                    'min'           => '1',
                    'max'           => '31',
                ],
                [
                    'label'         => 'At',
                    'modifier'      => 'at',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Monthly',
            'interval'          => 'monthly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Monthly On',
            'interval'          => 'monthlyOn',
            'parameters'        => [
                [
                    'label'         => 'On',
                    'modifier'      => 'on',
                    'type'          => 'number',
                    'max'           => '',
                ],
                [
                    'label'         => 'At',
                    'modifier'      => 'at',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Twice Monthly',
            'interval'          => 'twiceMonthly',
            'parameters'        => [
                [
                    'label'         => 'First',
                    'modifier'      => 'on',
                    'type'          => 'number',
                ],
                [
                    'label'         => 'Second',
                    'modifier'      => 'second_at',
                    'type'          => 'text',
                ],
            ],
        ],
        [
            'label'             => 'Quarterly',
            'interval'          => 'quarterly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Yearly',
            'interval'          => 'yearly',
            'parameters'        => false,
        ],
        [
            'label'             => 'Weekdays',
            'interval'          => 'weekdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Sunday',
            'interval'          => 'sundays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Monday',
            'interval'          => 'mondays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Tuesday',
            'interval'          => 'tuesdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Wednesday',
            'interval'          => 'wednesdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Thursday',
            'interval'          => 'thursdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Friday',
            'interval'          => 'fridays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Every Saturday',
            'interval'          => 'saturdays',
            'parameters'        => false,
        ],
        [
            'label'             => 'Between',
            'interval'          => 'between',
            'parameters'        => [
                [
                    'label'         => 'Start',
                    'modifier'      => 'start',
                    'type'          => 'time',
                ],
                [
                    'label'         => 'End',
                    'modifier'      => 'end',
                    'type'          => 'time',
                ],
            ],
        ],
        [
            'label'             => 'Unless Between',
            'interval'          => 'unlessBetween',
            'parameters'        => [
                [
                    'label'         => 'Start',
                    'modifier'      => 'start',
                    'type'          => 'time',
                ],
                [
                    'label'         => 'End',
                    'modifier'      => 'end',
                    'type'          => 'time',
                ],
            ],
        ],
    ],
];
