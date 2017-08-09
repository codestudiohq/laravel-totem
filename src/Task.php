<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'description',
        'command',
        'cron',
        'timezone',
        'is_active',
        'dont_overlap',
        'run_in_maintenance',
        'notification_email_address',
    ];

    protected $appends = [
        'activated',
    ];

    public function getActivatedAttribute()
    {
        return $this->is_active;
    }

    public function frequencies()
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id');
    }
}
