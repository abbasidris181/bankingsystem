<?php

class SavingsAccount extends BankAccount
{
    private float $interestRate;

    public function __construct(
        int $customerId,
        string $accountNumber,
        float $balance,
        float $interestRate = 5,
        ?int $id = null
    ) {
        parent::__construct(
            $customerId,
            $accountNumber,
            $balance,
            $id
        );

        $this->interestRate = $interestRate;
    }

    public function addInterest(): void
    {
        $interest =
            $this->balance *
            ($this->interestRate / 100);

        $this->balance += $interest;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getAccountType(): string
    {
        return "savings";
    }
}