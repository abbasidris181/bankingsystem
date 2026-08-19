<?php

require_once __DIR__ .
    "/../config/database.php";

require_once __DIR__ .
    "/../app/Models/Transaction.php";

require_once __DIR__ .
    "/../app/Repositories/TransactionRepository.php";


$repository =
    new TransactionRepository($pdo);

$transactions =
    $repository->all();

?>


<main class="flex-1 p-8">

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Transactions
        </h2>

        <p class="text-slate-500 mt-2">
            View all deposits and withdrawals.
        </p>

    </div>


    <div class="bg-white border rounded-xl
                shadow-sm overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-50 border-b">

                <tr>
                    <th class="text-left p-4">Customer</th>
                    <th class="text-left p-4">Account</th>
                    <th class="text-left p-4">Type</th>
                    <th class="text-left p-4">Amount</th>
                    <th class="text-left p-4">Balance After</th>
                    <th class="text-left p-4">Date</th>
                </tr>

            </thead>


            <tbody>

            <?php if (empty($transactions)): ?>

                <tr>

                    <td
                        colspan="6"
                        class="text-center p-10
                               text-slate-500"
                    >
                        No transactions available.
                    </td>

                </tr>

            <?php else: ?>


                <?php foreach ($transactions as $transaction): ?>

                    <tr class="border-b hover:bg-slate-50">

                        <td class="p-4">

                            <?= htmlspecialchars(
                                $transaction["full_name"]
                            ) ?>

                        </td>


                        <td class="p-4">

                            <?= htmlspecialchars(
                                $transaction["account_number"]
                            ) ?>

                        </td>


                        <td class="p-4 capitalize">

                            <?= htmlspecialchars(
                                $transaction["transaction_type"]
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

</main>