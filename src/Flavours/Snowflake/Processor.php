<?php

namespace Henriknordstrom\LaravelPdoOdbcPatched\Flavours\Snowflake;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Processors\Processor as BaseProcessor;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class Processor extends BaseProcessor
{
    /**
     * The connection instance.
     *
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * Create a new processor instance.
     *
     * @param  \Illuminate\Database\Connection  $connection
     * @return void
     */
    public function __construct($connection = null)
    {
        $this->connection = $connection;
    }
    public static function wrapTable($tableName): string
    {
        if ($tableName instanceof Blueprint) {
            $tableName = $tableName->getTable();
        }

        if (! env('SNOWFLAKE_COLUMNS_CASE_SENSITIVE', false)) {
            $tableName = Str::upper($tableName);
        }

        return $tableName;
    }

    /**
     * Process the results of a column listing query.
     *
     * @param array $results
     *
     * @return array
     */
    public function processColumnListing($results)
    {
        return array_map(function ($result) {
            return ((object) $result)->column_name;
        }, $results);
    }

    /**
     * Process an "insert get ID" query.
     *
     * @param string      $sql
     * @param array       $values
     * @param string|null $sequence
     *
     * @return int
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $connection = $query->getConnection();

        $connection->insert($sql, $values);

        $idColumn = $sequence ?: 'id';
        $wrappedTable = $query->getGrammar()->wrapTable($query->from);

        $result = $connection->selectOne(sprintf('select max("%s") as "%s" from %s', $idColumn, $idColumn, $wrappedTable));

        $id = $result->$idColumn;

        return is_numeric($id) ? (int) $id : $id;
    }
}
