<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $rules = [
            'birthdate' => 'nullable|date|date_format:Y-m-d',
            'image' => 'nullable|mimes:' . config('services.allowed_file_extensions.images'),
        ];

        return $rules;
    }
}
