<?php

namespace FenixDumper\LaravelMaskedDumper\ColumnDefinitions;

class ColumnDefinition
{

    public static function mask(string $column, string $maskCharacter = 'x'): MaskedColumn
    {
        return new MaskedColumn($column, $maskCharacter);
    }

    public static function replace(string $column, $replacer, $replaceNull): ReplacedColumn
    {
        return new ReplacedColumn($column, $replacer, $replaceNull);
    }

    public static function replaceWhere(string $column, $replacer, $checker): ReplacedWhereColumn
    {
        return new ReplacedWhereColumn($column, $replacer, $checker);
    }
}
