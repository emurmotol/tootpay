<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Setting;
use App\Models\TootCard;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() {
        if (request()->has('search')) {
            $results = User::searchFor(request()->get('search'));

            if (!$results->count()) {
                flash()->error(trans('search.empty', ['search' => request()->get('search')]))->important();
            }

            if (request()->has('sort')) {
                $sorted_results = User::sort(request()->get('sort'), $results);

                if (is_null($sorted_results)) {
                    return redirect()->back();
                }
                $users = $sorted_results->paginate(intval(Setting::value('per_page')));
            } else {
                $users = $results->paginate(intval(Setting::value('per_page')));
            }
        } else {
            if (request()->has('sort')) {
                $sorted = User::sort(request()->get('sort'));

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $users = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $users = User::paginate(intval(Setting::value('per_page')));
            }
        }
        $users->appends(request()->except('page'));
        return view('dashboard.admin.users.index', compact('users'));
    }

    public function create() {
        $roles = Role::all();
        return view('dashboard.admin.users.create', compact('roles'));
    }

    public function store(Requests\UserRequest $request) {
        $user = User::create($request->except('role'));
        $user->roles()->attach($request->input('role'));
        flash()->success(trans('user.created', ['name' => $user->name]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('users.index');
    }

    public function show(User $user) {
        $_transactions = $user->transactions()->where('status_response_id', 11);

        $transactions = collect();
        $orders = collect();

        if ($_transactions->get()->count()) {
            $_transactions->orderBy('id', 'desc');

            foreach ($_transactions->get() as $transaction) {
                $_orders = $transaction->orders()->get();

                if ($_orders->count()) {
                    $transactions->push($transaction);

                    foreach ($_orders as $order) {
                        $orders->push($order);
                    }
                }
            }
        }
        return view('dashboard.admin.users.show', compact('user', 'transactions', 'orders'));
    }

    public function edit(User $user) {
        return view('dashboard.admin.users.edit', compact('user'));
    }

    public function update(Requests\UserRequest $request, User $user) {
        try {
            $user->update($request->all());
            flash()->success(trans('user.updated', ['name' => $user->name]));
        } catch (\Exception $e) {
            flash()->error(trans('user.exception', ['error' => $e->getMessage()]))->important();
        } finally {
            if (request()->has('redirect')) {
                return redirect()->to(request()->get('redirect'));
            }
            return redirect()->route('users.index');
        }
    }

    public function destroy(User $user) {
        try {
            $toot_card = $user->tootCards()->first();
            if(!is_null($toot_card)) {
                flash()->error(trans('user.delete_fail_card_is_set', [
                    'name' => $user->name,
                    'toot_card_link' => '<a href="' . route('toot_cards.edit', $toot_card->id) . '"><strong>' . $toot_card->id . '</strong></a>'
                ]))->important();
            } else {
                $user->delete();
                flash()->success(trans('user.deleted', ['name' => $user->name]));
            }
        } catch (\Exception $e) {
            flash()->error(trans('user.exception', ['error' => $e->getMessage()]))->important();
        } finally {
            if (request()->has('redirect')) {
                return redirect()->to(request()->get('redirect'));
            }
            return redirect()->route('users.index');
        }
    }

    public function remove_card(User $user, TootCard $toot_card) {
        $user->tootCards()->detach($toot_card);
        $toot_card->is_active = 'off';
        $toot_card->save();
        flash()->success(trans('user.card_removed', ['toot_card_id' => $toot_card->id, 'name' => $user->name]));

        if (request()->has('redirect')) {
            return redirect()->to(request()->get('redirect'));
        }
        return redirect()->back();
    }

    public function associate_card(Request $request, User $user) {
        $user->tootCards()->attach($request->input('toot_card_id'));
        $toot_card = TootCard::find($request->input('toot_card_id'));
        $toot_card->is_active = 'on';
        $toot_card->save();
        flash()->success(trans('user.card_associated', ['toot_card_id' => $toot_card->id, 'name' => $user->name]));

        if (request()->has('redirect')) {
            return redirect()->to(request()->get('redirect'));
        }
        return redirect()->back();
    }
}
