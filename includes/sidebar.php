<?php
function navClass(string $currentPage, string $targetPage): string
{
    if ($currentPage === $targetPage) {
        return "bg-blue-600 text-white";
    }

    return "text-slate-300 hover:bg-slate-800 hover:text-white";
}
?>


<aside class="w-64 bg-slate-900 text-white min-h-[calc(100vh-4rem)] flex-shrink-0">

    <nav class="p-4 space-y-2">

        <a
            href="index.php?page=dashboard"
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white "
                        <?= navClass($page, 'dashboard') ?>                                    >
            <i class="fa-solid fa-house w-5"></i>

            <span>Dashboard</span>
        </a>


        <a
            href="index.php?page=customers"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-slate-300 hover:bg-slate-800 hover:text-white"
                        <?= navClass($page, 'customers') ?>                                >
            <i class="fa-solid fa-users w-5"></i>

            <span>Customers</span>
        </a>


        <a
            href="index.php?page=accounts"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-slate-300 hover:bg-slate-800 hover:text-white"
                            <?= navClass($page, 'accounts') ?>>
            <i class="fa-solid fa-wallet w-5"></i>

            <span>Accounts</span>
        </a>


        <a
            href="index.php?page=deposit"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-slate-300 hover:bg-slate-800 hover:text-white"
                        <?= navClass($page, 'deposit') ?> >
            <i class="fa-solid fa-arrow-down w-5"></i>

            <span>Deposit</span>
        </a>


        <a
            href="index.php?page=withdraw"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-slate-300 hover:bg-slate-800 hover:text-white"
                        <?= navClass($page, 'withdraw') ?>>
            <i class="fa-solid fa-arrow-up w-5"></i>

            <span>Withdraw</span>
        </a>


         <a
            href="index.php?page=transfer"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
                text-slate-300 hover:bg-slate-800 hover:text-white"
                        <?= navClass($page, 'transfer') ?> >

            <i class="fa-solid fa-arrow-right-arrow-left w-5"></i>

            <span>
                Transfer
            </span>

        </a>


        <a
            href="index.php?page=transactions"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-slate-300 hover:bg-slate-800 hover:text-white"
                            <?= navClass($page, 'transactions') ?>>
            <i class="fa-solid fa-receipt w-5"></i>

            <span>Transactions</span>
        </a>

    </nav>

</aside>