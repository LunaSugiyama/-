<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'username'=>'',
            'email'=>'required|email:filter|exists:users,email',
            'name'=>'',
            'password'=>''
        ];
    }
    public function messages()
    {
        return[
            'email.required'=>"enter your :attribute",
            'email.email'=>'enter correct email',
            'email.exists'=>'this email is not registered'
        ];
    }
    public function attributes()
    {
        return [
            'email'=>'email address',
        ];
    }
}
