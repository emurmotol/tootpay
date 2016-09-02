<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SettingTootCardRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'toot_card_expire_year_count' => 'required',
            'per_point' => 'required',
            'toot_card_max_load_limit' => 'required',
            'toot_card_default_load' => 'required',
            'toot_card_price' => 'required'
        ];
    }
}
