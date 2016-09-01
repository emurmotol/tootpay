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
            $toot_card = TootCard::find($request->get('toot_card_id'));
            return (String)view('dashboard.client.transactions._partials.check_balance', compact('toot_card'));
        }
        return StatusResponse::find(17)->name;
    }

    public function checkCard(Request $request) {
        if ($request->ajax()) {
            $toot_card_id = $request->get('toot_card_id');

            if (strlen($toot_card_id) > 10) {
                return TootCard::response(14, $toot_card_id);
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
