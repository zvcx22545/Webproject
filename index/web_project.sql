-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 30, 2024 at 05:38 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

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
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `post_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `post_id`, `user_id`, `create_date`) VALUES
(1, 'น่าไปสุดๆ ต้องไปกอนสักครั้ง', '58379761', '69704620163528', '2024-05-30 01:16:41'),
(2, 'ต้องไปโดน', '58379761', '69704620163528', '2024-05-30 01:48:57'),
(3, 'โดนๆ', '58379761', '69704620163528', '2024-05-30 01:49:16'),
(4, 'เม้นแรก', '58379761', '69704620163528', '2024-05-30 21:05:49'),
(5, 'ร้านสวย', '4863084969414070', '69704620163528', '2024-05-31 00:28:53'),
(6, 'เม้นๆ', '58379761', '69704620163528', '2024-05-31 00:30:19'),
(7, '////', '4863084969414070', '69704620163528', '2024-05-31 00:34:09'),
(8, 'ภภภภภ', '58379761', '69704620163528', '2024-05-31 00:34:23'),
(9, 'ฟหกดฟหกดฟหกด', '4863084969414070', '69704620163528', '2024-05-31 00:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `history_likes`
--

CREATE TABLE `history_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history_likes`
--

INSERT INTO `history_likes` (`id`, `post_id`, `user_id`) VALUES
(41, '58379761', '69704620163528');

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
  `location_id` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `has_image` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_name`, `user_id`, `image`, `map_link`, `location_id`, `has_image`, `first_name`, `category_name`, `create_at`, `status`) VALUES
(49, 'Mixue', '69704620163528', 'uploads/69704620163528/mxhNNhTYEdHqjUe.png', 'https://maps.app.goo.gl/2cbU5eioXqYMYzQf8', '644700297849385', 1, 'Mali', 'food', '2024-05-14 22:42:03', 'approved'),
(50, 'Dilly Lazy', '69704620163528', 'uploads/69704620163528/NkARsok3e7TiHtW.png', 'https://maps.app.goo.gl/8vgzNPxNPsxWnhnG6', '5002614', 1, 'Mali', 'food', '2024-05-16 09:49:48', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(19) NOT NULL,
  `postid` bigint(19) NOT NULL,
  `user_id` bigint(19) NOT NULL,
  `post` text CHARACTER SET utf8mb4 NOT NULL,
  `image` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `comments` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `has_image` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_profile_image` tinyint(1) NOT NULL,
  `is_cover_image` tinyint(1) NOT NULL,
  `status` varchar(255) NOT NULL,
  `countreport` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `postid`, `user_id`, `post`, `image`, `comments`, `category`, `location_name`, `likes`, `has_image`, `date`, `update_date`, `is_profile_image`, `is_cover_image`, `status`, `countreport`) VALUES
(163, 58379761, 69704620163528, 'ไอศครีมอร่อยมาก', 'uploads/69704620163528/Bn68fX6j6K3TNSL.jpg', 0, 'food', 'Mixue', 1, 1, '2024-05-30 17:29:52', '2024-05-31 00:37:42', 0, 0, '', 0),
(166, 4863084969414070, 69704620163528, 'Cafe นี้อาหารอร่อย', 'uploads/69704620163528/O2qUK44qX9RAQa6.jpg', 0, 'food', 'Dilly Lazy', 0, 1, '2024-05-30 17:34:57', '2024-05-31 00:37:38', 0, 0, 'approved', 8),
(169, 297129814910527822, 69704620163528, 'fd', '', 0, '', '', 0, 0, '2024-05-22 20:11:23', NULL, 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `report_count` int(11) NOT NULL,
  `report_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `post_id`, `user_id`, `report_count`, `report_time`) VALUES
(3, '4863084969414070', '69704620163528', 0, '2024-05-22 18:21:17'),
(4, '4863084969414070', '69704620163528', 0, '2024-05-22 18:31:29'),
(5, '4863084969414070', '69704620163528', 0, '2024-05-22 19:14:59'),
(6, '4863084969414070', '69704620163528', 0, '2024-05-22 19:32:28'),
(7, '4863084969414070', '69704620163528', 0, '2024-05-22 19:32:31'),
(8, '4863084969414070', '69704620163528', 0, '2024-05-22 19:41:48'),
(9, '4863084969414070', '69704620163528', 0, '2024-05-22 19:46:49'),
(10, '4863084969414070', '69704620163528', 0, '2024-05-22 19:54:55');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `url_address`, `email`, `password`, `first_name`, `last_name`, `urole`, `profile_image`, `cover_image`, `created_at`) VALUES
(41, 2251245, '', 'chisanupong.li@ku.th', '$2y$10$OBGm5impCgRumygXNu.wXuf.huULeFMUnc.5WGPZ9VuhBrnPKJAeK', 'Chisanupong', 'Limsakul', 'admin', '', '', '2023-11-01 10:07:33'),
(42, 69704620163528, 'mali.konglerdruk', 'Mali@ku.th', '$2y$10$a9fJE2f6iwFcdrM.DGXwJ.9ZtoWYIcNGYiVFVlqp29m9bSTS.vPqi', 'Mali', 'Konglerdruk', 'user', 'uploads/69704620163528/5xSgNgxTZo6zp1q.jpg', 'uploads/69704620163528/pf2F2RaiBZJk3wY.jpg', '2024-05-17 19:10:13'),
(43, 233577, 'arisorn.rungruk', 'Arisorn@ku.th', '$2y$10$bgVj90PuHz/qdE5/KF/aTOOXfx8D2.bLK2oaBLkDaEEOOqFW0VGlW', 'Arisorn', 'Rungruk', 'user', 'uploads/233577/zr4PQf8LkygXpZJ.jpg', 'uploads/233577/xTbI9OZ8rONfwlV.jpg', '2023-11-02 19:49:31'),
(49, 20700969, 'testone.testerone', 'Tester@ku.th', '$2y$10$ZCVL3CxCj75g22xPQZoMiOiRRE7tmvByQ1Ur2XeSFcf3HQNL5ovZO', 'Testone', 'TesterOne', 'user', '', 'uploads/20700969/SLb3V6ell9CbapA.jpg', '2024-05-06 15:41:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_likes`
--
ALTER TABLE `history_likes`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `category` (`category`),
  ADD KEY `status` (`status`),
  ADD KEY `countreport` (`countreport`);
ALTER TABLE `posts` ADD FULLTEXT KEY `post` (`post`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`,`user_id`),
  ADD KEY `report_count` (`report_count`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `history_likes`
--
ALTER TABLE `history_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
