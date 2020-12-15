<?php

namespace App\Http\Requests;

use App\Models\LabExeUser;
use App\Models\LabStudent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Factory as ValidationFactory;

class _StoreLabExeUserValidator extends FormRequest
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
            //'comment' => 'nullable|required_without:files|min:1',
            'comment' => [
                'nullable',
                $fileRule,
                'min:1',
            ],
            'student_id' => 'required',
            'status' => 'required'
            /*
            'upload_max_filesize' => 'max:32M',
            'post_max_size' => 'max:32M',
            'max_file_uploads' => 'max:10',
            'files.*' => 'nullable|file|max:10' . ini_get('post_max_size'),
            */
        ];

        // Waring, this is huck. On update model // TODO by id
        $model = LabStudent::find($this->input('id'));
        if ($model && count($model->labUserFiles)) {
            $key = array_search($fileRule, $rules['comment']);
            unset($rules['comment'][$key]);
        }

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
