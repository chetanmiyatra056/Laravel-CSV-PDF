-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 09:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_laravel_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `countries` varchar(255) DEFAULT NULL,
  `states` varchar(255) DEFAULT NULL,
  `cities` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `hobbies` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `countries`, `states`, `cities`, `password`, `hobbies`, `gender`, `date_of_birth`, `type`, `status`, `profile`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'a', 'a@gmail.com', NULL, '101', '12', '1011', '$2y$10$7dOFeUE75VtV8dtP5QXid.gurY1F2zpsvRo2uw0OrJehJMJy20Gye', 'reading,writting,gaming', 'male', '2024-07-06', 'seller', '0', NULL, NULL, '2024-07-06 00:47:47', '2024-07-06 00:47:47'),
(8, 's', 's@gmail.com', NULL, '101', '12', '888', '$2y$10$QOIQ41rEu7XKvfaleATuq.p4SoLNcvCKsqzIjXQdUFHLjMGtrzfqm', 'reading,writting,gaming', 'male', '2024-07-06', 'user', '0', NULL, NULL, '2024-07-06 00:48:46', '2024-07-06 00:48:46'),
(9, 'd', 'd@gmail.com', NULL, '15', '307', '7230', '$2y$10$LzOAN/zFzZKG6KPelWoFn.TNbEH86vnz1CQUqeh1PZVlC7yMmHLMa', 'reading,writting,gaming', 'female', '2024-07-06', 'user', '0', NULL, NULL, '2024-07-06 00:51:53', '2024-07-06 00:51:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
