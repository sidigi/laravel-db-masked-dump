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
        ->table('users', function (TableDefinition $table) {
            $table->replace('name', function (Faker $faker) {
                return $faker->name;
            });

            $table->replace('email', function (Faker $faker) {
                return $faker->safeEmail;
            }, false);

            $table->replaceWhere('updated_at', function (Faker $faker) {
                return $faker->safeEmail;
            }, function ($value) {
                if ($value == null) {
                    return true;
                }

                return false;
            });

            $table->mask('password');
        })
        ->schemaOnly('failed_jobs')
        ->schemaOnly('password_resets'),
];
