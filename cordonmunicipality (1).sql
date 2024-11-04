-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 03:02 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cordonmunicipality`
--

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `incident_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `incident_image`) VALUES
(1, 'uploads/2023-05-27.png'),
(2, 'uploads/2023-05-27.png'),
(3, 'uploads/2023-05-27.png'),
(4, 'uploads/Screenshot 2023-06-30 230642.png'),
(5, 'uploads/Screenshot 2023-08-14 214728.png'),
(6, 'uploads/3bf95a0a-8cd0-4faa-b94d-bab620c869d8.jpeg'),
(7, 'uploads/Picsart_24-08-31_08-45-55-946.jpg'),
(8, 'uploads/Picsart_24-08-31_08-45-55-946.jpg'),
(9, 'uploads/Picsart_24-08-31_08-45-55-946.jpg'),
(10, 'uploads/0c38ba02-0993-47bb-9835-9e5165022d2b.jpeg'),
(11, 'uploads/Screenshot 2024-10-18 183206.png'),
(12, 'uploads/Screenshot 2024-10-21 150111.png'),
(13, 'uploads/Screenshot 2024-10-18 155536.png'),
(14, 'uploads/Screenshot 2024-10-22 231444.png'),
(15, 'uploads/Screenshot 2024-10-22 231444.png'),
(16, 'uploads/Screenshot 2024-10-22 105030.png'),
(17, 'uploads/Screenshot 2024-09-20 194622.png'),
(18, 'uploads/Screenshot 2024-08-08 233003.png'),
(19, 'uploads/Screenshot 2024-10-20 224649.png'),
(20, 'uploads/Screenshot 2024-10-17 124742.png'),
(21, 'uploads/Screenshot 2024-10-22 105030.png'),
(22, 'uploads/Screenshot 2024-10-22 105030.png'),
(23, 'uploads/Screenshot 2024-10-22 231444.png');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NOT NULL DEFAULT (current_timestamp() + interval 10 minute)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `email`, `otp`, `created_at`, `expires_at`) VALUES
(1, 'Juliusmanaois5@gmail.com', 289966, '2024-10-13 11:05:15', '2024-10-13 11:15:15'),
(2, 'jaypeepumihic11@gmail.com', 994682, '2024-10-13 11:05:54', '2024-10-13 11:15:54'),
(3, 'joh@gmail.com', 266900, '2024-10-18 10:56:04', '2024-10-18 11:06:04'),
(4, 'jaypeepumihic11@gmail.com', 216748, '2024-10-20 13:44:33', '2024-10-20 13:54:33'),
(5, 'jaypeepumihic11@gmail.com', 791118, '2024-10-20 13:50:01', '2024-10-20 14:00:01'),
(6, 'jaypeepumihic11@gmail.com', 249580, '2024-10-20 13:52:37', '2024-10-20 14:02:37'),
(7, 'Juliusmanaois5@gmail.com', 732744, '2024-10-20 14:21:40', '2024-10-20 14:31:40'),
(8, 'admin@gmail.com', 252301, '2024-10-22 02:35:08', '2024-10-22 02:45:08'),
(9, 'Juliusmanaois5@gmail.com', 379579, '2024-10-25 02:26:20', '2024-10-25 02:36:20'),
(10, 'cleo@gmail.com', 180218, '2024-10-28 03:51:34', '2024-10-28 04:01:34'),
(11, 'julius@gmail.com', 425692, '2024-10-28 03:59:34', '2024-10-28 04:09:34'),
(12, 'jaypeepumihic11@gmail.com', 505225, '2024-10-28 06:11:46', '2024-10-28 06:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `respondent_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `incident_type` varchar(255) DEFAULT NULL,
  `incident_image` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `documentation_message` text DEFAULT NULL,
  `additional_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `respondent_name`, `location`, `phone_number`, `incident_type`, `incident_image`, `latitude`, `longitude`, `created_at`, `status`, `user_id`, `documentation_message`, `additional_notes`) VALUES
(1, 'qweq', 'Malapat', '09553765379', 'Fire', 'uploads/Screenshot 2024-09-20 194622.png', 16.63164990, 99.99999999, '2024-10-23 09:24:34', 'Finished', NULL, NULL, NULL),
(2, 'jp', 'Anonang', '09553765379', 'Landslide', 'uploads/Screenshot 2024-08-08 233003.png', 16.63164990, 99.99999999, '2024-10-23 09:26:42', 'Finished', NULL, NULL, NULL),
(3, 'qweq', 'Rizaluna', '09553765379', 'Landslide', '', 16.63303680, 99.99999999, '2024-10-23 14:45:16', 'Rejected', NULL, NULL, NULL),
(4, 'qweq', 'Quezon', '09553765379', 'Accident', 'uploads/Screenshot 2024-10-20 224649.png', 16.63164510, 99.99999999, '2024-10-25 02:00:24', 'Finished', NULL, NULL, NULL),
(5, 'jp', 'Malapat', '09553765379', 'Landslide', 'uploads/Screenshot 2024-10-17 124742.png', 16.63631360, 99.99999999, '2024-10-25 02:08:13', 'Rejected', NULL, NULL, NULL),
(6, 'qweq', 'Osmeña', '09553765379', 'Earthquake', 'uploads/Screenshot 2024-10-22 105030.png', 16.63631360, 99.99999999, '2024-10-25 02:37:16', 'Finished', NULL, NULL, NULL),
(7, 'qweq', 'Osmeña', '09553765379', 'Landslide', 'uploads/Screenshot 2024-10-22 105030.png', 16.63631360, 99.99999999, '2024-10-25 02:38:04', 'Rejected', NULL, NULL, NULL),
(8, 'jp', 'Caquilingan', '09553765379', 'Flood', '', 16.65597440, 99.99999999, '2024-10-27 13:25:04', 'Rejected', NULL, NULL, NULL),
(9, 'jp12r35terdg', 'quirino', '09553765379', 'Flood', 'uploads/Screenshot 2024-10-22 231444.png', 16.60088250, 99.99999999, '2024-10-28 06:18:30', 'Finished', NULL, '<br />\r\n<b>Warning</b>:  Undefined array key \"documentation_message\" in <b>C:\\xampp\\htdocs\\WEBSITECORDON3\\edit_report.php</b> on line <b>99</b><br />\r\n', '<br />\r\n<b>Warning</b>:  Undefined array key \"additional_notes\" in <b>C:\\xampp\\htdocs\\WEBSITECORDON3\\edit_report.php</b> on line <b>103</b><br />\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `municipality` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `purok` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `name`, `email`, `password`, `contact`, `municipality`, `barangay`, `purok`, `verified`) VALUES
(8, 'Admin', 'j', 'admin@gmail.com', '$2y$10$hEkta5jLh9eV2xrNN0lx6eX9eQp3Ljr7H6M5g.j57n92ImZShA2Sy', '09553765379', 'Cordon', 'Sagat', 3, 1),
(9, 'User ', 'jaypee11', 'Juliusmanaois5@gmail.com', '$2y$10$E2QSnLt7Z6De1icVp8l95e/RYZGtd1dRSjZNTG0rp5qAIF823n1eu', '09553765379', 'Cordon', 'Quirino', 6, 1),
(10, 'Admin', 'vleo', 'cleo@gmail.com', '$2y$10$ck8toGniXs6HPGJo/ZaRNOhreBLyvKt8tcAD6knjv/zqRUlL3pUsu', '09553765379', 'Cordon', 'Taliktik', 2, 1),
(12, 'User ', 'jaypee11', 'jaypeepumihic11@gmail.com', '$2y$10$i4qvzqTm7YMGu.cejMJuxO9DGbEzpyU5tZxpoaSYpNwmCuM6h8/re', '09553765379', 'Cordon', 'Sagat', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
