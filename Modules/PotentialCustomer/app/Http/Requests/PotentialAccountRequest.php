<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PotentialAccountRequest extends FormRequest
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


        $potentialAccount = $this->route('potential_account');
        if ($this->route()->getName() === 'potential_account.update') {
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
                        })->ignore($potentialAccount->id)
                ],
                'personal_number' => [
                    'required',
                    'string',
                    'min:11',
                    'max:15',
                    Rule::unique('lead_accounts', 'personal_number')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($potentialAccount->id)
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
                        })->ignore($potentialAccount->id)
                ],
                'website' => 'nullable|url',
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

                'starting_date' => 'nullable|date',
                'current_insurer' => 'nullable|in:yes,no',
                'utilization' => 'nullable|in:yes,no',
                'potential_premium' => 'nullable|numeric',
                'chance_of_sale' => 'nullable|integer|min:0|max:100',
                'price_range_min' => 'nullable|numeric|min:0',
                'price_range_max' => 'nullable|numeric|gte:price_range_min',
                'reason' => 'nullable|string|max:500',
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

                'starting_date' => 'nullable|date',
                'current_insurer' => 'nullable|in:yes,no',
                'utilization' => 'nullable|in:yes,no',
                'potential_premium' => 'nullable|numeric',
                'chance_of_sale' => 'nullable|integer|min:0|max:100',
                'price_range_min' => 'nullable|numeric|min:0',
                'price_range_max' => 'nullable|numeric|gte:price_range_min',
                'reason' => 'nullable|string|max:500',
            ];
        }
    }
}
