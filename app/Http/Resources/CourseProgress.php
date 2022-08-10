<?php

namespace App\Http\Resources;

use App\Enums\CourseProgressStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseProgress extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $progressStatus = CourseProgressStatus::fromValue($this->status);

        return [
            'id' => $this->id,
            'course_obj' => Course::make($this->course),
            'duration' => $this->id,
            'percentage' => $this->id,
            'status' => [
                'key' => $progressStatus->key,
                'name' => $progressStatus->description,
                'value' => $progressStatus->value,
            ],
        ];
    }
}
