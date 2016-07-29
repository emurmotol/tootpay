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
        if($this->method() == 'POST') {
            return [
                'id' => 'required|numeric|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'name' => 'required|max:255',
                'phone_number' => 'required|numeric',
            ];
        } elseif ($this->method() == 'PUT') {
            return [
                'id' => 'required|numeric',
                'email' => 'required|email|max:255',
                'name' => 'required|max:255',
                'phone_number' => 'required|numeric',
            ];
        }
    }
}
