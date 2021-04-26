Test task - cart with offer rules and delivery rules

Solution consists of Cart class;

To create new cart object:

$cart = new Cart ($products, $offerRules, $deliveryPricing);

$products is a products list. An array of items:
        'name' - product name (string),
        'code' - product code (string),
        'price' - prodduct price (float)
        
$offerRules is an array of offer rules. Each rule should contain:
        'rule' - an array of products codes, '*' mean any code. If codes order match cart code order, rule is applied
        'price_change' - an array of float. Price multiplier for products in cart, if cart contain more products multiplier of 1
        is applied
        
Rule         'rule' => [
                 'R01', '*'
             ],
             'price_change' => [
                 1, 0.5
             ]
             
            mean "Buy firs R01 product, get any second product for half price"        
        
Rule        [
                'rule' => [
                    'G01', 'G01', 'G01'
                ],
                'price_change' => [
                    1, 1, 0
                ]
            ]        
        
            mean "Buy two G01 products, get third G01 for free"
        
$deliveryPricing is an array of delivery price ranges:
            'price' - minimum range price (float),
            'delivery_price' - delivery price (float)      
            
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
            
            Mean free delivery for cart cost from 90, 2.95 delivery for cost from 50, 4.95 for cost lower than 50
            
Method add() add one item into cart

Method total() calculates total cost with offers and delivery             