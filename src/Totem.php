<?php

namespace Studio\Totem;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Command\Command;
use Throwable;

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

        return new static();
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
        $whitelist = config('totem.artisan.whitelist', true);
        $all_commands = collect(Artisan::all());

        if (! empty($command_filter)) {
            $all_commands = $all_commands->filter(function (Command $command) use ($command_filter, $whitelist) {
                foreach ($command_filter as $filter) {
                    if (fnmatch($filter, $command->getName())) {
                        return $whitelist;
                    }
                }

                return ! $whitelist;
            });
        }

        return $all_commands->sortBy(function (Command $command) {
            $name = $command->getName();
            if (mb_strpos($name, ':') === false) {
                $name = ':'.$name;
            }

            return $name;
        });
    }

    /**
     * @return bool
     */
    public static function isEnabled(): bool
    {
        try {
            if (Cache::get('totem.table.'.TOTEM_TABLE_PREFIX.'tasks')) {
                return true;
            }

            if (Schema::hasTable(TOTEM_TABLE_PREFIX.'tasks')) {
                Cache::forever('totem.table.'.TOTEM_TABLE_PREFIX.'tasks', true);

                return true;
            }
        } catch (Throwable $e) {
            return false;
        }

        return false;
    }
}
