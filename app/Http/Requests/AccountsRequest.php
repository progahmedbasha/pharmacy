<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountsRequest extends FormRequest
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
            'name_ar' => 'required',
            'name_en' => 'required',
            'credit_debit' => 'required',
            'final_acc' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'الإسم العربى مطلوب',
            'name_en.required' => 'الإسم الانجليزي مطلوب',
            'credit_debit.required' => 'نوع الحساب مطلوب',
            'final_acc.required' => 'الحساب الختامى  مطلوب',
        ];
    }
}
