<?php

class AccountRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(
        BankAccount $account
    ): bool {

        $interestRate = null;
        $overdraftLimit = null;

        if ($account instanceof SavingsAccount) {

            $interestRate =
                $account->getInterestRate();

        }

        if ($account instanceof CurrentAccount) {

            $overdraftLimit =
                $account->getOverdraftLimit();

        }


        $sql = "
            INSERT INTO accounts (
                customer_id,
                account_number,
                account_type,
                balance,
                interest_rate,
                overdraft_limit
            )
            VALUES (
                :customer_id,
                :account_number,
                :account_type,
                :balance,
                :interest_rate,
                :overdraft_limit
            )
        ";


        $statement =
            $this->pdo->prepare($sql);


        return $statement->execute([

            "customer_id" =>
                $account->getCustomerId(),

            "account_number" =>
                $account->getAccountNumber(),

            "account_type" =>
                $account->getAccountType(),

            "balance" =>
                $account->getBalance(),

            "interest_rate" =>
                $interestRate,

            "overdraft_limit" =>
                $overdraftLimit

        ]);
    }


    public function all(): array
    {
        $sql = "
            SELECT
                accounts.*,
                customers.full_name
            FROM accounts
            INNER JOIN customers
                ON customers.id =
                   accounts.customer_id
            ORDER BY accounts.id DESC
        ";

        $statement =
            $this->pdo->query($sql);

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }
}