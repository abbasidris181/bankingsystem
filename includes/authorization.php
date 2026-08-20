<?php

function isAdmin(): bool
{
    return isset($_SESSION["user"])
        && $_SESSION["user"]["role"] === "admin";
}


function hasRole(string $role): bool
{
    return isset($_SESSION["user"])
        && $_SESSION["user"]["role"] === $role;
}


function requireRole(string $role): void
{
    if (!hasRole($role)) {

        $_SESSION["error"] =
            "You are not authorized to perform this action.";

        header(
            "Location: /BankingSystem/index.php?page=dashboard"
        );

        exit;
    }
}