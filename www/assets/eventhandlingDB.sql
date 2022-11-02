-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 02. Nov, 2022 11:28 AM
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
(1, 2, 2),
(2, 1, 3),
(3, 2, 3);

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
(2, 'Film'),
(5, 'Friluft'),
(1, 'Idrett'),
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
  `website` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `events`
--

INSERT INTO `events` (`event_id`, `title`, `info`, `host`, `location`, `time`, `category_id`, `endtime`, `ticketprice`, `website`) VALUES
(1, 'Skogsmarathon', 'Kom og løp 42 km i skauen.', 1, 'Bymarka, start og mål i Ravnedalen', '2023-04-01 12:00:00', 1, NULL, NULL, NULL),
(2, 'Filmfestival', 'Filmfestival hos SørKino, gratis inngang for alle hele dagen!', 2, 'Sør Kino, Kristiansand', '2023-01-07 14:00:00', 2, NULL, NULL, NULL),
(3, 'Le Mans-løp', 'Karting Le Mans-stil hos X3M Sørlandsparken!', 1, 'X3M Sørlandsparken', '2023-01-21 18:30:00', 1, NULL, NULL, NULL),
(4, 'Gratiskonsert', 'Gratis konsert med flotte musikere', 1, 'Tresse, Kristiansand', '2023-02-06 20:00:00', 4, NULL, NULL, NULL),
(5, 'Flåklypa Grand Prix teaterforestilling', 'Teaterforestilling av klassikeren Flåklypa Grand Prix, kom og se!', 2, 'Kilden, Kristiansand', '2023-02-06 19:00:00', 3, NULL, NULL, NULL);

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
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES
(1, 'Erlend', 'Lotsberg', 'erlend@mail.no', '81549300', '$2y$10$Z.Yy0Zc54g1v1ORbmA5oFO5Mu4MGdfHG85ertxl7dhVA.qs6PTPj2'),
(2, 'Joachim', 'Western', 'joachim@wildwildwest.com', '22225555', '$2y$10$xeyDCV5AgA.fn1u.HrBcaO.s9WqG9v0FjR01n7Z58cOEBBY.wqj5i');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
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
  MODIFY `booking_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `preference_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `booking_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `booking_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Begrensninger for tabell `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `host_id` FOREIGN KEY (`host`) REFERENCES `users` (`user_id`);

--
-- Begrensninger for tabell `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `preference_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
