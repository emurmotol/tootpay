<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\StatusResponse;
use App\Models\TootCard;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

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
            $toot_card_id = $request->get('toot_card_id');

            if (strlen($toot_card_id) > 10) {
                return response()->make(14);
            } else {
                if (!is_null(TootCard::where('id', $toot_card_id)->first())) {
                    return response()->make(1);
                }
                return response()->make(2);
            }
        }
    }

    public function tootCardAuthAttempt(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('toot_card_id'))->first();

            if ($toot_card->pin_code == $request->get('pin_code')) {
                return response()->make(3);
            }
            return response()->make(4);
        }
    }

    public function idle() {
        return view('dashboard.client.idle');
    }

    public function tootCardBalanceCheck(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('toot_card_id'))->first();
            return (String)view('dashboard.client._partials.toot_card_details', compact('toot_card'));
        }
    }

//    public function tootCardReloadPending(Request $request) {
//        if ($request->ajax()) {
//            $toot_card = TootCard::find($request->get('id'));
//            $user = $toot_card->users()->first();
//
//            $user->tootCardReload()->save($toot_card, [
//                'user_id' => $user->id,
//                'amount' => $request->get('amount'),
//            ]);
//
//            return DB::table($user->tootCardReload()->getTable())->orderBy('id', 'desc')->first()->id;
//        }
//    }
//
//    public function tootCardReloadStatus(Request $request) {
//        if ($request->ajax()) {
//            $toot_card = TootCard::find($request->get('id'));
//            $status = $toot_card->tootCardReload()->wherePivot('id', $request->get('reload_id'))
//                ->withPivot('status')->first()->pivot->status;
//            if (is_null($status)) {
//                return response()->make(config('static.status')[4]);
//            } else {
//                if ($status) {
//                    $load_amount = $toot_card->load + $toot_card->tootCardReload()
//                            ->wherePivot('id', $request->get('reload_id'))
//                            ->withPivot('amount')->first()->pivot->amount;
//                    $toot_card->load = $load_amount;
//                    $toot_card->save();
//                    return response()->make(config('static.status')[5]);
//                }
//                return response()->make(config('static.status')[6]);
//            }
//        }
//    }

    public function tootCardGetOrders(Request $request) {
        if ($request->ajax()) {
            $toot_card_id = $request->get('toot_card_id');
            $toot_card = TootCard::find($toot_card_id);

            if (strlen($toot_card_id) > 10) {
                return response()->make(14);
            } else {
                $user = $toot_card->users()->first();
                $queued = Transaction::madeFrom($toot_card_id, 10, 2);
                $on_hold = Transaction::madeFrom($toot_card_id, 12, 2);
                $pending = Transaction::madeFrom($toot_card_id, 5, 2);

                if (!$queued->count() && !$on_hold->count() && !$pending->count()) {
                    return response()->make(13);
                }
            }
            return (String)view('dashboard.client._partials.get_orders', compact('queued', 'on_hold', 'pending', 'user'));
        }
    }

    public function loadOrders(Request $request) {
        $orders = collect();

        foreach (Order::byTransaction($request->get('transaction_id')) as $order) {
            $_order = [
                'id' => $order->id,
                'merchandise_id' => $order->merchandise_id,
                'name' => Merchandise::find($order->merchandise_id)->name,
                'price' => Merchandise::find($order->merchandise_id)->price,
                'qty' => $order->quantity,
            ];

            $orders->push($_order);
        }
        return response()->make($orders->toJson());
    }

    public function merchandisePurchase(Request $request) {
        if ($request->ajax()) {
            $toot_card_id = $request->get('toot_card_id');
            $transaction = collect(json_decode($request->get('transaction'), true)[0]);
            $orders = collect(json_decode($request->get('orders'), true));
            $grand_total = $orders->sum('total');
            $per_point = intval(Setting::value('per_point'));
            $status_insufficient_balance = response()->make(8);
            $user_id = null;
            $transaction_id = null;

            switch ($transaction->get('payment_method_id')) {
                case 1:
                    $guest = User::guestJson('id');
                    $user_id = User::find($guest)->id;
                    $_transaction = Transaction::create($transaction->toArray());
                    $transaction_id = $_transaction->id;
                    $_transaction->users()->attach($user_id);
                    break;
                case 2:
                    $toot_card = TootCard::find($toot_card_id);
                    $user_id = $toot_card->users()->first()->id;
                    $transaction->put('queue_number', Transaction::queueNumber());
                    $_transaction = Transaction::create($transaction->toArray());
                    $transaction_id = $_transaction->id;
                    $_transaction->tootCards()->attach($toot_card_id, compact('user_id'));

                    if ($transaction->get('status_response_id') != 12) {
                        if (count($toot_card->load)) {
                            if ($toot_card->load < $grand_total) {
                                $load_points = $toot_card->load + $toot_card->points;

                                if ($load_points < $grand_total) {
                                    return $status_insufficient_balance;
                                } else {
                                    $current_load = $toot_card->load;
                                    $toot_card->load = ($current_load - $grand_total) > 1 ?: 0;
                                    $points = $toot_card->points - ($grand_total - $current_load);
                                    $toot_card->points = (($points < 1) ? 0 : $points) + ($current_load / $per_point);
                                }
                            } else {
                                $toot_card->load = $toot_card->load - $grand_total;
                                $toot_card->points = $toot_card->points + ($grand_total / $per_point);
                            }
                        } else {
                            if (count($toot_card->points)) {
                                if ($toot_card->points < $grand_total) {
                                    return $status_insufficient_balance;
                                } else {
                                    $points = $toot_card->points - $grand_total;
                                    $toot_card->points = ($points < 1) ? 0 : $points;
                                }
                            } else {
                                return $status_insufficient_balance;
                            }
                        }
                        $toot_card->save();
                    }
                    break;
                default:
            }

            foreach ($orders as $order) {
                $_order = collect($order);

                if ($_order->has('id')) {
                    Order::find($_order->get('id'))->fill($_order->toArray())->save();
                } else {
                    $_order->put('transaction_id', $transaction_id);
                    Order::create($_order->toArray());
                }
            }

            $status = collect();
            $response = StatusResponse::find(9)->name => [ // todo make root element
                    'queue_number' => $transaction->get('queue_number')
                ];
            $status->push($response);
            return response()->make($status[0]);
        }
    }
}
