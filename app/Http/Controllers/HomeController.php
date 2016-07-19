<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'index', 'faq',
        ]);
    }

    public function index()
    {
        if (Auth::guest()) {
            return view('welcome');
        }
        return $this->home();
    }

    public function home()
    {
        return app('App\Http\Controllers\DashboardController')->index();
    }

    public function faq()
    {
        return view('faq');
    }
}
