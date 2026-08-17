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

        public function find(int $id): ?array
            {
                $sql = "
                    SELECT
                        id,
                        full_name,
                        phone,
                        email,
                        created_at
                    FROM customers
                    WHERE id = :id
                    LIMIT 1
                ";

                $statement = $this->pdo->prepare($sql);

                $statement->execute([
                    "id" => $id
                ]);

                $customer = $statement->fetch(PDO::FETCH_ASSOC);

                return $customer ?: null;
            }

            public function update(
                    int $id,
                    Customer $customer
                ): bool {

                    $sql = "
                        UPDATE customers
                        SET
                            full_name = :full_name,
                            phone = :phone,
                            email = :email
                        WHERE id = :id
                    ";

                    $statement = $this->pdo->prepare($sql);

                    return $statement->execute([
                        "id" => $id,
                        "full_name" => $customer->getFullName(),
                        "phone" => $customer->getPhone(),
                        "email" => $customer->getEmail()
                    ]);
                }

            public function delete(int $id): bool
                {
                    $sql = "
                        DELETE FROM customers
                        WHERE id = :id
                    ";

                    $statement = $this->pdo->prepare($sql);

                    return $statement->execute([
                        "id" => $id
                    ]);
                }    
}