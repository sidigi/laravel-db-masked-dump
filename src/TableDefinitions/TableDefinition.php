<?php

namespace FenixDumper\LaravelMaskedDumper\TableDefinitions;

use FenixDumper\LaravelMaskedDumper\ColumnDefinitions\ColumnDefinition;
use FenixDumper\LaravelMaskedDumper\Contracts\Column;
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

    public function mask(string $column, string $maskCharacter = 'x'): self
    {
        $this->columns[$column] = ColumnDefinition::mask($column, $maskCharacter);

        return $this;
    }

    public function replace(string $column, $replacer, $replaceNull = true): self
    {
        $this->columns[$column] = ColumnDefinition::replace($column, $replacer, $replaceNull);

        return $this;
    }

    public function whenReplace(string $column, callable $condition, $replacer): self
    {
        $this->columns[$column] = ColumnDefinition::replaceWhere($column, $replacer, $condition);

        return $this;
    }

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
