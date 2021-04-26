<?php

class Cart
{

    protected $products;
    protected $offerRules;
    protected $deliveryPricing;
    protected $cart;

    public function __construct(array $products, array $offerRules, array $deliveryPricing)
    {
        $this->products = $products;
        $this->offerRules = $offerRules;
        $this->deliveryPricing = $deliveryPricing;
        $this->cart = [];

        //sort delivery pricing by minimum range price descending
        //This make comparison from high price to low

        usort($this->deliveryPricing, function ($a, $b) {
            return $a['price'] > $b['price'] ? -1 : 1;
        });
    }

    //Add item

    public function add(string $item): void
    {

        //Search for item by code in array

        foreach ($this->products as $product) {
            if ($product['code'] == $item) {
                $this->cart[] = $product; // store whole product data to cart
                break;
            }
        }
    }

    //Calculate total

    public function total(): float
    {

        //Find rule match cart items list

        $ruleFired = false;

        //Go through all rules

        foreach ($this->offerRules as $offer) {

            //Check every item of rule

            foreach ($offer['rule'] as $key => $rule) {

                //If cart have no item on corresponding position - break and rule not match

                if (!isset($this->cart[$key])) {
                    $ruleFired = false;
                    break;
                }

                //Rule item may be '*' - any cart item, if not match cart item - break and rule not match

                if ($rule != '*' && $rule != $this->cart[$key]['code']) {
                    $ruleFired = false;
                    break;
                }
                $ruleFired = $offer['price_change']; //Store price change rules for matched rule
            }
            if ($ruleFired !== false) {
                break;
            }
        }

        //Calculate total cost according to matched rule

        $total = 0;
        foreach ($this->cart as $key => $item) {
            if ($ruleFired !== false && isset($ruleFired[$key])) {
                $total += $item['price'] * $ruleFired[$key];
            } else {
                $total += $item['price'];
            }
        }

        //Apply delivery price according to cost range. High range checked first

        $deliveryPrice = 0;
        foreach ($this->deliveryPricing as $delivery) {
            if ($total >= $delivery['price']) {
                $deliveryPrice = $delivery['delivery_price'];
                break;
            }
        }

        return floor(($total + $deliveryPrice) * 100) / 100;
    }
}
