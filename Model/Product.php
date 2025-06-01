<?php

class Product
{
    private int $discount_id;
    private string $name;
    private string $product_type;
    private float $price;
    private bool $enabled;

    public function __construct($discount_id, $name, $price, $product_type, $enabled)
    {
        $this->discount_id = $discount_id;
        $this->name = $name;
        $this->price = $price;
        $this->product_type = $product_type;
        $this->enabled = $enabled;
    }

}

?>