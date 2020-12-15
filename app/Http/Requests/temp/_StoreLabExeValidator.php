<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class _StoreLabExeValidator extends FormRequest
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
            'group_id' => 'nullable|int',
            'comment' => 'nullable|string',
            ///'status' => 'required|string',
        ];
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
