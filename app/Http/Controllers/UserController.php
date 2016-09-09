<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Setting;
use App\Models\TootCard;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function profile(User $user) {
        if (Auth::user()->id == $user->id || Auth::user()->hasRole(admin())) {
            return view('dashboard.cardholder.profile.index', compact('user'));
        }
        return redirect()->back();
    }

    public function profileEdit(User $user) {
        if (Auth::user()->id == $user->id || Auth::user()->hasRole(admin())) {
            return view('dashboard.cardholder.profile.edit', compact('user'));
        }
        return redirect()->back();
    }

    public function profileUpdate(Requests\UserRequest $request, User $user) {
        if ($request->get('id') == $user->id) {
            $user->update($request->all());
            flash()->success(trans('user.profile_updated'));
            return redirect()->back();
        }
        $user->update($request->all());
        return redirect()->to('/');
    }

    public function profileUpdatePassword(Requests\PasswordRequest $request, User $user) {
        $user->password = bcrypt($request->get('password'));
        $user->save();
        flash()->success(trans('user.profile_updated_password'));
        return redirect()->back();
    }

    public function tootCard(User $user) {
        if (Auth::user()->id == $user->id || Auth::user()->hasRole(admin())) {
            $toot_card = $user->tootCards()->first();
            $_transactions = $user->transactions()->where('status_response_id', 11);

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
            return view('dashboard.cardholder.toot_card.index', compact('toot_card', 'load_shares', 'reloads'));
        }
        return redirect()->back();
    }

    public function tootCardEditPinCode(User $user) {
        if (Auth::user()->id == $user->id || Auth::user()->hasRole(admin())) {
            return view('dashboard.cardholder.toot_card.pin_code', compact('user'));
        }
        return redirect()->back();
    }

    public function tootCardUpdatePinCode(Requests\PinCodeRequest $request, User $user) {
        $toot_card = $user->tootCards()->first();
        $toot_card->pin_code = $request->get('pin_code');
        $toot_card->save();
        flash()->success(trans('user.toot_card_updated_pin_code'));
        return redirect()->route('users.toot_card', $user->id);
    }

    public function orderHistory(User $user) {
        if (Auth::user()->id == $user->id || Auth::user()->hasRole(admin())) {
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
            return view('dashboard.cardholder.order_history', compact('user', 'transactions', 'orders'));
        }
        return redirect()->back();
    }

    public static function admin() {
        $_users = User::admin();

        if (request()->has('search')) {
            $results = User::searchFor(request()->get('search'), $_users);

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
                $sorted = User::sort(request()->get('sort'), $_users);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $users = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $users = $_users->paginate(intval(Setting::value('per_page')));
            }
        }
        $users->appends(request()->except('page'));
        return view('dashboard.admin.users.admin', compact('users'));
    }

    public static function cardholder() {
        $_users = User::cardholder();

        if (request()->has('search')) {
            $results = User::searchFor(request()->get('search'), $_users);

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
                $sorted = User::sort(request()->get('sort'), $_users);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $users = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $users = $_users->paginate(intval(Setting::value('per_page')));
            }
        }
        $users->appends(request()->except('page'));
        return view('dashboard.admin.users.cardholder', compact('users'));
    }

    public static function cashier() {
        $_users = User::cashier();

        if (request()->has('search')) {
            $results = User::searchFor(request()->get('search'), $_users);

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
                $sorted = User::sort(request()->get('sort'), $_users);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $users = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $users = $_users->paginate(intval(Setting::value('per_page')));
            }
        }
        $users->appends(request()->except('page'));
        return view('dashboard.admin.users.cashier', compact('users'));
    }

    public static function guest() {
        $_users = User::guest();

        if (request()->has('search')) {
            $results = User::searchFor(request()->get('search'), $_users);

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
                $sorted = User::sort(request()->get('sort'), $_users);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $users = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $users = $_users->paginate(intval(Setting::value('per_page')));
            }
        }
        $users->appends(request()->except('page'));
        return view('dashboard.admin.users.guest', compact('users'));
    }
}
