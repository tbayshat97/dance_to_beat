<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseProgressCollection;
use App\Http\Resources\ReviewCollection;
use App\Traits\ApiResponser;

class DashboardController extends Controller
{
    use ApiResponser;

    public function dashboard()
    {
        $customer = auth()->user();

        $result = [
            'artists_reviews_count' => $customer->artistsReviews()->count(),
            'artists_reviews' => new ReviewCollection($customer->artistsReviews),
            'progresses' => new CourseProgressCollection($customer->progresses),
        ];

        return $this->successResponse(200, trans('api.public.done'), 200, $result);
    }
}
