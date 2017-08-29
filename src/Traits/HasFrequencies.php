<?php

namespace Studio\Totem\Traits;

use Closure;
use Studio\Totem\Frequency;
use Illuminate\Console\Scheduling\ManagesFrequencies;

trait HasFrequencies
{
    use ManagesFrequencies;

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
     * Boot HasFrequencies Trait.
     */
    public static function bootHasFrequencies()
    {
        static::created(function ($model) {
            $model->afterCreated();
        });

        static::updated(function ($model) {
            $model->afterUpdated();
        });

        static::deleting(function ($model) {
            $model->beforeDeleted();
        });
    }

    /**
     * Task Created.
     */
    public function afterCreated()
    {
        $input = request()->all();

        if ($input['type'] == 'frequency') {
            foreach ($input['frequencies'] as $_frequency) {
                $this->frequencies()->create($_frequency);
            }
        }
    }

    /**
     * Task Updated.
     */
    public function afterUpdated()
    {
        $input = request()->all();

        if ($input['type'] == 'frequency') {
            foreach ($this->frequencies as $frequency) {
                if (! in_array($frequency->interval, collect($input['frequencies'])->pluck('interval')->toArray())) {
                    $frequency->delete();
                }
            }

            foreach ($input['frequencies'] as $_frequency) {
                $frequency = $this->frequencies()->updateOrCreate(array_only($_frequency, ['task_id', 'label', 'interval']));

                $parameters = isset($_frequency['parameters']) ? $_frequency['parameters'] : [];
                foreach ($parameters as $_parameter) {
                    $frequency->parameters()->updateOrCreate($_parameter);
                }
            }
            $this->expression = null;
            $this->save();
        } else {
            $this->frequencies()->delete();
        }
    }

    /**
     * Task Deleted.
     */
    public function beforeDeleted()
    {
        $this->frequencies()->delete();

        $this->results()->delete();
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

            $expression = $this->expression;

            $this->expression = null;

            return $expression;
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
