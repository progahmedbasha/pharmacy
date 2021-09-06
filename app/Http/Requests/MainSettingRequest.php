<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainSettingRequest extends FormRequest
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
            'site_name' => 'required',
            'site_name_en' => 'required',
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'site_name.required' => 'إسم الموقع مطلوب',
            'site_name_en.required' => 'مطلوب إسم الموقع(en) ',
            'phone.required' => 'رقم الهاتف مطلوب'
        ];
    }
}
