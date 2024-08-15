<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesCommissionRequest extends FormRequest
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
            'amount_from'=>'required|array',
            'amount_to'=>'required|array',
            'percent'=>'required|array',
            'amount_from.*' => ['required'],
            'amount_to.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    $index = str_replace('amount_to.', '', $attribute);
                    $amountFrom = $this->input("amount_from.$index");

                    if ($amountFrom > $value) {
                        $fail("The amount from must be less than or equal to the amount to.");
                    }
                },
            ],
            'percent.*' => 'required|numeric|between:0,100',
            "title" => 'required|string|min:3|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            "notes" => 'nullable|string|max:500',
        ];
    }
}
