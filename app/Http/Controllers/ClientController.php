<?php

namespace App\Http\Controllers;

use App\Models\MerchandiseCategory;
use App\Models\TootCard;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function order() {
        return view('dashboard.client.order');
    }

    public function todaysMenu(Request $request) {
        if ($request->ajax()) {
            $merchandise_category = MerchandiseCategory::all();
            return (String)view('dashboard.client._partials.todays_menu', compact('merchandise_category'));
        }
    }

    public function checkTootCard(Request $request) {
        if ($request->ajax()) {
            if (!is_null(TootCard::find($request->get('toot_card'))->first())) {
                return response()->make('true');
            }
            return response()->make('false');
        }
    }

    public function authTootCard(Requests\PinCodeRequest $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::findOrFail($request->get('id'));

            if ($toot_card->pin_code == $request->get('pin_code')) {
                Auth::loginUsingId($toot_card->users()->first()->id);
                return route('client.order');
            }
            return redirect()->back()->with(['error' => trans('auth.failed')]);
        }
    }
}
