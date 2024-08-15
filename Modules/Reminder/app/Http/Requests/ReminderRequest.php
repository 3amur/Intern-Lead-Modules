<?php

namespace Modules\Reminder\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'reminder_title' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s_@.-]+$/',
            'reminder_start_date' => 'required|date',
            'reminder_end_date' => 'required|date|after:reminder_start_date',
            'description' => 'nullable|string|max:2000|regex:/^[a-zA-Z0-9\s_@.-]+$/',
            'reminder_relation' => 'nullable|string|max:100',
            'reminder_type' => 'required|string|max:100',
            'lead_id' => 'nullable|numeric',
            'status' => 'required|string',
        ];

        if ($this->input('reminder_type') == 'call') {
            $rules += [
                'name.*' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'email.*' => [
                    'nullable',
                    'email',
                    'max:100',
                    Rule::unique('contacts', 'email')
                        ->where('deleted_at', NULL)
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        }),
                ],
                'phone.*' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('phones', 'phone')
                        ->where('deleted_at', NULL)
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        }),
                ],
                'status' => 'required',
            ];
        }

        return $rules;
    }
}
