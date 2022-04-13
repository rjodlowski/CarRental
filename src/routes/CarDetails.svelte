<script>
    export let params = {};
    let id = params.id;
    let car = getCarById();

    let loggedIn = chceckIfLoggedIn();
    let datePickerShown = false;
    let startDate, endDate, costToShow;
    let costShown = false;

    async function chceckIfLoggedIn() {
        const URL = "./backend/checkIfLoggedIn.php";
        let res = await fetch(URL);
        res = await res.text();
        return res;
    }

    async function getCarById() {
        let data = new FormData();
        data.append("id", id);
        const URL = "./backend/getSelectedCar.php";
        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.json();
        console.log(res);
        return res;
    }

    function showDate() {
        datePickerShown = !datePickerShown;
    }

    async function showCost() {
        if (startDate != undefined && endDate != undefined) {
            let start = new Date(startDate);
            let end = new Date(endDate);

            if (start <= end) {
                let a = await car;
                let diff = (end - start) / 1000 / 60 / 60 / 24;
                let amount = parseInt(a.price_per_hour) * diff;

                if (amount >= 0) {
                    costShown = !costShown;
                    costToShow = amount;
                }
            }
        }
    }

    async function submitReservation() {
        // console.log(startDate, endDate);
        // console.log(startDate < endDate);

        if (startDate != undefined && endDate != undefined) {
            if (startDate < endDate) {
                const URL = "./backend/addToQueue.php";
                let data = new FormData();
                data.append("id", id);
                data.append("start", startDate);
                data.append("end", endDate);
                let res = await fetch(URL, {
                    method: "POST",
                    body: data,
                });
                res = await res.text();

                // console.log(res);
                if (res == "success") {
                    window.location.href = "./#/cars";
                } else if (res == "record exists") {
                    alert(
                        "You have submitted a reservation request for this car!"
                    );
                    window.location.href = "./#/cars";
                } else if (res == "car taken") {
                    alert("Car you have selected is taken!");
                    window.location.href = "./#/cars";
                } else {
                    console.log(res);
                }
            } else {
                alert("Data końcowa musi być po dacie początkowej!");
            }
        } else {
            alert("Wybierz datę rezerwacji!");
        }
    }
</script>

<section class="text-gray-600 body-font">
    {#await car}
        loading
    {:then data}
        <section class="text-gray-400 bg-gray-900 body-font">
            <div
                class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center"
            >
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 md:mb-0 mb-10">
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
                    {#if data.status == "available"}
                        <p class="mb-2 leading-relaxed text-green-500">
                            Status: {data.status}
                        </p>
                    {:else if data.status == "qualifying"}
                        <p class="mb-2 leading-relaxed text-yellow-300">
                            Status: {data.status}
                        </p>
                    {:else}
                        <p class="mb-2 leading-relaxed text-red-600">
                            Status: {data.status}
                        </p>
                    {/if}
                    {#if data.wanted_by > 0}
                        <p class="mb-2 leading-relaxed">
                            Wanted by {data.wanted_by} people
                        </p>
                    {/if}
                    {#if costShown == true}
                        <p class="mb-2 leading-relaxed">
                            Total cost: ${costToShow}
                        </p>
                    {/if}
                    {#if datePickerShown == true}
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
                                    on:change={() => showCost()}
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
                                    on:change={() => showCost()}
                                />
                            </div>
                        </div>
                    {/if}
                    <div class="flex justify-center mt-2">
                        {#await loggedIn}
                            loading
                        {:then data}
                            {#if data == "logged in"}
                                <button
                                    class="inline-flex text-gray-400 bg-gray-800 border-0 py-2 px-6 focus:outline-none hover:bg-gray-700 hover:text-white rounded text-lg"
                                    on:click={() => showDate()}
                                    >Select a date</button
                                >
                            {:else}
                                <button
                                    class="inline-flex text-gray-400 bg-gray-800 border-0 py-2 px-6 focus:outline-none hover:bg-gray-700 hover:text-white rounded text-lg"
                                    on:click={() => {
                                        window.location = "./#/login";
                                    }}>Log in to choose a date!</button
                                >
                            {/if}
                        {/await}
                        <button
                            class="ml-4 inline-flex text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded text-lg"
                            on:click={() => submitReservation()}>Book</button
                        >
                    </div>
                </div>
            </div>
        </section>
    {/await}
</section>
