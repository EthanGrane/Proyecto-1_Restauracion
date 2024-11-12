<?php

class Product
{
    private string $name;
    private float $value;

    public function __construct($name, $value)
    {
        $this->$name = $name;
        $this->$value = $value;
    }

    /**
     * Get Product name
     */
    public function GetName(): string
    {
        return $this->name;
    }

    /**
     * Get Product value
     */
    public function GetValue(): float
    {
        return $this->value;
    }
}

?>