<?php

session_start();
require_once "includes/header.php";
require_once "includes/navbar.php";

?>

<div class="flex">

    <?php require_once "includes/sidebar.php"; ?>

    <?php

    $page = $_GET["page"] ?? "dashboard";

    if ($page === "customers") {

        require_once "pages/customers.php";

    } elseif ($page === "create-customer") {

        require_once "pages/create-customer.php";

    }
    
    elseif ($page === "customer-details") {

    require_once "pages/customer-details.php";

    }

    elseif ($page === "edit-customer") {

    require_once "pages/edit-customer.php";

    }


    
    elseif ($page === "delete-customer") {

    require_once "pages/delete-customer.php";

    }

    else {

        require_once "pages/dashboard.php";

    }

    ?>

</div>

<?php

require_once "includes/footer.php";

?>