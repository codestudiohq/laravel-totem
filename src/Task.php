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
        'notification_email_address'
    ];

    public function frequencies()
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id');
    }
}
