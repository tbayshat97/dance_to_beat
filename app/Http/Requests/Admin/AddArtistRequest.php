<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddArtistRequest extends FormRequest
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
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'percentage'=>'required|min:0|integer',
            'password' => 'nullable|min:6|confirmed'
        ];
    }
}
