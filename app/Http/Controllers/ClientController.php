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

    public function tootCardGetOrders(Request $request) {
        if ($request->ajax()) {
            $toot_card_id = $request->get('id');
            $queued_orders = Merchandise::queuedOrders($toot_card_id);
            $on_hold_orders = Merchandise::onHoldOrders($toot_card_id);
            $pending_orders = Merchandise::pendingOrders($toot_card_id);
            return (String)view('dashboard.client._partials.get_orders', compact('queued_orders', 'on_hold_orders', 'pending_orders'));
        }
    }

    public function merchandisePurchase(Request $request){
        if ($request->ajax()) {
            $orders = collect(json_decode($request->get('orders'), true));
            $status = $orders->first()['status'];
            $toot_card_id = $orders->first()['toot_card_id'];
            $payment_method = $orders->first()['payment_method'];

            if ($payment_method == config('static.payment_method')[0]) {
                foreach ($orders as $order) {
                    DB::table('merchandise_purchase')->insert([
                        'order_id' => $order['order_id'],
                        'merchandise_id' => $order['merchandise_id'],
                        'quantity' => $order['quantity'],
                        'total' => $order['total'],
                        'payment_method' => $order['payment_method'],
                        'status' => $order['status'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            } else if ($payment_method == config('static.payment_method')[1]) {
                $toot_card = TootCard::find($toot_card_id);
                $grand_total = $orders->sum('total');
                $per_point = intval(Setting::value('per_point'));
                $status_insufficient_balance = response()->make(config('static.status')[7]);

                if ($status != config('static.status')[11]) {
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

                foreach ($orders as $order) {
                    Merchandise::find($order['merchandise_id'])->tootCards()->save($toot_card, [
                        'queue_number' => $order['queue_number'],
                        'order_id' => $order['order_id'],
                        'user_id' => $toot_card->users()->first()->id,
                        'quantity' => $order['quantity'],
                        'total' => $order['total'],
                        'payment_method' => $order['payment_method'],
                        'status' => $order['status'],
                    ]);
                }
            }
            return response()->make(config('static.status')[8]);
        }
    }
}
