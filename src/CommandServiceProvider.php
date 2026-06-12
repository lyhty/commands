<?php

namespace Lyhty\Commands;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    private const string CONFIG_NAME = 'lyhty_commands';

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/' . self::CONFIG_NAME . '.php', 
            self::CONFIG_NAME
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        if (App::runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/' . self::CONFIG_NAME . '.php' => App::configPath(self::CONFIG_NAME . '.php'),
            ], 'lyhty-commands-config');

            $this->bootConsoleCommands();
        }
    }

    /**
     * Commands booter.
     */
    protected function bootConsoleCommands(): void
    {
        $config = Config::get(self::CONFIG_NAME, []);

        $activeCommands = Arr::where(
            $config, 
            fn (mixed $active): bool => $active === true
        );

        $this->commands(array_keys($activeCommands));
    }
}