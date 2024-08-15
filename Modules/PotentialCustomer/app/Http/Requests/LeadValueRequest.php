<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LeadValueRequest extends FormRequest
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
        $leadValue = $this->route('lead_value');
        if ($this->route()->getName() === 'lead_value.update') {
            // Validation rules for update
            return [
                'title' => [
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[a-zA-Z0-9\s_@.-]+$/',

                    Rule::unique('lead_values', 'title')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($leadValue->id)
                ],
                'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'status' => 'required|string',
            ];
        } else {
            // Validation rules for store
            return [
                'title' => [
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[a-zA-Z0-9\s_@.-]+$/',

                    Rule::unique('lead_values', 'title')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })
                ],
                'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'status' => 'required|string',
            ];
        }
    }
}
