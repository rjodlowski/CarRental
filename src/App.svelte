<script>
	import Router from "svelte-spa-router";

	import NotFound from "./routes/NotFound.svelte";
	import SignUp from "./routes/SignUp.svelte";
	import LogIn from "./routes/LogIn.svelte";
	import CarDetails from "./routes/CarDetails.svelte";
	import Admin from "./routes/Admin.svelte";
	import Moderator from "./routes/Moderator.svelte";

	import Header from "./components/Header.svelte";
	import Footer from "./components/Footer.svelte";
	import Reservations from "./components/Reservations.svelte";
	import Gallery from "./components/Gallery.svelte";

	import Tailwindcss from "./Tailwindcss.svelte";
	import ChangeReservationDate from "./routes/ChangeReservationDate.svelte";
	import Pdf from "./routes/Pdf.svelte";
</script>

<Tailwindcss />
<div
	class="flex flex-col h-screen justify-between text-gray-400 bg-gray-900 m-0 m-auto"
>
	<Header />
	<Router
		routes={{
			"/": Gallery,
			"/cars": Gallery,
			"/login": LogIn,
			"/signup": SignUp,
			"/cardetails/:id": CarDetails,
			"/reservations": Reservations,
			"/moderator": Moderator,
			"/moderator/reservation/:id": ChangeReservationDate,
			"/admin": Admin,
			"/pdf": Pdf,
			"*": NotFound,
		}}
	/>
	<Footer />
</div>
