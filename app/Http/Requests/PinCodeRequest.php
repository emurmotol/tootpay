<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PinCodeRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pin_code' => 'required|min:4|max:4',
        ];
    }
}
