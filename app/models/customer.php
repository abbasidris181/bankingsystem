<?php

class Customer
{
    private ?int $id;
    private string $fullName;
    private string $phone;
    private string $email;

    public function __construct(
        string $fullName,
        string $phone,
        string $email,
        ?int $id = null
    ) {
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->email = $email;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}