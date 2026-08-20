<?php

session_start();


$_SESSION = [];


session_destroy();


session_start();


$_SESSION["success"] =
    "You have been signed out successfully.";


header(
    "Location: /BankingSystem/index.php?page=login"
);

exit;