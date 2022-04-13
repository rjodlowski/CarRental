<script>
    export let params = {};
    let id = params.id;
    let car = getReservation();
    let startDate, endDate;
    let user = getUserType();
    let statuses = getRentStatuses();

    async function getUserType() {
        const URL = "./backend/getUser.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);
        return res;
    }

    async function getReservation() {
        let data = new FormData();
        data.append("id", id);
        const URL = "./backend/getReservation.php";
        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.json();

        startDate = res.start;
        endDate = res.end;

        console.log(res);
        return res;
    }

    async function getRentStatuses() {
        const URL = "./backend/getRentStatuses.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log("Rent statuses", res);
        return res;
    }

    async function changeRentStatus(id) {
        console.log("changeRentStatus");
        let newStatus = document.getElementById("rentStatusSelect").value;
        console.log(id, newStatus);
        const URL = "./backend/changeRentStatus.php";
        let data = new FormData();
        data.append("id", id);
        data.append("newStatus", newStatus);

        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.text();
        if (res == "success") {
            alert("Successfully changed rent status!");
        }
        console.log(res);
    }

    async function changeDate(id) {
        console.log("Changing date");
        console.log(id, startDate, endDate);
        if (startDate < endDate) {
            const URL = "./backend/changeReservationDate.php";
            let data = new FormData();
            data.append("id", id);
            data.append("start", startDate);
            data.append("end", endDate);
            let res = await fetch(URL, {
                method: "POST",
                body: data,
            });
            res = await res.text();

            console.log(res);
            if (res == "success") {
                alert("Successfully changed date!");
            }
        } else {
            alert("Data końcowa musi być po dacie początkowej!");
        }
    }
</script>

<section class="text-gray-600 body-font">
    {#await user then userData}
        {#if userData.loggedIn == 1 && userData.userType == "moderator"}
            {#await car}
                loading
            {:then data}
                <section class="text-gray-400 bg-gray-900 body-font">
                    <div
                        class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center"
                    >
                        <div
                            class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 md:mb-0 mb-10"
                        >
                            <img
                                class="object-cover object-center rounded"
                                alt="hero"
                                src={data.image}
                            />
                        </div>
                        <div
                            class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center"
                        >
                            <h1
                                class="title-font sm:text-4xl text-3xl mb-4 font-medium text-white"
                            >
                                {data.brand}
                                <br class="hidden lg:inline-block" />
                                {data.model}
                            </h1>
                            <p class="leading-relaxed">
                                Price per day: ${data.price_per_hour}
                            </p>
                            {#await statuses}
                                <p>Loading</p>
                            {:then data2}
                                <p class="leading-relaxed">Rent status:</p>
                                <select
                                    class="mb-2 text-black"
                                    id="rentStatusSelect"
                                >
                                    {#each data2 as status}
                                        {#if status.name == data.rent_status}
                                            <option selected
                                                >{status.name}
                                            </option>
                                        {:else}
                                            <option>{status.name}</option>
                                        {/if}
                                    {/each}
                                </select>
                            {/await}
                            <div
                                class="lg:flex-grow flex flex-col md:text-left items-center text-center mb-4"
                            >
                                <div class="mb-1">
                                    Start date:
                                    <input
                                        type="date"
                                        id="startDate"
                                        name="startDate"
                                        class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        bind:value={startDate}
                                    />
                                </div>
                                <div>
                                    End date:
                                    <input
                                        type="date"
                                        id="endDate"
                                        name="endDate"
                                        class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        bind:value={endDate}
                                    />
                                </div>
                            </div>
                            <div class="flex justify-center mt-2">
                                <button
                                    class="ml-1 inline-flex text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded text-lg"
                                    on:click={() => changeRentStatus(data.id)}
                                    >Change rent status</button
                                >
                            </div>
                            <div class="flex justify-center mt-2">
                                <button
                                    class="ml-1 inline-flex text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded text-lg"
                                    on:click={() => changeDate(data.id)}
                                    >Change date</button
                                >
                            </div>
                        </div>
                    </div>
                </section>
            {/await}
        {:else}
            <div
                class="lg:w-3/5 mx-auto w-full flex justify-center items-center text-6xl text-white font-bold text-center"
            >
                Nie masz uprawnień do wyświetlania tej strony!
            </div>
        {/if}
    {/await}
</section>
