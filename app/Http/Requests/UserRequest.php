<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users',
                    'password' => 'string|min:6|confirmed',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required|string|min:5',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore($this->segment(2)),
                    ],
                    'password' => 'nullable|string|min:6|confirmed',
                ];
                break;
            default:
                return [];
                break;
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
