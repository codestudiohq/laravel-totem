<?php

namespace Studio\Totem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateTaskRequest extends FormRequest
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
            'description'   => 'required',
            'command'       => 'required',
            'cron'          => 'required_if:type,cron|cron_expression',
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
            'description.required'      => 'Task description is required',
            'command.required'          => 'Please select a command',
            'cron.required_if'          => 'Cron Expression is required if task type is Cron',
            'cron_expression'           => 'This is not a valid cron expression.',
        ];
    }
}
