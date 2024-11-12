<?php

class User
{
    private string $name;
    private string $mail;

    public function __construct($name, $mail)
    {
        $this->$name = $name;
        $this->$mail = $mail;
    }

    /**
     * Get User mail
     */
    public function GetMail(): string
    {
        return $this->mail;
    }

    /**
     * Get User name
     */
    public function GetName(): string
    {
        return $this->name;
    }
}

?>