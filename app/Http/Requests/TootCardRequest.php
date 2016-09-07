<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TootCardRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->method() == 'POST') {
            return [
                'id' => 'required|numeric|unique:toot_cards',
                'uid' => 'required|numeric|unique:toot_cards',
                'load' => '',
                'points' => '',
                'pin_code' => 'numeric',
            ];
        } elseif ($this->method() == 'PUT') {
            return [
                'id' => 'required|numeric',
                'uid' => 'required|numeric',
                'load' => '',
                'points' => '',
                'pin_code' => 'numeric',
                'is_active' => '',
            ];
        }
    }
}
