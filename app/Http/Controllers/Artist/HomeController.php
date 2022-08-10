<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\CustomerCourse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $artist = auth('artist')->user();

        $myReview = starRatingsCalculator(Artist::class, $artist->id);

        $courses = $artist->courses()->count();

        $appointments = $artist->appointments()->count();

        $students = CustomerCourse::whereIn('course_id', $artist->courses()->pluck('id')->toArray())->count();

        return view('backend-artist.dashboard', compact('myReview', 'artist', 'courses', 'appointments', 'students'));
    }
}
