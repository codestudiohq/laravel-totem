<?php

namespace Studio\Totem\SqlSrv;

use Illuminate\Notifications\Notifiable;
use Studio\Totem\Task as TotemTask;
use Studio\Totem\Traits\FrontendSortable;
use Studio\Totem\SqlSrv\HasFrequencies;

class Task extends TotemTask
{
    use Notifiable, HasFrequencies, FrontendSortable;
}
