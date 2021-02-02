<?php

namespace App\Http\Requests\Holiday;

use App\Http\Requests\Request;

class AdminHolidayRequest extends Request
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
            'holiday_name'      => 'required|min:2',
            'holiday_date'     => 'required|date'
        ];
    }

    public function messages(){
        return [
            'required' => '必填欄位!'
            
        ];
    }
}
