<?php

require_once __DIR__ . "/../config/database.php";

require_once __DIR__ .
    "/../app/Repositories/AccountRepository.php";

require_once __DIR__ .
    "/../app/Repositories/TransactionRepository.php";


        $id = (int) ($_GET["id"] ?? 0);


        $accountRepository =
            new AccountRepository($pdo);

        $transactionRepository =
            new TransactionRepository($pdo);


        $account =
            $accountRepository->find($id);


        if (!$account) {

            $_SESSION["error"] =
                "Bank account not found.";

            header(
                "Location: index.php?page=accounts"
            );

            exit;
        }


        $transactions =
            $transactionRepository
                ->findByAccount($id);

?>

<main class="flex-1 min-w-0 p-8">

    <div class="flex items-center justify-between mb-8">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">
                Account Details
            </h2>

            <p class="text-slate-500 mt-2">
                View account information and transaction history.
            </p>

        </div>

        <a
            href="index.php?page=transfer&from=<?= $account['id'] ?>"
            class="bg-blue-700 hover:bg-blue-800
                   text-white px-5 py-3 rounded-lg"
        >
            <i class="fa-solid fa-arrow-right-arrow-left mr-2"></i>
            Transfer Money
        </a>

    </div>


    <!-- ACCOUNT SUMMARY -->

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white border rounded-xl p-6">

            <p class="text-sm text-slate-500">
                Customer
            </p>

            <p class="font-bold text-lg mt-2">
                <?= htmlspecialchars(
                    $account["full_name"]
                ) ?>
            </p>

        </div>


        <div class="bg-white border rounded-xl p-6">

            <p class="text-sm text-slate-500">
                Account Number
            </p>

            <p class="font-bold text-lg mt-2">
                <?= htmlspecialchars(
                    $account["account_number"]
                ) ?>
            </p>

        </div>


        <div class="bg-white border rounded-xl p-6">

            <p class="text-sm text-slate-500">
                Account Type
            </p>

            <p class="font-bold text-lg mt-2 capitalize">
                <?= htmlspecialchars(
                    $account["account_type"]
                ) ?>
            </p>

        </div>


        <div class="bg-white border rounded-xl p-6 min-w-0">

            <p class="text-sm text-slate-500">
                Current Balance
            </p>

            <p class="font-bold text-xl mt-2 break-words">
                ₦<?= number_format(
                    $account["balance"],
                    2
                ) ?>
            </p>

        </div>

    </div>

    <div class="bg-white border rounded-xl p-6 mt-8">

    <h3 class="text-lg font-semibold mb-5">
        Account Configuration
    </h3>


    <?php if (
        $account["account_type"] === "savings"
    ): ?>

        <p class="text-slate-600">
            Interest Rate:
            <strong>
                <?= number_format(
                    $account["interest_rate"],
                    2
                ) ?>%
            </strong>
        </p>

    <?php else: ?>

        <p class="text-slate-600">
            Overdraft Limit:
            <strong>
                ₦<?= number_format(
                    $account["overdraft_limit"],
                    2
                ) ?>
            </strong>
        </p>

    <?php endif; ?>

</div>

<div class="bg-white border rounded-xl mt-8 overflow-hidden">

    <div class="p-6 border-b">

        <h3 class="text-lg font-semibold">
            Transaction History
        </h3>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full min-w-[700px]">

            <thead class="bg-slate-50">

                <tr>

                    <th class="text-left p-4">
                        Type
                    </th>

                    <th class="text-left p-4">
                        Amount
                    </th>

                    <th class="text-left p-4">
                        Before
                    </th>

                    <th class="text-left p-4">
                        After
                    </th>

                    <th class="text-left p-4">
                        Date
                    </th>

                </tr>

            </thead>


            <tbody>

            <?php if (empty($transactions)): ?>

                <tr>

                    <td
                        colspan="5"
                        class="text-center p-10 text-slate-500"
                    >
                        No transactions found.
                    </td>

                </tr>

            <?php else: ?>


                <?php foreach ($transactions as $transaction): ?>

                    <tr class="border-t">

                        <td class="p-4 capitalize">

                            <?= htmlspecialchars(
                                str_replace(
                                    "_",
                                    " ",
                                    $transaction["transaction_type"]
                                )
                            ) ?>

                        </td>


                        <td class="p-4 font-semibold">

                            ₦<?= number_format(
                                $transaction["amount"],
                                2
                            ) ?>

                        </td>


                        <td class="p-4">

                            ₦<?= number_format(
                                $transaction["balance_before"],
                                2
                            ) ?>

                        </td>


                        <td class="p-4">

                            ₦<?= number_format(
                                $transaction["balance_after"],
                                2
                            ) ?>

                        </td>


                        <td class="p-4 text-slate-500">

                            <?= htmlspecialchars(
                                $transaction["created_at"]
                            ) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>


            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</main>