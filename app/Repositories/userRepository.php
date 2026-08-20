<?php

class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(
        string $email
    ): ?array {

        $sql = "
            SELECT
                id,
                name,
                email,
                password,
                role
            FROM users
            WHERE email = :email
            LIMIT 1
        ";

        $statement =
            $this->pdo->prepare($sql);

        $statement->execute([
            "email" => $email
        ]);

        $user =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $user ?: null;
    }
}