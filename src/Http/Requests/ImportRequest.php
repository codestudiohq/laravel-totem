<?php

namespace Studio\Totem\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImportRequest extends FormRequest
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
            'tasks' => 'required|file|jsonFile',
            'content' => 'json',
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
            'tasks.required'    => 'Please select a file to import',
            'tasks.file'    => 'Please select a file to import',
            'tasks.json_file'    => 'Please select a json file',
            'content' => 'File does not contain valid json',
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param  array|mixed  $keys
     * @return array
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function all($keys = null)
    {
        $content = '';

        if ($jsonFile = $this->file('tasks')) {
            $content = $jsonFile->get();
        }

        return array_merge(parent::all($keys), compact('content'));
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function validated()
    {
        $content = '';

        if ($jsonFile = $this->file('tasks')) {
            $content = $jsonFile->get();
        }

        return array_merge(parent::validated(), compact('content'));
    }

    /**
     * * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
