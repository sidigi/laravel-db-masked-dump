<?php

use BeyondCode\LaravelMaskedDumper\DumpSchema;
use BeyondCode\LaravelMaskedDumper\TableDefinitions\TableDefinition;
use Faker\Generator as Faker;

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

            $table->replace('email', $faker->safeEmail, false);

            $table->whenReplace('updated_at', function ($value) {
                return (bool) $value;
            }, $faker->safeEmail);

            $table->replace('updated_at', function (Faker $faker, $value, $rows) {
                if ($rows['created_at']) {
                    return $value;
                }

                return now();
            });

            $table->mask('password');
        })
        ->schemaOnly('failed_jobs')
        ->schemaOnly('password_resets'),
];
