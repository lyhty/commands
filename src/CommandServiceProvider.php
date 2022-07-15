<?php

namespace Lyhty\Commands;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    const CONFIG = 'lyhty_commands';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/'.static::CONFIG.'.php', static::CONFIG);
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/'.static::CONFIG.'.php' => config_path(static::CONFIG.'.php'),
        ]);

        $this->bootConsoleCommands();
    }

    /**
     * Commands booter.
     *
     * @return void
     */
    protected function bootConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $commands = Arr::where($this->app['config'][static::CONFIG], function ($active) {
                return $active === true;
            });

            // If spatie query builder package exists.
            if (! interface_exists('Spatie\QueryBuilder\Sorts\Sort')) {
                unset($commands[QuerySortMakeCommand::class]);
            }

            if (! interface_exists('Spatie\QueryBuilder\Filters\Filter')) {
                unset($commands[QueryFilterMakeCommand::class]);
            }

            $this->commands(array_keys($commands));
        }
    }
}
