<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use App\Models\TootCard;
use App\Models\User;
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

    public function checkTootCard(Request $request) {
        if ($request->ajax()) {
            if (!is_null(TootCard::where('id', $request->get('toot_card'))->first())) {
                return response()->make('valid');
            }
            return response()->make('invalid');
        }
    }

    public function authTootCard(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('id'))->first();

            if ($toot_card->pin_code == $request->get('pin_code')) {
                // Auth::loginUsingId($toot_card->users()->first()->id);
                return response()->make('correct');
            }
            return response()->make('incorrect');
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
            ]);

            return DB::table($user->reload()->getTable())->orderBy('id', 'desc')->first()->id;
        }
    }

    public function reloadStatus(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::find($request->get('id'));
            $paid = $toot_card->reload()->wherePivot('id', $request->get('reload_id'))
                ->withPivot('paid')->first()->pivot->paid;
            if (is_null($paid)) {
                return response()->make('pending');
            } else {
                if ($paid) {
                    $load_amount = $toot_card->load + $toot_card->reload()
                            ->wherePivot('id', $request->get('reload_id'))
                            ->withPivot('amount')->first()->pivot->amount;
                    $toot_card->load = $load_amount;
                    $toot_card->save();
                    return response()->make('paid');
                }
                return response()->make('canceled');
            }
        }
    }

    public function purchase(Request $request){
        if ($request->ajax()) {
            $table_data = collect(json_decode($request->get('table_data'), true));
            $toot_card = TootCard::find($table_data->first()['toot_card_id']);

            foreach ($table_data as $row) {
                Merchandise::find($row['merchandise_id'])->tootCards()->save($toot_card, [
                    'order_id' => $row['order_id'],
                    'user_id' => $toot_card->users()->first()->id,
                    'quantity' => $row['quantity'],
                    'total' => $row['total']
                ]);
            }

            return response()->make($toot_card);
        }
    }
}
