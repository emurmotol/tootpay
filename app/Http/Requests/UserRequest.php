<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|numeric',
        ];
    }
}
