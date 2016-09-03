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

function groupSum($array) {
    $sums = array();

    foreach ($array as $key => $values) {
        foreach ($values as $label => $count) {

            if (!array_key_exists($label, $sums)) {
                $sums[$label] = 0;
            }
            $sums[$label] += $count;
        }
    }
    arsort($sums);
    return $sums;
}
