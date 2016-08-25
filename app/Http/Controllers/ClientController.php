<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use App\Models\Setting;
use App\Models\TootCard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function tootCardCheck(Request $request) {
        if ($request->ajax()) {
            if (!is_null(TootCard::where('id', $request->get('id'))->first())) {
                return response()->make(config('static.status')[0]);
            }
            return response()->make(config('static.status')[1]);
        }
    }

    public function tootCardAuthentication(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('id'))->first();

            if ($toot_card->pin_code == $request->get('pin_code')) {
                return response()->make(config('static.status')[2]);
            }
            return response()->make(config('static.status')[3]);
        }
    }

    public function idle() {
        return view('dashboard.client.idle');
    }

    public function tootCardBalanceCheck(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('id'))->first();
            return (String) view('dashboard.client._partials.toot_card_details', compact('toot_card'));
        }
    }

    public function tootCardReloadPending(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::find($request->get('id'));
            $user = $toot_card->users()->first();

            $user->tootCardReload()->save($toot_card, [
                'user_id' => $user->id,
                'amount' => $request->get('amount'),
            ]);

            return DB::table($user->tootCardReload()->getTable())->orderBy('id', 'desc')->first()->id;
        }
    }

    public function tootCardReloadStatus(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::find($request->get('id'));
            $status= $toot_card->tootCardReload()->wherePivot('id', $request->get('reload_id'))
                ->withPivot('status')->first()->pivot->status;
            if (is_null($status)) {
                return response()->make(config('static.status')[4]);
            } else {
                if ($status) {
                    $load_amount = $toot_card->load + $toot_card->tootCardReload()
                            ->wherePivot('id', $request->get('reload_id'))
                            ->withPivot('amount')->first()->pivot->amount;
                    $toot_card->load = $load_amount;
                    $toot_card->save();
                    return response()->make(config('static.status')[5]);
                }
                return response()->make(config('static.status')[6]);
            }
        }
    }

    public function tootCardMyOrders(Request $request) {
        if ($request->ajax()) { // status 11 (HOLD)
            return response()->make('my_order');
        }
    }

    public function merchandisePurchase(Request $request){
        if ($request->ajax()) {
            return Merchandise::purchase(collect(json_decode($request->get('orders'), true)));
        }
    }
}
