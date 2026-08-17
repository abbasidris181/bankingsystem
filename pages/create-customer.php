<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/Models/Customer.php";
require_once __DIR__ . "/../app/Repositories/CustomerRepository.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullName = trim($_POST["full_name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");

    $errors = [];


    if ($fullName === "") {
        $errors[] = "Full name is required.";
    }


    if ($phone === "") {
        $errors[] = "Phone number is required.";
    }


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }


    if (empty($errors)) {

        try {

            $customer = new Customer(
                $fullName,
                $phone,
                $email
            );

            $repository = new CustomerRepository($pdo);

            $repository->create($customer);


            $_SESSION["success"] =
                "Customer created successfully.";

            header(
                "Location: index.php?page=customers"
            );

            exit;


        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {

                $errors[] =
                    "A customer with this email already exists.";

            } else {

                $errors[] =
                    "Something went wrong while saving the customer.";
            }

        }

    }

}
?>



<main class="flex-1 p-8">

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Create Customer
        </h2>

        <p class="text-slate-500 mt-2">
            Register a new customer with GPT Bank.
        </p>

    </div>

    <?php if (!empty($errors)): ?>

    <div class="mb-6 bg-red-50 border border-red-200
                text-red-700 rounded-lg p-4">

        <div class="flex items-start gap-3">

            <i class="fa-solid fa-circle-exclamation mt-1"></i>

            <div>

                <p class="font-semibold mb-2">
                    Please correct the following:
                </p>

                <ul class="list-disc ml-5 space-y-1">

                    <?php foreach ($errors as $error): ?>

                        <li>
                            <?= htmlspecialchars($error) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

    </div>

<?php endif; ?>
    <div class="max-w-2xl bg-white rounded-xl shadow-sm border p-8">

        <form method="POST" action="index.php?page=create-customer">

            <div class="mb-5">

                <label
                    for="full_name"
                    class="block text-sm font-medium text-slate-700 mb-2"
                >
                    Full Name
                </label>
                <input
                    type="text"
                    name="full_name"
                    id="full_name"
                    value="<?= htmlspecialchars($fullName ?? '') ?>"
                    required
                    class="w-full border border-slate-300 rounded-lg
                        px-4 py-3 outline-none
                        focus:ring-2 focus:ring-blue-500"
                >

            </div>


            <div class="mb-5">

                <label
                    for="phone"
                    class="block text-sm font-medium text-slate-700 mb-2"
                >
                    Phone Number
                </label>

                <input
                    type="text"
                    value="<?= htmlspecialchars($phone ?? '') ?>"
                    name="phone"
                    id="phone"
                    required
                    class="w-full border border-slate-300 rounded-lg
                           px-4 py-3 outline-none
                           focus:ring-2 focus:ring-blue-500"
                >

            </div>


            <div class="mb-6">

                <label
                    for="email"
                    class="block text-sm font-medium text-slate-700 mb-2"
                >
                    Email Address
                </label>

                <input
                    type="email"
                    value="<?= htmlspecialchars($email ?? '') ?>"
                    name="email"
                    id="email"
                    required
                    class="w-full border border-slate-300 rounded-lg
                           px-4 py-3 outline-none
                           focus:ring-2 focus:ring-blue-500"
                >

            </div>


            <button
                type="submit"
                class="bg-blue-700 hover:bg-blue-800
                       text-white px-6 py-3
                       rounded-lg font-medium"
            >
                <i class="fa-solid fa-user-plus mr-2"></i>

                Create Customer
            </button>

        </form>

    </div>

</main>