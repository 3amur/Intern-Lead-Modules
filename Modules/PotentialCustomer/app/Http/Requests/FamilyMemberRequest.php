<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberRequest extends FormRequest
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
        $familyMember = $this->route('family_member');
        if ($this->route()->getName() === 'family_members.update') {
            // Validation rules for update
            return [
                'name'=>'required|string|min:3|max:150|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'phone'=>'required|string|max:15',
                'birth_date'=>'required|date',
                'national_id'=>[
                    'required',
                    'numeric',
                    Rule::unique('lead_accounts', 'account_national_id')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        })->ignore($familyMember->id),
                    Rule::unique('family_members', 'national_id') ->where(function ($query) {
                        return $query->where('created_by', auth()->id());
                    })->ignore($familyMember->id),
                ],
                'national_id_card'=>'required|image|max:2048|mimes:png,jpg,jpeg',
                'personal_image'=>'required|image|max:2048|mimes:png,jpg,jpeg',
            ];
        } else {
            // Validation rules for store
            return [
                'name'=>'required|string|min:3|max:150|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'phone'=>'required|string|max:15',
                'birth_date'=>'required|date',
                'national_id'=>[
                    'required',
                    'numeric',
                    Rule::unique('lead_accounts', 'account_national_id')
                        ->whereNull('deleted_at')
                        ->where(function ($query) {
                            return $query->where('created_by', auth()->id());
                        }),
                    Rule::unique('family_members', 'national_id') ->where(function ($query) {
                        return $query->where('created_by', auth()->id());
                    }),
                ],
                'national_id_card'=>'required|image|max:2048|mimes:png,jpg,jpeg',
                'personal_image'=>'required|image|max:2048|mimes:png,jpg,jpeg',

            ];
        }
    }
}
