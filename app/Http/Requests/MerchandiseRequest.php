<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MerchandiseRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'merchandise_category_id' => 'required',
            'image' => '',
        ];
    }
}
