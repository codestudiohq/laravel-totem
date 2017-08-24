<?php

namespace Studio\Totem;

use Cron\CronExpression;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Scheduling\ManagesFrequencies;

class Task extends Model
{
    use ManagesFrequencies;

    protected $fillable = [
        'description',
        'command',
        'parameters',
        'expression',
        'timezone',
        'is_active',
        'dont_overlap',
        'run_in_maintenance',
        'notification_email_address',
    ];

    protected $appends = [
        'activated',
        'upcoming',
    ];

    public function getActivatedAttribute()
    {
        return $this->is_active;
    }

    public function getUpcomingAttribute()
    {
        return CronExpression::factory($this->getCronExpression())->getNextRunDate()->format('Y-m-d H:i:s');
    }

    public function frequencies()
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id');
    }

    public function results()
    {
        return $this->hasMany(TaskResult::class, 'task_id', 'id');
    }

    public function getCronExpression()
    {
        if (! $this->expression) {
            $this->expression = '* * * * * *';
            foreach ($this->frequencies as $frequency) {
                $method = $frequency->interval;
                $args = [];
                $config = collect(config('totem.frequencies'))->filter(function ($item) use ($method) {
                    return $item['interval'] == $method;
                })->first();
                if ($config['parameters']) {
                    foreach ($config['parameters'] as $parameter) {
                        $args[] = $frequency->{$parameter['modifier']};
                    }
                }
                call_user_func_array([$this, $method], $args);
            }
        }

        return $this->expression;
    }

    public function getFormattedFrequencies()
    {
        return $this->frequencies->map(function ($frequency) {
            $parameters = false;
            if ($frequency->on) {
                $parameters[] = [
                    'label'    => 'On',
                    'modifier' => 'on',
                    'value'    => $frequency->on,
                ];
            }
            if ($frequency->second_on) {
                $parameters[] = [
                    'label'    => 'Second On',
                    'modifier' => 'second_on',
                    'value'    => $frequency->second_on,
                ];
            }
            if ($frequency->at) {
                $parameters[] = [
                    'label'    => 'At',
                    'modifier' => 'second_at',
                    'value'    => $frequency->at,
                ];
            }
            if ($frequency->second_at) {
                $parameters[] = [
                    'label'    => 'Second At',
                    'modifier' => 'second_at',
                    'value'    => $frequency->second_at,
                ];
            }
            if ($frequency->start) {
                $parameters[] = [
                    'label'    => 'Start',
                    'modifier' => 'start',
                    'value'    => $frequency->start,
                ];
            }
            if ($frequency->end) {
                $parameters[] = [
                    'label'    => 'End',
                    'modifier' => 'end',
                    'value'    => $frequency->end,
                ];
            }
            $frequency->parameters = $parameters;

            return $frequency;
        });
    }
}
