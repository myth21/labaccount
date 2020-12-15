<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabStudentExeValidator extends FormRequest
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
        $fileRule = 'required_without:files';
        $rules = [
            'comment' => [
                'nullable',
                $fileRule,
                'min:1',
            ],
            'student_id' => 'required',
            'status' => 'required',
            'files.*' => 'nullable|file|max:10' . ini_get('post_max_size'),
        ];

        /*
        if ($this->input('isFiles')) {
            $key = array_search($fileRule, $rules['comment']);
            unset($rules['comment'][$key]);
        }
        */

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'comment.required_without' => 'Comment is required if files are missing',
            'student_id.required' => 'The student(s) is required',
        ];
    }
}
