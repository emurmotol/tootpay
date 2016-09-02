<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\StatusResponse;
use App\Models\TootCard;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    public function order() {
        return view('dashboard.client.orders.order');
    }

    public function userOrder(Request $request) {
        if ($request->ajax()) {
            $toot_card_id = $request->get('toot_card_id');
            $toot_card = TootCard::find($toot_card_id);

            if (strlen($toot_card_id) > 10) {
                return StatusResponse::def(14);
            } else {
                $user = $toot_card->users()->first();
                $queued = Transaction::createdBy($toot_card_id, 10, 2);
                $on_hold = Transaction::createdBy($toot_card_id, 12, 2);
                $pending = Transaction::createdBy($toot_card_id, 5, 2);

                if (!$queued->count() && !$on_hold->count() && !$pending->count()) {
                    return StatusResponse::def(13);
                }
            }
            return (String)view('dashboard.client.orders._partials.load', compact('queued', 'on_hold', 'pending', 'user'));
        }
        return StatusResponse::find(17)->name;
    }

    public function send(Request $request) {
        if ($request->ajax()) {
            $transaction = collect(json_decode($request->get('transaction'), true));
            $orders = collect(json_decode($request->get('orders'), true));
            $toot_card = TootCard::find($request->get('toot_card_id'));
            $guest_user_id = User::find(User::guestJson('id'))->id;
            return Order::transaction($transaction, (is_null($toot_card) ? $guest_user_id : $toot_card->users()->first()->id), $orders);
        }
        return StatusResponse::find(17)->name;
    }

    public function menu(Request $request) {
        if ($request->ajax()) {
            $categories = Category::all();
            return (String)view('dashboard.client.orders._partials.menu', compact('categories'));
        }
        return StatusResponse::find(17)->name;
    }

    public function load() {
        //
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