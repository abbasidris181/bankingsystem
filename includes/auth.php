<?php

if (!isset($_SESSION["user"])) {

    $_SESSION["error"] =
        "Please sign in to continue.";

    header(
        "Location: /BankingSystem/index.php?page=login"
    );

    exit;
}