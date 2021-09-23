<?php

namespace FenixDumper\LaravelMaskedDumper\ColumnDefinitions;

use FenixDumper\LaravelMaskedDumper\Contracts\Column;

class MaskedColumn implements Column
{
    protected $column;
    protected string $maskCharacter;

    public function __construct(string $column, string $maskCharacter)
    {
        $this->column = $column;
        $this->maskCharacter = $maskCharacter;
    }

    public function modifyValue($value, $rows): string
    {
        return str_repeat($this->maskCharacter, strlen($value));
    }
}
