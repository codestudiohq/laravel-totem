<?php

namespace Studio\Totem;

use Cron\CronExpression;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'description',
        'command',
        'parameters',
        'cron',
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

    public function setTimezoneAttribute($value)
    {
        return $this->attributes['timezone'] = $value?: config('app.timezone');
    }

    public function getActivatedAttribute()
    {
        return $this->is_active;
    }

    public function getUpcomingAttribute()
    {
        return CronExpression::factory($this->cron)->getNextRunDate()->format('Y-m-d H:i:s');
    }

    public function frequencies()
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id');
    }

    public function results()
    {
        return $this->hasMany(TaskResult::class, 'task_id', 'id');
    }
}
