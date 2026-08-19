<?php

class Transaction
{
    private ?int $id;
    private int $accountId;
    private string $type;
    private float $amount;
    private float $balanceBefore;
    private float $balanceAfter;

    public function __construct(
        int $accountId,
        string $type,
        float $amount,
        float $balanceBefore,
        float $balanceAfter,
        ?int $id = null
    ) {
        $this->accountId = $accountId;
        $this->type = $type;
        $this->amount = $amount;
        $this->balanceBefore = $balanceBefore;
        $this->balanceAfter = $balanceAfter;
        $this->id = $id;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getBalanceBefore(): float
    {
        return $this->balanceBefore;
    }

    public function getBalanceAfter(): float
    {
        return $this->balanceAfter;
    }
}