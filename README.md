# Laravel DB Masked Dump

A database dumping package that allows you to replace and mask columns while dumping your database.

[![Total Downloads](https://img.shields.io/packagist/dt/sergefenix/laravel-db-masked-dump.svg?style=flat-square)](https://packagist.org/packages/sergefenix/laravel-db-masked-dump)

## Installation

You can install the package via composer:

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
