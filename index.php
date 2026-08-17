<?php

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

    } else {

        require_once "pages/dashboard.php";

    }

    ?>

</div>

<?php

require_once "includes/footer.php";

?>