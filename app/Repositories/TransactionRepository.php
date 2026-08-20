<?php

class TransactionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(
        Transaction $transaction
    ): bool {

        $sql = "
            INSERT INTO transactions (
                account_id,
                transaction_type,
                amount,
                balance_before,
                balance_after
            )
            VALUES (
                :account_id,
                :transaction_type,
                :amount,
                :balance_before,
                :balance_after
            )
        ";

        $statement =
            $this->pdo->prepare($sql);

        return $statement->execute([

            "account_id" =>
                $transaction->getAccountId(),

            "transaction_type" =>
                $transaction->getType(),

            "amount" =>
                $transaction->getAmount(),

            "balance_before" =>
                $transaction->getBalanceBefore(),

            "balance_after" =>
                $transaction->getBalanceAfter()

        ]);
    }

    public function all(): array
    {
        $sql = "
            SELECT
                transactions.*,
                accounts.account_number,
                customers.full_name

            FROM transactions

            INNER JOIN accounts
                ON accounts.id =
                   transactions.account_id

            INNER JOIN customers
                ON customers.id =
                   accounts.customer_id

            ORDER BY transactions.id DESC
        ";

        return $this->pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByAccount(
            int $accountId
        ): array {

            $sql = "
                SELECT
                    id,
                    transaction_type,
                    amount,
                    balance_before,
                    balance_after,
                    created_at
                FROM transactions
                WHERE account_id = :account_id
                ORDER BY id DESC
            ";

            $statement =
                $this->pdo->prepare($sql);

            $statement->execute([
                "account_id" => $accountId
            ]);

            return $statement->fetchAll(
                PDO::FETCH_ASSOC
            );
        }
}