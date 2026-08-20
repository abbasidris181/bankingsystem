<?php

session_start();

require_once __DIR__ .
    "/../config/database.php";

require_once __DIR__ .
    "/../app/Repositories/UserRepository.php";


if (
    $_SERVER["REQUEST_METHOD"]
    !== "POST"
) {

    header(
        "Location: /BankingSystem/index.php?page=login"
    );

    exit;
}


$email =
    trim($_POST["email"] ?? "");

$password =
    $_POST["password"] ?? "";


if (
    $email === ""
    || $password === ""
) {

    $_SESSION["error"] =
        "Email and password are required.";

    header(
        "Location: /BankingSystem/index.php?page=login"
    );

    exit;
}


$repository =
    new UserRepository($pdo);

$user =
    $repository->findByEmail($email);


if (
    !$user
    || !password_verify(
        $password,
        $user["password"]
    )
) {

    $_SESSION["error"] =
        "Invalid email or password.";

    header(
        "Location: /BankingSystem/index.php?page=login"
    );

    exit;
}


session_regenerate_id(true);


$_SESSION["user"] = [

    "id" =>
        (int) $user["id"],

    "name" =>
        $user["name"],

    "email" =>
        $user["email"],

    "role" =>
        $user["role"]

];


$_SESSION["success"] =
    "Welcome back, " .
    $user["name"] .
    ".";


header(
    "Location: /BankingSystem/index.php?page=dashboard"
);

exit;