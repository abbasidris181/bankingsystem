<?php

require_once __DIR__ .
    "/../config/database.php";

require_once __DIR__ .
    "/../app/Interfaces/AccountInterface.php";

require_once __DIR__ .
    "/../app/Models/BankAccount.php";

require_once __DIR__ .
    "/../app/Models/SavingsAccount.php";

require_once __DIR__ .
    "/../app/Models/CurrentAccount.php";

require_once __DIR__ .
    "/../app/Repositories/CustomerRepository.php";

require_once __DIR__ .
    "/../app/Repositories/AccountRepository.php";


$customerRepository =
    new CustomerRepository($pdo);

$customers =
    $customerRepository->all();


$errors = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $customerId =
        (int) ($_POST["customer_id"] ?? 0);

    $accountType =
        $_POST["account_type"] ?? "";

    $openingBalance =
        (float) ($_POST["opening_balance"] ?? 0);


    if ($customerId <= 0) {
        $errors[] =
            "Please select a customer.";
    }


    if (!in_array(
        $accountType,
        ["savings", "current"],
        true
    )) {
        $errors[] =
            "Please select a valid account type.";
    }


    if ($openingBalance < 0) {
        $errors[] =
            "Opening balance cannot be negative.";
    }


    if (empty($errors)) {

        try {

            $accountNumber =
                (string) random_int(
                    1000000000,
                    9999999999
                );


            if ($accountType === "savings") {

                $interestRate =
                    (float) (
                        $_POST["interest_rate"]
                        ?? 5
                    );

                $account =
                    new SavingsAccount(
                        $customerId,
                        $accountNumber,
                        $openingBalance,
                        $interestRate
                    );

            } else {

                $overdraftLimit =
                    (float) (
                        $_POST["overdraft_limit"]
                        ?? 0
                    );

                $account =
                    new CurrentAccount(
                        $customerId,
                        $accountNumber,
                        $openingBalance,
                        $overdraftLimit
                    );
            }


            $repository =
                new AccountRepository($pdo);

            $repository->create($account);


            $_SESSION["success"] =
                "Bank account created successfully.";


            header(
                "Location: index.php?page=accounts"
            );

            exit;


        } catch (Throwable $e) {

            $errors[] =
                "Unable to create account.";

        }

    }
}

?>


<main class="flex-1 p-8">

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Open Bank Account
        </h2>

        <p class="text-slate-500 mt-2">
            Create a savings or current account
            for an existing customer.
        </p>

    </div>


    <div class="max-w-2xl bg-white border
                rounded-xl shadow-sm p-8">


        <form
            method="POST"
            action="index.php?page=create-account"
        >


            <div class="mb-5">

                <label
                    class="block text-sm font-medium
                           text-slate-700 mb-2"
                >
                    Customer
                </label>

                <select
                    name="customer_id"
                    required
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

                    <option value="">
                        Select Customer
                    </option>

                    <?php foreach ($customers as $customer): ?>

                        <option
                            value="<?= $customer['id'] ?>"
                        >
                            <?= htmlspecialchars(
                                $customer["full_name"]
                            ) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="mb-5">

                <label
                    class="block text-sm font-medium
                           text-slate-700 mb-2"
                >
                    Account Type
                </label>

                <select
                    name="account_type"
                    id="account_type"
                    required
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

                    <option value="">
                        Select Type
                    </option>

                    <option value="savings">
                        Savings Account
                    </option>

                    <option value="current">
                        Current Account
                    </option>

                </select>

            </div>


            <div class="mb-5">

                <label
                    class="block text-sm font-medium
                           text-slate-700 mb-2"
                >
                    Opening Balance
                </label>

                <input
                    type="number"
                    name="opening_balance"
                    min="0"
                    step="0.01"
                    value="0"
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

            </div>


            <div
                id="interest-section"
                class="mb-5 hidden"
            >

                <label
                    class="block text-sm font-medium
                           text-slate-700 mb-2"
                >
                    Interest Rate (%)
                </label>

                <input
                    type="number"
                    name="interest_rate"
                    value="5"
                    min="0"
                    step="0.01"
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

            </div>


            <div
                id="overdraft-section"
                class="mb-5 hidden"
            >

                <label
                    class="block text-sm font-medium
                           text-slate-700 mb-2"
                >
                    Overdraft Limit
                </label>

                <input
                    type="number"
                    name="overdraft_limit"
                    value="0"
                    min="0"
                    step="0.01"
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

            </div>


            <button
                type="submit"
                class="bg-blue-700 hover:bg-blue-800
                       text-white px-6 py-3
                       rounded-lg font-medium"
            >

                <i class="fa-solid fa-wallet mr-2"></i>

                Create Account

            </button>

        </form>

    </div>

</main>