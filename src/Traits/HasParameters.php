<?php

namespace Studio\Totem\Traits;

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
        $frequency = collect(request()->input('frequencies'))->filter(function ($frequency) {
            return $frequency['interval'] == $this->interval;
        })->first();

        if (isset($frequency['parameters'])) {
            foreach ($frequency['parameters'] as $parameter) {
                $this->parameters()->updateOrCreate(array_only($parameter, 'name'), $parameter);
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
}
