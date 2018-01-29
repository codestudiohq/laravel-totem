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
            // this regex matches pieces of text separated by spaces as long as they are not quoted
            $regex = '/(?=\S)[^\'"\s]*(?:\'[^\']*\'[^\'"\s]*|"[^"]*"[^\'"\s]*)*/';
            preg_match_all($regex, $this->parameters, $matches, PREG_SET_ORDER, 0);

            $index = 0;
            // flatten() because preg_match_all puts all matches inside their own array...
            $parameters = collect($matches)->flatten()->mapToGroups(function ($parameter) use ($console, &$index) {
                // handles quoted positional arguments
                // TODO: this is fragile and doesn't handle all possible cases
                if (starts_with($parameter, ['"', '\''])) {
                    return [$index++ => $parameter];
                }
                [$key, $value] = array_pad(explode('=', $parameter, 2), 2, null);
                $isOption = starts_with($key, '--');
                $hasValue = isset($value);
                if ($console) {
                    // if it is an option use the whole parameter because we don't wanna throw away its key
                    if ($isOption) {
                        return [$index++ => $parameter];
                    }
                    if ($hasValue) {
                        return [$index++ => $value];
                    }
                } else {
                    // first check if it has a value because we don't wanna discard that
                    if ($hasValue) {
                        return [$key => $value];
                    }
                    if ($isOption) {
                        return [$key => true];
                    }
                }
                // positional arguments end up here (no value and not an option/flag)
                // TODO: if we are not compiling for console this is technically wrong:
                // in order to be able to use these parameters for Artisan::call we need the name
                // of the parameter in question, should we just throw if this happens?
                return [$index++ => $key];
            })->map(function ($parameter) {
                // if a parameter has only one value flatten it
                return (($parameter->count() > 1) ? $parameter : $parameter->first());
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
