<?php

class Customer
{
    private $id;
    private $fullName;
    private $phone;
    private $email;

    public function __construct(
        $fullName,
        $phone,
        $email,
        $id = null
    ) {
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->email = $email;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
?>
