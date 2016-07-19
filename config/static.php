<?php

return [

    'app' => [
        'name' => 'Toot Pay',
        'meta' => [
            'author' => 'Klarizon Emar Motol',
            'description' => 'Cashless Payment System using Digital Wallet (Toot Card)',
            'keywords' => 'rfid, smart card, payment, digital, electronic, food',
        ],
    ],

    'toot_card_count' => 50,

    'settings' => [
        [
            'key' => 'per_page',
            'value' => 30,
        ],
        [
            'key' => 'expire_year_count',
            'value' => 2,
        ],
    ],

    'administrator' => [
        'id' => '00420130131',
        'name' => 'Klarizon Emar Motol',
        'email' => 'klarizonemar@gmail.com',
        'password' => '123qwe',
        'phone_number' => '09261951315',
    ],

    'demo' => [
        'password' => '123qwe',
        'pin_code' => '123456',
    ],

    'roles' => [
        [
            'id' => 111111,
            'name' => 'Administrator',
            'description' => 'The administrator account is a blah blah blah.',
        ],
        [
            'id' => 222222,
            'name' => 'Cashier',
            'description' => 'The cashier account is a blah blah blah.',

        ],
        [
            'id' => 333333,
            'name' => 'Cardholder',
            'description' => 'The cardholder account is a blah blah blah.',
        ],
    ],

    'merchandises' => [
        [
            'name' => 'COKE (MISMO)',
            'price' => 15,
        ],
        [
            'name' => 'TAPSILOG',
            'price' => 45,
        ],
        [
            'name' => 'TOCILOG',
            'price' => 45,
        ],
        [
            'name' => 'HOTSILOG',
            'price' => 30,
        ],
        [
            'name' => 'RICE',
            'price' => 10,
        ],
        [
            'name' => 'CANDY',
            'price' => 1,
        ],
        [
            'name' => 'SKY FLAKES',
            'price' => 10,
        ],
        [
            'name' => 'BULALO',
            'price' => 60,
        ],
        [
            'name' => 'MACARONI SALAD',
            'price' => 20,
        ],
        [
            'name' => 'KOPIKO',
            'price' => 10,
        ],
        [
            'name' => 'TURON',
            'price' => 10,
        ],
        [
            'name' => 'BENG-BENG',
            'price' => 10,
        ],
        [
            'name' => 'BALL PEN (HBW)',
            'price' => 12,
        ],
        [
            'name' => 'SPRITE (MISMO)',
            'price' => 15,
        ],
        [
            'name' => 'PANCIT CANTON',
            'price' => 15,
        ],
        [
            'name' => 'TOKWA\'T BABOY',
            'price' => 50,
        ],
        [
            'name' => 'PARES',
            'price' => 30,
        ],
        [
            'name' => 'SIOMAI',
            'price' => 20,
        ],
        [
            'name' => 'CALDERETA',
            'price' => 45,
        ],
        [
            'name' => 'SPAGHETTI',
            'price' => 20,
        ],
        [
            'name' => 'SOPAS',
            'price' => 20,
        ],
    ],
];