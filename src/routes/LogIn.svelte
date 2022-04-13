<script>
    let username, password;

    async function logIn() {
        console.log("es");
        if (username && password) {
            console.log("es2");
            let data = new FormData();
            data.append("username", username);
            data.append("password", password);

            console.log(username, password);

            const URL = "./backend/logIn.php";
            let res = await fetch(URL, {
                method: "POST",
                body: data,
            });

            // console.log("No siema");
            let ans = await res.text();
            console.log(ans);
            if (ans === "success") {
                console.log("lol");
                location.reload();
            } else if (ans === "wrong password") {
                alert("Niepoprawne hasło!");
            } else if (ans === "already logged in") {
                alert("Użytkownik jest zalogowany!");
            } else if (ans === "user doesn't exist") {
                alert("Użytkownik o podanym loginie nie istnieje!");
            }
        }
    }
</script>

<section class="text-gray-600 body-font">
    <div class="container px-5 mx-auto flex flex-wrap items-center">
        <!-- <div class="lg:w-3/5 md:w-1/2 md:pr-16 lg:pr-0 pr-0">
            <h1 class="title-font font-medium text-3xl text-gray-900">
                Slow-carb next level shoindcgoitch ethical authentic, poko
                scenester
            </h1>
            <p class="leading-relaxed mt-4">
                Poke slow-carb mixtape knausgaard, typewriter street art
                gentrify hammock starladder roathse. Craies vegan tousled etsy
                austin.
            </p>
        </div> -->
        <div
            class="lg:w-2/6 md:w-1/2 bg-gray-100 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0"
        >
            <h2 class="text-gray-900 text-lg font-medium title-font mb-5">
                Log In
            </h2>
            <div class="relative mb-4">
                <label for="full-name" class="leading-7 text-sm text-gray-600"
                    >Username</label
                >
                <input
                    type="text"
                    id="full-name"
                    name="full-name"
                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                    bind:value={username}
                />
            </div>
            <div class="relative mb-4">
                <label for="password" class="leading-7 text-sm text-gray-600"
                    >Password</label
                >
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                    bind:value={password}
                />
            </div>
            <button
                class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                on:click={() => logIn()}>Log in</button
            >
            <!-- <p class="text-xs text-gray-500 mt-3">
                Literally you probably haven't heard of them jean shorts.
            </p> -->
        </div>
    </div>
</section>
