<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'required' => __('auth.messages.failed.required'),
            'email.unique' => __('auth.messages.failed.unique_email'),
            'email' => __('auth.messages.failed.email'),
            'string' => __('auth.messages.failed.string')
        ];
    }
}
