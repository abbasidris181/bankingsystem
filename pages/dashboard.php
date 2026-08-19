<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/Repositories/DashboardRepository.php";

$dashboardRepository =
    new DashboardRepository($pdo);

$customerCount =
    $dashboardRepository->getCustomerCount();

$accountCount =
    $dashboardRepository->getAccountCount();

$totalBalance =
    $dashboardRepository->getTotalBalance();

$todayDeposits =
    $dashboardRepository->getTodayDeposits();

$recentTransactions =
    $dashboardRepository->getRecentTransactions();

$chartData =
    $dashboardRepository->getTransactionChartData();


$chartLabels = [];
$depositData = [];
$withdrawalData = [];

foreach ($chartData as $row) {

    $chartLabels[] =
        $row["transaction_date"];

    $depositData[] =
        (float) $row["deposits"];

    $withdrawalData[] =
        (float) $row["withdrawals"];
}

?>


<main class="flex-1 min-w-0 p-8 overflow-x-hidden">

    <!-- Page Heading -->

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Welcome Back 👋
        </h2>

        <p class="text-slate-500 mt-2">
            Here's what's happening with your bank today.
        </p>

    </div>


    <!-- Dashboard Statistics -->

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">


        <!-- Customers -->

        <div class="bg-white rounded-xl shadow-sm border p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Total Customers
                    </p>

                    <h3 class="text-3xl font-bold text-slate-800 mt-2">
                        <?= number_format($customerCount) ?>
                    </h3>

                </div>

                <div
                    class="w-12 h-12 rounded-xl bg-blue-100
                           flex items-center justify-center"
                >
                    <i class="fa-solid fa-users text-blue-700 text-xl"></i>
                </div>

            </div>

        </div>


        <!-- Accounts -->

        <div class="bg-white rounded-xl shadow-sm border p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Total Accounts
                    </p>

                    <h3 class="text-3xl font-bold text-slate-800 mt-2">
                        <?= number_format($accountCount) ?>
                    </h3>

                </div>

                <div
                    class="w-12 h-12 rounded-xl bg-green-100
                           flex items-center justify-center"
                >
                    <i class="fa-solid fa-wallet text-green-700 text-xl"></i>
                </div>

            </div>

        </div>


        <!-- Total Balance -->

        <div class="bg-white rounded-xl shadow-sm border p-6 min-w-0">

            <div class="flex items-center gap-4">

                <div class="min-w-0 flex-1">

                    <p class="text-sm text-slate-500">
                        Total Balance
                    </p>

                    <h3 class="text-xl lg:text-2xl font-bold text-slate-800 mt-2 break-words">
                        ₦<?= number_format($totalBalance, 2) ?>
                    </h3>

                </div>

                <div
                    class="shrink-0 w-11 h-11 rounded-xl bg-purple-100
                        flex items-center justify-center"
                >
                    <i class="fa-solid fa-naira-sign text-purple-700 text-lg"></i>
                </div>

            </div>

        </div>

        <!-- Today's Deposits -->

        <div class="bg-white rounded-xl shadow-sm border p-6 min-w-0">

            <div class="flex items-center gap-4">

                <div class="min-w-0 flex-1">

                    <p class="text-sm text-slate-500">
                        Today's Deposits
                    </p>

                    <h3 class="text-xl lg:text-2xl font-bold text-slate-800 mt-2 break-words">
                        ₦<?= number_format($todayDeposits, 2) ?>
                    </h3>

                </div>

                <div
                    class="shrink-0 w-11 h-11 rounded-xl bg-emerald-100
                        flex items-center justify-center"
                >
                    <i class="fa-solid fa-arrow-down text-emerald-700 text-lg"></i>
                </div>

            </div>

        </div>


    <!-- Transaction Chart -->

    <div class="bg-white rounded-xl shadow-sm border p-6 mt-8">

        <div class="mb-6">

            <h3 class="text-lg font-semibold text-slate-800">
                Transaction Activity
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Deposits and withdrawals for the last 7 days.
            </p>

        </div>

        <div class="h-80">

            <canvas id="transactionChart"></canvas>

        </div>

    </div>


    <!-- Recent Transactions -->

    <div class="bg-white rounded-xl shadow-sm border mt-8 overflow-hidden">

        <div class="p-6 border-b">

            <h3 class="font-semibold text-lg text-slate-800">
                Recent Transactions
            </h3>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="text-left p-4">
                            Customer
                        </th>

                        <th class="text-left p-4">
                            Account
                        </th>

                        <th class="text-left p-4">
                            Type
                        </th>

                        <th class="text-left p-4">
                            Amount
                        </th>

                        <th class="text-left p-4">
                            Date
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php if (empty($recentTransactions)): ?>

                    <tr>

                        <td
                            colspan="5"
                            class="p-10 text-center text-slate-500"
                        >
                            No transactions available.
                        </td>

                    </tr>

                <?php else: ?>


                    <?php foreach ($recentTransactions as $transaction): ?>

                        <tr class="border-t">

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


<script>

const transactionChart =
    document.getElementById("transactionChart");

if (transactionChart) {

    new Chart(transactionChart, {

        type: "line",

        data: {

            labels:
                <?= json_encode($chartLabels) ?>,

            datasets: [

                {
                    label: "Deposits",

                    data:
                        <?= json_encode($depositData) ?>,

                    tension: 0.3
                },

                {
                    label: "Withdrawals",

                    data:
                        <?= json_encode($withdrawalData) ?>,

                    tension: 0.3
                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false

        }

    });

}

</script>