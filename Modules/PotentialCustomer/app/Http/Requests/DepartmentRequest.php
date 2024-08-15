<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
        $department = $this->route('department');
        if ($this->route()->getName() === 'departments.update') {
            // Validation rules for update
            return [
                'title' => [
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[a-zA-Z0-9\s_@.-]+$/',
                    Rule::unique('departments', 'title')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($department->id)
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
                    Rule::unique('departments', 'title')
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
