-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 06. Des, 2022 17:11 PM
-- Tjener-versjon: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventhandling`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `event_id`) VALUES
(22, 1, 3),
(18, 1, 4),
(19, 1, 7),
(24, 1, 10),
(1, 2, 2),
(3, 2, 3),
(23, 3, 13);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(9, 'Dans'),
(2, 'Film'),
(5, 'Friluft'),
(7, 'Gratistjenester'),
(8, 'Hjelp'),
(1, 'Idrett'),
(6, 'Mat'),
(4, 'Musikk'),
(3, 'Teater');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `events`
--

CREATE TABLE `events` (
  `event_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `info` varchar(1000) NOT NULL,
  `host` int(10) NOT NULL,
  `location` varchar(200) NOT NULL,
  `time` datetime NOT NULL,
  `category_id` int(10) NOT NULL,
  `endtime` datetime DEFAULT NULL,
  `ticketprice` varchar(10) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `img_path` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `events`
--

INSERT INTO `events` (`event_id`, `title`, `info`, `host`, `location`, `time`, `category_id`, `endtime`, `ticketprice`, `website`, `img_path`) VALUES
(1, 'Skogsmarathon', 'Kom og løp 42 km i skauen.', 1, 'Bymarka, start og mål i Ravnedalen', '2023-04-01 12:00:00', 1, NULL, NULL, NULL, 'assets/img/event1.jpg'),
(2, 'Filmfestival', 'Filmfestival hos SørKino, gratis inngang for alle hele dagen!', 2, 'Sør Kino, Kristiansand', '2023-01-07 14:00:00', 2, '2023-01-08 23:00:00', '0', 'https://www.nfkino.no/kino/kristiansand', 'assets/img/event2.jpg'),
(3, 'Gokart', 'Le Mans', 1, 'X3M', '2023-01-21 18:30:00', 1, NULL, '5000', 'https://x3m.no', 'assets/img/315ed.jpg'),
(4, 'Gratiskonsert', 'Gratis konsert med flotte musikere', 1, 'Tresse, Kristiansand', '2023-02-06 20:00:00', 4, NULL, '', '', 'assets/img/27d59.jpg'),
(5, 'Flåklypa Grand Prix teaterforestilling', 'Teaterforestilling av klassikeren Flåklypa Grand Prix, kom og se!', 2, 'Kilden, Kristiansand', '2023-02-06 19:00:00', 3, NULL, NULL, NULL, 'assets/img/event5.jpg'),
(6, 'Ballett', 'Kom og se ballettdansere danse ballett. Disse folkene er bedre enn deg på balanse, rytme, kroppsbeherskelse, utholdenhet, osv osv.\r\n\r\nSvanesjøen blir fremført.', 2, 'Kilden', '2023-04-01 19:00:00', 9, '2023-04-01 21:00:00', '350', NULL, NULL),
(7, 'Gitarkurs', 'Kom og lær å spille gitar. Du vil adri bli Jimi Hendrix, men du kan alltids prøve og derpå få drømmene dine knust.', 1, 'Kvadraturen Videregående Skole', '2023-02-09 15:00:00', 4, NULL, '500', NULL, NULL),
(8, 'Romjulsgløggfest', 'Her skal det drekkas gløgg guttær og jæntær! Ta med ditt feteste krus og ubegrensede mengder pepperkaker.', 2, 'Wergelandsparken/Torvet', '2022-12-23 19:00:00', 6, NULL, '0', NULL, NULL),
(9, 'Gratis dekkskift', 'Kom og få gratis dekkskift. Hvis du er gammel eller av andre grunner ikke klarer å bytte fra vinter- til sommerhjul selv, så gjør vi jobben for deg.', 1, 'Dekkmann Sørlandsparken', '2023-04-01 10:00:00', 7, '2023-04-01 16:00:00', '0', NULL, NULL),
(10, 'TestEvent1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 'Lorem Ipsum', '2022-12-21 15:00:00', 8, NULL, '200', 'https://no.wikipedia.org/wiki/Lorem_ipsum', NULL),
(11, 'TestEvent2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 'TestLocation', '2022-12-31 12:00:00', 4, NULL, '1000', NULL, NULL),
(12, 'TestEvent3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 'TestLocation', '2022-12-01 15:00:00', 1, '2022-12-01 16:00:00', '500', 'https://no.wikipedia.org/wiki/Lorem_ipsum', NULL),
(13, 'Skirenn', 'Vi skal ut og gå på ski, førstemann til mål får premie (twistpose)', 3, 'Baneheia', '2022-12-04 12:00:00', 1, '2022-12-04 14:00:00', '100', '', NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `preferences`
--

CREATE TABLE `preferences` (
  `preference_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `preferences`
--

INSERT INTO `preferences` (`preference_id`, `user_id`, `category_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 2, 2),
(5, 2, 3);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES
(1, 'Erlend', 'Lotsberg', 'erlend@mail.no', '81509000', '$2y$10$p9e5MMy7W.Bk1wsw42u7yuSCwJGOba71vpr2O0NUdkY0oYin4jdS2'),
(2, 'Joachim', 'Western', 'joachim@wildwildwest.com', '22225555', '$2y$10$xeyDCV5AgA.fn1u.HrBcaO.s9WqG9v0FjR01n7Z58cOEBBY.wqj5i'),
(3, 'Ole', 'Lukkøye', 'ole@lukkøye.no', '12345678', '$2y$10$IjCWvA3vGyCunO80JdlpPuskslmToo0QX2BuWGK6fXmwL6Hp9Dn0i'),
(9, 'Mikke', 'Mus', 'mikke@disney.no', '88888888', '$2y$10$hFmzAdXlQ1KvDmiRp9h1O.vTmwoSl6m9B2hOa6gC5Gs8VeKdjhcKK'),
(10, 'Donald', 'Duck', 'donald@disney.com', '84488448', '$2y$10$v/NWytdsGZqL6hZoiIByYemVX5sRjT5Zlj38FBN8HezUrDhrC7ySm'),
(11, 'Solan', 'Gundersen', 'solan@flaaklypa.no', '12343215', '$2y$10$IZzFTFQ1d20lDL3vSsSWheyAS8bveM1qhaYeT5M34MYC1mTtD7MaS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`event_id`),
  ADD KEY `booking_user_id` (`user_id`),
  ADD KEY `booking_event_id` (`event_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `id` (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `id` (`event_id`),
  ADD KEY `host_id` (`host`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`preference_id`),
  ADD UNIQUE KEY `id` (`preference_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`,`phone`),
  ADD UNIQUE KEY `id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `preference_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `booking_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Begrensninger for tabell `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `host_id` FOREIGN KEY (`host`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Begrensninger for tabell `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `preference_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
