<script>
    import QrCode from "svelte-qrcode";

    let qrShown = false;

    async function getQueueUser() {
        const URL = "./backend/getQueueUser.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);

        return res;
    }

    async function getUserType() {
        const URL = "./backend/getUser.php";
        let res = await fetch(URL);
        res = await res.json();
        return res;
    }

    async function getReservationsUser() {
        const URL = "./backend/getReservationsUser.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);
        return res;
    }
    async function showQR() {
        qrShown = !qrShown;
    }
    async function checkUserVeracity() {
        const URL = "./backend/checkUserVeracity.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);
        return res;
    }

    async function rentCar(reservationId, oldStatus) {
        let data = new FormData();
        data.append("reservationId", reservationId);
        data.append("oldStatus", oldStatus);
        const URL = "./backend/rentCar.php";
        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.text();
        if (res == "success") {
            location.reload();
        } else {
            console.log(res);
        }
        return res;
    }

    let queue = getQueueUser();
    let reservations = getReservationsUser();
    let a = checkUserVeracity();
    let userLoggedIn = getUserType();
</script>

<section class="text-gray-600 body-font h-4/6">
    <div class="px-5 w-11/12 h-full mx-auto justify-start ">
        <div class="flex h-full">
            {#await userLoggedIn}
                <div>Loading</div>
            {:then data}
                {#if data.loggedIn == 1}
                    <div class="lg:w-3/5 mr-20 w-full overflow-auto">
                        {#await a}
                            <div>Loading</div>
                        {:then b}
                            {#if b == 1}
                                <h2
                                    class="text-3xl text-white font-medium title-font mb-4"
                                >
                                    Pending requests
                                </h2>
                                <table
                                    class="table-auto w-full text-center whitespace-no-wrap"
                                >
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                                >Brand</th
                                            >
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >Model</th
                                            >
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >Cost / h</th
                                            >
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >Total cost</th
                                            >
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                >Od</th
                                            >
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-br rounded-tr"
                                                >Do</th
                                            >
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {#await queue}
                                            <p>Loading</p>
                                        {:then res}
                                            {#each res as item}
                                                <tr>
                                                    <td
                                                        class="text-white px-2 py-1 border-b-2"
                                                        >{item.brand}</td
                                                    >
                                                    <td
                                                        class="text-white px-2 py-1 border-b-2"
                                                        >{item.model}</td
                                                    >
                                                    <td
                                                        class="text-white px-2 py-1 border-b-2"
                                                        >${item.price_per_hour}</td
                                                    >
                                                    <td
                                                        class="text-white px-2 py-1 border-b-2"
                                                        >${((Date.parse(
                                                            item.end
                                                        ) -
                                                            Date.parse(
                                                                item.start
                                                            )) /
                                                            360000) *
                                                            item.price_per_hour}</td
                                                    >
                                                    <td
                                                        class="text-white px-2 py-1 border-b-2"
                                                        >{item.start}</td
                                                    >
                                                    <td
                                                        class="text-white px-2 py-1 border-b-2"
                                                        >{item.end}</td
                                                    >
                                                </tr>
                                            {/each}
                                        {/await}
                                    </tbody>
                                </table>
                            {:else}
                                <div>You shall not pass</div>
                            {/if}
                        {/await}
                    </div>
                    <div class="lg:w-2/5 h-full mx-2 overflow-auto">
                        <h2
                            class="text-3xl text-white font-medium title-font mb-4"
                        >
                            Rented cars
                        </h2>
                        <div class="flex flex-wrap ">
                            {#await reservations}
                                <div>Loading</div>
                            {:then res}
                                {#each res as car}
                                    <div class="p-4">
                                        <div
                                            class="bg-gray-800 bg-opacity-40 p-6 rounded-lg"
                                        >
                                            {#if qrShown == true}
                                                <QrCode
                                                    value={JSON.stringify(
                                                        car,
                                                        null,
                                                        4
                                                    )}
                                                />
                                            {:else}
                                                <img
                                                    class="h-40 rounded w-full object-cover object-center mb-1"
                                                    src={car.image}
                                                    alt="car"
                                                />
                                            {/if}
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
                                            <p class="leading-relaxed text-sm ">
                                                From: {car.start} <br />
                                                To: {car.end}
                                            </p>
                                            <button
                                                class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                                                on:click={() => showQR()}
                                            >
                                                {#if qrShown == true}
                                                    Show image
                                                {:else}
                                                    Show QR code
                                                {/if}
                                            </button>
                                            <button
                                                class="inline-flex items-center bg-gray-800 border-0 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                                                on:click={() =>
                                                    rentCar(
                                                        car.id,
                                                        car.rent_status
                                                    )}
                                            >
                                                {#if car.rent_status == 1}
                                                    Rent
                                                {:else}
                                                    Return
                                                {/if}
                                            </button>
                                        </div>
                                    </div>
                                {/each}
                            {/await}
                        </div>
                    </div>
                {/if}
            {/await}
        </div>
    </div>
</section>
