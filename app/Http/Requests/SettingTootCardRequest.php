<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Setting;

class SettingTootCardRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $max = intval(Setting::value('toot_card_price'));
        return [
            'toot_card_expire_year_count' => 'numeric|required',
            'per_point' => 'numeric|required',
            'toot_card_max_load_limit' => 'numeric|required',
            'toot_card_min_load_limit' => 'numeric|required',
            'toot_card_default_load' => "numeric|required|max:$max",
            'toot_card_price' => 'numeric|required'
        ];
    }
}
