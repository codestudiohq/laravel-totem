<?php

namespace Studio\Totem;

use Closure;

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
}
