<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteArtist;
use App\Http\Resources\FavoriteArtistCollection;
use App\Http\Resources\FavoriteCourse;
use App\Http\Resources\FavoriteCourseCollection;
use App\Models\Artist;
use App\Models\Course;
use App\Models\Favorite;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ApiResponser;

    public function favoriteCourses()
    {
        $customer = auth()->user();

        $favoriteCourses = $customer->favoriteCourses;

        return $this->successResponse(200, trans('api.public.done'), 200, new FavoriteCourseCollection($favoriteCourses));
    }

    public function favoriteArtists()
    {
        $customer = auth()->user();

        $favoriteArtists = $customer->favoriteArtists;

        return $this->successResponse(200, trans('api.public.done'), 200, new FavoriteArtistCollection($favoriteArtists));
    }

    public function addArtist(Artist $artist)
    {
        $customer = auth()->user();

        $isExist = Favorite::where([
            'customer_id' => $customer->id,
            'favourable_type' => Artist::class,
            'favourable_id' => $artist->id,
        ])->count();

        if (!$isExist) {
            $favorite = new Favorite();
            $favorite->customer_id = $customer->id;
            $favorite->favourable_type = Artist::class;
            $favorite->favourable_id  = $artist->id;
            $favorite->save();

            return $this->successResponse(200, trans('api.public.done'), 200, new FavoriteArtist($favorite));
        }

        return $this->successResponse(200, trans('api.public.done'), 200);
    }

    public function addCourse(Course $course)
    {
        $customer = auth()->user();

        $isExist = Favorite::where([
            'customer_id' => $customer->id,
            'favourable_type' => Course::class,
            'favourable_id' => $course->id,
        ])->count();

        if (!$isExist) {
            $favorite = new Favorite();
            $favorite->customer_id = $customer->id;
            $favorite->favourable_type = Course::class;
            $favorite->favourable_id  = $course->id;
            $favorite->save();

            return $this->successResponse(200, trans('api.public.done'), 200, new FavoriteCourse($favorite));
        }

        return $this->successResponse(200, trans('api.public.done'), 200);
    }

    public function delete(Request $request)
    {
        $customer = auth()->user();

        Favorite::where([
            'customer_id' => $customer->id,
            'favourable_type' => ($request->favorite_type == 'course') ? Course::class : Artist::class,
            'favourable_id' => $request->favorite_type_id
        ])->delete();

        return $this->successResponse(200, trans('api.public.done'), 200);
    }
}
