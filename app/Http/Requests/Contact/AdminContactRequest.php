<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\Request;

class AdminContactRequest extends Request
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
            //'captcha' => 'required|captcha'
        ];
    }

    public function messages(){
        return [
            'required' => '必填欄位!'
            // 'integer' => '請輸入數字格式!'
            
        ];
    }
}
