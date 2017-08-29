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

    public function afterCreated()
    {
        $input = collect(request()->only('frequencies'));
        dd($input);
//        if (isset($_frequency['parameters'])) {
//            $this->parameters()->createMany($_frequency['parameters']);
//        }
    }

    public function afterUpdated()
    {
    }

    public function beforeDeleted()
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
