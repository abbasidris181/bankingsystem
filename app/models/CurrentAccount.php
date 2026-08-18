<?php

class CurrentAccount extends BankAccount
{
    private float $overdraftLimit;

    public function __construct(
        int $customerId,
        string $accountNumber,
        float $balance,
        float $overdraftLimit = 0,
        ?int $id = null
    ) {
        parent::__construct(
            $customerId,
            $accountNumber,
            $balance,
            $id
        );

        $this->overdraftLimit =
            $overdraftLimit;
    }

    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException(
                "Withdrawal amount must be greater than zero."
            );
        }

        $available =
            $this->balance +
            $this->overdraftLimit;

        if ($amount > $available) {
            throw new RuntimeException(
                "Withdrawal exceeds available balance and overdraft."
            );
        }

        $this->balance -= $amount;
    }

    public function getOverdraftLimit(): float
    {
        return $this->overdraftLimit;
    }

    public function getAccountType(): string
    {
        return "current";
    }
}