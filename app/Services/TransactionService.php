<?php

class TransactionService
{
    private PDO $pdo;
    private AccountRepository $accountRepository;
    private TransactionRepository $transactionRepository;

    public function __construct(
        PDO $pdo,
        AccountRepository $accountRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->pdo = $pdo;
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
    }

    

        public function deposit(
            int $accountId,
            float $amount
        ): void {

            if ($amount <= 0) {
                throw new InvalidArgumentException(
                    "Deposit amount must be greater than zero."
                );
            }

            $accountData =
                $this->accountRepository->find($accountId);

            if (!$accountData) {
                throw new RuntimeException(
                    "Bank account not found."
                );
            }

            $balanceBefore =
                (float) $accountData["balance"];

            $balanceAfter =
                $balanceBefore + $amount;


            try {

                $this->pdo->beginTransaction();


                $this->accountRepository
                    ->updateBalance(
                        $accountId,
                        $balanceAfter
                    );


                $transaction =
                    new Transaction(
                        $accountId,
                        "deposit",
                        $amount,
                        $balanceBefore,
                        $balanceAfter
                    );


                $this->transactionRepository
                    ->create($transaction);


                $this->pdo->commit();


            } catch (Throwable $e) {

                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }

                throw $e;
            }
        }

        public function withdraw(
            int $accountId,
            float $amount
        ): void {

            if ($amount <= 0) {
                throw new InvalidArgumentException(
                    "Withdrawal amount must be greater than zero."
                );
            }


            $accountData =
                $this->accountRepository->find($accountId);


            if (!$accountData) {
                throw new RuntimeException(
                    "Bank account not found."
                );
            }


            if (
                $accountData["account_type"]
                === "savings"
            ) {

                $account =
                    new SavingsAccount(
                        (int) $accountData["customer_id"],
                        $accountData["account_number"],
                        (float) $accountData["balance"],
                        (float) $accountData["interest_rate"],
                        (int) $accountData["id"]
                    );

            } else {

                $account =
                    new CurrentAccount(
                        (int) $accountData["customer_id"],
                        $accountData["account_number"],
                        (float) $accountData["balance"],
                        (float) $accountData["overdraft_limit"],
                        (int) $accountData["id"]
                    );

            }


            $balanceBefore =
                $account->getBalance();


            $account->withdraw($amount);


            $balanceAfter =
                $account->getBalance();


            try {

                $this->pdo->beginTransaction();


                $this->accountRepository
                    ->updateBalance(
                        $accountId,
                        $balanceAfter
                    );


                $transaction =
                    new Transaction(
                        $accountId,
                        "withdrawal",
                        $amount,
                        $balanceBefore,
                        $balanceAfter
                    );


                $this->transactionRepository
                    ->create($transaction);


                $this->pdo->commit();


            } catch (Throwable $e) {

                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }

                throw $e;
            }
        } 

        public function transfer(
            int $sourceAccountId,
            int $destinationAccountId,
            float $amount
        ): void {

            if ($sourceAccountId === $destinationAccountId) {

                throw new InvalidArgumentException(
                    "Source and destination accounts cannot be the same."
                );
            }


            if ($amount <= 0) {

                throw new InvalidArgumentException(
                    "Transfer amount must be greater than zero."
                );
            }


            $sourceData =
                $this->accountRepository
                    ->find($sourceAccountId);

            $destinationData =
                $this->accountRepository
                    ->find($destinationAccountId);


            if (!$sourceData) {

                throw new RuntimeException(
                    "Source account not found."
                );
            }


            if (!$destinationData) {

                throw new RuntimeException(
                    "Destination account not found."
                );
            }

                if (
                    $sourceData["account_type"]
                    === "savings"
                ) {

                    $sourceAccount =
                        new SavingsAccount(
                            (int) $sourceData["customer_id"],
                            $sourceData["account_number"],
                            (float) $sourceData["balance"],
                            (float) $sourceData["interest_rate"],
                            (int) $sourceData["id"]
                        );

                } else {

                    $sourceAccount =
                        new CurrentAccount(
                            (int) $sourceData["customer_id"],
                            $sourceData["account_number"],
                            (float) $sourceData["balance"],
                            (float) $sourceData["overdraft_limit"],
                            (int) $sourceData["id"]
                        );

                }

                    $sourceBalanceBefore =
                    $sourceAccount->getBalance();


                $destinationBalanceBefore =
                    (float) $destinationData["balance"];


                $sourceAccount->withdraw($amount);


                $sourceBalanceAfter =
                    $sourceAccount->getBalance();


                $destinationBalanceAfter =
                    $destinationBalanceBefore
                    + $amount;

                try {

                    $this->pdo->beginTransaction();


                    // Debit source

                    $this->accountRepository
                        ->updateBalance(
                            $sourceAccountId,
                            $sourceBalanceAfter
                        );


                    // Credit destination

                    $this->accountRepository
                        ->updateBalance(
                            $destinationAccountId,
                            $destinationBalanceAfter
                        );


                                $outgoingTransaction =
                                new Transaction(
                                    $sourceAccountId,
                                    "transfer_out",
                                    $amount,
                                    $sourceBalanceBefore,
                                    $sourceBalanceAfter
                                );


                    $this->transactionRepository
                        ->create(
                            $outgoingTransaction
                        );

                                $incomingTransaction =
                    new Transaction(
                        $destinationAccountId,
                        "transfer_in",
                        $amount,
                        $destinationBalanceBefore,
                        $destinationBalanceAfter
                    );


                $this->transactionRepository
                    ->create(
                        $incomingTransaction
                    );


                $this->pdo->commit();


                } catch (Throwable $e) {

                    if ($this->pdo->inTransaction()) {

                        $this->pdo->rollBack();

                    }

                    throw $e;
                }
            }
                                         
}
