<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TootCard;
use App\Models\User;
use Carbon\Carbon;
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
        $toot_card = TootCard::create([
            'id' => $request->get('id'),
            'uid' => $request->get('uid'),
            'pin_code' => $request->get('pin_code'),
            'load' => floatval($request->get('load')),
            'points' => floatval($request->get('points')),
            'is_active' => $request->get('is_active'),
            'expires_at' => Carbon::now()->addYear(intval(Setting::value('toot_card_expire_year_count'))),
        ]);
        flash()->success(trans('toot_card.created', ['uid' => $toot_card->uid]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('toot_cards.index');
    }

    public function show(TootCard $toot_card) {
        $_transactions = $toot_card->transactions()->where('status_response_id', 11);

        $transactions = collect();
        $reloads = collect();
        $load_shares = collect();

        if ($_transactions->get()->count()) {
            $_transactions->orderBy('id', 'desc');

            foreach ($_transactions->get() as $transaction) {
                $_reloads = $transaction->reloads()->get();
                $_load_shares = $transaction->loadShares()->get();

                if ($_reloads->count()) {
                    $transactions->push($transaction);

                    foreach ($_reloads as $reload) {
                        $reloads->push($reload);
                    }
                }

                if ($_load_shares->count()) {
                    $transactions->push($transaction);

                    foreach ($_load_shares as $load_share) {
                        $load_shares->push($load_share);
                    }
                }
            }
        }
        return view('dashboard.admin.toot_cards.show', compact('toot_card', 'load_shares', 'reloads'));
    }

    public function edit(TootCard $toot_card) {
        return view('dashboard.admin.toot_cards.edit', compact('toot_card'));
    }

    public function update(Requests\TootCardRequest $request, TootCard $toot_card) {
        try {
            $toot_card->update($request->all());
            flash()->success(trans('toot_card.updated', ['uid' => $toot_card->uid]));
        } catch (\Exception $e) {
            flash()->error(trans('toot_card.exception', ['error' => $e->getMessage()]))->important();
        } finally {
            if (request()->has('redirect')) {
                return redirect()->to(request()->get('redirect'));
            }
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
                flash()->error(trans('toot_card.delete_fail_active', ['uid' => $toot_card->uid]))->important();
            } else {
                $toot_card->delete();
                flash()->success(trans('toot_card.deleted', ['uid' => $toot_card->uid]));
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

    public function active() {
        $_toot_cards = TootCard::active();

        if (request()->has('search')) {
            $results = TootCard::searchFor(request()->get('search'), $_toot_cards);

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
                $sorted = TootCard::sort(request()->get('sort'), $_toot_cards);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $toot_cards = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $toot_cards = $_toot_cards->paginate(intval(Setting::value('per_page')));
            }
        }
        $toot_cards->appends(request()->except('page'));
        return view('dashboard.admin.toot_cards.active', compact('toot_cards'));
    }

    public function inactive() {
        $_toot_cards = TootCard::inactive();

        if (request()->has('search')) {
            $results = TootCard::searchFor(request()->get('search'), $_toot_cards);

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
                $sorted = TootCard::sort(request()->get('sort'), $_toot_cards);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $toot_cards = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $toot_cards = $_toot_cards->paginate(intval(Setting::value('per_page')));
            }
        }
        $toot_cards->appends(request()->except('page'));
        return view('dashboard.admin.toot_cards.active', compact('toot_cards'));
    }

    public function expired() {
        $_toot_cards = TootCard::expired();

        if (request()->has('search')) {
            $results = TootCard::searchFor(request()->get('search'), $_toot_cards);

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
                $sorted = TootCard::sort(request()->get('sort'), $_toot_cards);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $toot_cards = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $toot_cards = $_toot_cards->paginate(intval(Setting::value('per_page')));
            }
        }
        $toot_cards->appends(request()->except('page'));
        return view('dashboard.admin.toot_cards.active', compact('toot_cards'));
    }

    public function notAssociated() {
        $_toot_cards = TootCard::notAssociated();

        if (request()->has('search')) {
            $results = TootCard::searchFor(request()->get('search'), $_toot_cards);

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
                $sorted = TootCard::sort(request()->get('sort'), $_toot_cards);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $toot_cards = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $toot_cards = $_toot_cards->paginate(intval(Setting::value('per_page')));
            }
        }
        $toot_cards->appends(request()->except('page'));
        return view('dashboard.admin.toot_cards.not_associated', compact('toot_cards'));
    }
}
