<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AdminUserRequest extends Request
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
        //'edit:PATCH , create->POST'
        $inputs=$this->request->all();
        if($inputs['flag']=='change_password'){
            return [
                'newpassword'              => 'required|min:6|confirmed',
                'newpassword_confirmation' => 'required'
            ];
        }
        else if($inputs['flag']=='create'){
            return [
                'name'                  => 'required',
                'email'                 => 'required|email|unique:admins',
                'password'              => 'required|min:6|confirmed',
                'password_confirmation' => 'required'
            ];
        }
        else{
            return [
                'name'  => 'required',
                'email' => 'required|email',
            ];
        }
    }

    public function messages(){
        return [
            'required'  => '必填欄位!',
            'min'       => '請至少輸入5個字元以上!',
            'confirmed' => '密碼及確認密碼欄位的值必需相同!',
            'email'     =>'請輸入正確的電子郵件格式'
        ];
    }
}
