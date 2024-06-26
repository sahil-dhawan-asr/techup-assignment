<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskAndNotesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "subject"=>"required|string|max:250|unique:tasks",
            "description"=>"required|string",
            "start_date"=>"required|date",
            "due_date"=>"required|date|after:start_date",
            "status"=>"required|in:New,Incomplete,Complete",
            'priority' => 'required|in:High,Medium,Low',
            'notes' => 'required|array',
            'notes.*.subject' => 'required|string|max:250',
            'notes.*.note' => 'required|string',
            'notes.*.attachments' => 'array',
            'notes.*.attachments.*' => 'file',
        ];
    }
}
