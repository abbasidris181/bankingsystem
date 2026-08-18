<?php

abstract class BankAccount implements AccountInterface
{
    protected ?int $id;
    protected int $customerId;
    protected string $accountNumber;
    protected float $balance;

    public function __construct(
        int $customerId,
        string $accountNumber,
        float $balance = 0,
        ?int $id = null
    ) {
        $this->customerId = $customerId;
        $this->accountNumber = $accountNumber;
        $this->balance = $balance;
        $this->id = $id;
    }

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException(
                "Deposit amount must be greater than zero."
            );
        }

        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException(
                "Withdrawal amount must be greater than zero."
            );
        }

        if ($amount > $this->balance) {
            throw new RuntimeException(
                "Insufficient balance."
            );
        }

        $this->balance -= $amount;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    abstract public function getAccountType(): string;
}