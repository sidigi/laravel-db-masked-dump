<?php

namespace FenixDumper\LaravelMaskedDumper;

use Doctrine\DBAL\Schema\Table;
use Faker\Factory;
use FenixDumper\LaravelMaskedDumper\TableDefinitions\TableDefinition;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

class DumpSchema
{
    protected $connectionName;
    protected $availableTables = [];
    protected $dumpTables = [];

    protected $loadAllTables = false;
    protected $disableAllConstrains = false;
    protected $customizedTables = [];
    protected $priorityTables = [];

    public function __construct($connectionName = null)
    {
        $this->connectionName = $connectionName;
    }

    public function disableAllConstrains(bool $disable = true): self
    {
        $this->disableAllConstrains = $disable;

        return $this;
    }

    public function isDisableAllConstrains(): bool
    {
        return $this->disableAllConstrains;
    }

    public static function define($connectionName = null): DumpSchema
    {
        return new static($connectionName);
    }

    public function schemaOnly(string $tableName): DumpSchema
    {
        return $this->table($tableName, function (TableDefinition $table) {
            $table->schemaOnly();
        });
    }

    public function table(string $tableName, callable $tableDefinition): self
    {
        $this->customizedTables[$tableName] = $tableDefinition;

        return $this;
    }

    public function allTables(): self
    {
        $this->loadAllTables = true;

        return $this;
    }

    public function priorityTables(array $tablesName): self
    {
        $this->priorityTables = $tablesName;

        return $this;
    }

    public function getConnection(): ConnectionInterface
    {
        return DB::connection($this->connectionName);
    }

    protected function getTable(string $tableName)
    {
        $table = collect($this->availableTables)->first(function (Table $table) use ($tableName) {
            return $table->getName() === $tableName;
        });

        if (is_null($table)) {
            throw new \Exception("Invalid table name {$tableName}");
        }

        return $table;
    }

    public function getDumpTables(): array
    {
        return $this->dumpTables;
    }

    protected function loadAvailableTables(): void
    {
        if ($this->availableTables !== []) {
            return;
        }

        $this->availableTables = $this->getConnection()->getDoctrineSchemaManager()->listTables();
    }

    public function load(): void
    {
        $this->loadAvailableTables();

        if ($this->loadAllTables) {
            $this->dumpTables = collect($this->availableTables)->mapWithKeys(function (Table $table) {
                return [$table->getName() => new TableDefinition($table)];
            })->toArray();

            $this->dumpTables = array_replace(array_flip($this->priorityTables), $this->dumpTables);
        }

        foreach ($this->customizedTables as $tableName => $tableDefinition) {
            $table = new TableDefinition($this->getTable($tableName));
            call_user_func_array($tableDefinition, [$table, Factory::create()]);

            $this->dumpTables[$tableName] = $table;
        }
    }
}
