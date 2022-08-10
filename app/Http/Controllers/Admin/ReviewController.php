<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Artist;

class ReviewController extends Controller
{

    public function courses() {
        $courses = Course::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Courses Reviews"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.reviews.course-list', compact('breadcrumbs', 'pageConfigs', 'courses'));
    }

    public function artists() {
        $artists = Artist::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Reviews"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $artists = Artist::all();

        return view('backend.reviews.artist-list', compact('breadcrumbs', 'pageConfigs', 'artists'));
    }

    public function showCourse(Course $course) {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/reviews-courses", 'name' => "Courses Reviews"], ['name' => "Update"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.reviews.course-show', compact('course', 'breadcrumbs', 'pageConfigs'));
    }

    public function showArtist(Artist $artist) {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/reviews-artists", 'name' => "Artists Reviews"], ['name' => "Update"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.reviews.artist-show', compact('artist', 'breadcrumbs', 'pageConfigs'));
    }
}
