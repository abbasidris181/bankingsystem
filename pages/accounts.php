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
    "/../app/Repositories/AccountRepository.php";


$repository =
    new AccountRepository($pdo);

$accounts =
    $repository->all();

?>


<main class="flex-1 p-8">


    <div class="flex justify-between
                items-center mb-8">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">
                Bank Accounts
            </h2>

            <p class="text-slate-500 mt-2">
                Manage customer bank accounts.
            </p>

        </div>


        <a
            href="index.php?page=create-account"
            class="bg-blue-700 hover:bg-blue-800
                   text-white px-5 py-3 rounded-lg"
        >

            <i class="fa-solid fa-plus mr-2"></i>

            Open Account

        </a>

    </div>


    <div class="bg-white border rounded-xl
                shadow-sm overflow-hidden">


        <table class="w-full">

            <thead class="bg-slate-50 border-b">

                <tr>

                    <th class="text-left p-4">
                        Customer
                    </th>

                    <th class="text-left p-4">
                        Account Number
                    </th>

                    <th class="text-left p-4">
                        Type
                    </th>

                    <th class="text-left p-4">
                        Balance
                    </th>

                </tr>

            </thead>


            <tbody>

            <?php if (empty($accounts)): ?>

                <tr>

                    <td
                        colspan="4"
                        class="text-center p-10
                               text-slate-500"
                    >
                        No bank accounts available.
                    </td>

                </tr>

            <?php else: ?>


                <?php foreach ($accounts as $account): ?>

                    <tr class="border-b
                               hover:bg-slate-50">

                        <td class="p-4 font-medium">

                            <?= htmlspecialchars(
                                $account["full_name"]
                            ) ?>

                        </td>


                        <td class="p-4">

                            <?= htmlspecialchars(
                                $account["account_number"]
                            ) ?>

                        </td>


                        <td class="p-4 capitalize">

                            <?= htmlspecialchars(
                                $account["account_type"]
                            ) ?>

                        </td>


                        <td class="p-4 font-semibold">

                            ₦<?= number_format(
                                $account["balance"],
                                2
                            ) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>


            <?php endif; ?>

            </tbody>

        </table>

    </div>

</main>