<?php

function csrfToken(): string
{
    if (empty($_SESSION["csrf_token"])) {

        $_SESSION["csrf_token"] =
            bin2hex(random_bytes(32));
    }

    return $_SESSION["csrf_token"];
}


function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' .
        htmlspecialchars(csrfToken()) .
        '">';
}


function verifyCsrf(): void
{
    $submittedToken =
        $_POST["csrf_token"] ?? "";

    $sessionToken =
        $_SESSION["csrf_token"] ?? "";


    if (
        !$sessionToken
        || !$submittedToken
        || !hash_equals(
            $sessionToken,
            $submittedToken
        )
    ) {

        http_response_code(403);

        exit("Invalid CSRF token.");
    }
}