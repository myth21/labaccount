<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class _StoreLabFileValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Here check permission for form
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
            'lab_id' => 'required|int',
            'name' => 'required|min:1|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.min' => 'Название должно быть минимум 1 символ',
        ];
    }
}
