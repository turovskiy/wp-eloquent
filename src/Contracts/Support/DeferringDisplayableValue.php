<?php

namespace Turovskiy\WpEloquent\Contracts\Support;

interface DeferringDisplayableValue
{
    /**
     * Resolve the displayable value that the class is deferring.
     *
     * @return \Turovskiy\WpEloquent\Contracts\Support\Htmlable|string
     */
    public function resolveDisplayableValue();
}
