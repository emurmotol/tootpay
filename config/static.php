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
        'VALID_TOOT_CARD',
        'INVALID_TOOT_CARD',
        'CORRECT_PIN_CODE',
        'INCORRECT_PIN_CODE',
        'PENDING',
        'PAID',
        'CANCELED',
        'INSUFFICIENT_BALANCE',
        'SUCCESS',
        'QUEUED',
        'DONE',
        'ON_HOLD',
        'EMPTY',
        'TO_MANY_CARD_TAP',
        'VALID_USER',
        'INVALID_USER',
    ],

    'payment_method' => [
        'CASH',
        'TOOT_CARD',
    ],
];