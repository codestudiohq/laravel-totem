<?php

namespace Studio\Totem\Traits;

use Illuminate\Support\Arr;
use Studio\Totem\Parameter;

trait HasParameters
{
    /**
     * Boot HasParameters Trait.
     */
    public static function bootHasParameters()
    {
        static::saved(function ($model) {
            $model->afterSave();
        });

        static::deleting(function ($model) {
            $model->beforeDelete();
        });
    }

    public function afterSave()
    {
        $data = $this->processData();

        $frequency = collect($data['frequencies'])->filter(function ($frequency) {
            return $frequency['interval'] == $this->interval;
        })->first();

        if (isset($frequency['parameters'])) {
            foreach ($frequency['parameters'] as $parameter) {
                $this->parameters()->updateOrCreate(Arr::only($parameter, 'name'), $parameter);
            }
        }
    }

    public function beforeDelete()
    {
        $this->parameters()->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parameters()
    {
        return $this->hasMany(Parameter::class);
    }

    /**
     * Process input data. If its an import action we must find out if the imported json has frequencies or not and
     * prepare data accordingly.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function processData()
    {
        $data = request()->all();

        if (! request()->hasFile('tasks')) {
            return $data;
        }

        $task = collect(json_decode(request()->file('tasks')->get()))
            ->filter(function ($task) {
                return $task->id === $this->task->id;
            })
            ->first();

        if ($task && $task->frequencies) {
            $data['frequencies'] = collect($task->frequencies)
                ->map(function ($frequency) {
                    $frequency->parameters = collect($frequency->parameters)
                        ->map(function ($parameter) {
                            return (array) $parameter;
                        });

                    return (array) $frequency;
                })
                ->toArray();
        }

        return $data;
    }
}
