-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 11:05 PM
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
  `category_name` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_name`, `user_id`, `image`, `map_link`, `location_id`, `has_image`, `first_name`, `category_name`, `create_at`, `status`) VALUES
(43, 'Mixue', '69704620163528', 'uploads/69704620163528/j26NnkcCTbQEOs6.png', 'https://maps.app.goo.gl/2cbU5eioXqYMYzQf8', '76673', 1, 'Mali', 'food', '2024-05-13 11:17:33', 'approved'),
(48, 'U Avenue', '69704620163528', 'uploads/69704620163528/zToqMiPaCdIu8Tb.png', 'https://maps.app.goo.gl/2cbU5eioXqYMYzQf8', '889597478163713', 1, 'Mali', '', '2024-05-13 14:03:01', '');

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
  `category` varchar(255) DEFAULT NULL,
  `location_name` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `has_image` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_profile_image` tinyint(1) NOT NULL,
  `is_cover_image` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `postid`, `user_id`, `post`, `image`, `comments`, `category`, `location_name`, `likes`, `has_image`, `date`, `is_profile_image`, `is_cover_image`) VALUES
(129, 27961068031535, 69704620163528, '', 'uploads/69704620163528/91F4ZQwDaKc4PBf.jpg', 0, '', '', 0, 1, '2024-04-28 23:21:17', 1, 0),
(130, 9151151, 69704620163528, '', 'uploads/69704620163528/ZaEKHvfgjagf5xg.jpg', 0, '', '', 0, 1, '2024-04-28 23:24:20', 1, 0),
(131, 4333, 69704620163528, '', 'uploads/69704620163528/wB814VUd3iHFWlx.jpg', 0, '', '', 0, 1, '2024-04-28 23:24:20', 1, 0),
(133, 3532332258965184, 69704620163528, '', 'uploads/69704620163528/lOsUJbCovZyMzVF.jpg', 0, '', '', 0, 1, '2024-04-28 23:24:32', 1, 0),
(134, 222403389343385454, 69704620163528, 'เสื้อสีใหม่', 'uploads/69704620163528/H32BHwluWZQs2uP.jpg', 0, 'clothing', '', 0, 1, '2024-04-29 03:20:10', 0, 0),
(145, 6715939602883043959, 20700969, '', 'uploads/20700969/U9Mh26e9uomh8S0.jpg', 0, '', '', 0, 1, '2024-05-06 15:34:49', 0, 1),
(146, 631669127194966, 20700969, '', 'uploads/20700969/SLb3V6ell9CbapA.jpg', 0, '', '', 0, 1, '2024-05-06 15:41:27', 0, 1),
(155, 752119, 69704620163528, '', 'uploads/69704620163528/pf2F2RaiBZJk3wY.jpg', 0, '', '', 0, 1, '2024-05-09 18:59:56', 0, 1),
(156, 3549995400106, 69704620163528, '', 'uploads/69704620163528/sTPUNY6fj4NZNuL.jpg', 0, '', '', 0, 1, '2024-05-09 19:00:07', 1, 0),
(157, 391839, 69704620163528, '', 'uploads/69704620163528/Vx32I1nZMfptBgd.jpg', 0, '', '', 0, 1, '2024-05-09 19:00:07', 1, 0),
(160, 5180343661007450910, 69704620163528, 'delicious', 'uploads/69704620163528/UdkDopR88JOTgI8.jpg', 0, '', '', 0, 1, '2024-05-10 11:09:57', 0, 0),
(161, 1713091, 69704620163528, 'ร้านอาหาร', 'uploads/69704620163528/GbEpkQTJ73qRZxq.jpg', 0, '', '', 0, 1, '2024-05-10 11:47:57', 0, 0),
(162, 7746112, 69704620163528, 'gg', 'uploads/69704620163528/9WnpyauIiiiEwEl.jpg', 0, '', 'Mixue', 0, 1, '2024-05-10 12:02:58', 0, 0);

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
(42, 69704620163528, 'mali.konglerdruk', 'Mali@ku.th', '$2y$10$a9fJE2f6iwFcdrM.DGXwJ.9ZtoWYIcNGYiVFVlqp29m9bSTS.vPqi', 'Mali', 'Konglerdruk', 'user', 'uploads/69704620163528/Vx32I1nZMfptBgd.jpg', 'uploads/69704620163528/pf2F2RaiBZJk3wY.jpg', '2024-05-09 19:00:07'),
(43, 233577, 'arisorn.rungruk', 'Arisorn@ku.th', '$2y$10$bgVj90PuHz/qdE5/KF/aTOOXfx8D2.bLK2oaBLkDaEEOOqFW0VGlW', 'Arisorn', 'Rungruk', 'user', 'uploads/233577/zr4PQf8LkygXpZJ.jpg', 'uploads/233577/xTbI9OZ8rONfwlV.jpg', '2023-11-02 19:49:31'),
(49, 20700969, 'testone.testerone', 'Tester@ku.th', '$2y$10$ZCVL3CxCj75g22xPQZoMiOiRRE7tmvByQ1Ur2XeSFcf3HQNL5ovZO', 'Testone', 'TesterOne', 'user', '', 'uploads/20700969/SLb3V6ell9CbapA.jpg', '2024-05-06 15:41:27');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
