<?php

function admin() {
    return \App\Models\Role::json(0);
}

function cashier() {
    return \App\Models\Role::json(1);
}

function cardholder() {
    return \App\Models\Role::json(2);
}

function guest() {
    return \App\Models\Role::json(3);
}
