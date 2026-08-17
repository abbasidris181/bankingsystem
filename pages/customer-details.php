<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/Models/Customer.php";
require_once __DIR__ . "/../app/Repositories/CustomerRepository.php";

$id = (int) ($_GET["id"] ?? 0);

$repository = new CustomerRepository($pdo);

$customer = $repository->find($id);

if (!$customer) {
    echo "Customer not found.";
    return;
}

?>


<main class="flex-1 p-8">

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Customer Details
        </h2>

        <p class="text-slate-500 mt-2">
            View customer information.
        </p>

    </div>

    <div class="max-w-3xl bg-white border rounded-xl shadow-sm p-8">

        <div class="grid md:grid-cols-2 gap-6">

            <div>
                <p class="text-sm text-slate-500">
                    Full Name
                </p>

                <p class="text-lg font-semibold mt-1">
                    <?= htmlspecialchars($customer["full_name"]) ?>
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">
                    Phone
                </p>

                <p class="text-lg font-semibold mt-1">
                    <?= htmlspecialchars($customer["phone"]) ?>
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">
                    Email
                </p>

                <p class="text-lg font-semibold mt-1">
                    <?= htmlspecialchars($customer["email"]) ?>
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">
                    Registered
                </p>

                <p class="text-lg font-semibold mt-1">
                    <?= htmlspecialchars($customer["created_at"]) ?>
                </p>
            </div>

        </div>

    </div>

</main>