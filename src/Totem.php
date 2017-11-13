<?php

namespace Studio\Totem;

use Closure;
use Illuminate\Support\Facades\Artisan;

class Totem
{
    /**
     * The callback that should be used to authenticate Totem users.
     *
     * @var \Closure
     */
    public static $authUsing;

    /**
     * Determine if the given request can access the Totem dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function check($request)
    {
        return (static::$authUsing ?: function () {
            return app()->environment('local');
        })($request);
    }

    /**
     * Set the callback that should be used to authenticate Totem users.
     *
     * @param  \Closure  $callback
     * @return static
     */
    public static function auth(Closure $callback)
    {
        static::$authUsing = $callback;

        return new static;
    }

    /**
     * Return available frequencies.
     *
     * @return array
     */
    public static function frequencies()
    {
        return config('totem.frequencies');
    }

    /**
     * Return collection of Artisan commands filtered if needed.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getCommands()
    {
        $command_filter = config('totem.artisan.command_filter');
        $all_commands = collect(Artisan::all());

        if (! empty($command_filter)) {
            $all_commands = $all_commands->filter(function ($command) use ($command_filter) {
                foreach ($command_filter as $filter) {
                    if (fnmatch($filter, $command->getName())) {
                        return true;
                    }
                }

                return false;
            });
        }

        return $all_commands->sortBy(function ($command) {
            return $command->getDescription();
        });
    }
}
