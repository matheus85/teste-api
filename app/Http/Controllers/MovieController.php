<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends BaseController
{
    public function index()
    {
        $movies = Movie::with('ratings')->get();

        return $this->sendOk(null, $movies);
    }

    public function show($id)
    {
        $movie = Movie::with('ratings')->where('id', $id)->first();

        if (empty($movie)) {
            return $this->sendError('Movie not found.');
        }

        return $this->sendOk(null, $movie);
    }
}
