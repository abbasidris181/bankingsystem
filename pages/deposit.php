<?php

require_once __DIR__ . "/../config/database.php";

require_once __DIR__ . "/../app/Interfaces/AccountInterface.php";

require_once __DIR__ . "/../app/Models/BankAccount.php";
require_once __DIR__ . "/../app/Models/SavingsAccount.php";
require_once __DIR__ . "/../app/Models/CurrentAccount.php";
require_once __DIR__ . "/../app/Models/Transaction.php";

require_once __DIR__ . "/../app/Repositories/AccountRepository.php";
require_once __DIR__ . "/../app/Repositories/TransactionRepository.php";

require_once __DIR__ . "/../app/Services/TransactionService.php";


$accountRepository =
    new AccountRepository($pdo);

$transactionRepository =
    new TransactionRepository($pdo);

$service =
    new TransactionService(
        $pdo,
        $accountRepository,
        $transactionRepository
    );


$accounts =
    $accountRepository->all();


$errors = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {


     verifyCsrf();

    $accountId =
        (int) ($_POST["account_id"] ?? 0);

    $amount =
        (float) ($_POST["amount"] ?? 0);


    try {

        $service->deposit(
            $accountId,
            $amount
        );


        $_SESSION["success"] =
            "Deposit completed successfully.";


        header(
            "Location: index.php?page=transactions"
        );

        exit;


    } catch (Throwable $e) {

        $errors[] =
            $e->getMessage();

    }
}

?>


<main class="flex-1 p-8">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">
            Deposit Money
        </h2>

        <p class="text-slate-500 mt-2">
            Credit funds into a bank account.
        </p>
    </div>


    <div class="max-w-2xl bg-white border
                rounded-xl shadow-sm p-8">

        <?php if (!empty($errors)): ?>

            <div class="mb-6 bg-red-50
                        border border-red-200
                        text-red-700 p-4 rounded-lg">

                <?= htmlspecialchars($errors[0]) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="index.php?page=deposit"
        >


            <?= csrfField() ?>


            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    Account
                </label>

                <select
                    name="account_id"
                    required
                    class="w-full border rounded-lg
                           px-4 py-3"
                >

                    <option value="">
                        Select Account
                    </option>

                    <?php foreach ($accounts as $account): ?>

                        <option value="<?= $account['id'] ?>">

                            <?= htmlspecialchars(
                                $account["account_number"]
                            ) ?>

                            -

                            <?= htmlspecialchars(
                                $account["full_name"]
                            ) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Amount
                </label>

                <input
                    type="number"
                    name="amount"
                    min="0.01"
                    step="0.01"
                    required
                    class="w-full border rounded-lg
                           px-4 py-3"
                >

            </div>


            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700
                       text-white px-6 py-3 rounded-lg"
            >

                <i class="fa-solid fa-arrow-down mr-2"></i>

                Deposit

            </button>

        </form>

    </div>

</main>