-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 04:55 AM
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
-- Database: `taskmonitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `picname` varchar(255) DEFAULT NULL,
  `taskname` varchar(255) DEFAULT NULL,
  `createdate` date DEFAULT NULL,
  `tasksystem` varchar(255) DEFAULT NULL,
  `taskterminal` varchar(255) DEFAULT NULL,
  `tasklocation` varchar(255) DEFAULT NULL,
  `taskunit` varchar(255) DEFAULT NULL,
  `taskdescription` text DEFAULT NULL,
  `taskstatus` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `picname`, `taskname`, `createdate`, `tasksystem`, `taskterminal`, `tasklocation`, `taskunit`, `taskdescription`, `taskstatus`, `created_at`) VALUES
(1, 'pic1', 'Task 1', '2025-04-15', 'system', 'FX34', 'location', 'unit', 'task', 'completed', '2025-04-15 00:45:21'),
(2, 'pic2', 'Task A', '2025-04-15', 'system', 'FL37', 'location', 'unit', 'task', 'completed', '2025-04-15 01:27:17'),
(3, 'pic1', 'Task b', '2025-04-17', 'system', 'COTP10', 'location', 'unit', 'task', 'completed', '2025-04-16 03:27:27'),
(4, 'pic2', 'Task C', '2025-04-30', 'system', 'MP54', 'location', 'unit', 'task', 'inprogress', '2025-04-18 04:26:43'),
(5, 'pic1', 'Task X', '2025-05-20', 'system', NULL, 'location', 'unit', 'describe', 'inprogress', '2025-05-19 03:13:18'),
(6, 'pic2', 'Task N', '2025-05-21', 'system', NULL, 'location', 'unit', 'describe', 'todo', '2025-05-21 04:28:53'),
(7, 'pic1', 'Task J', '2025-05-21', 'system', '', 'location', 'unit', 'task', 'inprogress', '2025-05-21 04:35:15'),
(8, 'pic1', 'PM SB5', '2025-05-18', 'FX22, FX23, FX38, FL47', NULL, 'Sabah (KK,Kudat, K.Belud)', 'SK', 'LO', 'completed', '2025-05-22 08:12:45'),
(9, 'pic2', 'Task A', '2025-05-23', 'systems', 'FX44', 'location', 'unit', 'LO', 'todo', '2025-05-23 01:12:07'),
(10, 'pic1', 'SB1', '2025-06-09', 'X-BAND', 'MP36', 'location', 'unit', 'describe', 'inprogress', '2025-06-09 00:38:07'),
(11, 'pic1', 'Task C', '2025-06-10', 'system', 'MP45', 'location', 'unit', 'describe', 'todo', '2025-06-09 08:20:12'),
(12, 'pic2', 'Task X', '2025-06-16', 'X-BAND', 'fx21', 'location', 'unit', 'describe', 'todo', '2025-06-09 08:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `task_attachments`
--

CREATE TABLE `task_attachments` (
  `id` int(11) NOT NULL,
  `progress_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_progress`
--

CREATE TABLE `task_progress` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `update_status` varchar(255) DEFAULT NULL,
  `progress_text` text DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_progress`
--

INSERT INTO `task_progress` (`id`, `task_id`, `update_status`, `progress_text`, `created_at`) VALUES
(1, 1, 'serviceable', 'no progress', '2025-05-15'),
(2, 1, 'serviceable', 'blabla\r\n            ', '2025-05-16'),
(3, 8, 'serviceable', 'fx22 - siap', '2025-05-18'),
(4, 5, 'serviceable', 'blablabala\r\n            ', '2025-05-28'),
(5, 5, 'serviceable', 'blablabala\r\n            ', '2025-05-28'),
(6, 5, 'serviceable', 'blablabala\r\n            ', '2025-05-28'),
(7, 5, 'serviceable', 'blablabala\r\n            ', '2025-05-28'),
(8, 5, 'serviceable', 'blablabala\r\n            ', '2025-05-28'),
(9, 5, 'serviceable', 'blablabala\r\n            ', '2025-05-28'),
(10, 5, 'serviceable', 'test\r\n            ', '2025-05-29'),
(14, 5, 'serviceable', 'testt\r\n            ', '2025-06-05');

-- --------------------------------------------------------

--
-- Table structure for table `task_remarks`
--

CREATE TABLE `task_remarks` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `remark` text DEFAULT NULL,
  `completed_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_remarks`
--

INSERT INTO `task_remarks` (`id`, `task_id`, `remark`, `completed_date`) VALUES
(1, 2, 'bla bla', NULL),
(2, 1, 'test', NULL),
(3, 8, 'Telah dilaksanakan', NULL),
(4, 3, 'yes', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `role`) VALUES
(1, 'admin', '', '123', 'admin'),
(2, 'manager', '', '1234', 'manager'),
(3, 'pic1', '', '1234', 'pic'),
(4, 'pic2', '', '1234', 'pic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_attachments`
--
ALTER TABLE `task_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `progress_id` (`progress_id`);

--
-- Indexes for table `task_progress`
--
ALTER TABLE `task_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `task_remarks`
--
ALTER TABLE `task_remarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `task_attachments`
--
ALTER TABLE `task_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_progress`
--
ALTER TABLE `task_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `task_remarks`
--
ALTER TABLE `task_remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `task_attachments`
--
ALTER TABLE `task_attachments`
  ADD CONSTRAINT `task_attachments_ibfk_1` FOREIGN KEY (`progress_id`) REFERENCES `task_progress` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_progress`
--
ALTER TABLE `task_progress`
  ADD CONSTRAINT `task_progress_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_remarks`
--
ALTER TABLE `task_remarks`
  ADD CONSTRAINT `task_remarks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
