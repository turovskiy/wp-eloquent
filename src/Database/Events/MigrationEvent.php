<?php

namespace Turovskiy\WpEloquent\Database\Events;

use Turovskiy\WpEloquent\Contracts\Database\Events\MigrationEvent as MigrationEventContract;
use Turovskiy\WpEloquent\Database\Migrations\Migration;

abstract class MigrationEvent implements MigrationEventContract
{
    /**
     * An migration instance.
     *
     * @var \Turovskiy\WpEloquent\Database\Migrations\Migration
     */
    public $migration;

    /**
     * The migration method that was called.
     *
     * @var string
     */
    public $method;

    /**
     * Create a new event instance.
     *
     * @param  \Turovskiy\WpEloquent\Database\Migrations\Migration  $migration
     * @param  string  $method
     * @return void
     */
    public function __construct(Migration $migration, $method)
    {
        $this->method = $method;
        $this->migration = $migration;
    }
}
