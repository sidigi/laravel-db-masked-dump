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

    public function modifyValue($value)
    {
        if (! $this->replaceNull && is_null($value)) {
            return $value;
        }

        $faker = Factory::create();

        if (is_callable($this->replacer)) {
            return call_user_func_array($this->replacer, [$faker, $value]);
        }

        return $this->replacer;
    }
}
