<?php

namespace App\Http\Controllers;

use App\Models\MerchandiseCategory;
use App\Models\TootCard;
use App\Models\User;
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
            return (String)view('dashboard.client._partials.todays_menu', compact('merchandise_category'));
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

    public function authTootCard(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('id'))->first();

            if ($toot_card->pin_code == $request->get('pin_code')) {
                // Auth::loginUsingId($toot_card->users()->first()->id);
                return response()->make('true');
            }
            return response()->make('false');
        }
    }

    public function idle() {
        return view('dashboard.client.idle');
    }

    public function checkBalance(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('id'))->first();
            return (String) view('dashboard.client._partials.toot_card_details', compact('toot_card'));
        }
    }

    public function reloadPending(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::find($request->get('id'));
            $user = $toot_card->users()->first();

            $user->reload()->save($toot_card, [
                'user_id' => $user->id,
                'amount' => $request->get('amount'),
                'status' => $request->get('status'),
            ]);

            return $user->reload()->wherePivot('status', $request->get('status'))
                ->latest()->withPivot('id')->first()->pivot->id;
        }
    }

    public function reloadStatus(Request $request) {
        if ($request->ajax()) {
            return response()->make(TootCard::find($request->get('id'))
                ->reload()->wherePivot('id', $request->get('reload_id'))
                ->withPivot('status')->first()->pivot->status);
        }
    }
}
