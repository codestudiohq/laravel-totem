<?php

namespace Studio\Totem\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class TotemEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        'Studio\Totem\Events\Created'     => ['Studio\Totem\Listeners\BustCache', 'Studio\Totem\Listeners\BuildCache'],
        'Studio\Totem\Events\Updated'     => ['Studio\Totem\Listeners\BustCache', 'Studio\Totem\Listeners\BuildCache'],
        'Studio\Totem\Events\Activated'   => ['Studio\Totem\Listeners\BustCache', 'Studio\Totem\Listeners\BuildCache'],
        'Studio\Totem\Events\Deactivated' => ['Studio\Totem\Listeners\BustCache', 'Studio\Totem\Listeners\BuildCache'],
        'Studio\Totem\Events\Deleting'    => ['Studio\Totem\Listeners\BustCacheImmediately'],
    ];
}
