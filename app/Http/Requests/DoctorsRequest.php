<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'doc_phone' => 'required|unique:doctors,phone',
            'doc_email' => 'required|unique:doctors,email'
        ];
    }

    public function messages()
    {
        return [
            'doc_phone.required' => 'رقم الطبيب مطلوب',
            'doc_phone.unique' => 'رقم الطبيب مسجل من قبل',
            'doc_email.required' => 'البريد الإلكترونى للطبيب مطلوب',
            'doc_email.unique' => 'البريد الإلكترونى للطبيب مسجل من قبل',
        ];
    }
}
