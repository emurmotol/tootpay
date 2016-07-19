<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        if (Auth::user()->hasRole(Role::json(0))) {
            return $this->admin();
        }

        if (Auth::user()->hasRole(Role::json(1))) {
            return $this->cashier();
        }

        if (Auth::user()->hasRole(Role::json(2))) {
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
