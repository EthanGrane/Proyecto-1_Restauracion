<?php

class Order
{
    public int $id;
    public ?int $discount_id;
    public int $user_id;
    public float $total_price;
    public string $date;

    // public function __construct($discount_id, $user_id, $total_price)
    // {
    //     $this->discount_id = $discount_id;
    //     $this->user_id = $user_id;
    //     $this->total_price = $total_price;
    // }

}
?>
