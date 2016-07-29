<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TootCard;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class TootCardController extends Controller
{
    public function index() {
        if (request()->has('search')) {
            $results = TootCard::searchFor(request()->get('search'));

            if (!$results->count()) {
                flash()->error(trans('search.empty', ['search' => request()->get('search')]))->important();
            }

            if (request()->has('sort')) {
                $sorted_results = TootCard::sort(request()->get('sort'), $results);

                if (is_null($sorted_results)) {
                    return redirect()->back();
                }
                $toot_cards = $sorted_results->paginate(intval(Setting::value('per_page')));
            } else {
                $toot_cards = $results->paginate(intval(Setting::value('per_page')));
            }
        } else {
            if (request()->has('sort')) {
                $sorted = TootCard::sort(request()->get('sort'));

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $toot_cards = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $toot_cards = TootCard::paginate(intval(Setting::value('per_page')));
            }
        }
        $toot_cards->appends(request()->except('page'));
        return view('dashboard.admin.toot_cards.index', compact('toot_cards'));
    }

    public function create() {
        return view('dashboard.admin.toot_cards.create');
    }

    public function store(Requests\TootCardRequest $request) {
        $toot_card = TootCard::create($request->all());
        flash()->success(trans('toot_card.created', ['id' => $toot_card->id]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('toot_cards.index');
    }

    public function show(TootCard $toot_card) {
        return view('dashboard.admin.toot_cards.show', compact('toot_card'));
    }

    public function edit(TootCard $toot_card) {
        return view('dashboard.admin.toot_cards.edit', compact('toot_card'));
    }

    public function update(Requests\TootCardRequest $request, TootCard $toot_card) {
        try {
            $toot_card->update($request->all());
            flash()->success(trans('toot_card.updated', ['id' => $toot_card->id]));
        } catch (\Exception $e) {
            flash()->error(trans('toot_card.exception', ['error' => $e->getMessage()]))->important();
        } finally {
            return redirect()->route('toot_cards.index');
        }
    }

    public function destroy(TootCard $toot_card) {
        try {
            $user = $toot_card->users()->first();
            if(!is_null($user)) {
                flash()->error(trans('toot_card.delete_fail_associated', [
                    'id' => $toot_card->id,
                    'user_link' => '<a href="' . route('users.edit', $user->id) . '"><strong>' . $user->name . '</strong></a>'
                ]))->important();
            } elseif ($toot_card->is_active) {
                flash()->error(trans('toot_card.delete_fail_active', ['id' => $toot_card->id]))->important();
            } else {
                $toot_card->delete();
                flash()->success(trans('toot_card.deleted', ['id' => $toot_card->id]));
            }
        } catch (\Exception $e) {
            flash()->error(trans('toot_card.exception', ['error' => $e->getMessage()]))->important();
        } finally {
            if (request()->has('redirect')) {
                return redirect()->to(request()->get('redirect'));
            }
            return redirect()->route('toot_cards.index');
        }
    }
}
