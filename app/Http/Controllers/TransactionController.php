<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StatusResponse;
use App\Models\TootCard;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class TransactionController extends Controller
{
    public function idle() {
        return view('dashboard.client.idle');
    }

    public function checkBalance(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::find($request->get('toot_card_id'));
            return (String)view('dashboard.client.transactions._partials.check_balance',
                compact('toot_card'));
        }
        return StatusResponse::find(17)->name;
    }

    public function checkCard(Request $request) {
        if ($request->ajax()) {
            $toot_card_id = $request->get('toot_card_id');

            if (strlen($toot_card_id) > 10) {
                return StatusResponse::def(14);
            } else {
                if (!is_null(TootCard::find($toot_card_id))) {
                    return TootCard::response(1, $toot_card_id);
                }
                return TootCard::response(2, $toot_card_id);
            }
        }
        return StatusResponse::find(17)->name;
    }

    public function authCard(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::find($request->get('toot_card_id'));
            $toot_card_id = $toot_card->id;

            if ($toot_card->pin_code == $request->get('pin_code')) {
                return TootCard::response(3, $toot_card_id);
            }
            return TootCard::response(4, $toot_card_id);
        }
        return StatusResponse::find(17)->name;
    }

    public function reloadRequest(Request $request) {
        if ($request->ajax()) {
            $toot_card_id = $request->get('toot_card_id');
            $load_amount = $request->get('load_amount');

            if (TootCard::loadExceeds($toot_card_id, $load_amount)) {
                return TootCard::response(19, $toot_card_id);
            }

            $transaction = Transaction::create([
                'payment_method_id' => 1,
                'status_response_id' => 5
            ]);
            $transaction->users()->attach(TootCard::find($toot_card_id)->users()->first(),
                compact('toot_card_id'));

            $order = Order::create([
                'merchandise_id' => 1,
                'quantity' => 1,
                'total' => $load_amount
            ]);
            $transaction->orders()->attach($order);
            return TootCard::response(9, $toot_card_id);
        }
        return StatusResponse::find(17)->name;
    }

    public function shareLoad(Request $request) {
        if ($request->ajax()) {
            $toot_card_id = $request->get('toot_card_id');
            $user_id = $request->get('user_id');
            $load_amount = $request->get('load_amount');

            $toot_card_id_receiver = User::find($user_id)->tootCards()->first()->id;

            if (TootCard::loadExceeds($toot_card_id_receiver, $load_amount)) {
                return TootCard::response(19, $toot_card_id_receiver);
            }

            if (TootCard::hasSufficientLoad($toot_card_id, $load_amount)) {
                TootCard::shareLoad($toot_card_id, $user_id, $load_amount);
                return TootCard::response(19, $toot_card_id);
            }
            return TootCard::response(18, $toot_card_id);
        }
        return StatusResponse::find(17)->name;
    }

    public function index() {
        //
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        //
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
