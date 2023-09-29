-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 25, 2023 at 02:18 PM
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
-- Database: `social-media`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`follower_id`, `following_id`, `timestamp`) VALUES
(1, 2, '2023-09-23 04:20:22'),
(1, 3, '2023-09-25 03:37:02'),
(2, 1, '2023-09-24 13:00:02'),
(3, 1, '2023-09-24 05:00:03'),
(3, 2, '2023-09-24 05:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `usr_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `usr_id`, `content`, `image`, `created_at`) VALUES
(1, 2, 'New Post', '../img/650de2c78e08b_83139073.png', '2023-09-22 18:56:59'),
(2, 3, 'Hello I am new user', NULL, '2023-09-24 05:04:50'),
(3, 2, 'hi', NULL, '2023-09-24 12:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reaction_type` enum('like','haha','love','sad') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `post_id`, `user_id`, `reaction_type`, `timestamp`) VALUES
(9, 2, 3, 'love', '2023-09-24 05:04:59'),
(10, 1, 3, 'haha', '2023-09-24 05:21:43'),
(12, 2, 1, 'love', '2023-09-24 05:37:54'),
(13, 1, 2, 'haha', '2023-09-24 07:15:26'),
(15, 2, 2, 'haha', '2023-09-24 12:05:08'),
(16, 3, 2, 'like', '2023-09-24 13:01:55'),
(17, 1, 1, 'haha', '2023-09-24 13:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `profile` varchar(255) NOT NULL DEFAULT 'profile.jpeg',
  `cover` varchar(50) NOT NULL DEFAULT 'banner.jpg',
  `bio` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `interaction` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`interaction`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `profile`, `cover`, `bio`, `email`, `password`, `interaction`) VALUES
(1, 'Soe Nyi Nyi Aung', '650ee65958214_5348981.png', 'banner.jpg', 'I am programmer I have no life', 'soenyi5002@gmail.com', '', NULL),
(2, 'Soe Nyi', '650fa77925505_ba0d53f2945b995c5b95b32f1a7bead8.jpg', '651033e7b0463_83139073.png', 'Hello Programmers', 'lusifersoe@gmail.com', '', NULL),
(3, 'Aung Aung', '650fc5342b109_What is Weak Narrow AI Here Are 8 Practical Examples.jpg', 'banner.jpg', 'I am not a hacker. I am helper. Don&#039;t attack normal users.', 'aungaung@gmail.com', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`follower_id`,`following_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`usr_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`email`,`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `reactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
