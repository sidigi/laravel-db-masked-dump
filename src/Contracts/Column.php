<?php

namespace FenixDumper\LaravelMaskedDumper\Contracts;

interface Column
{
    public function modifyValue($value, $rows);
}
