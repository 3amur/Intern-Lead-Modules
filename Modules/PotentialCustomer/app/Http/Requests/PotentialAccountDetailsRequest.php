<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PotentialAccountDetailsRequest extends FormRequest
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
        request()->merge([
            'potential_premium' => floatval(str_replace(',', '',request('potential_premium'))),
            'price_range_min' => floatval(str_replace(',', '', request('price_range_min'))),
            'price_range_max' => floatval(str_replace(',', '', request('price_range_max'))),
        ]);

      return [
        [
            'starting_date' => 'nullable|date',
            'current_insurer' => 'nullable|in:yes,no',
            'utilization' => 'nullable|in:yes,no',
            'potential_premium' => 'nullable|numeric',
            'chance_of_sale' => 'nullable|integer|min:0|max:100',
            'price_range_min' => 'nullable|numeric|min:0',
            'price_range_max' => 'nullable|numeric|gte:price_range_min',
            'reason' => 'nullable|string|max:500',
        ]
      ];
    }
}
