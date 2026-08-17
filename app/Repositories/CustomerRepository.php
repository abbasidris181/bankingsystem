<?php

class CustomerRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Customer $customer): bool
    {
        $sql = "
            INSERT INTO customers (
                full_name,
                phone,
                email
            )
            VALUES (
                :full_name,
                :phone,
                :email
            )
        ";

        $statement = $this->pdo->prepare($sql);

        return $statement->execute([
            "full_name" => $customer->getFullName(),
            "phone" => $customer->getPhone(),
            "email" => $customer->getEmail()
        ]);
    }

    public function all(): array
        {
            $sql = "
                SELECT
                    id,
                    full_name,
                    phone,
                    email,
                    created_at
                FROM customers
                ORDER BY id DESC
            ";

            $statement = $this->pdo->query($sql);

            return $statement->fetchAll(
                PDO::FETCH_ASSOC
            );
        }
}