<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ExpenseRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'amount' => 'required|numeric',
            'description' => '',
        ];
    }
}
