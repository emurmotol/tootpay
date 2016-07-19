<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        if (Auth::user()->hasRole(config('static.roles')[0]['id'])) {
            return $this->admin();
        }

        if (Auth::user()->hasRole(config('static.roles')[1]['id'])) {
            return $this->cashier();
        }

        if (Auth::user()->hasRole(config('static.roles')[2]['id'])) {
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
