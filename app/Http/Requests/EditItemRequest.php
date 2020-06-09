<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditItemRequest extends FormRequest
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
            'type' => 'string|in:' . implode(',', config('item.types')),
            'title' => 'string',
            'effort' => 'integer|in:' . implode(',', config('item.effort_points')),
            'description' => 'string',
            'status' => 'string|in:' . implode(',', config('item.statuses')),
            'acceptance_criteria' => 'string',
            'assignee_id' => 'integer',
            'reporter_id' => 'integer',
            'priority' => 'integer'
        ];
    }
}
