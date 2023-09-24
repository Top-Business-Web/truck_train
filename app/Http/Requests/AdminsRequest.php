<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminsRequest extends FormRequest
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
            'name' =>'required|string',
            'email' =>'required|email|unique:admins,email,'.$this->id,
            'phone' =>'required',
            //'password' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('validationMessages.nameRequired'),
            'email.required' => __('validationMessages.emailRequired'),
            'phone.required' => __('validationMessages.phoneRequired'),
            //'password.required' => __('validationMessages.passwordRequired'),
        ];
    }
}
