<?php

namespace App\Http\Requests\Artist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class AddCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'dance' => 'required|exists:dances,id',
            'artist' => 'required|exists:artists,id',
            'videoType' => 'required|in:1,2',
            'courseLevel' => 'required|in:1,2,3',
            'promo_video' => ['nullable', new RequiredIf($this['fileuploader-list-gallery'] == json_encode([])), 'regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'video' => ['nullable', 'regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'price' => 'nullable',
            'duration' => 'required',
            'start_at' => 'nullable|date_format:Y-m-d\TH:i',
            'expire_at' => 'nullable|date_format:Y-m-d\TH:i',
            'fileuploader-list-image' => 'required',
            'fileuploader-list-gallery' => 'required_without:promo_video',
            'image' => new RequiredIf($this['fileuploader-list-image'] == json_encode([])) . '|mimes:' . config('services.allowed_file_extensions.images'),
            'gallery.*' => 'required_without:promo_video|mimes:' . config('services.allowed_file_extensions.images'),
        ];
    }

    public function messages()
    {
        return [
            'gallery.*.required' => 'At least one of (gallery or promo video) should be presented',
            'promo_video.required' => 'At least one of (gallery or promo video) should be presented',
        ];
    }
}
