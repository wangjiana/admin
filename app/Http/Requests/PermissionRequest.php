<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
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
                    'name' => 'required|string|unique:permissions'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => [
                        'required',
                        'string',
                        Rule::unique('permissions')->ignore($this->segment(2)),
                    ]
                ];
                break;
            default:
                return [];
                break;
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '权限名称',
        ];
    }
}
