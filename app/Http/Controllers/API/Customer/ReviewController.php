<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckReviewRequest;
use App\Http\Requests\Customer\ReviewRequest;
use App\Http\Resources\Review as ResourcesReview;
use App\Models\Artist;
use App\Models\Course;
use App\Models\Review;
use App\Traits\ApiResponser;

class ReviewController extends Controller
{
    use ApiResponser;

    public function store(ReviewRequest $request)
    {
        $review = new Review();
        $review->customer_id = auth()->user()->id;
        $review->reviewable_type = ($request->rate_type == 'course') ? Course::class : Artist::class;
        $review->reviewable_id = intval($request->rate_type_id);
        $review->rate = $request->rate;
        $review->note = trim($request->note);
        $review->save();

        if ($request->rate_type == 'course') {
            $course = $review->reviewable;
            $courseRate = starRatingsCalculator(Course::class, $course->id);
            $course->rate = $courseRate['total'];
            $course->save();
        }

        return $this->successResponse(200, trans('api.public.done'), 200, []);
    }

    public function checkReview(CheckReviewRequest $request)
    {
        $review = Review::where('customer_id', auth()->user()->id)
            ->where('reviewable_type', ($request->rate_type == 'course') ? Course::class : Artist::class)
            ->where('reviewable_id', intval($request->rate_type_id));

        return $this->successResponse(200, trans('api.public.done'), 200, [
            'is_review' => ($review->count() > 0) ? true : false,
            'review' => ($review->count() > 0) ? new ResourcesReview($review->first()) : null,
        ]);
    }
}
