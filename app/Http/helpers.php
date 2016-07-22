<?php

function paginator($array = array()) {
    $total = count($array);
    $per_page = intval(\App\Models\Setting::value('per_page'));
    $page = \Illuminate\Support\Facades\Input::get('page', 1);
    $offset = ($page * $per_page) - $per_page;
    $items = array_slice($array, $offset, $per_page, true);
    return (new \Illuminate\Pagination\LengthAwarePaginator($items, $total, $per_page, $page, [
            'path'  => request()->url(),
            'query' => request()->query(),
        ]
    ));
}

function admin() {
    return \App\Models\Role::json(0);
}

function cashier() {
    return \App\Models\Role::json(1);
}

function cardholder() {
    return \App\Models\Role::json(2);
}