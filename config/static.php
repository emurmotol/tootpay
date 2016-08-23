<?php

return [

    'app' => [
        'name' => 'toot',
        'company' => 'NFIM Food Services',
        'meta' => [
            'author' => 'Klarizon Emar Motol',
            'description' => 'Cashless Payment System using Digital Wallet (Toot Card)',
            'keywords' => 'rfid, smart card, cashless payment, digital payment, electronic payment, food',
        ],
    ],

    'merchandises' => [
        'default_image_name' => 'default-merchandise-image',
    ],

    'status' => [
        'valid',
        'invalid',
        'correct',
        'incorrect',
        'pending',
        'paid',
        'canceled',
        'insufficient_load',
        'success',
    ]
];