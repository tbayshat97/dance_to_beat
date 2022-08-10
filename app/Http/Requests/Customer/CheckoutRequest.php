<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'type' => 'required|in:order,subscription,appointment',
            'id' =>  $this->checkId($this['type'])
        ];
    }

    protected function checkId($type)
    {
        switch ($type) {
            case 'order':
                return 'required|exists:orders,id';
                break;
            case 'subscription':
                return 'required|exists:customer_subscriptions,id';
                break;
            case 'appointment':
                return 'required|exists:appointments,id';
                break;
            default:
                return 'required|required_with:type';
                break;
        }
    }
}
