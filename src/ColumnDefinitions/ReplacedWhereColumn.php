<?php

namespace BeyondCode\LaravelMaskedDumper\ColumnDefinitions;

use BeyondCode\LaravelMaskedDumper\Contracts\Column;
use Faker\Factory;

class ReplacedWhereColumn implements Column
{
    protected string $column;
    protected $replacer;
    protected $checker;

    public function __construct(string $column, $replacer, callable $checker)
    {
        $this->column = $column;
        $this->replacer = $replacer;
        $this->checker = $checker;
    }

    public function modifyValue($value, $rows)
    {
        $bool = (bool) call_user_func($this->checker, $value);

        if ($bool) {
            return $value;
        }

        if (is_callable($this->replacer)) {
            return call_user_func_array($this->replacer, [Factory::create(), $value, $rows]);
        }

        return $this->replacer;
    }
}
