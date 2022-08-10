<?php

namespace App\Http\Resources;

use App\Enums\CourseAccessType;
use App\Enums\CourseLevel;
use App\Enums\CourseType;
use App\Enums\VideoType;
use App\Models\Course as ModelsCourse;
use Illuminate\Http\Resources\Json\JsonResource;

class Course extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $course_level = CourseLevel::fromValue($this->course_level);
        $course_type = $this->live ? CourseType::fromValue(CourseType::Live) : CourseType::fromValue(CourseType::Recorded);
        $video_type = VideoType::fromValue($this->video_type);
        $access_type = $this->live ? CourseAccessType::fromValue(CourseAccessType::Buy) : CourseAccessType::fromValue(CourseAccessType::Subscribe);
        $customer = auth()->user();

        return [
            'course_id' => $this->id,
            'course_artist' => $this->artist->profile->fullName,
            'course_artist_id' => $this->artist->id,
            'course_title' => $this->translateOrDefault()->title,
            'course_content' => $this->translateOrDefault()->description,
            'course_dance' => Dance::make($this->dance),
            'course_price' => $this->price,
            'course_image' => $this->getCourseImage(),
            'course_gallery' => $this->getCourseGallery(),
            'course_promo_video_url' => $this->promo_video,
            'course_video_url' => $this->video,
            'course_join_url' => $this->live ? $this->live->join_url : null,
            'course_participant_video' => $this->live ? $this->live->participant_video : null,
            'course_mute_upon_entry' => $this->live ? $this->live->mute_upon_entry : null,
            'course_duration' => $this->duration,
            'course_start_at' => $this->start_at->format('Y-m-d H:m'),
            'course_expire_at'  => $this->expire_at->format('Y-m-d H:m'),
            'course_course_level' => [
                'key' => $course_level->key,
                'name' => $course_level->description,
                'value' => $course_level->value,
            ],
            'course_course_type' => [
                'key' => $course_type->key,
                'name' => $course_type->description,
                'value' => $course_type->value,
            ],
            'course_video_type' => [
                'key' => $video_type->key,
                'name' => $video_type->description,
                'value' => $video_type->value,
            ],
            'course_access_type' => [
                'key' => $access_type->key,
                'name' => $access_type->description,
                'value' => $access_type->value,
            ],
            'course_reviews' => starRatingsCalculator(ModelsCourse::class, $this->id),
            'course_is_bought' => $this->live ? in_array($this->id, $customer->courses()->pluck('course_id')->toArray()) : null,
        ];
    }
}
