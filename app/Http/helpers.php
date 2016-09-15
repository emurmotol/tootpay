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

function sendSms($phone_number, $message) {
    $sms = new \App\Libraries\SmsGateway(config('mail.from.address'), config('sms.password'));
    return $sms->sendMessageToNumber($phone_number, $message, config('sms.device'));
}

function sendEmail() {

}