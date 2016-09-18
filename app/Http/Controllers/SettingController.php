<?php

namespace App\Http\Controllers;

use App\Models\OperationDay;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;

class SettingController extends Controller
{
    public function tootCard() {
        return view('dashboard.admin.settings.toot_card');
    }

    public function updateTootCard(Requests\SettingTootCardRequest $request) {
        if ($request->has('toot_card_expire_year_count')) {
            $expire_year_count = Setting::find('toot_card_expire_year_count');
            $expire_year_count->value = $request->get('toot_card_expire_year_count');
            $expire_year_count->save();
        }

        if ($request->has('per_point')) {
            $per_point = Setting::find('per_point');
            $per_point->value = $request->get('per_point');
            $per_point->save();
        }

        if ($request->has('toot_card_max_load_limit')) {
            $toot_card_max_load_limit = Setting::find('toot_card_max_load_limit');
            $toot_card_max_load_limit->value = $request->get('toot_card_max_load_limit');
            $toot_card_max_load_limit->save();
        }

        if ($request->has('toot_card_min_load_limit')) {
            $toot_card_min_load_limit = Setting::find('toot_card_min_load_limit');
            $toot_card_min_load_limit->value = $request->get('toot_card_min_load_limit');
            $toot_card_min_load_limit->save();
        }

        if ($request->has('toot_card_default_load')) {
            $toot_card_default_load = Setting::find('toot_card_default_load');
            $toot_card_default_load->value = $request->get('toot_card_default_load');
            $toot_card_default_load->save();
        }

        if ($request->has('toot_card_price')) {
            $toot_card_price = Setting::find('toot_card_price');
            $toot_card_price->value = $request->get('toot_card_price');
            $toot_card_price->save();
        }
        flash()->success(trans('setting.toot_card_saved'));
        return redirect()->back();
    }

    public function operationDay() {
        return view('dashboard.admin.settings.operation_day');
    }

    public function updateOperationDay(Requests\OperationDayRequest $request) {
        if ($request->has('day') && count($request->get('day'))) {
            foreach (OperationDay::whereIn('id', $request->get('day'))->get() as $day) {
                $operation_day = OperationDay::find($day->id);
                $operation_day->has_operation = true;
                $operation_day->save();
            }

            foreach (OperationDay::whereNotIn('id', $request->get('day'))->get() as $day) {
                $operation_day = OperationDay::find($day->id);
                $operation_day->has_operation = false;
                $operation_day->save();
            }
        } else {
            foreach (OperationDay::all() as $day) {
                $day->has_operation = false;
                $day->save();
            }
        }
        flash()->success(trans('setting.operation_day_saved'));
        return redirect()->back();
    }
}
