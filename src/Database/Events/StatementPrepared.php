<?php

namespace Turovskiy\WpEloquent\Database\Events;

class StatementPrepared
{
    /**
     * The database connection instance.
     *
     * @var \Turovskiy\WpEloquent\Database\Connection
     */
    public $connection;

    /**
     * The PDO statement.
     *
     * @var \PDOStatement
     */
    public $statement;

    /**
     * Create a new event instance.
     *
     * @param  \Turovskiy\WpEloquent\Database\Connection  $connection
     * @param  \PDOStatement  $statement
     * @return void
     */
    public function __construct($connection, $statement)
    {
        $this->statement = $statement;
        $this->connection = $connection;
    }
}
