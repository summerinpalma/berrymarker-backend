-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 15, 2024 at 03:34 PM
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
-- Database: `berrymarker`
--

-- --------------------------------------------------------

--
-- Table structure for table `marker`
--

CREATE TABLE `marker` (
  `markerid` int(11) NOT NULL,
  `plantid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marker`
--

INSERT INTO `marker` (`markerid`, `plantid`, `userid`, `longitude`, `latitude`, `added`) VALUES
(36, 1, 13, '2.656401751645973', '50.85262381368301', '2024-02-15 14:13:00'),
(37, 2, 13, '2.656403756155356', '50.852582516055975', '2024-02-15 14:13:13'),
(38, 3, 13, '2.6561881877820497', '50.85272734434193', '2024-02-15 14:13:37'),
(39, 1, 14, '2.6581012495002483', '50.853543272796514', '2024-02-15 14:14:28'),
(40, 5, 14, '2.6578748187221777', '50.853521111049275', '2024-02-15 14:14:40'),
(41, 4, 14, '2.6579737920289404', '50.85344189494526', '2024-02-15 14:15:00'),
(42, 3, 15, '2.6546226759912486', '50.85184243585357', '2024-02-15 14:16:14'),
(43, 4, 15, '2.6546339477818606', '50.851766403909494', '2024-02-15 14:16:24'),
(44, 6, 15, '2.654415946481663', '50.85179835827836', '2024-02-15 14:16:36'),
(45, 5, 18, '2.649277975057089', '50.8536761216819', '2024-02-15 14:19:33'),
(46, 6, 18, '2.6494108137692933', '50.85374964162645', '2024-02-15 14:19:57'),
(47, 9, 18, '2.649661568350922', '50.85385902753211', '2024-02-15 14:20:07'),
(48, 7, 19, '2.650824744821705', '50.85278924611421', '2024-02-15 14:20:53'),
(49, 8, 19, '2.651134309640156', '50.85279330293761', '2024-02-15 14:21:03'),
(50, 10, 19, '2.6515091501110533', '50.85273783580598', '2024-02-15 14:21:12'),
(51, 10, 20, '2.6506696798905693', '50.849830448916606', '2024-02-15 14:22:15'),
(52, 10, 20, '2.6504882363805677', '50.84975437450231', '2024-02-15 14:22:28'),
(53, 10, 20, '2.6503118495101603', '50.84967198228725', '2024-02-15 14:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `plant`
--

CREATE TABLE `plant` (
  `plantid` int(11) NOT NULL,
  `planttypeid` int(11) DEFAULT NULL,
  `plantname` varchar(255) DEFAULT NULL,
  `harvestperiod` varchar(255) DEFAULT NULL,
  `added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plant`
--

INSERT INTO `plant` (`plantid`, `planttypeid`, `plantname`, `harvestperiod`, `added`) VALUES
(1, 1, 'Cranberries', 'mid September - mid November', '2024-02-12 07:46:01'),
(2, 1, 'Blueberries', 'June - August', '2024-02-12 07:46:01'),
(3, 1, 'Elderblossoms - Elderberries', 'mid June / end September - October', '2024-02-12 07:47:57'),
(4, 1, 'Gooseberries', 'July - August', '2024-02-12 07:47:57'),
(5, 1, 'Blackberries', 'August - September - Start October', '2024-02-12 07:50:23'),
(6, 1, 'Raspberries', 'June - July - August - September - October', '2024-02-12 07:50:23'),
(7, 3, 'Hazelnut', 'September - October', '2024-02-12 07:55:39'),
(8, 3, 'Walnut', 'September - November', '2024-02-12 07:55:39'),
(9, 2, 'Oyster Mushroom', 'November', '2024-02-12 08:01:14'),
(10, 4, 'Wild Garlic', 'mid March', '2024-02-12 08:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `planttype`
--

CREATE TABLE `planttype` (
  `planttypeid` int(11) NOT NULL,
  `typename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `planttype`
--

INSERT INTO `planttype` (`planttypeid`, `typename`) VALUES
(1, 'Berry Shrub'),
(2, 'Mushrooms'),
(3, 'Nuts'),
(4, 'Culinary Herb'),
(5, 'Fruit');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(13, 'mrfern', 'fern@proton.me', '$2y$10$FMlKrGciWeGB7p5Xa2P1YuD5N4Rvj0WOF/VX7neTnu.w6dGKcPWg2', 'user'),
(14, 'mrslily', 'lily@proton.me', '$2y$10$2C7iEl1SpUGEaZeU2GF8XeG3AHHVvgBrjJY4m0BE9VjVMJjiimgzW', 'user'),
(15, 'mrsrose', 'rose@proton.me', '$2y$10$AK4LmuGkNMhZithFeh44fOU2KMagbBAOsl6rxVcm9l4x66nySUayO', 'user'),
(18, 'mrsdaisy', 'daisy@proton.me', '$2y$10$YP2yFiFjz77DSvMiKrMI4.0qEhJNy/DlulYcv4UV3IH4viUYaIJWG', 'user'),
(19, 'mrsivy', 'ivy@proton.me', '$2y$10$pIJ9qo/WWENSvx8FlAb68Oro07MvGwQv3yxbixwWfscEHcaiEteji', 'user'),
(20, 'mrbasil', 'basil@proton.me', '$2y$10$GK/bV3uHBlAAdcKZjtaXA.usCVuPlo/h5KHwXQANwrod1YYfBVrPu', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `marker`
--
ALTER TABLE `marker`
  ADD PRIMARY KEY (`markerid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `plantid` (`plantid`);

--
-- Indexes for table `plant`
--
ALTER TABLE `plant`
  ADD PRIMARY KEY (`plantid`),
  ADD KEY `plant_ibfk_1` (`planttypeid`);

--
-- Indexes for table `planttype`
--
ALTER TABLE `planttype`
  ADD PRIMARY KEY (`planttypeid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailadress` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `marker`
--
ALTER TABLE `marker`
  MODIFY `markerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `plant`
--
ALTER TABLE `plant`
  MODIFY `plantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `planttype`
--
ALTER TABLE `planttype`
  MODIFY `planttypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marker`
--
ALTER TABLE `marker`
  ADD CONSTRAINT `marker_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `marker_ibfk_2` FOREIGN KEY (`plantid`) REFERENCES `plant` (`plantid`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `plant`
--
ALTER TABLE `plant`
  ADD CONSTRAINT `plant_ibfk_1` FOREIGN KEY (`planttypeid`) REFERENCES `planttype` (`planttypeid`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
