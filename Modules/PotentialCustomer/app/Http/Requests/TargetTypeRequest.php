<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TargetTypeRequest extends FormRequest
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
        $targetType = $this->route('target_type');
        if ($this->route()->getName() === 'target_types.update') {
            // Validation rules for update
            return [
                'title' =>[
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[a-zA-Z0-9\s_@.-]+$/',
                    Rule::unique('target_types', 'title')
                    ->whereNull('deleted_at')
                    ->where(function ($query) {
                        return $query->where('created_by', auth()->id());
                    })->ignore($targetType->id)
            ],

                'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
                'status' => 'required|string',
            ];
        } else {
            // Validation rules for store
            return [
                'title' =>[
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[a-zA-Z0-9\s_@.-]+$/',
                    Rule::unique('target_types', 'title')
                    ->whereNull('deleted_at')
                    ->where(function ($query) {
                        return $query->where('created_by', auth()->id());
                    })
            ],                'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
                'status' => 'required|string',
            ];
        }

    }
}
