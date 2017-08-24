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

    /**
     * @return mixed
     */
    public function getActivatedAttribute()
    {
        return $this->is_active;
    }

    /**
     * @return string
     */
    public function getUpcomingAttribute()
    {
        return CronExpression::factory($this->getCronExpression())->getNextRunDate()->format('Y-m-d H:i:s');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function frequencies()
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id')->with('parameters');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany(TaskResult::class, 'task_id', 'id');
    }

    public function getCronExpression()
    {
        if (! $this->expression) {
            $this->expression = '* * * * * *';

            foreach ($this->frequencies as $frequency) {
                call_user_func_array([$this, $frequency->interval], $frequency->parameters->pluck('value')->toArray());
            }
        }

        return $this->expression;
    }
}
