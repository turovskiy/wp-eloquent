<?php

declare(strict_types=1);

namespace Turovskiy\WpEloquent\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word) : string;
}
