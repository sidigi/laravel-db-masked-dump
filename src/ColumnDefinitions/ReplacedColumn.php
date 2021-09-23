<?php

namespace BeyondCode\LaravelMaskedDumper\ColumnDefinitions;

use BeyondCode\LaravelMaskedDumper\Contracts\Column;
use Faker\Factory;

class ReplacedColumn implements Column
{
    protected string $column;
    protected $replacer;
    protected bool $replaceNull;

    public function __construct(string $column, $replacer, $replaceNull)
    {
        $this->column = $column;
        $this->replacer = $replacer;
        $this->replaceNull = $replaceNull;
    }

    public function modifyValue($value, $rows)
    {
        if (! $this->replaceNull && is_null($value)) {
            return null;
        }

        if (is_callable($this->replacer)) {
            return call_user_func_array($this->replacer, [Factory::create(), $value, $rows]);
        }

        return $this->replacer;
    }
}
