<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class languageRequest extends FormRequest
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
            "name" => "required|max:100",
            "abbr" => "required|max:10",
           // "active" => "required|in:1",
            "direction" => "required|in:rtl,ltr"
        ];
    }
    public function messages()
    {
        return [
            "required" => "هذا الحقل مطلوب",
            "name.max" => "يجب الا يكون الاسم طويلا",
            "abbr.max" => "يجب الا يكون الاختصار كبير",
            "in" => "القيم المدخله غير صحيحه"
        ];
    }
}
