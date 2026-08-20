<?php

        session_start();

        $page =
            $_GET["page"] ?? "dashboard";


        require_once "includes/header.php";


        if ($page === "login") {

            require_once "pages/login.php";

            require_once "includes/footer.php";

            exit;
        }


        require_once "includes/auth.php";

        require_once "includes/navbar.php";

        ?>

        <div class="flex">

            <?php require_once "includes/sidebar.php"; ?>


            <?php

            if ($page === "dashboard") {

                require_once "pages/dashboard.php";

            } elseif ($page === "customers") {

                require_once "pages/customers.php";

            } elseif ($page === "create-customer") {

                require_once "pages/create-customer.php";

            } elseif ($page === "customer-details") {

                require_once "pages/customer-details.php";

            } elseif ($page === "edit-customer") {

                require_once "pages/edit-customer.php";

            } elseif ($page === "delete-customer") {

                require_once "pages/delete-customer.php";

            } elseif ($page === "accounts") {

                require_once "pages/accounts.php";

            } elseif ($page === "create-account") {

                require_once "pages/create-account.php";

            } elseif ($page === "deposit") {

                require_once "pages/deposit.php";

            } elseif ($page === "withdraw") {

                require_once "pages/withdraw.php";

            } elseif ($page === "transactions") {

                require_once "pages/transactions.php";

            } else {

                require_once "pages/dashboard.php";

            }

            ?>

        </div>

        <?php

        require_once "includes/footer.php";