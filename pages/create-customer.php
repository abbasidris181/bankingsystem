<main class="flex-1 p-8">

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Create Customer
        </h2>

        <p class="text-slate-500 mt-2">
            Register a new customer with GPT Bank.
        </p>

    </div>


    <div class="max-w-2xl bg-white rounded-xl shadow-sm border p-8">

        <form method="POST" action="index.php?page=create-customer">

            <div class="mb-5">

                <label
                    for="full_name"
                    class="block text-sm font-medium text-slate-700 mb-2"
                >
                    Full Name
                </label>

                <input
                    type="text"
                    name="full_name"
                    id="full_name"
                    required
                    class="w-full border border-slate-300 rounded-lg
                           px-4 py-3 outline-none
                           focus:ring-2 focus:ring-blue-500"
                >

            </div>


            <div class="mb-5">

                <label
                    for="phone"
                    class="block text-sm font-medium text-slate-700 mb-2"
                >
                    Phone Number
                </label>

                <input
                    type="text"
                    name="phone"
                    id="phone"
                    required
                    class="w-full border border-slate-300 rounded-lg
                           px-4 py-3 outline-none
                           focus:ring-2 focus:ring-blue-500"
                >

            </div>


            <div class="mb-6">

                <label
                    for="email"
                    class="block text-sm font-medium text-slate-700 mb-2"
                >
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    required
                    class="w-full border border-slate-300 rounded-lg
                           px-4 py-3 outline-none
                           focus:ring-2 focus:ring-blue-500"
                >

            </div>


            <button
                type="submit"
                class="bg-blue-700 hover:bg-blue-800
                       text-white px-6 py-3
                       rounded-lg font-medium"
            >
                <i class="fa-solid fa-user-plus mr-2"></i>

                Create Customer
            </button>

        </form>

    </div>

</main>