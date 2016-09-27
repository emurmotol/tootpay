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

function sendToPhoneNumber($phone_number, $view, $data = null) {
    $sms = new \App\Libraries\SmsGateway(config('mail.from.address'), config('sms.password'));
    return $sms->sendMessageToNumber($phone_number, (String)view($view, compact('data')), config('sms.device'));
}

function sendToEmail($email, $view, $data = null) {
    return \Illuminate\Support\Facades\Mail::send($view, compact('data'), function ($message) use ($email) {
        $message->from(config('mail.from.address'), config('mail.from.name'));
        $message->to($email);
    });
}

function sendToPhoneNumberAndEmail($phone_number, $email, $view, $data = null) {
    sendToPhoneNumber($phone_number, $view, $data);
    sendToEmail($email, $view, $data);
}