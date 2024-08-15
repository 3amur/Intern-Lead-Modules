<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LeadAccountRequest extends FormRequest
{

    //test for repo
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
        $leadAccount = $this->route('lead_account');
        if ($this->route()->getName() === 'lead_account.update') {
            // Validation rules for update
            return [
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
                'account_name' => 'required|string|max:100|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'account_contact_name'=>'required|string|max:100|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'lead_account_title' => 'nullable|string|max:100|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('lead_accounts', 'email')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($leadAccount->id)
                ],
                'website' => 'nullable|url',
                'personal_number' => [
                    'required',
                    'string',
                    'min:11',
                    'max:15',
                    Rule::unique('lead_accounts', 'personal_number')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($leadAccount->id)
                ],
                'mobile' => [
                    'nullable',
                    'string',
                    'min:11',
                    'max:15',
                    Rule::unique('lead_accounts', 'mobile')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($leadAccount->id)
                ],
                'phone' => 'nullable|string|min:7|max:15',
                'lead_source_id' => 'required|integer',
                'lead_status_id' => 'required|integer',
                'lead_value_id' => 'required|integer',
                'lead_type_id' => 'required|integer',
                'country_id' => 'required|integer',
                'state_id' => 'required|integer',
                'city_id' => 'required|integer',
                'zip_code' => 'nullable|string|max:10|min:5',
                'address' => 'nullable|string|max:500|min:3|regex:/^[a-zA-Z0-9\s_@.,-]+$/',
                'notes' => 'nullable|string|max:500|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'status' => 'required|string',
            ];
        } else {
            // Validation rules for store
            return [
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
                'account_name' => 'required|string|max:100|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'account_contact_name'=>'required|string|max:100|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'lead_account_title' => 'nullable|string|max:100|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('lead_accounts', 'email')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })
                ],
                'website' => 'nullable|url',
                'personal_number' => [
                    'required',
                    'string',
                    'min:11',
                    'max:15',
                    Rule::unique('lead_accounts', 'personal_number')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })
                ],
                'mobile' => [
                    'nullable',
                    'string',
                    'min:11',
                    'max:15',
                    Rule::unique('lead_accounts', 'mobile')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })
                ],
                'phone' => 'nullable|string|min:7|max:15',
                'lead_source_id' => 'required|integer',
                'lead_status_id' => 'required|integer',
                'lead_value_id' => 'required|integer',
                'lead_type_id' => 'required|integer',
                'country_id' => 'required|integer',
                'state_id' => 'required|integer',
                'city_id' => 'required|integer',
                'zip_code' => 'nullable|string|max:10|min:5',
                'address' => 'nullable|string|max:500|min:3|regex:/^[a-zA-Z0-9\s_@.,-]+$/',
                'notes' => 'nullable|string|max:500|min:3|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'status' => 'required|string',
            ];
        }
    }
}

