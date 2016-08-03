<?php

namespace App\Http\Controllers;

use App\Models\MerchandiseCategory;
use App\Models\TootCard;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index() {
        return view('dashboard.client.index');
    }

    public function todaysMenu(Request $request) {
        if ($request->ajax()) {
            $merchandise_category = MerchandiseCategory::all();
            return (String) view('dashboard.client._partials.todays_menu', compact('merchandise_category'));
        }
    }

    public function checkTootCard(Request $request) {
        if ($request->ajax()) {
            if (!is_null(TootCard::where('id', $request->get('toot_card'))->first())) {
                return response()->make('true');
            }
            return response()->make('false');
        }
    }

    public function authTootCard(Requests\PinCodeRequest $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('id'))->first();

            if ($toot_card->pin_code == $request->get('pin_code')) {
                Auth::loginUsingId($toot_card->users()->first()->id);
                return response()->make('true');
            }
            return response()->make('false');
        }
    }

    public function idle() {
        return view('dashboard.client.idle');
    }
}
