<?php

namespace BeyondCode\LaravelMaskedDumper\TableDefinitions;

use BeyondCode\LaravelMaskedDumper\ColumnDefinitions\ColumnDefinition;
use BeyondCode\LaravelMaskedDumper\Contracts\Column;
use Doctrine\DBAL\Schema\Table;

class TableDefinition
{
    const DUMP_FULL = 'full';
    const DUMP_SCHEMA = 'schema';

    protected $query;
    protected Table $table;
    protected string $dumpType;
    protected array $columns = [];

    public function __construct(Table $table)
    {
        $this->table = $table;
        $this->dumpType = static::DUMP_FULL;
    }

    public function schemaOnly(): self
    {
        $this->dumpType = static::DUMP_SCHEMA;

        return $this;
    }

    public function fullDump(): self
    {
        $this->dumpType = static::DUMP_FULL;

        return $this;
    }

    public function query(callable $callable): void
    {
        $this->query = $callable;
    }

    public function mask(string $column, string $maskCharacter = 'x'):self
    {
        $this->columns[$column] = ColumnDefinition::mask($column, $maskCharacter);

        return $this;
    }

    public function replace(string $column, $replacer, $replaceNull = true): self
    {
        $this->columns[$column] = ColumnDefinition::replace($column, $replacer, $replaceNull);

        return $this;
    }

    public function replaceWhere(string $column, $replacer, callable $checker): self
    {
        $this->columns[$column] = ColumnDefinition::replaceWhere($column, $replacer, $checker);

        return $this;
    }

    /**
     * @param string $column
     *
     * @return Column|null
     */
    public function findColumn(string $column): ?Column
    {
        if (array_key_exists($column, $this->columns)) {
            return $this->columns[$column];
        }

        return null;
    }

    public function getDoctrineTable()
    {
        return $this->table;
    }

    public function shouldDumpData(): bool
    {
        return $this->dumpType === static::DUMP_FULL;
    }

    public function modifyQuery($query): void
    {
        if (is_null($this->query)) {
            return;
        }

        call_user_func($this->query, $query);
    }
}
