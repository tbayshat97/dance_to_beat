<?php

namespace App\Http\Controllers\API\Customer;

use App\Enums\CourseLevel;
use App\Enums\CourseType;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\DanceCollection;
use App\Models\Course;
use App\Models\Dance;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use ApiResponser;

    public function searchAttributes()
    {
        $data = [
            'sort' => [
                'asc' => trans('api.search.asc'),
                'desc' => trans('api.search.desc'),
            ],
            'level' => CourseLevel::asSelectArray(),
            'dances' => new DanceCollection(Dance::all()),
            'price_range' => [
                'min' => Course::min('price'),
                'max' => Course::max('price'),
            ],
            'ratings' => [1, 2, 3, 4, 5],
            'type_of_classes' => CourseType::asSelectArray(),
        ];

        return $this->successResponse(200, trans('api.public.done'), 200, $data);
    }

    public function search(Request $request)
    {
        $searchQuery = Course::query();

        $searchQuery->where('is_published', true);

        if ($request->filled('type') && intval($request->type) == CourseType::Recorded) {
            $searchQuery->whereDoesntHave('live');
        }

        if ($request->filled('type') && intval($request->type) == CourseType::Live) {
            $searchQuery->whereHas('live');
        }

        if ($request->filled('title')) {
            $searchQuery->whereTranslationLike('title', '%' . $request->title . '%');
        }

        if ($request->filled('level')) {
            $searchQuery->where('course_level', intval($request->level));
        }

        if ($request->filled('dances')) {
            $searchQuery->whereIn('dance_id', $request->dances);
        }

        if ($request->filled('priceFrom') && $request->filled('priceTo')) {
            $searchQuery->whereBetween('price', [$request->priceFrom - 1, $request->priceTo + 1]);
        }

        if ($request->filled('rate')) {
            $searchQuery->where('rate', $request->rate);
        }

        if ($request->filled('sort')) {
            $searchQuery->orderBy('price', $request->sort);
        }

        $courses = $searchQuery->get();

        return $this->successResponse(200, trans('api.public.done'), 200, new CourseCollection($courses));
    }
}
