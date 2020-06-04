<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */

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

        $types = config('item.types');
        $effort = config('item.effort_points');
        $statuses = config('item.statuses');

        return [
            'type' => 'required|string|in:' . implode(',', $types),
            'title' => 'required|string',
            'effort' => 'integer|in:' . implode(',', $effort),
            'description' => 'string',
            'status' => 'string|in:' . implode(',', $statuses),
            'acceptance_criteria' => 'string',
            'assignee_id' => 'integer',
            'reporter_id' => 'required|integer',
            'priority' => 'integer'
        ];
    }
}
