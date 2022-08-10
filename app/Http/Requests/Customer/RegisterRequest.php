<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|unique:customers',
            'email' => 'required|unique:customers',
            'password' => 'required|min:6',
            'rpassword' => 'required|same:password',
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'nullable|mimes:' . config('services.allowed_file_extensions.images'),
            'birthdate' => 'nullable|date|date_format:Y-m-d',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'username.required' => 'The phone number is required.',
            'username.unique' => 'The phone number has already been taken.',
        ];
    }
}
