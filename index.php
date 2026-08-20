<?php

ob_start();

session_start();

require_once "app/Helpers/helpers.php";

$page =
    $_GET["page"] ?? "dashboard";

require_once "includes/header.php";


if ($page === "login") {

    require_once "pages/login.php";

    require_once "includes/footer.php";

    ob_end_flush();

    exit;
}


require_once "includes/auth.php";
require_once "includes/authorization.php";
require_once "includes/csrf.php";
require_once "includes/navbar.php";


$routes = [

    "dashboard" =>
        "pages/dashboard.php",

    "customers" =>
        "pages/customers.php",

    "create-customer" =>
        "pages/create-customer.php",

    "customer-details" =>
        "pages/customer-details.php",

    "edit-customer" =>
        "pages/edit-customer.php",

    "delete-customer" =>
        "pages/delete-customer.php",

    "accounts" =>
        "pages/accounts.php",

    "create-account" =>
        "pages/create-account.php",

    "account-details" =>
        "pages/account-details.php",

    "deposit" =>
        "pages/deposit.php",

    "withdraw" =>
        "pages/withdraw.php",

    "transfer" =>
        "pages/transfer.php",

    "transactions" =>
        "pages/transactions.php"

];

?>

<div class="flex">

    <?php require_once "includes/sidebar.php"; ?>


    <?php

    if (isset($routes[$page])) {

        require_once $routes[$page];

    } else {

        http_response_code(404);

        require_once "pages/404.php";

    }

    ?>

</div>

<?php

require_once "includes/footer.php";

ob_end_flush();