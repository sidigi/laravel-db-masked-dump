<?php

namespace BeyondCode\LaravelMaskedDumper;

use BeyondCode\LaravelMaskedDumper\Console\DumpDatabaseCommand;
use Illuminate\Support\ServiceProvider;

class LaravelMaskedDumpServiceProvider extends ServiceProvider
{

    protected string $path = '/../config/masked-dump.php';

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.$this->path => config_path('masked-dump.php')], 'config');
        }
    }

    public function register()
    {
        $this->commands([DumpDatabaseCommand::class]);

        $this->mergeConfigFrom(__DIR__.$this->path, 'masked-dump');
    }
}
