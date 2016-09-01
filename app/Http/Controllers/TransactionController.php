<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TransactionController extends Controller
{
    public function idle() {
        return view('dashboard.client.idle');
    }

    public function ordering() {
        return view('dashboard.client.ordering');
    }

    public function index() {
        //
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        //
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
