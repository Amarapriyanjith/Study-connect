-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2026 at 08:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `password`, `created_at`) VALUES
(1, 'R.M Amara Priyanjith', 'abc@gmail.com', 'amara', '$2y$10$kRX2O26RZMZTE5ezUydBeOOIBrwnArl/k1yRJV.QjjwcAIOouloUW', '2026-09-06 13:12:39'),
(2, 'Amara Priyanjith', 'amara@gmail.com', 'amara1', '$2y$10$98uZ8REpKzS6287Xr4g96uMAcazWSyM0CHmo/I6pr1RGkrOhMLAwy', '2026-09-06 13:18:20'),
(3, 'priyanjith amara', 'bcd@gmail.com', 'user', '$2y$10$91gOso4vtQcY02Bj3qgCXOSDToOysKvXQQM2hzRPqn56ihdZQ/s4m', '2026-09-06 13:27:29'),
(4, 'R.M Amara', 'ict@gmail.com', 'ict', '$2y$10$1BZ8TZHHdsqL1fOZaiL52ep8x4y3Gm2EVKJv1PTol2CmBEcLxSugm', '2026-09-06 15:37:30'),
(5, 'dumindu chamikara', 'dumindu@gmail.com', 'dumindu', '$2y$10$aRrVKleviCTsiTC9a1YZfeEymZo6ZO1RqzRDXaKn6Lx9tMim/tSmu', '2026-09-06 16:17:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
