<?php

namespace Studio\Totem\SqlSrv;

use Illuminate\Support\Arr;
use Studio\Totem\Frequency;
use Illuminate\Support\Facades\DB;
use Studio\Totem\Traits\HasFrequencies as HasFrequenciesBase;

trait HasFrequencies
{
    use HasFrequenciesBase {
        HasFrequenciesBase::afterSave as parentAfterSave;
    }
    /**
     * When task is updated or created, we grab the input. If the type is set to frequency in input we try to either
     * update or create the frequencies included in input else delete the frequency. If the type is not frequency and
     * the task in question has frequencies saved in databased, delete them all.
     */
    public function afterSave()
    {
        $input = $this->processData();

        if (isset($input['type'])) {
            if ($input['type'] == 'frequency') {
                foreach ($this->frequencies as $frequency) {
                    if (!in_array($frequency->interval, collect($input['frequencies'])->pluck('interval')->toArray())) {
                        $frequency->delete();
                    }
                }

                foreach ($input['frequencies'] as $_frequency) {
                    DB::unprepared("SET IDENTITY_INSERT " . TOTEM_TABLE_PREFIX . "task_frequencies ON");        
                    $this->frequencies()->updateOrCreate(Arr::only($_frequency, ['task_id', 'label', 'interval']));
                    DB::unprepared("SET IDENTITY_INSERT " . TOTEM_TABLE_PREFIX . "task_frequencies OFF");        
                }
            } else {
                $this->frequencies->each(function ($frequency) {
                    $frequency->delete();
                });
            }
        }
    }
}
