<?php

class DashboardRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCustomerCount(): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM customers
        ";

        return (int) $this->pdo
            ->query($sql)
            ->fetchColumn();
    }

    public function getAccountCount(): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM accounts
        ";

        return (int) $this->pdo
            ->query($sql)
            ->fetchColumn();
    }

    public function getTotalBalance(): float
    {
        $sql = "
            SELECT COALESCE(SUM(balance), 0)
            FROM accounts
        ";

        return (float) $this->pdo
            ->query($sql)
            ->fetchColumn();
    }

    public function getTodayDeposits(): float
    {
        $sql = "
            SELECT COALESCE(SUM(amount), 0)
            FROM transactions
            WHERE transaction_type = 'deposit'
            AND DATE(created_at) = CURDATE()
        ";

        return (float) $this->pdo
            ->query($sql)
            ->fetchColumn();
    }

    public function getRecentTransactions(
                int $limit = 5
                ): array {

                $sql = "
                SELECT
                    transactions.transaction_type,
                    transactions.amount,
                    transactions.created_at,
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

                LIMIT :limit
                ";

                $statement = $this->pdo->prepare($sql);

                $statement->bindValue(
                ":limit",
                $limit,
                PDO::PARAM_INT
                );

                $statement->execute();

                return $statement->fetchAll(
                PDO::FETCH_ASSOC
                );
                }

                public function getTransactionChartData(): array
        {
            $sql = "
                SELECT
                    DATE(created_at) AS transaction_date,

                    SUM(
                        CASE
                            WHEN transaction_type = 'deposit'
                            THEN amount
                            ELSE 0
                        END
                    ) AS deposits,

                    SUM(
                        CASE
                            WHEN transaction_type = 'withdrawal'
                            THEN amount
                            ELSE 0
                        END
                    ) AS withdrawals

                FROM transactions

                WHERE created_at >= DATE_SUB(
                    CURDATE(),
                    INTERVAL 6 DAY
                )

                GROUP BY DATE(created_at)

                ORDER BY transaction_date ASC
            ";

            return $this->pdo
                ->query($sql)
                ->fetchAll(PDO::FETCH_ASSOC);
            }
}