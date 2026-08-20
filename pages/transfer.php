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


$selectedSource =
    (int) ($_GET["from"] ?? 0);


$errors = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    verifyCsrf();


    $sourceAccountId =
        (int) ($_POST["source_account_id"] ?? 0);

    $destinationAccountId =
        (int) ($_POST["destination_account_id"] ?? 0);

    $amount =
        (float) ($_POST["amount"] ?? 0);


    try {

        $service->transfer(
            $sourceAccountId,
            $destinationAccountId,
            $amount
        );


        $_SESSION["success"] =
            "Transfer completed successfully.";


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


<main class="flex-1 min-w-0 p-8">

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Transfer Money
        </h2>

        <p class="text-slate-500 mt-2">
            Transfer funds between bank accounts.
        </p>

    </div>


    <div class="max-w-2xl bg-white border rounded-xl shadow-sm p-8">


        <?php if (!empty($errors)): ?>

            <div class="bg-red-50 border border-red-200
                        text-red-700 p-4 rounded-lg mb-6">

                <?= htmlspecialchars($errors[0]) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="index.php?page=transfer"
        >

            <?= csrfField() ?>


            <!-- SOURCE ACCOUNT -->

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    From Account
                </label>

                <select
                    name="source_account_id"
                    required
                    class="w-full border rounded-lg px-4 py-3"
                >

                    <option value="">
                        Select Source Account
                    </option>

                    <?php foreach ($accounts as $account): ?>

                        <option
                            value="<?= $account['id'] ?>"

                            <?= $selectedSource === (int) $account["id"]
                                ? "selected"
                                : "" ?>
                        >

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


            <!-- DESTINATION -->

            <div class="mb-5">

                <label class="block mb-2 font-medium">
                    To Account
                </label>

                <select
                    name="destination_account_id"
                    required
                    class="w-full border rounded-lg px-4 py-3"
                >

                    <option value="">
                        Select Destination Account
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


            <!-- AMOUNT -->

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
                    class="w-full border rounded-lg px-4 py-3"
                >

            </div>


            <button
                type="submit"
                class="bg-blue-700 hover:bg-blue-800
                       text-white px-6 py-3 rounded-lg"
            >
                <i class="fa-solid fa-arrow-right-arrow-left mr-2"></i>

                Transfer Funds

            </button>

        </form>

    </div>

</main>