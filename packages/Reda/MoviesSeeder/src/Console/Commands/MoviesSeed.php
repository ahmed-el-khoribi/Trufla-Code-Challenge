<?php

namespace Reda\MoviesSeeder\Console\Commands;

use Illuminate\Console\Command;

class MoviesSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:seed
                            {limit} : The number of records to be seeded';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds Movies for TMDB, with time interval, and number of movies to be seeded.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if( !is_numeric( $this->argument('limit') ) )
        {
            $this->error('Limit must be a number...');

            return 0;
        }

        $limit = (int) $this->argument('limit');

        $this->line('Movies Seeder started to seed ' . $limit . ' Items');

        app('Reda\MoviesSeeder\Http\Controllers\API\MoviesController')->store( $limit );

        $this->info('The data is seeded successful!');

        return 0;
    }
}
