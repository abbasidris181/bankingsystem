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

                <tr>

                    <td
                        colspan="4"
                        class="text-center p-10 text-slate-500"
                    >
                        No customers registered yet.
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</main>