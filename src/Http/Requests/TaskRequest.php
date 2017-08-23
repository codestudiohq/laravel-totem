<?php

namespace Studio\Totem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'expression'    => 'required_if:type,expression|cron_expression',
            'frequencies'   => 'required_if:type,frequency|array',
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
            'expression.required_if'    => 'Cron Expression is required if task type is expression',
            'frequencies.required_if'   => 'At least one frequency is required',
            'frequencies.array'         => 'At least one frequency is required',
            'cron_expression'           => 'This is not a valid cron expression.',
        ];
    }
}
