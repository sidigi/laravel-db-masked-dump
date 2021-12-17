<?php

use Faker\Generator as Faker;
use FenixDumper\LaravelMaskedDumper\DumpSchema;
use FenixDumper\LaravelMaskedDumper\TableDefinitions\TableDefinition;

return [
    /**
     * Use this dump schema definition to remove, replace or mask certain parts of your database tables.
     */
    'default' => DumpSchema::define()
        ->allTables()
        ->table('users', function (TableDefinition $table, Faker $faker) {
            $table->replace('name', function (Faker $faker) {
                return $faker->name;
            });

            $table
                ->ignore(['1'])
                ->disableConstrain()
                ->replace('email', $faker->safeEmail, false)
                ->mask('password');

            $table->replaceWhen('updated_at', now()->addDay(), function ($value) {
                return (bool) $value;
            });

            $table->replace('updated_at', function (Faker $faker, $value, $rows) {
                if ($rows['created_at']) {
                    return $value;
                }

                return now();
            });
        })
        ->schemaOnly('failed_jobs')
        ->schemaOnly('password_resets')
        ->priorityTables(['password_resets']),
];
