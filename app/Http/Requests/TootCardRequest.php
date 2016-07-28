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
        return [
            'id' => 'required',
        ];
    }
}
