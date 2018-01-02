<?php

namespace Studio\Totem;

use Carbon\Carbon;
use Cron\CronExpression;
use Studio\Totem\Traits\HasFrequencies;
use Illuminate\Notifications\Notifiable;

class Task extends TotemModel
{
    use Notifiable, HasFrequencies;

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
        'auto_cleanup_type',
        'auto_cleanup_num',
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
     * Convert a string of command arguments and options to an array.
     *
     * @param bool $console if true will convert arguments to non associative array
     *
     * @return array
     */
    public function compileParameters($console = false)
    {
        if ($this->parameters) {
            $regex = '/(?=\S)[^\'"\s]*(?:\'[^\']*\'[^\'"\s]*|"[^"]*"[^\'"\s]*)*/';
            preg_match_all($regex, $this->parameters, $matches, PREG_SET_ORDER, 0);

            $argument_index = 0;
            $parameters = collect($matches)->mapWithKeys(function ($parameter) use ($console, &$argument_index) {
                $param = explode('=', $parameter[0]);

                return count($param) > 1
                    ? ($console ? (starts_with($param[0], '--') ? [$param[0] => $param[1]] : [$argument_index++ => $param[1]]) : [$param[0] => $param[1]])
                    : (starts_with($param[0], '--') && ! $console ? [$param[0] => true] : [$argument_index++ => $param[0]]);
            })->toArray();

            return $parameters;
        }

        return [];
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
     * Returns the most recent result entry for this task.
     *
     * @return Model|null
     */
    public function getLastResultAttribute()
    {
        return $this->results()->orderBy('id', 'desc')->first();
    }

    /**
     * @return float
     */
    public function getAverageRuntimeAttribute()
    {
        return $this->results()->avg('duration') ?? 0.00;
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
     * Attempt to perform clean on task results.
     */
    public function autoCleanup()
    {
        if ($this->auto_cleanup_num > 0) {
            if ($this->auto_cleanup_type === 'results') {
                $oldest_id = self::results()
                    ->orderBy('ran_at', 'desc')
                    ->limit($this->auto_cleanup_num)
                    ->get()
                    ->min('id');
                self::results()
                    ->where('id', '<', $oldest_id)
                    ->delete();
            } else {
                self::results()
                    ->where('ran_at', '<', Carbon::now()->subDays($this->auto_cleanup_num - 1))
                    ->delete();
            }
        }
    }
}
