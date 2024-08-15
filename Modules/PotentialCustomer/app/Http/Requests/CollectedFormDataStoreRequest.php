<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CollectedFormDataStoreRequest extends FormRequest
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
        //dd(request());
        $array = [
            'head_personal_image'=>'required|image|max:2048|mimes:png,jpg,jpeg',
            'head_national_id_card.*'=>'required|image|max:2048|mimes:png,jpg,jpeg',
            'head_name'=> 'required|string|min:3|max:150|regex:/^[a-zA-Z0-9\s_@.-]+$/',
            'head_phone'=> 'required|string|max:15',
            'head_birth_date'=>'required|date',
            'head_national_id'=>[
                'nullable',
                'numeric',
                Rule::unique('head_family_members', 'head_national_id')
                    ->whereNull('deleted_at')
                    ->where(function ($query) {
                        return $query;
                    }),
                Rule::unique('family_members', 'national_id') ->where(function ($query) {
                    return $query;
                }),
                'required_if:head_passport_id,null',
            ],
            'head_passport_id'=>[
                'nullable',
                'numeric',
                Rule::unique('head_family_members', 'head_national_id')
                    ->whereNull('deleted_at')
                    ->where(function ($query) {
                        return $query;
                    }),
                Rule::unique('family_members', 'national_id') ->where(function ($query) {
                    return $query;
                }),
                'required_if:head_national_id,null',
            ],

        ];


        if(request()->name)
        {
            foreach(request('name') as $key => $value)
            {
                $array['name.'.$key] = 'required|string|min:3|max:150|regex:/^[a-zA-Z0-9\s_@.-]+$/';
                $array['phone.'.$key]= 'required|string|max:15';
                $array['birth_date.'.$key]='required|date';
                $array['national_id'] = 'required|array';
                $array['national_id.'.$key]= [
                    'nullable',
                    'required_if:passport_id,null',
                    'numeric',
                    Rule::unique('head_family_members', 'head_national_id')
                        ->whereNull('deleted_at')
                        ->where(function ($query) use ($key) {
                            return $query->where('id', '!=', $key); // Exclude current record from unique check
                        }),
                    Rule::unique('family_members', 'national_id')
                        ->where(function ($query) use ($key) {
                            return $query->where('id', '!=', $key); // Exclude current record from unique check
                        }),
                    Rule::requiredIf(function () use ($key) {
                        return request('passport_id.'.$key) === null;
                    }),
                ];
                $array['passport_id.'.$key]= [
                    'nullable',
                    'required_if:national_id,null',
                    'string',
                    Rule::unique('head_family_members', 'head_national_id')
                        ->whereNull('deleted_at')
                        ->where(function ($query) use ($key) {
                            return $query->where('id', '!=', $key); // Exclude current record from unique check
                        }),
                    Rule::unique('family_members', 'national_id')
                        ->where(function ($query) use ($key) {
                            return $query->where('id', '!=', $key); // Exclude current record from unique check
                        }),
                    Rule::requiredIf(function () use ($key) {
                        return request('national_id.'.$key) === null;
                    }),
                ];

                // Assuming 'national_id_card_' and 'personal_image' are arrays of uploaded files
                $array["national_id_card_$key"]='required|array';
                $array["national_id_card_$key.*"] = 'max:2048|image|mimes:png,jpg,jpeg';
                $array["personal_image.$key"] = 'required|image|max:2048|mimes:png,jpg,jpeg';
            }
        }

        return $array;
    }
}
