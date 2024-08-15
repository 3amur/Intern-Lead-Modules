<?php

namespace Modules\Reminder\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
//dd(request()->file);
        //Rule::unique('mail_settings')->where('deleted_at',NULL)->where(function ($query) {return $query->where('created_by', auth()->id());})->ignore($mailSetting,'id')

        $contact = $this->route('contact');
        if ($this->route()->getName() === 'contacts.update') {
            return [
                'name' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'email' => [
                    'nullable',
                    'email',
                    'max:100',
                ],
                'phone.*' => [
                    'required',
                    'string',
                    'max:20',
                ],
                'status' => 'required'
            ];
        } else {
            if(request()->hasFile('file'))
            {
                return [
                    'file'=>'mimeTypes:vcf,text/vcard',
                    'name' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                    'email' => [
                        'nullable',
                        'email',
                        'max:100',
                    ],
                    'phone.*' => [
                        'required',
                        'string',
                        'max:20',
                        Rule::unique('phones', 'phone')->where('deleted_at', NULL)->where(function ($query) {
                            return $query->where('created_by', auth()->id()); })
                    ],
                ];
            }
            return [
                'name' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s_@.-]+$/',
                'email' => [
                    'nullable',
                    'email',
                    'max:100',
                ],
                'phone.*' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('phones', 'phone')->where('deleted_at', NULL)->where(function ($query) {
                        return $query->where('created_by', auth()->id()); })
                ],
                'status' => 'required'
            ];
        }
    }
}
