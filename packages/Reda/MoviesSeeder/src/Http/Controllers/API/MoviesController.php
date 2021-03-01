<?php

namespace Reda\MoviesSeeder\Http\Controllers\API;

use Illuminate\Http\Request;
use Reda\MoviesSeeder\Models\Movie;
use Reda\MoviesSeeder\Models\Genre;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\GenreRepository;
use Reda\MoviesSeeder\Http\Requests\MovieRequest;
use Reda\MoviesSeeder\Http\Controllers\Controller;

class MoviesController extends Controller
{
    /**
     * Movies Repository object
     *
     * @var Tmdb\Repository\GenreRepository
     */
    protected $genresRepository;

    /**
     * Movies Repository object
     *
     * @var Tmdb\Repository\MovieRepository
     */
    protected $moviesRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Tmdb\Repository\MovieRepository  $moviesRepository
     * @param  \Tmdb\Repository\GenreRepository  $genresRepository
     * @return void
     */
    public function __construct(
        MovieRepository $moviesRepository,
        GenreRepository $genresRepository
    )
    {
        $this->moviesRepository = $moviesRepository;
        $this->genresRepository = $genresRepository;
    }

    /**
     * List all requested resources
     *
     * @param Reda\MoviesSeeder\Http\Requests\MovieRequest $request
     *
     * @return true
     */
    public function index(MovieRequest $request)
    {
        if ( isset($request->validator) && $request->validator->fails() )
        {
            return response()->json( $request->validator->messages(), 422 );
        }

        $movies = Movie::with('genres');

        if( $category_id = $request->category_id )
        {
            $movies->categoryid($category_id);
        }

        if( $request->popular )
        {
            $movies->popular($request->popular);
        }

        if( $request->rated )
        {
            $movies->rated($request->rated);
        }

        return response()->json($movies->paginate(10));
    }

    /**
     * Store topRated movies to database
     *
     * @param Int $limit
     *
     * @return true
     */
    public function store(Int $limit)
    {
        $total_pages = 1 ;

        if($limit > 20 )
        {
            $total_pages = floor( $limit/20 );
        }

        for( $i = 1; $i <= $total_pages; $i++ )
        {
            $this->retrieveList( $this->moviesRepository->getTopRated( [ 'page' =>  $i ] ) );
        }

        return true;
    }

    /**
     * Performs loop on given collection
     *
     * @param Array $collection
     *
     * @return true
     */
    private function retrieveList($collection)
    {
        foreach( $collection as $movie )
        {
            $data = [
                'tmdb_id'       =>  $movie->getId(),
                'title'         =>  $movie->getTitle(),
                'overview'      =>  $movie->getOverview(),
                'voteAverage'   =>  $movie->getVoteAverage(),
                'voteCount'     =>  $movie->getVoteCount(),
                'popularity'    =>  $movie->getPopularity(),
            ];

            $movieCreated = Movie::firstOrCreate(
                [   'tmdb_id' => $movie->getId()    ],
                $data
            );

            $genre_ids  = [];

            foreach( $movie->getGenres() as $genre )
            {

                $genreCreated = Genre::firstOrCreate([
                    'name' =>  $this->genresRepository->load(  $genre->getId() )->getName()
                ]);

                $genre_ids[]    =   $genreCreated->id;
            }

            $movieCreated->genres()->attach( $genre_ids );
        }
    }
}
