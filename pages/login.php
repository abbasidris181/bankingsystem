<main class="min-h-screen bg-slate-100 flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">

            <div
                class="w-16 h-16 bg-blue-700
                       text-white rounded-2xl
                       flex items-center justify-center
                       mx-auto mb-4"
            >
                <i class="fa-solid fa-building-columns text-2xl"></i>
            </div>

            <h1 class="text-3xl font-bold text-slate-800">
                GPT Bank PLC
            </h1>

            <p class="text-slate-500 mt-2">
                Sign in to continue to the admin portal.
            </p>

        </div>


        <div class="bg-white border rounded-2xl shadow-sm p-8">

            <form
                method="POST"
                action="/BankingSystem/auth/login.php"
            >

                <div class="mb-5">

                    <label
                        class="block text-sm font-medium
                               text-slate-700 mb-2"
                    >
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        autocomplete="email"
                        class="w-full border border-slate-300
                               rounded-lg px-4 py-3
                               outline-none
                               focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                <div class="mb-6">

                    <label
                        class="block text-sm font-medium
                               text-slate-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full border border-slate-300
                               rounded-lg px-4 py-3
                               outline-none
                               focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                <button
                    type="submit"
                    class="w-full bg-blue-700
                           hover:bg-blue-800
                           text-white font-medium
                           py-3 rounded-lg"
                >
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>

                    Sign In
                </button>

            </form>

        </div>

    </div>

</main>