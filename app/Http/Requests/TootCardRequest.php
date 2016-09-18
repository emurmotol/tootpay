<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Setting;

class TootCardRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $max = Setting::value('toot_card_max_load_limit');
        $min = Setting::value('toot_card_min_load_limit');
        if($this->method() == 'POST') {
            return [
                'id' => 'required|numeric|unique:toot_cards',
                'uid' => 'required|numeric|unique:toot_cards',
                'load' => "numeric|max:$max|min:$min",
                'points' => 'numeric',
                'pin_code' => 'numeric',
            ];
        } elseif ($this->method() == 'PUT') {
            return [
                'id' => 'required|numeric',
                'uid' => 'required|numeric',
                'load' => "numeric|max:$max|min:$min",
                'points' => 'numeric',
                'pin_code' => 'numeric',
                'is_active' => '',
            ];
        }
    }
}
