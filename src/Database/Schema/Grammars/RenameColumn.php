<?php

namespace Turovskiy\WpEloquent\Database\Schema\Grammars;

use Doctrine\DBAL\Schema\AbstractSchemaManager as SchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\TableDiff;
use Turovskiy\WpEloquent\Database\Connection;
use Turovskiy\WpEloquent\Database\Schema\Blueprint;
use Turovskiy\WpEloquent\Support\Fluent;

class RenameColumn
{
    /**
     * Compile a rename column command.
     *
     * @param  \Turovskiy\WpEloquent\Database\Schema\Grammars\Grammar  $grammar
     * @param  \Turovskiy\WpEloquent\Database\Schema\Blueprint  $blueprint
     * @param  \Turovskiy\WpEloquent\Support\Fluent  $command
     * @param  \Turovskiy\WpEloquent\Database\Connection  $connection
     * @return array
     */
    public static function compile(Grammar $grammar, Blueprint $blueprint, Fluent $command, Connection $connection)
    {
        $schema = $connection->getDoctrineSchemaManager();
        $databasePlatform = $schema->getDatabasePlatform();
        $databasePlatform->registerDoctrineTypeMapping('enum', 'string');

        $column = $connection->getDoctrineColumn(
            $grammar->getTablePrefix().$blueprint->getTable(), $command->from
        );

        return (array) $databasePlatform->getAlterTableSQL(static::getRenamedDiff(
            $grammar, $blueprint, $command, $column, $schema
        ));
    }

    /**
     * Get a new column instance with the new column name.
     *
     * @param  \Turovskiy\WpEloquent\Database\Schema\Grammars\Grammar  $grammar
     * @param  \Turovskiy\WpEloquent\Database\Schema\Blueprint  $blueprint
     * @param  \Turovskiy\WpEloquent\Support\Fluent  $command
     * @param  \Doctrine\DBAL\Schema\Column  $column
     * @param  \Doctrine\DBAL\Schema\AbstractSchemaManager  $schema
     * @return \Doctrine\DBAL\Schema\TableDiff
     */
    protected static function getRenamedDiff(Grammar $grammar, Blueprint $blueprint, Fluent $command, Column $column, SchemaManager $schema)
    {
        return static::setRenamedColumns(
            $grammar->getDoctrineTableDiff($blueprint, $schema), $command, $column
        );
    }

    /**
     * Set the renamed columns on the table diff.
     *
     * @param  \Doctrine\DBAL\Schema\TableDiff  $tableDiff
     * @param  \Turovskiy\WpEloquent\Support\Fluent  $command
     * @param  \Doctrine\DBAL\Schema\Column  $column
     * @return \Doctrine\DBAL\Schema\TableDiff
     */
    protected static function setRenamedColumns(TableDiff $tableDiff, Fluent $command, Column $column)
    {
        $tableDiff->renamedColumns = [
            $command->from => new Column($command->to, $column->getType(), $column->toArray()),
        ];

        return $tableDiff;
    }
}
