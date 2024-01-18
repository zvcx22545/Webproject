-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2024 at 01:39 PM
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
-- Database: `web_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(19) NOT NULL,
  `postid` bigint(19) NOT NULL,
  `user_id` bigint(19) NOT NULL,
  `post` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comments` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `has_image` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_profile_image` tinyint(1) NOT NULL,
  `is_cover_image` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `postid`, `user_id`, `post`, `image`, `comments`, `category`, `likes`, `has_image`, `date`, `is_profile_image`, `is_cover_image`) VALUES
(3, 156824626704041, 233577, 'ง่วงนอน', '', 0, '', 0, 0, '2023-10-31 05:37:56', 0, 0),
(4, 2246, 1040179099111984, 'I\\\'m so sleepy', '', 0, '', 0, 1, '2023-11-01 21:54:25', 0, 0),
(5, 28318495609107420, 1040179099111984, 'i\\\'m', '', 0, '', 0, 0, '2023-11-01 21:54:52', 0, 0),
(6, 582502770681062806, 69704620163528, 'โพสต์นี้ทดสอบการโพสต์รูปภาพ', 'uploads/69704620163528/LruIpkCRI6hyDbl.jpg', 0, '', 0, 1, '2023-11-02 00:31:51', 0, 0),
(15, 574237977146015, 233577, 'แมวเหงา', 'uploads/233577/t3DCoZ3pCexiqJG.jpg', 0, '', 0, 1, '2023-11-02 01:38:03', 0, 0),
(16, 95232333692089789, 233577, 'HIHI', 'uploads/233577/UIwnZ6TusIJIuZ5.jpg', 0, '', 0, 1, '2023-11-02 06:25:48', 0, 0),
(28, 495384499985278500, 69704620163528, '', 'uploads/69704620163528/lDNZxZjSFA1SONC.jpg', 0, '', 0, 1, '2023-11-03 00:30:05', 1, 0),
(32, 12743370366065814, 69704620163528, 'ขายเสื้อนะ', 'uploads/69704620163528/cYVYRNSOEgjm12i.jpg', 0, 'clothing', 0, 1, '2023-11-03 03:10:12', 0, 0),
(33, 1441311406566014422, 69704620163528, 'ขอผ่านนะครับเดี๋ยวไปวิ่งแก้บน', 'uploads/69704620163528/9qav3HjQAoOZlzA.jpg', 0, 'travel', 0, 1, '2023-11-03 03:15:39', 0, 0),
(34, 7183299235307662, 233577, 'หิวจังเลยครับหาคนเลี้ยง', 'uploads/233577/mAfPtZ4ot4yEYZV.jpg', 0, 'food', 0, 1, '2023-11-03 03:17:30', 0, 0),
(36, 868031531512344875, 233577, 'ปีนี้สวยมาก', 'uploads/233577/KB55QwsUISGoerD.jpg', 0, 'travel', 0, 1, '2023-11-03 03:25:41', 0, 0),
(37, 855175612431776, 242499072638, '', 'uploads/242499072638/WVSsnvX7C8yEvNT.jpg', 0, '', 0, 1, '2023-11-03 07:02:59', 1, 0),
(38, 11202, 242499072638, '', 'uploads/242499072638/0EgaIMW9KvLf376.jpg', 0, '', 0, 1, '2023-11-03 07:03:30', 1, 0),
(40, 8344, 242499072638, 'พระพิรุณ', 'uploads/242499072638/6bzSrNXjKvp9Qmx.jpg', 0, 'travel', 0, 1, '2023-11-03 07:08:21', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `userid` bigint(19) NOT NULL,
  `url_address` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `urole` varchar(255) NOT NULL,
  `profile_image` varchar(1000) NOT NULL,
  `cover_image` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `url_address`, `email`, `password`, `first_name`, `last_name`, `urole`, `profile_image`, `cover_image`, `created_at`) VALUES
(41, 2251245, '', 'chisanupong.li@ku.th', '$2y$10$OBGm5impCgRumygXNu.wXuf.huULeFMUnc.5WGPZ9VuhBrnPKJAeK', 'Chisanupong', 'Limsakul', 'admin', '', '', '2023-11-01 10:07:33'),
(42, 69704620163528, 'mali.konglerdruk', 'Mali@ku.th', '$2y$10$a9fJE2f6iwFcdrM.DGXwJ.9ZtoWYIcNGYiVFVlqp29m9bSTS.vPqi', 'Mali', 'Konglerdruk', 'user', 'uploads/69704620163528/lDNZxZjSFA1SONC.jpg', 'uploads/69704620163528/YEAx4ZKIEPNANCe.jpg', '2023-11-03 00:30:05'),
(43, 233577, 'arisorn.rungruk', 'Arisorn@ku.th', '$2y$10$bgVj90PuHz/qdE5/KF/aTOOXfx8D2.bLK2oaBLkDaEEOOqFW0VGlW', 'Arisorn', 'Rungruk', 'user', 'uploads/233577/zr4PQf8LkygXpZJ.jpg', 'uploads/233577/xTbI9OZ8rONfwlV.jpg', '2023-11-02 19:49:31'),
(44, 1040179099111984, 'rawadee.meechupmun', 'rawadee@ku.th', '$2y$10$U5i3h2UXmnJwe2vo2E6OeOEkKM.R7e.kvjxdb5Wpuaw.zcH7nxYq6', 'Rawadee', 'meechupmun', 'user', 'uploads/1040179099111984/zWfRxj8EwFcKrm9.jpg', 'uploads/1040179099111984/4E9uga6BKhRAFo4.jpg', '2023-11-01 21:57:38'),
(45, 242499072638, 'suraseg.limsakul', 'suraseg@ku.th', '$2y$10$20buEitGnbIX0m5uHojvmud5zecUlQDPM5.ZidCQ2ctZx.ugNMORu', 'suraseg', 'limsakul', 'user', 'uploads/242499072638/0EgaIMW9KvLf376.jpg', 'uploads/242499072638/bD9AJsCCFaM7Oh9.jpg', '2023-11-03 07:04:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postid` (`postid`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comments` (`comments`),
  ADD KEY `likes` (`likes`),
  ADD KEY `date` (`date`),
  ADD KEY `has_image` (`has_image`),
  ADD KEY `is_profile_image` (`is_profile_image`),
  ADD KEY `is_cover_image` (`is_cover_image`),
  ADD KEY `category` (`category`);
ALTER TABLE `posts` ADD FULLTEXT KEY `post` (`post`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `first_name` (`first_name`),
  ADD KEY `last_name` (`last_name`),
  ADD KEY `email` (`email`),
  ADD KEY `url_address` (`url_address`),
  ADD KEY `created_at` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
