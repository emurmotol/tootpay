<?php

namespace App\Http\Controllers;

use App\Models\StatusResponse;
use App\Models\TootCard;
use Illuminate\Http\Request;

use App\Http\Requests;

class TransactionController extends Controller
{
    public function idle() {
        return view('dashboard.client.idle');
    }

    public function checkBalance(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('toot_card_id'))->first();
            return (String)view('dashboard.client.transactions._partials.check_balance', compact('toot_card'));
        }
        return StatusResponse::find(17)->name;
    }

    public function checkCard(Request $request) {
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
        return StatusResponse::find(17)->name;
    }

    public function authCard(Request $request) {
        if ($request->ajax()) {
            $toot_card = TootCard::where('id', $request->get('toot_card_id'))->first();

            if ($toot_card->pin_code == $request->get('pin_code')) {
                return response()->make(3);
            }
            return response()->make(4);
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
