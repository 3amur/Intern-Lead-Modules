<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SalesTargetRequest extends FormRequest
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
        return [
            'target_name' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s_@.-]+$/',
            'target_value' => 'required',
            'target_type_id' => 'required|array',
            'target_type_id.*' => 'exists:target_types,id',
            'sales_agent_id' => 'required|array',
            'sales_agent_id.*' => 'exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_calc_method' => 'nullable|string|in:separate,group',
            'notes' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s_@.-]+$/',
            'status' => 'required|string|in:active,inactive,draft',
            'from' => 'array',
            'to' => 'array',
            'percentage' => 'array',
            'from.*' => 'required',
            'to.*' => 'required',
            'percentage.*' => 'required|between:0,100',
        ];
    }
}
