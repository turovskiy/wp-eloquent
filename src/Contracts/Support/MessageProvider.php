<?php

namespace Turovskiy\WpEloquent\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \Turovskiy\WpEloquent\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
