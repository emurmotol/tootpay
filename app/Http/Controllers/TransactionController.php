<?php

namespace App\Http\Controllers;

use App\Models\LoadShare;
use App\Models\Order;
use App\Models\Reload;
use App\Models\Serial;
use App\Models\Setting;
use App\Models\StatusResponse;
use App\Models\TootCard;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
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
            return (String)view('dashboard.client.transactions._partials.check_balance', compact('toot_card'));
        }
        return StatusResponse::find(17)->name;
    }

    public function ready(Request $request) {
        $ready = Setting::find('ready');
        $ready->value = intval($request->get('bool'));
        $ready->save();
        return collect($ready)->toJson();
    }

    public function checkCard(Request $request) {
        if ($request->ajax()) {
            if (Setting::value('ready')) {
                $tag = Serial::tag();

                if (!is_null($tag)) {
                    $toot_card_id = $tag;

                    if (strlen($toot_card_id) > 10) {
                        return StatusResponse::def(14);
                    }

                    $toot_card = TootCard::find($toot_card_id);

                    if (!is_null($toot_card)) {

                        if (!$toot_card->is_active) {
                            return TootCard::response(21, $toot_card->id);
                        }

                        if (Carbon::now()->gt($toot_card->expires_at)) {
                            return TootCard::response(22, $toot_card->id);
                        }
                        return TootCard::response(1, $toot_card->id);
                    }
                    return StatusResponse::def(2);
                }
            }
        }
        return StatusResponse::find(17)->name;
    }

    public function checkUserId(Request $request) {
        if ($request->ajax()) {
            $user_id = $request->get('user_id');
            $user = User::find($user_id);

            if (!is_null($user)) {
                if ($user->hasRole(cardholder())) {
                    return StatusResponse::def(15);
                }
            }
            return StatusResponse::def(16);
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

            if (TootCard::loadExceedsMax($toot_card_id, $load_amount)) {
                return TootCard::response(19, $toot_card_id);
            }

            if (TootCard::loadExceedsMin($toot_card_id, $load_amount)) {
                return TootCard::response(12, $toot_card_id);
            }

            $transaction = Transaction::create([
                'payment_method_id' => 1,
                'status_response_id' => 5
            ]);
            $transaction->users()->attach(TootCard::find($toot_card_id)->users()->first(),
                compact('toot_card_id'));

            $reload = Reload::create([
                'load_amount' => $load_amount
            ]);
            $transaction->reloads()->attach($reload);
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

            if (TootCard::loadExceedsMax($toot_card_id_receiver, $load_amount)) {
                return TootCard::response(19, $toot_card_id);
            }

            if (TootCard::hasSufficientLoad($toot_card_id, $load_amount)) {
                $transaction = Transaction::create([
                    'payment_method_id' => 3,
                    'status_response_id' => 11
                ]);
                $transaction->users()->attach(TootCard::find($toot_card_id)->users()->first());

                $load_share = LoadShare::create([
                    'from_toot_card_id' => $toot_card_id,
                    'to_toot_card_id' => User::find($user_id)->tootCards()->first()->id,
                    'load_amount' => $load_amount
                ]);
                LoadShare::fromTo($toot_card_id, $user_id, $load_amount);
                $transaction->loadShares()->attach($load_share);

                $sms1 = new \App\Libraries\SmsGateway(config('mail.from.address'), config('sms.password'));
                $sms1->sendMessageToNumber(TootCard::find($toot_card_id)->users()->first()->phone_number, 'You have successfully shared P' . $load_amount . ' to ' . User::find($user_id)->name, config('sms.device'));
                $sms2 = new \App\Libraries\SmsGateway(config('mail.from.address'), config('sms.password'));
                $sms2->sendMessageToNumber(User::find($user_id)->phone_number, 'You have received P' . $load_amount . ' from ' . TootCard::find($toot_card_id)->users()->first()->name, config('sms.device'));
                return TootCard::response(9, $toot_card_id);
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
