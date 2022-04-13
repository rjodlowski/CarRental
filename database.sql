-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 13 Kwi 2022, 21:19
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt_samochody`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `brand` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `model` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `price_per_hour` int(11) NOT NULL,
  `wanted_by` int(11) NOT NULL,
  `image` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `cars`
--

INSERT INTO `cars` (`id`, `status`, `brand`, `model`, `price_per_hour`, `wanted_by`, `image`) VALUES
(1, 2, 'Lamborghini', 'Gallardo', 2137, 0, 'https://i.iplsc.com/1/0001RZIEL3O4IB2B-C321-F4.jpg'),
(2, 2, 'Dodge', 'Challenger', 550, 1, 'https://ymimg1.b8cdn.com/resized/car_version/6636/pictures/3043849/mobile_listing_main_11787_st1280_116.jpg'),
(3, 1, 'Toyota', 'Corolla', 15, 0, 'https://i.iplsc.com/toyota-corolla-2022/000DTFOFVLE7SGTT-C122-F4.jpg'),
(4, 3, 'Fiat', 'Multipla', 1, 1, 'https://wallpapercave.com/wp/wp4243811.jpg'),
(5, 3, 'Porsche', '911', 420, 0, 'https://www.lego.com/cdn/cs/set/assets/blt3d62bb5d68e6dbd7/10295.jpg?fit=bounds&format=jpg&quality=80&width=1500&height=1500&dpr=1'),
(6, 1, 'Skoda', 'Octavia', 50, 0, 'https://ireland.apollo.olxcdn.com/v1/files/eyJmbiI6IjltcWU0YWw2Ymw4azEtT1RPTU9UT1BMIiwidyI6W3siZm4iOiJ3ZzRnbnFwNnkxZi1PVE9NT1RPUEwiLCJzIjoiMTYiLCJwIjoiMTAsLTEwIiwiYSI6IjAifV19.0dOZTjpPQT2XWLLdXElYxNeOAmLs7qsYhxT34-hpxwI/image;s=1080x720'),
(7, 1, 'Mazda', 'Miata', 99999, 0, 'https://3dwarehouse.sketchup.com/warehouse/v1.0/publiccontent/ab3b4be4-34a3-48a9-b74d-68abe67df3da'),
(8, 3, 'Toyota', 'Supra', 1999, 0, 'https://ocdn.eu/pulscms-transforms/1/IoWktkuTURBXy9iMzQ2NjYyMC04Y2NhLTQyMTItYTgzYS00NGRhZDVmYThmMTMuanBlZ5GTBc0EsM0CpA');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `decisions`
--

CREATE TABLE `decisions` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `decisions`
--

INSERT INTO `decisions` (`id`, `name`) VALUES
(1, 'accpted'),
(2, 'declined'),
(3, 'undecided');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `decision` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `queue`
--

INSERT INTO `queue` (`id`, `user_id`, `car_id`, `start`, `end`, `decision`) VALUES
(10, 8, 4, '2021-12-17', '2021-12-25', 2),
(11, 9, 2, '2021-12-10', '2021-12-24', 2);

--
-- Wyzwalacze `queue`
--
DELIMITER $$
CREATE TRIGGER `tr_before_delete_queue` BEFORE DELETE ON `queue` FOR EACH ROW INSERT INTO reservations(user_id, car_id, start, end, rent_status)
VALUES(OLD.user_id, OLD.car_id, OLD.start, OLD.end, 1)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rent_statuses`
--

CREATE TABLE `rent_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `rent_statuses`
--

INSERT INTO `rent_statuses` (`id`, `name`) VALUES
(1, 'undecided'),
(2, 'rented'),
(3, 'returned');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `rent_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `car_id`, `start`, `end`, `rent_status`) VALUES
(3, 6, 1, '2021-12-05', '2021-12-12', 1),
(5, 6, 2, '2021-12-17', '2021-12-18', 1),
(7, 8, 2, '2021-12-23', '2022-01-01', 2),
(8, 9, 4, '2021-12-09', '2021-12-12', 1),
(9, 8, 5, '2021-12-03', '2021-12-24', 1),
(10, 8, 8, '2021-12-12', '2021-12-19', 1);

--
-- Wyzwalacze `reservations`
--
DELIMITER $$
CREATE TRIGGER `tr_before_del_reservations` BEFORE DELETE ON `reservations` FOR EACH ROW INSERT INTO reservations_archive(user_id, car_id, start, end, rent_status)
VALUES(OLD.user_id, OLD.car_id, OLD.start, OLD.end, 3)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations_archive`
--

CREATE TABLE `reservations_archive` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `rent_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `reservations_archive`
--

INSERT INTO `reservations_archive` (`id`, `user_id`, `car_id`, `start`, `end`, `rent_status`) VALUES
(2, 8, 2, '2021-12-03', '2021-12-04', 3),
(3, 8, 7, '2021-12-14', '2021-12-20', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `status` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `statuses`
--

INSERT INTO `statuses` (`id`, `status`) VALUES
(1, 'available'),
(2, 'qualifying'),
(3, 'unavailable');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(500) COLLATE utf8_polish_ci NOT NULL,
  `can_rent_car` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `type`, `username`, `password`, `can_rent_car`) VALUES
(5, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(6, 2, 'moderator', '0408f3c997f309c03b08bf3a4bc7b730', 1),
(8, 3, 'user1', '962012d09b8170d912f0669f6d7d9d07', 1),
(9, 3, 'user2', '962012d09b8170d912f0669f6d7d9d07', 1),
(10, 3, 'qwer', '962012d09b8170d912f0669f6d7d9d07', 1),
(11, 3, 'qwerqwer', '962012d09b8170d912f0669f6d7d9d07', 1),
(16, 3, 'username', '5f4dcc3b5aa765d61d8327deb882cf99', 1),
(19, 3, 'aaaaaaaaaaa', 'c162de19c4c3731ca3428769d0cd593d', 1),
(24, 3, '!@#$%^', '962012d09b8170d912f0669f6d7d9d07', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user_types`
--

INSERT INTO `user_types` (`id`, `type`) VALUES
(1, 'admin'),
(2, 'moderator'),
(3, 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `decisions`
--
ALTER TABLE `decisions`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `decision` (`decision`);

--
-- Indeksy dla tabeli `rent_statuses`
--
ALTER TABLE `rent_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `rent_status` (`rent_status`);

--
-- Indeksy dla tabeli `reservations_archive`
--
ALTER TABLE `reservations_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `rent_status` (`rent_status`);

--
-- Indeksy dla tabeli `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `type` (`type`);

--
-- Indeksy dla tabeli `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `decisions`
--
ALTER TABLE `decisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `rent_statuses`
--
ALTER TABLE `rent_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `reservations_archive`
--
ALTER TABLE `reservations_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT dla tabeli `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`);

--
-- Ograniczenia dla tabeli `queue`
--
ALTER TABLE `queue`
  ADD CONSTRAINT `queue_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `queue_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `queue_ibfk_3` FOREIGN KEY (`decision`) REFERENCES `decisions` (`id`);

--
-- Ograniczenia dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`rent_status`) REFERENCES `rent_statuses` (`id`);

--
-- Ograniczenia dla tabeli `reservations_archive`
--
ALTER TABLE `reservations_archive`
  ADD CONSTRAINT `reservations_archive_ibfk_1` FOREIGN KEY (`rent_status`) REFERENCES `rent_statuses` (`id`),
  ADD CONSTRAINT `reservations_archive_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_archive_ibfk_3` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`type`) REFERENCES `user_types` (`id`);

DELIMITER $$
--
-- Zdarzenia
--
CREATE DEFINER=`root`@`localhost` EVENT `test_event_03` ON SCHEDULE EVERY 1 MINUTE STARTS '2021-12-06 20:05:59' ENDS '2021-12-06 21:05:59' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE reservations
   SET start = DATE(start + 1)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
