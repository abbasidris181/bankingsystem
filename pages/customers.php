<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/Models/Customer.php";
require_once __DIR__ . "/../app/Repositories/CustomerRepository.php";

$repository = new CustomerRepository($pdo);

$customers = $repository->all();

?>





<main class="flex-1 p-8">

    <div class="flex items-center justify-between mb-8">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">
                Customers
            </h2>

            <p class="text-slate-500 mt-2">
                Manage all registered bank customers.
            </p>

        </div>

        <a
            href="index.php?page=create-customer"
            class="bg-blue-700 hover:bg-blue-800
                   text-white px-5 py-3 rounded-lg"
        >
            <i class="fa-solid fa-plus mr-2"></i>

            Add Customer
        </a>

    </div>


    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-50 border-b">

                <tr>

                    <th class="text-left p-4">Name</th>

                    <th class="text-left p-4">Phone</th>

                    <th class="text-left p-4">Email</th>

                    <th class="text-left p-4">Action</th>

                </tr>

            </thead>

            <tbody>

                <?php if (empty($customers)): ?>

                    <tr>

                        <td
                            colspan="4"
                            class="text-center p-10 text-slate-500"
                        >
                            No customers registered yet.
                        </td>

                    </tr>

                <?php else: ?>


                    <?php foreach ($customers as $customer): ?>

                        <tr class="border-b hover:bg-slate-50">

                            <td class="p-4 font-medium text-slate-800">

                                <?= htmlspecialchars(
                                    $customer["full_name"]
                                ) ?>

                            </td>


                            <td class="p-4 text-slate-600">

                                <?= htmlspecialchars(
                                    $customer["phone"]
                                ) ?>

                            </td>


                            <td class="p-4 text-slate-600">

                                <?= htmlspecialchars(
                                    $customer["email"]
                                ) ?>

                            </td>


                            <td class="p-4">

                                <a
                                    href="index.php?page=customer-details&id=<?= $customer['id'] ?>"
                                    class="text-blue-600 hover:text-blue-800 mr-3"
                                >
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a
                                    href="index.php?page=edit-customer&id=<?= $customer['id'] ?>"
                                    class="text-amber-500 hover:text-amber-700 mr-3"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <!-- <button
                                    class="text-red-600 hover:text-red-800"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button> -->


                                <!-- <button
                                    type="button"
                                    class="text-red-600 hover:text-red-800 delete-customer"
                                    data-id="<?= $customer['id'] ?>"
                                    data-name="<?= htmlspecialchars($customer['full_name']) ?>"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button> -->
                                
                            <form
                                method="POST"
                                action="index.php?page=delete-customer"
                                class="inline delete-form"
                            >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $customer['id'] ?>"
                                >

                                <button
                                    type="button"
                                    class="text-red-600 hover:text-red-800 delete-customer"
                                    data-name="<?= htmlspecialchars($customer['full_name']) ?>"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>


                <?php endif; ?>

                </tbody>

        </table>

    </div>

</main>