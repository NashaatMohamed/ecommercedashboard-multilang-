<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class vendorRequest extends FormRequest
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
            "name" => "required",
            "logo" => "required_without:id|mimes:jpg,png,jpeg",
            "mobile" => "required|min:10|unique:vendors,mobile,". $this ->id,
            "address" => "required_without:id",
            "email" => "required|email|unique:vendors,email,".$this -> id,
            "password" => "required_without:id|unique:vendors,password",
            "category_id" => "required|exists:man_categories,id"
        ];
    }
    public function messages()
    {
        return [
            "required" => "هذا الحقل مطلوب",
            "logo.required_without" => "يجب ادخال الصوره",
            "mobile.min" => "رقم الهاتف لا بد ان يكون ان يكون اكبر من 10 ولا يقل عن 10",
            "email.email" => "البريد الالكترونى غير صخيح",
            "email.unique" => "هذا الايميل موجود بالفعل",
            "password.unique" => "كلمه المرور غير صحيحه",
            "category_id.exists" => "هذا القسم غير موجود"
        ];
    }
}
