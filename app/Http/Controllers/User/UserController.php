<?php

namespace App\Http\Controllers\User;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
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

    public function create()
    {
        return view('dashboard.admin.users.create');
    }

    public function store(Requests\UserRequest $request)
    {
        $user = User::create($request->all());

        flash()->success(trans('user.created', ['name' => $user->name]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('dashboard.admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('dashboard.admin.users.edit', compact('user'));
    }

    public function update(Requests\UserRequest $request, User $user)
    {
        // todo fails if associated to toot card
        $user->update($request->all());
        flash()->success(trans('user.updated', ['name' => $user->name]));
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        // todo fails if associated to toot card
        $user->delete();
        flash()->success(trans('user.deleted', ['name' => $user->name]));

        if (request()->has('redirect')) {
            return redirect()->to(request()->get('redirect'));
        }
        return redirect()->back();
    }
}
