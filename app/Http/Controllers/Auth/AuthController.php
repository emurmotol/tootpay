<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    protected $username = 'id';

    protected $maxLoginAttempts = 3;

    public function __construct() {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'id' => 'required|numeric|unique:users',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|numeric',
            'password' => 'required|min:6',
        ]);
    }

    protected function create(array $data) {
        $user = User::create([
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']),
        ]);
        $user->roles()->attach(Role::find(Role::json(2)));
        return $user;
    }

    public function showRegistrationForm() {
        return redirect('login');
    }
}
