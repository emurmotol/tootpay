<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $roles_json  = storage_path('app/public/seeds/') . 'roles.json';
        $roles = json_decode(file_get_contents($roles_json), true);
        $admin = $roles[0]['id'];
        $cashier = $roles[1]['id'];
        $cardholder = $roles[2]['id'];

        if (Auth::user()->hasRole($admin)) {
            return $this->admin();
        }

        if (Auth::user()->hasRole($cashier)) {
            return $this->cashier();
        }

        if (Auth::user()->hasRole($cardholder)) {
            return $this->cardholder();
        }
    }

    public function admin() {
        return view('dashboard.admin.index');
    }

    public function cashier() {
        return view('dashboard.cashier.index');
    }

    public function cardholder() {
        return view('dashboard.cardholder.index');
    }

    public function client() {
        return view('dashboard.client.index');
    }
}
