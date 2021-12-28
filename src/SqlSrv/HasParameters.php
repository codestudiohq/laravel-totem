<?php

namespace Studio\Totem\SqlSrv;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Studio\Totem\Traits\HasParameters as HasParametersBase;

trait HasParameters
{
    use HasParametersBase {
        HasParametersBase::afterSave as parentAfterSave;
    }

    public function afterSave()
    {
        $data = $this->processData();

        $frequency = collect($data['frequencies'])->filter(function ($frequency) {
            return $frequency['interval'] == $this->interval;
        })->first();

        if (isset($frequency['parameters'])) {
            foreach ($frequency['parameters'] as $parameter) {
                DB::unprepared("SET IDENTITY_INSERT " . TOTEM_TABLE_PREFIX . "frequency_parameters ON");        
                $this->parameters()->updateOrCreate(Arr::only($parameter, 'name'), $parameter);
                DB::unprepared("SET IDENTITY_INSERT " . TOTEM_TABLE_PREFIX . "frequency_parameters OFF");        
            }
        }
    }
}
