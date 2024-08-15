<?php

namespace Modules\PotentialCustomer\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrokerTypeRequest extends FormRequest
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
        $brokerType = $this->route('broker_type');
        if ($this->route()->getName() === 'broker_types.update') {
            // Validation rules for update
            return [
                'title' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s_@.-]+$/|unique:broker_types,title,' . $brokerType->id,
                'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'status' => 'required|string',
            ];
        } else {
            // Validation rules for store
            return [
                'title' => 'required|string|max:100||regex:/^[a-zA-Z0-9\s_@.-]+$/|unique:broker_types,title',
                'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'status' => 'required|string',
            ];
        }
    }
}
