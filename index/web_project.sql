-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 02:02 PM
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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `map_link` varchar(255) NOT NULL,
  `location_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `has_image` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_name`, `user_id`, `image`, `map_link`, `location_id`, `has_image`, `first_name`, `create_at`) VALUES
(1, 'Mixue ', '69704620163528', 'uploads/69704620163528/OtGcjE0ANOPFbB9.jpg', 'https://maps.app.goo.gl/2cbU5eioXqYMYzQf8', '679142', 1, 'Mali', '2024-04-28 23:50:53'),
(3, 'Mixue Kampangsan', '69704620163528', 'uploads/69704620163528/cpp8XDBQfYHcfBu.jpg', 'https://maps.app.goo.gl/2cbU5eioXqYMYzQf8', '65137', 1, 'Mali', '2024-04-28 23:50:53'),
(10, 'Mixue ', '69704620163528', 'uploads/69704620163528/SOPhrE0shZOkxme.jpg', 'https://maps.app.goo.gl/2cbU5eioXqYMYzQf8', '4501080428803342446', 1, 'Mali', '2024-04-29 03:16:13');

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
(34, 7183299235307662, 233577, 'หิวจังเลยครับหาคนเลี้ยง', 'uploads/233577/mAfPtZ4ot4yEYZV.jpg', 0, 'food', 0, 1, '2023-11-03 03:17:30', 0, 0),
(36, 868031531512344875, 233577, 'ปีนี้สวยมาก', 'uploads/233577/KB55QwsUISGoerD.jpg', 0, 'travel', 0, 1, '2023-11-03 03:25:41', 0, 0),
(37, 855175612431776, 242499072638, '', 'uploads/242499072638/WVSsnvX7C8yEvNT.jpg', 0, '', 0, 1, '2023-11-03 07:02:59', 1, 0),
(38, 11202, 242499072638, '', 'uploads/242499072638/0EgaIMW9KvLf376.jpg', 0, '', 0, 1, '2023-11-03 07:03:30', 1, 0),
(40, 8344, 242499072638, 'พระพิรุณ', 'uploads/242499072638/6bzSrNXjKvp9Qmx.jpg', 0, 'travel', 0, 1, '2023-11-03 07:08:21', 0, 0),
(103, 5633678907944, 69704620163528, '', 'uploads/69704620163528/T1KDYGRg5V2b2Cg.jpg', 0, '', 0, 1, '2024-04-28 22:29:56', 1, 0),
(104, 29780061756987, 69704620163528, '', 'uploads/69704620163528/NfVwYSAoHpK1eLy.jpg', 0, '', 0, 1, '2024-04-28 22:32:23', 0, 1),
(105, 2500189647898, 69704620163528, '', 'uploads/69704620163528/cbtcNgW8BcId9EQ.jpg', 0, '', 0, 1, '2024-04-28 22:33:28', 0, 1),
(107, 7057955668464270417, 69704620163528, '', 'uploads/69704620163528/jPXFgGnsIxt6lSH.jpg', 0, '', 0, 1, '2024-04-28 22:35:22', 1, 0),
(118, 971481368156729, 69704620163528, '', 'uploads/69704620163528/pSvVaGlwEMXYsC5.jpg', 0, '', 0, 1, '2024-04-28 23:16:35', 1, 0),
(119, 27574508574, 69704620163528, '', 'uploads/69704620163528/0WSant440rxhsMq.jpg', 0, '', 0, 1, '2024-04-28 23:16:36', 1, 0),
(121, 42363440845526041, 69704620163528, '', 'uploads/69704620163528/06rWwcV95ruwgQe.jpg', 0, '', 0, 1, '2024-04-28 23:17:44', 1, 0),
(122, 977128448945860, 69704620163528, '', 'uploads/69704620163528/tEs4jWmTsPxJQH3.jpg', 0, '', 0, 1, '2024-04-28 23:19:31', 1, 0),
(123, 8641900594404144, 69704620163528, '', 'uploads/69704620163528/ZooOHiPNVf6rwbF.jpg', 0, '', 0, 1, '2024-04-28 23:19:32', 1, 0),
(124, 3298, 69704620163528, '', 'uploads/69704620163528/8ingOzCbmLXbdaP.jpg', 0, '', 0, 1, '2024-04-28 23:20:32', 1, 0),
(125, 939483, 69704620163528, '', 'uploads/69704620163528/rE6rhITPRQYvQ4S.jpg', 0, '', 0, 1, '2024-04-28 23:20:33', 1, 0),
(126, 489585801657746, 69704620163528, '', 'uploads/69704620163528/trP0TIcixqwuLY4.jpg', 0, '', 0, 1, '2024-04-28 23:20:58', 1, 0),
(127, 8407108395780, 69704620163528, '', 'uploads/69704620163528/rfs2YpliDtwXts9.jpg', 0, '', 0, 1, '2024-04-28 23:20:59', 1, 0),
(128, 55434757002, 69704620163528, '', 'uploads/69704620163528/qTwbhZLGFMVN696.jpg', 0, '', 0, 1, '2024-04-28 23:21:16', 1, 0),
(129, 27961068031535, 69704620163528, '', 'uploads/69704620163528/91F4ZQwDaKc4PBf.jpg', 0, '', 0, 1, '2024-04-28 23:21:17', 1, 0),
(130, 9151151, 69704620163528, '', 'uploads/69704620163528/ZaEKHvfgjagf5xg.jpg', 0, '', 0, 1, '2024-04-28 23:24:20', 1, 0),
(131, 4333, 69704620163528, '', 'uploads/69704620163528/wB814VUd3iHFWlx.jpg', 0, '', 0, 1, '2024-04-28 23:24:20', 1, 0),
(132, 692299926476103099, 69704620163528, '', 'uploads/69704620163528/D59HCBNuq7ei4nc.jpg', 0, '', 0, 1, '2024-04-28 23:24:31', 1, 0),
(133, 3532332258965184, 69704620163528, '', 'uploads/69704620163528/lOsUJbCovZyMzVF.jpg', 0, '', 0, 1, '2024-04-28 23:24:32', 1, 0),
(134, 222403389343385454, 69704620163528, 'เสื้อสีใหม่', 'uploads/69704620163528/H32BHwluWZQs2uP.jpg', 0, 'clothing', 0, 1, '2024-04-29 03:20:10', 0, 0);

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
(42, 69704620163528, 'mali.konglerdruk', 'Mali@ku.th', '$2y$10$a9fJE2f6iwFcdrM.DGXwJ.9ZtoWYIcNGYiVFVlqp29m9bSTS.vPqi', 'Mali', 'Konglerdruk', 'user', 'uploads/69704620163528/lOsUJbCovZyMzVF.jpg', 'uploads/69704620163528/axzswDcVaeDT8ej.jpg', '2024-04-28 23:24:32'),
(43, 233577, 'arisorn.rungruk', 'Arisorn@ku.th', '$2y$10$bgVj90PuHz/qdE5/KF/aTOOXfx8D2.bLK2oaBLkDaEEOOqFW0VGlW', 'Arisorn', 'Rungruk', 'user', 'uploads/233577/zr4PQf8LkygXpZJ.jpg', 'uploads/233577/xTbI9OZ8rONfwlV.jpg', '2023-11-02 19:49:31'),
(44, 1040179099111984, 'rawadee.meechupmun', 'rawadee@ku.th', '$2y$10$U5i3h2UXmnJwe2vo2E6OeOEkKM.R7e.kvjxdb5Wpuaw.zcH7nxYq6', 'Rawadee', 'meechupmun', 'user', 'uploads/1040179099111984/zWfRxj8EwFcKrm9.jpg', 'uploads/1040179099111984/4E9uga6BKhRAFo4.jpg', '2023-11-01 21:57:38'),
(45, 242499072638, 'suraseg.limsakul', 'suraseg@ku.th', '$2y$10$20buEitGnbIX0m5uHojvmud5zecUlQDPM5.ZidCQ2ctZx.ugNMORu', 'suraseg', 'limsakul', 'user', 'uploads/242499072638/0EgaIMW9KvLf376.jpg', 'uploads/242499072638/bD9AJsCCFaM7Oh9.jpg', '2023-11-03 07:04:20'),
(46, 497337897843078, 'hidream.limsakkul', 'dream@ku.th', '$2y$10$TJQJYJyAMRZmuXk5cXtCseKQRyB6BKEswAsKMjGwr9uC7o6212Mq6', 'HIDREAM', 'LIMSAKKUL', 'user', '', '', '2024-02-22 09:39:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `location_name` (`location_name`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `map_link` (`map_link`),
  ADD KEY `has_image` (`has_image`),
  ADD KEY `first_name` (`first_name`);

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
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
