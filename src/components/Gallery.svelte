<script>
    async function getCars() {
        const URL = "./backend/getCars.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);
        // return res;
        let sorted = sortCars(res);
        return sorted;
    }

    async function getUser() {
        const URL = "./backend/getUser.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);
        return res;
    }

    function selectCar(id) {
        console.log(id);
        window.location = `./#/cardetails/${id}`;
    }

    let cars = getCars();
    let user = getUser();
    let direction = "asc";

    function sortCars(table) {
        direction = document.getElementById("sortSelect").value;
        console.log(direction);
        let sorted;
        if (direction == "asc") {
            sorted = table.sort((a, b) =>
                a.brand > b.brand ? 1 : b.brand > a.brand ? -1 : 0
            );
        } else {
            sorted = table.sort((a, b) =>
                a.brand > b.brand ? -1 : b.brand > a.brand ? 1 : 0
            );
        }
        console.log(sorted);
        return sorted;
    }
</script>

<section class="text-gray-400 body-font bg-gray-900">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap w-full mb-5">
            <div class="lg:w-1/2 w-full lg:mb-0">
                <h1
                    class="sm:text-3xl text-2xl font-medium title-font text-white"
                >
                    Cars in our offer
                </h1>
                <div class="h-1 w-20 bg-yellow-500 rounded" />
                <div>Sort by name:</div>
                <select
                    id="sortSelect"
                    on:change={() => {
                        cars = getCars();
                    }}
                >
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
        </div>
        <div class="flex flex-wrap -m-4">
            {#await user}
                <div>Loading</div>
            {:then response}
                {#if response.can_rent_car != 0}
                    {#await cars}
                        <div>Loading</div>
                    {:then res}
                        {#each res as car}
                            <div class="xl:w-1/4 md:w-1/2 p-4">
                                <div
                                    class="bg-gray-800 bg-opacity-40 p-6 rounded-lg"
                                >
                                    <img
                                        class="h-40 rounded w-full object-cover object-center mb-6"
                                        src={car.image}
                                        alt="car"
                                    />
                                    <h2
                                        class="text-lg text-white font-medium title-font mb-4"
                                    >
                                        {car.brand}
                                        {car.model}
                                    </h2>
                                    <h3
                                        class="tracking-widest text-yellow-400 text-xs font-medium title-font"
                                    >
                                        PRICE PER HOUR: ${car.price_per_hour}
                                    </h3>
                                    <p class="leading-relaxed text-sm ">
                                        Status: {car.status}
                                    </p>
                                    <button
                                        class="inline-flex items-center bg-gray-800 border-0 mt-5 ml-30 py-1 px-3 focus:outline-none hover:bg-gray-700 rounded text-base"
                                        on:click={() => selectCar(car.id)}
                                        >Reserve it for yourself!
                                    </button>
                                </div>
                            </div>
                        {/each}
                    {/await}
                {:else}
                    <div>You shall not pass!</div>
                {/if}
            {/await}
        </div>
    </div>
</section>
