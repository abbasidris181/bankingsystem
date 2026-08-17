<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/Repositories/CustomerRepository.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php?page=customers");
    exit;

}


$id = (int) ($_POST["id"] ?? 0);


if ($id <= 0) {

    $_SESSION["error"] =
        "Invalid customer.";

    header("Location: index.php?page=customers");
    exit;

}


$repository = new CustomerRepository($pdo);

$customer = $repository->find($id);


if (!$customer) {

    $_SESSION["error"] =
        "Customer not found.";

    header("Location: index.php?page=customers");
    exit;

}


try {

    $repository->delete($id);

    $_SESSION["success"] =
        "Customer deleted successfully.";

} catch (PDOException $e) {

    $_SESSION["error"] =
        "Unable to delete customer.";

}


header("Location: index.php?page=customers");

exit;