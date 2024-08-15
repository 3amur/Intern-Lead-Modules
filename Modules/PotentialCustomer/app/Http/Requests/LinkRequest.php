<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
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
            'subject' => 'required|string|between:3,100|regex:/^[a-zA-Z0-9\s_@.-]+$/',
            'expired_at' => 'required|date|after:now',
            'children_count' => [
                Rule::requiredIf(function () {
                    return $this->input('has_children') == 'yes';
                }),
            ],
        ];
    }
}
