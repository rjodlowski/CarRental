<script>
    async function getUserType() {
        const URL = "./backend/getUser.php";
        let res = await fetch(URL);
        res = await res.json();
        return res;
    }

    async function getUsers() {
        const URL = "./backend/getUsers.php";
        let res = await fetch(URL);
        res = await res.json();
        console.log(res);
        return res;
    }

    async function submitChange(id) {
        let newType = document.getElementById(`type${id}`).value;
        let data = new FormData();

        data.append("id", id);
        data.append("newType", newType);

        const URL = "./backend/changeUserType.php";
        let res = await fetch(URL, {
            method: "POST",
            body: data,
        });
        res = await res.text();
        console.log(res);
        if (res == "success") {
            alert("User type changed successfully!");
        } else {
            console.log(res);
        }
    }

    let user = getUserType();
    let userList = getUsers();
</script>

<section class="container mx-auto text-gray-600 body-font h-4/6">
    {#await user}
        <div>Loading</div>
    {:then userData}
        {#if userData.loggedIn == 1 && userData.userType == "admin"}
            <div
                class="lg:w-3/5 mx-auto w-full flex justify-center items-center flex-col"
            >
                <h2 class="text-3xl text-white font-medium title-font mb-4">
                    Users
                </h2>
                <table class="table-auto w-full text-center whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                >User ID</th
                            >
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                >Username</th
                            >
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                >Type</th
                            >
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-br rounded-tr"
                            />
                        </tr>
                    </thead>
                    <tbody>
                        {#await userList}
                            <p>Loading</p>
                        {:then u}
                            {#each u as item}
                                <tr>
                                    <td class="text-white px-2 py-1 border-b-2"
                                        >{item.id}</td
                                    >
                                    <td class="text-white px-2 py-1 border-b-2"
                                        >{item.username}</td
                                    >
                                    <td class="text-black px-2 py-1 border-b-2"
                                        ><select id={`type${item.id}`}>
                                            {#if item.type == "admin"}
                                                <option>admin</option>
                                                <option disabled
                                                    >moderator</option
                                                >
                                                <option disabled>user</option>
                                            {:else if item.type == "moderator"}
                                                <option disabled>admin</option>
                                                <option selected
                                                    >moderator</option
                                                >
                                                <option>user</option>
                                            {:else if item.type == "user"}
                                                <option disabled>admin</option>
                                                <option>moderator</option>
                                                <option selected>user</option>
                                            {/if}
                                        </select></td
                                    >
                                    <td class="text-white px-2 py-1 border-b-2">
                                        <button
                                            class="px-1"
                                            on:click={() =>
                                                submitChange(item.id)}
                                            >Change type</button
                                        >
                                    </td>
                                </tr>
                            {/each}
                        {/await}
                    </tbody>
                </table>
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
