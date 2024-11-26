<?php

namespace Turovskiy\WpEloquent\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param  string|null  $name
     * @return \Turovskiy\WpEloquent\Contracts\Queue\Queue
     */
    public function connection($name = null);
}
