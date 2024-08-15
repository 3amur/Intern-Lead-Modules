<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BrokerRequest extends FormRequest
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
        $broker = $this->route('broker');
        if ($this->route()->getName() === 'brokers.update') {
            // Validation rules for update
            return [
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
                'name' => 'required|string|max:100|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'email' => [
                    'email',
                    Rule::unique('brokers', 'email')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($broker->id)
                ],

                'phone' => [
                    'required',
                    'string',
                    'min:11',
                    'max:15',
                    Rule::unique('lead_accounts', 'mobile')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($broker->id)
                ],

                'broker_type_id' => 'required|integer',
                'status' => 'required|string',
            ];
        } else {
            // Validation rules for store
            return [
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
                'name' => 'required|string|max:100|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'email' => [
                    'email',
                    Rule::unique('brokers', 'email')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })
                ],
                'phone' => [
                    'required',
                    'string',
                    'min:11',
                    'max:15',
                    Rule::unique('lead_accounts', 'mobile')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })
                ],
                'broker_type_id' => 'required|integer',
                'status' => 'required|string',
            ];
    }
}
}
