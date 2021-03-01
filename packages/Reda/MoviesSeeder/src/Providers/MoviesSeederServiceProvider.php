<?php

namespace Reda\MoviesSeeder\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Reda\MoviesSeeder\Console\Commands\MoviesSeed;

/**
* Movies Seeder Service Provider
*
* @copyright 2021 Reda (reda19952013@gmail.com)
*/
class MoviesSeederServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap services.
    *
    * @return void
    */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->registerCommands();

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('movies:seed 100')->everyMinute();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Register the console commands of this package
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MoviesSeed::class
            ]);
        }
    }
}
