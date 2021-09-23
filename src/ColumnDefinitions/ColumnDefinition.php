<?php

namespace BeyondCode\LaravelMaskedDumper\ColumnDefinitions;

class ColumnDefinition
{

    public static function mask(string $column, string $maskCharacter = 'x')
    {
        return new MaskedColumn($column, $maskCharacter);
    }

    public static function replace(string $column, $replacer, $replaceNull)
    {
        return new ReplacedColumn($column, $replacer, $replaceNull);
    }

    public static function replaceWhere(string $column, $replacer, $checker)
    {
        return new ReplacedWhereColumn($column, $replacer, $checker);
    }

    public static function replaceWhereNot(string $column, $replacer, $checker)
    {
        return new ReplacedWhereNotColumn($column, $replacer, $checker);
    }
}
