<script>
    async function getUser() {
        const URL = "./backend/getUser.php";
        let res = await fetch(URL);
        res = await res.json();
        return res;
    }

    async function logOut() {
        console.log("es");
        const URL = "./backend/logOut.php";
        let res = await fetch(URL);
        res = await res.text();
        location.reload();
        window.location = "./#/";
        return res;
    }

    let userData = getUser();
</script>

<header class="text-gray-400 bg-gray-900 body-font">
    <div
        class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center"
    >
        <span
            class="flex title-font font-medium items-center text-white mb-4 md:mb-0"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                class="w-10 h-10 text-white p-2 bg-yellow-500 rounded-full"
                viewBox="0 0 24 24"
            >
                <path
                    d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                />
            </svg>
            <span class="ml-3 text-xl">Car rental</span>
        </span>
        <nav
            class="md:ml-auto flex flex-wrap items-center text-base justify-center"
        >
            <a href="./#/" class="mr-5 hover:text-white">Cars</a>
            <a href="./#/signup" class="mr-5 hover:text-white">Sign Up</a>
            <a href="./#/login" class="mr-5 hover:text-white">Log In</a>
            {#await userData then res}
                {#if res.loggedIn == 1}
                    {#if res.userType == "user"}
                        <a href="./#/reservations" class="mr-5 hover:text-white"
                            >Your reservations</a
                        >
                    {:else if res.userType == "moderator"}
                        <a href="./#/moderator" class="mr-5 hover:text-white"
                            >Moderator panel</a
                        >
                    {:else if res.userType == "admin"}
                        <a href="./#/admin" class="mr-5 hover:text-white"
                            >Admin panel</a
                        >
                    {/if}
                    <button
                        class="inline-flex items-center bg-gray-800 border-0 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base mt-4 md:mt-0"
                        on:click={() => logOut()}
                        >Log out
                        <svg
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            class="w-4 h-4 ml-1"
                            viewBox="0 0 24 24"
                        >
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                {/if}
            {/await}
        </nav>
    </div>
</header>
