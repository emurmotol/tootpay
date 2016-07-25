<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TootCard;
use Illuminate\Http\Request;

use App\Http\Requests;

class TootCardController extends Controller
{
    public function index() {
        if (request()->has('sort')) {
            $sort = TootCard::sort(request()->get('sort'));

            if (is_null($sort)) {
                return redirect()->back();
            }
            $toot_cards = $sort->paginate(intval(Setting::value('per_page')));
        } else {
            $toot_cards = TootCard::paginate(intval(Setting::value('per_page')));
        }
        $toot_cards->appends(request()->except('page'));
        return view('dashboard.admin.toot_card.index', compact('toot_cards'));
    }

    public function create() {
        return view('dashboard.admin.toot_card.create');
    }

    public function store(Request $request) {
        $toot_card = TootCard::create($request->all());

        flash()->success(trans('toot_card.created', ['id' => $toot_card->id]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('toot_cards.index');
    }

    public function show(TootCard $toot_card) {
        return view('dashboard.admin.toot_card.show', compact('toot_card'));
    }

    public function edit(TootCard $toot_card) {
        return view('dashboard.admin.toot_card.edit', compact('toot_card'));
    }

    public function update(Request $request, TootCard $toot_card) {
        $toot_card->update($request->all());

        flash()->success(trans('toot_card.updated', ['id' => $toot_card->id]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('toot_cards.index');
    }

    public function destroy(TootCard $toot_card) {
        $toot_card->delete();
        flash()->success(trans('toot_card.deleted', ['id' => $toot_card->id]));

        if (request()->has('redirect')) {
            return redirect()->to(request()->get('redirect'));
        }
        return redirect()->back();
    }
}
