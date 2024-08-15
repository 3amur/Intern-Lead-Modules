<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user = $this->route('user');
        if ($this->route()->getName() === 'users.update') {
            // Validation rules for update
            return [
                'name' => 'required|string|max:150',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->whereNull('deleted_at')->where(function ($query) {
                        return $query->where('created_by', auth()->id());
                    })->ignore($user, 'id')

                ],
                'password' => ['nullable', 'confirmed', Password::defaults()],
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
                'status' => 'required|string',
                'role_id' => 'required|array',
                'role_id.*' => 'required|integer',
                'permissions' => 'required|array',
                'permissions.*' => 'required',
            ];
        } else {
            // Validation rules for store
            return [
                'name' => 'required|string|max:150',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->whereNull('deleted_at')->where(function ($query) {
                        return $query->where('created_by', auth()->id());
                    })->ignore($user, 'id')

                ],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
                'status' => 'required|string',
                'role_id' => 'required|array',
                'role_id.*' => 'required|integer',
                'permissions' => 'required|array',
                'permissions.*' => 'required',
            ];
        }
    }
}
