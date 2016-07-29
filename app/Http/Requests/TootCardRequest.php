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
                'load' => 'required',
                'points' => 'required',
            ];
        } elseif ($this->method() == 'PUT') {
            return [
                'id' => 'required|numeric',
                'load' => 'required',
                'points' => 'required',
                'is_active' => '',
            ];
        }
    }
}
