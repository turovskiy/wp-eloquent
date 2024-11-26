<?php

namespace Turovskiy\WpEloquent\Events;

use Closure;

if (! function_exists('Turovskiy\WpEloquent\Events\queueable')) {
    /**
     * Create a new queued Closure event listener.
     *
     * @param  \Closure  $closure
     * @return \Turovskiy\WpEloquent\Events\QueuedClosure
     */
    function queueable(Closure $closure)
    {
        return new QueuedClosure($closure);
    }
}
