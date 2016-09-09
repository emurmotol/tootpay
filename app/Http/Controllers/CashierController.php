<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SoldCard;
use App\Models\StatusResponse;
use App\Models\TootCard;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function transactionsCashier(Request $request) {
        if ($request->ajax()) {
            $transactions = Transaction::pendingAndCash();
            return (String)view('dashboard.cashier._partials.transactions', compact('transactions'));
        }
        return StatusResponse::find(17)->name;
    }

    public function transactionsCount(Request $request) {
        if ($request->ajax()) {
            return Transaction::pendingAndCash()->count();
        }
        return StatusResponse::find(17)->name;
    }

    public function transactionDone(Request $request) {
        if ($request->ajax()) {
            return Transaction::setStatusResponse($request->get('transaction_id'), 10);
        }
        return StatusResponse::find(17)->name;
    }

    public function transactionCancel(Request $request) {
        if ($request->ajax()) {
            return Transaction::setStatusResponse($request->get('transaction_id'), 7);
        }
        return StatusResponse::find(17)->name;
    }

    public function transactionCreateCardHolder(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('uid', $request->get('toot_card_uid'))->first();

            if (is_null($toot_card)) {
                return StatusResponse::def(2);
            }

            if ($toot_card->is_active) {
                return StatusResponse::def(24);
            }

            if (!is_null($toot_card->users()->first())) {
                return StatusResponse::def(25);
            }

            if (!is_null(User::find($request->get('user_id')))) {
                return StatusResponse::def(26);
            }

            if (!is_null(User::where('email', $request->get('email'))->first())) {
                return StatusResponse::def(27);
            }

            $transaction = Transaction::create([
                'payment_method_id' => 1,
                'status_response_id' => 5
            ]);

            $password = bcrypt(str_random(6));

            $user = User::create([
                'id' => $request->get('user_id'),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone_number' => $request->get('phone_number'),
                'password' => $password
            ]);
            $user->roles()->attach(cardholder());
            $toot_card->users()->attach($user);

            $sold_card = SoldCard::create([
                'toot_card_id' => $toot_card->id,
                'price' => floatval(Setting::value('toot_card_price'))
            ]);
            $transaction->soldCards()->attach($sold_card);
            return StatusResponse::def(23);
        }
        return StatusResponse::find(17)->name;
    }
}
