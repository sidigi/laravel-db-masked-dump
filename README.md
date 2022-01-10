# Laravel DB Masked Dump
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sergefenix/laravel-db-masked-dump.svg?style=flat-square)](https://packagist.org/packages/sergefenix/laravel-db-masked-dump)
[![Total Downloads](https://img.shields.io/packagist/dt/sergefenix/laravel-db-masked-dump.svg?style=flat-square)](https://packagist.org/packages/sergefenix/laravel-db-masked-dump)

A database dumping package that allows you to replace and mask columns while dumping your database.

You can :
* Replace
```bash
$table->replace();
```

* Ignore ids
```bash
$table->ignore();
$table->isIgnored();
```

* Mask
```bash
$table->mask();
```

* Create rule for replace
```bash
$table->replaceWhen();
```

* Get schema or full dump
```bash
$table->schemaOnly();
```

* Set priority tables for dump
```bash
$shema->priorityTables();
```

* Disable constrain for table
```bash
$table->disableConstrain();
$shema->disableAllConstrains();
```
* More
```bash
modifyQuery()
fullDump()
schemaOnly()
shouldDumpData()
```

## Installation

You can install the package via composer v2:

```bash
composer require sergefenix/laravel-db-masked-dump
```

## Commands
```bash
php artisan vendor:publish --provider=FenixDumper\\LaravelMaskedDumper\\LaravelMaskedDumpServiceProvider
php artisan db:masked-dump output.sql
php artisan db:masked-dump output.sql --definition=sqlite
php artisan db:masked-dump output.sql --gzip
```

## Credits

- [Serge Demidenko](https://github.com/sergefenix)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
