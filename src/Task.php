<?php

namespace Studio\Totem;

use Closure;
use Cron\CronExpression;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Console\Scheduling\ManagesFrequencies;

class Task extends Model
{
    use Notifiable, ManagesFrequencies;

    /**
     * The array of filter callbacks.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * The array of reject callbacks.
     *
     * @var array
     */
    protected $rejects = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'notification_phone_number',
        'notification_slack_webhook',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'activated',
        'upcoming',
    ];

    /**
     * Activated Accessor.
     *
     * @return bool
     */
    public function getActivatedAttribute()
    {
        return $this->is_active;
    }

    /**
     * Upcoming Accessor.
     *
     * @return string
     */
    public function getUpcomingAttribute()
    {
        return CronExpression::factory($this->getCronExpression())->getNextRunDate()->format('Y-m-d H:i:s');
    }

    /**
     * Frequencies Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function frequencies()
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id')->with('parameters');
    }

    /**
     * Results Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany(Result::class, 'task_id', 'id');
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->notification_email_address;
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        return $this->notification_phone_number;
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return $this->notification_slack_webhook;
    }

    /**
     * Generate a cron expression from frequencies.
     *
     * @return string
     */
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

    /**
     * Get the mutex name for the scheduled task.
     *
     * @return string
     */
    public function getMutexName()
    {
        return 'logs'.DIRECTORY_SEPARATOR.'schedule-'.sha1($this->expression.$this->command);
    }

    /**
     * Determine if the filters pass for the event.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return bool
     */
    public function filtersPass($app)
    {
        foreach ($this->filters as $callback) {
            if (! $app->call($callback)) {
                return false;
            }
        }

        foreach ($this->rejects as $callback) {
            if ($app->call($callback)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Register a callback to further filter the schedule.
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function when(Closure $callback)
    {
        $this->filters[] = $callback;

        return $this;
    }

    /**
     * Schedule the event to run between start and end time.
     *
     * @param  string  $startTime
     * @param  string  $endTime
     * @return $this
     */
    public function between($startTime, $endTime)
    {
        return $this->when($this->inTimeInterval($startTime, $endTime));
    }
}
