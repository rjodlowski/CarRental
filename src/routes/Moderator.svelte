<script>
    async function getUserType() {
        const URL = "./backend/getUser.php";
        let res = await fetch(URL);
        res = await res.json();
        return res;
    }

    async function getAllQueue() {
        const URL = "./backend/getAllQueue.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);

        return res;
    }

    async function getAllReservations() {
        const URL = "./backend/getAllReservations.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);
        return res;
    }

    async function acceptRequest(id) {
        console.log("Request id: ", id);

        let data = new FormData();
        data.append("queueId", id);
        const URL = "./backend/acceptRequest.php";
        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.text();
        console.log(res);
        return res;
    }

    async function declineRequest(id) {
        console.log("Request id: ", id);

        let data = new FormData();
        data.append("queueId", id);
        const URL = "./backend/declineRequest.php";
        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.text();
        console.log(res);
        return res;
    }

    async function changeDate(id) {
        console.log("Changing date");
        window.location = `./#/moderator/reservation/${id}`;
    }

    function changePage(a) {
        page = a;
        // console.log(page);
    }

    async function updateScheduler() {
        schedulerState == "ON"
            ? (schedulerState = "OFF")
            : (schedulerState = "ON");

        let data = new FormData();
        data.append("schedulerState", schedulerState);
        const URL = "./backend/updateScheduler.php";
        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.text();
        console.log(res);
        return res;

        // console.log("Updating scheduler... ", schedulerState);
    }

    async function symulateTimePass() {
        let daysPassed = document.getElementById("inputTime").value;
        console.log(daysPassed);
        let data = new FormData();
        data.append("daysPassed", daysPassed);
        const URL = "./backend/symulateTimePass.php";
        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.text();
        console.log(res);
        return res;
    }

    // TODO kalkulator + sortowanie po nazwie (ew sotrowanie użytkowników moderator/admin)
    let schedulerState = "OFF";
    let user = getUserType();
    let page = "reservations";
    let queue = getAllQueue();
    let reservations = getAllReservations();
</script>

<section class="text-gray-600 body-font h-4/6">
    {#await user}
        <div>Loading</div>
    {:then userData}
        {#if userData.loggedIn == 1 && userData.userType == "moderator"}
            <div class="px-5 w-11/12 h-full mx-auto justify-start ">
                <div>
                    <button
                        class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                        on:click={() => changePage("reservations")}
                        >Reservations</button
                    >
                    <button
                        class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                        on:click={() => changePage("requests")}>Requests</button
                    >
                    <button
                        class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                        on:click={() => changePage("timePass")}
                        >Time manipulation</button
                    >
                    <button
                        class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                        on:click={() => updateScheduler(2)}
                        >Scheduler {schedulerState}</button
                    >
                </div>
                <div class="flex h-full">
                    {#if page == "reservations"}
                        <div class="w-4/5 h-full mx-2 overflow-auto">
                            <h2
                                class="text-3xl text-white font-medium title-font mb-4"
                            >
                                Reservations
                            </h2>
                            <div class="flex flex-wrap ">
                                {#await reservations}
                                    <div>Loading</div>
                                {:then res}
                                    {#each res as car}
                                        <div class="w-3/4 md:w-1/2 p-4">
                                            <div
                                                class="bg-gray-800 bg-opacity-40 p-6 rounded-lg"
                                            >
                                                <img
                                                    class="h-40 rounded w-full object-cover object-center mb-1"
                                                    src={car.image}
                                                    alt="car"
                                                />
                                                <h2
                                                    class="text-lg text-white font-medium title-font mb-1"
                                                >
                                                    {car.brand} - {car.model}
                                                </h2>
                                                <h3
                                                    class="tracking-widest text-yellow-400 text-xs font-medium title-font"
                                                >
                                                    Price/h: ${car.price_per_hour}
                                                </h3>
                                                <p
                                                    class="leading-relaxed text-sm "
                                                >
                                                    From: {car.start} <br />
                                                    To: {car.end}
                                                </p>
                                                <button
                                                    class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                                                    on:click={() =>
                                                        changeDate(car.id)}
                                                >
                                                    Change date
                                                </button>
                                            </div>
                                        </div>
                                    {/each}
                                {/await}
                            </div>
                        </div>
                    {:else if page == "requests"}
                        <div class="w-4/5 h-full mx-2 overflow-auto">
                            <h2
                                class="text-3xl text-white font-medium title-font mb-4"
                            >
                                Requests
                            </h2>
                            <div class="flex flex-wrap ">
                                {#await queue}
                                    <div>Loading</div>
                                {:then res}
                                    {#each res as car}
                                        <div class="w-6/12 md:w-1/2 p-4">
                                            <div
                                                class="bg-gray-800 bg-opacity-40 p-6 rounded-lg"
                                            >
                                                <img
                                                    class="h-40 rounded w-full object-cover object-center mb-1"
                                                    src={car.image}
                                                    alt="car"
                                                />
                                                <h2
                                                    class="text-lg text-white font-medium title-font mb-1"
                                                >
                                                    {car.brand} - {car.model}
                                                </h2>
                                                <p
                                                    class="leading-relaxed text-sm "
                                                >
                                                    From: {car.start} <br />
                                                    To: {car.end}
                                                </p>
                                                <p
                                                    class="leading-relaxed text-sm "
                                                >
                                                    Status: {car.name}
                                                </p>
                                                <button
                                                    class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                                                    on:click={() =>
                                                        acceptRequest(car.id)}
                                                    >Accept</button
                                                >
                                                <button
                                                    class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                                                    on:click={() =>
                                                        declineRequest(car.id)}
                                                    >Decline</button
                                                >
                                            </div>
                                        </div>
                                    {/each}
                                {/await}
                            </div>
                        </div>
                    {:else if page == "timePass"}
                        <div>
                            <p>Days to move date by:</p>
                            <input
                                type="number"
                                name=""
                                id="inputTime"
                                value="2"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            />
                            <button
                                class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                                on:click={() => symulateTimePass()}
                                >Switch</button
                            >
                        </div>
                    {/if}
                </div>
            </div>
        {:else}
            <div
                class="lg:w-3/5 mx-auto w-full flex justify-center items-center text-6xl text-white font-bold text-center"
            >
                Nie masz uprawnień do wyświetlania tej strony!
            </div>
        {/if}
    {/await}
</section>
