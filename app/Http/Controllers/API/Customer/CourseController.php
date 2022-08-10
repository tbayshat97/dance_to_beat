<?php

namespace App\Http\Controllers\API\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course as ResourcesCourse;
use App\Http\Resources\CourseCollection;
use App\Models\Course;
use App\Models\Order;
use App\Traits\ApiResponser;
use Carbon\Carbon;

class CourseController extends Controller
{
    use ApiResponser;

    public function live()
    {
        $courses = Course::where([
            'is_published' => true
        ])->whereHas('live')->get();

        return $this->successResponse(200, trans('api.public.done'), 200, new CourseCollection($courses));
    }

    public function recorded()
    {
        $courses = Course::where([
            'is_published' => true
        ])->whereDoesntHave('live')->get();

        return $this->successResponse(200, trans('api.public.done'), 200, new CourseCollection($courses));
    }

    public function recommended()
    {
        $customer = auth()->user();
        $dancesId = $customer->interests()->count() ? $customer->interests()->pluck('dance_id')->toArray() : [];

        $query = Course::query();

        if (count($dancesId)) {
            $query->where('is_published', true);

            $query->whereIn('dance_id', $dancesId);
        } else {
            $query->inRandomOrder()->limit(5);
        }

        $courses = $query->get();

        return $this->successResponse(200, trans('api.public.done'), 200, new CourseCollection($courses));
    }

    function trending()
    {
        $tendingCoursesIds = Order::where('status', OrderStatus::Paid)->where('created_at', '>=' ,Carbon::now()->subMonths(1))->pluck('course_id')->toArray();

        $courses = Course::where([
            'is_published' => true
        ])->whereIn('id', $tendingCoursesIds)->get();

        return $this->successResponse(200, trans('api.public.done'), 200, new CourseCollection($courses));
    }

    public function show(Course $course)
    {
        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCourse($course));
    }
}
