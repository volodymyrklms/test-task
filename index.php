<?php

require_once ('Cart.php');

$products = [
    [
        'name' => 'Red Widget',
        'code' => 'R01',
        'price' => 32.95
    ],
    [
        'name' => 'Green Widget',
        'code' => 'G01',
        'price' => 24.95
    ],
    [
        'name' => 'Blue Widget',
        'code' => 'B01',
        'price' => 7.95
    ]
];

$deliveryPricing = [
    [
        'price' => 90,
        'delivery_price' => 0
    ],
    [
        'price' => 50,
        'delivery_price' => 2.95
    ],
    [
        'price' => 0,
        'delivery_price' => 4.95
    ],
];

$offerRules = [
    [
        'rule' => [
            'R01', '*'
        ],
        'price_change' => [
            1, 0.5
        ]
    ],
    [
        'rule' => [
            'G01', 'G01', 'G01'
        ],
        'price_change' => [
            1, 1, 0
        ]
    ]
];

$cart = new Cart($products, $offerRules, $deliveryPricing);
$cart->add('R01');
$cart->add('R01');
$cart->add('R01');
$cart->add('B01');
$cart->add('B01');
echo $cart->total();