<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\Category;
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
            $categories = Category::all();
            return (String)view('dashboard.client._partials.todays_menu', compact('categories'));
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

    public function tootCardBalance(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('toot_card_id'))->first();
            return (String)view('dashboard.client._partials.toot_card_balance', compact('toot_card'));
        }
    }

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
            $user_id = null;
            $transaction_id = null;
            $status_response_id = null;

            $toot_card_id = $request->get('toot_card_id');
            $transaction = collect(json_decode($request->get('transaction'), true));
            $payment_method_id = $transaction->get('payment_method_id');
            $orders = collect(json_decode($request->get('orders'), true));
            $grand_total = $orders->sum('total');
            $per_point = intval(Setting::value('per_point'));
            $queue_number = Transaction::queueNumber();
            $insufficient_balance = 8;
            $status_response_id = $transaction->get('status_response_id');
            $transaction_id = $orders->pluck('transaction_id', 'transaction_id')->first();
            $order_ids = collect();

            switch ($payment_method_id) {
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

                    if ($status_response_id != 12) {
                        if (count($toot_card->load)) {
                            if ($toot_card->load < $grand_total) {
                                $load_points = $toot_card->load + $toot_card->points;

                                if ($load_points < $grand_total) {
                                    $status_response_id = $insufficient_balance;
                                } else {
                                    $current_load = $toot_card->load;
                                    $toot_card->load = ($current_load - $grand_total) > 1 ?: 0;
                                    $points = $toot_card->points - ($grand_total - $current_load);
                                    $toot_card->points = (($points < 1) ? 0 : $points) + ($current_load / $per_point);
                                    $toot_card->save();

                                    if ($transaction_id == 0) {
                                        $transaction->put('queue_number', $queue_number);
                                    }
                                }
                            } else {
                                $toot_card->load = $toot_card->load - $grand_total;
                                $toot_card->points = $toot_card->points + ($grand_total / $per_point);
                                $toot_card->save();

                                if ($transaction_id == 0) {
                                    $transaction->put('queue_number', $queue_number);
                                }
                            }
                        } else {
                            if (count($toot_card->points)) {
                                if ($toot_card->points < $grand_total) {
                                    $status_response_id = $insufficient_balance;
                                } else {
                                    $points = $toot_card->points - $grand_total;
                                    $toot_card->points = ($points < 1) ? 0 : $points;
                                    $toot_card->save();

                                    if ($transaction_id == 0) {
                                        $transaction->put('queue_number', $queue_number);
                                    }
                                }
                            } else {
                                $status_response_id = $insufficient_balance;
                            }
                        }
                    }
                    if ($transaction_id == 0) {
                        $_transaction = Transaction::create($transaction->toArray());
                        $transaction_id = $_transaction->id;
                        $_transaction->tootCards()->attach($toot_card_id, compact('user_id'));
                    }
                    break;
                default:
            }

            foreach ($orders as $order) {
                $_order = collect($order);

                if($_order->get('transaction_id') == 0) {
                    $_order->forget('transaction_id');
                    $_order->put('transaction_id', $transaction_id);
                }

                if($_order->has('id')) {
                    Order::find($_order->get('id'))->fill($_order->toArray())->save();
                    $order_ids->push($_order->get('id'));
                } else {
                    Order::create($_order->toArray());
                }
            }

            foreach (Order::removedByUser($order_ids->all()) as $order) {
                $order->delete();
            }

            $response = [
                'status' => StatusResponse::find($status_response_id)->name,
                'queue_number' => ($transaction_id > 0) ? Transaction::find($transaction_id)->queue_number : $transaction->get('queue_number'),
                'transaction_id' => $transaction_id,
                'payment_method' => PaymentMethod::find($payment_method_id)->name
            ];
            $status = collect($response);
            Log::debug($status->toArray());
            return response()->make($status->toJson());
        }
    }
}
