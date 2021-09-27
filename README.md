# Laravel DB Masked Dump
[![Total Downloads](https://img.shields.io/packagist/dt/sergefenix/laravel-db-masked-dump.svg?style=flat-square)](https://packagist.org/packages/sergefenix/laravel-db-masked-dump)

A database dumping package that allows you to replace and mask columns while dumping your database.

You can :
* Replace
* Ignore
* Mask
* Create rule for replace
* Get schema or full dump

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
