<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Artist as ResourcesArtist;
use App\Http\Resources\ArtistCollection;
use App\Models\Artist;
use App\Traits\ApiResponser;

class ArtistController extends Controller
{
    use ApiResponser;

    public function list()
    {
        $artists = Artist::all();
        return $this->successResponse(200, trans('api.public.done'), 200, new ArtistCollection($artists));
    }

    public function show(Artist $artist)
    {
        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesArtist($artist));
    }
}
