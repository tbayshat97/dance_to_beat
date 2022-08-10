<?php

namespace App\Http\Requests\Artist;

use Illuminate\Foundation\Http\FormRequest;

class AddAvailableTime extends FormRequest
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
            'available_times.*.available_times_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'available_times.*.available_times_time.required' => 'Please check all fields if they enterd correctly',
        ];
    }
}
