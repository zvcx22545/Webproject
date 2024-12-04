-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 11:51 AM
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
-- Database: `web_project_test`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_likes`
--

CREATE TABLE `history_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `history_likes`
--

INSERT INTO `history_likes` (`id`, `post_id`, `user_id`) VALUES
(3, '251661351238774', '69704620163528');

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
(54, 'Mixue', '69704620163528', 'uploads/69704620163528/9TJckbKUPRWVtou.png', 'https://maps.app.goo.gl/2cbU5eioXqYMYzQf8', '94830848482458428', 1, 'Mali', 'food', '2024-06-07 19:27:31', 'approved'),
(55, 'U Avenue', '69704620163528', 'uploads//LJ7pDYAfTla04AO.jpg', 'https://maps.app.goo.gl/tyP6mgqcU2cNfYfb6', '08739877689', 1, 'Mali', 'travel', '2024-06-11 15:37:07', 'approved'),
(56, 'Dilly Lazy', '69704620163528', 'uploads/69704620163528/GOevvRlciRviVe3.png', 'https://maps.app.goo.gl/8vgzNPxNPsxWnhnG6', '61190996760311531', 1, 'Mali', 'food', '2024-06-11 15:36:55', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(19) NOT NULL,
  `postid` bigint(19) NOT NULL,
  `user_id` bigint(19) NOT NULL,
  `post` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comments` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `has_image` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `is_profile_image` tinyint(1) NOT NULL,
  `is_cover_image` tinyint(1) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'approved',
  `countreport` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `postid`, `user_id`, `post`, `image`, `comments`, `category`, `location_name`, `likes`, `has_image`, `date`, `update_date`, `is_profile_image`, `is_cover_image`, `status`, `countreport`) VALUES
(181, 870578015398269049, 69704620163528, '', 'uploads/69704620163528/ZMesB3Lyvzsh6Uf.jpg', 0, '', '', 0, 1, '2024-06-07 19:53:12', NULL, 1, 0, '', 0),
(182, 5498153189670, 69704620163528, '', 'uploads/69704620163528/PXEmpQBbe8aNhQw.jpg', 0, '', '', 0, 1, '2024-06-07 19:53:39', NULL, 0, 1, '', 0),
(183, 937412472881592, 2251245, 'เวลาเปิด-ปิด : 8:00–22:00\nFaceBook : https://www.facebook.com/uavenueku\nTel : 0988988325\nรายละเอียด : เป็นแหล่งรวมร้านค้า และ ของกินมากมายไม่ว่าจะเป็น\nของหวาน ของคาว หรือ มีของขวััญเช่น ดอกไม้อีกด้วย อย่าลืมแวะมาชมกันนะ\n\n\n\n', 'uploads/2251245/WWSnHgZWObOfFdx.jpg', 0, 'travel', 'U Avenue', 0, 1, '2024-06-08 17:15:54', '2024-06-11 19:37:04', 0, 0, 'approved', 0),
(184, 957008641458169974, 2251245, 'วันอาทิตย์ :11:00–20:30\r\nวันจันทร์ : 11:00–20:30\r\nวันอังคาร : 11:00–20:30\r\nวันพุธ : ปิดทำการ\r\nวันพฤหัสบดี :11:00–20:30\r\nวันศุกร์ :11:00–20:30\r\nวันเสาร์ : 11:00–20:30\r\nเบอร์โทร : 0842357755\r\nรายละเอียด : เป็น Cafe ที่ อาหารอร่อยและถูกมากแนะนำเลย\r\nFacebook : https://www.facebook.com/dilly.lazy\r\n\r\n', 'uploads/2251245/dRPmR4t67a1lMtD.jpg', 0, 'food', 'Dilly Lazy', 0, 1, '2024-06-08 18:11:25', '2024-06-12 02:54:57', 0, 0, 'approved', 0),
(188, 89793766743797710, 2251245, 'วันอาทิตย์ :11:00–20:30\nวันจันทร์ : 11:00–20:30\nวันอังคาร : 11:00–20:30\nวันพุธ : ปิดทำการ\nวันพฤหัสบดี :11:00–20:30\nวันศุกร์ :11:00–20:30\nวันเสาร์ : 11:00–20:30\nเบอร์โทร : 0842357755\nรายละเอียด : เป็น Cafe ที่ อาหารอร่อยและถูกมากแนะนำเลย\nFacebook : https://www.facebook.com/dilly.lazy\n\n', 'uploads/2251245/iCzucQeq8h3T35k.jpg', 0, 'food', 'Mixue', 0, 1, '2024-06-12 07:51:10', '2024-06-12 16:01:42', 0, 0, 'approved', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint(19) NOT NULL,
  `post_id` bigint(19) NOT NULL,
  `tag_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`id`, `post_id`, `tag_name`) VALUES
(1, 1255483, 'ร้านกาแฟ'),
(2, 1255483, 'Cafe'),
(3, 2381, 'ร้านกาแฟ'),
(4, 2381, 'Cafe'),
(5, 2381, 'จอดรถฟรี'),
(6, 89793766743797710, 'ร้านกาแฟ'),
(7, 89793766743797710, 'Cafe'),
(8, 89793766743797710, 'อาหารราคาถูก');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `report_count` int(11) NOT NULL,
  `report_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `post_id`, `user_id`, `report_count`, `report_time`) VALUES
(1, '251661351238774', '69704620163528', 0, '2024-06-11 19:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `subtag`
--

CREATE TABLE `subtag` (
  `id` bigint(19) NOT NULL,
  `tagname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(19) NOT NULL,
  `create_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subtag`
--

INSERT INTO `subtag` (`id`, `tagname`, `category`, `user_id`, `create_at`) VALUES
(14, 'ร้านกาแฟ', 'food', 2251245, '2024-06-12 01:31:34'),
(15, 'WIFIฟรี', 'clothing', 2251245, '2024-06-12 02:49:13'),
(16, 'จอดรถฟรี', 'clothing', 2251245, '2024-06-12 02:53:53'),
(17, 'Cafe', 'food', 2251245, '2024-06-12 03:14:31'),
(18, 'จอดรถฟรี', 'food', 2251245, '2024-06-12 14:18:35'),
(19, 'อาหารราคาถูก', 'food', 2251245, '2024-06-12 14:19:59'),
(23, 'จอดรถฟรี', 'travel', 2251245, '2024-06-12 15:34:20'),
(24, 'มีน้ำดื่มให้', 'food', 2251245, '2024-06-12 16:23:40');

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
(42, 69704620163528, 'mali.konglerdruk', 'Mali@ku.th', '$2y$10$a9fJE2f6iwFcdrM.DGXwJ.9ZtoWYIcNGYiVFVlqp29m9bSTS.vPqi', 'Mali', 'Konglerdruk', 'user', 'uploads/69704620163528/ZMesB3Lyvzsh6Uf.jpg', 'uploads/69704620163528/PXEmpQBbe8aNhQw.jpg', '2024-06-07 19:53:39'),
(43, 233577, 'arisorn.rungruk', 'Arisorn@ku.th', '$2y$10$bgVj90PuHz/qdE5/KF/aTOOXfx8D2.bLK2oaBLkDaEEOOqFW0VGlW', 'Arisorn', 'Rungruk', 'user', 'uploads/233577/zr4PQf8LkygXpZJ.jpg', 'uploads/233577/xTbI9OZ8rONfwlV.jpg', '2023-11-02 19:49:31'),
(49, 20700969, 'testone.testerone', 'Tester@ku.th', '$2y$10$ZCVL3CxCj75g22xPQZoMiOiRRE7tmvByQ1Ur2XeSFcf3HQNL5ovZO', 'Testone', 'TesterOne', 'user', '', 'uploads/20700969/SLb3V6ell9CbapA.jpg', '2024-05-06 15:41:27'),
(50, 981946354296, 'chisanupongs.limsakul', 'Malis@ku.th', '$2y$10$kTYF0Qjb9qU9rj4ARYXyB.OCjFHS8b9jACeCFHM8yUprd3DHv0QPO', 'Chisanupongs', 'Limsakul', 'user', '', '', '2024-06-03 13:55:36'),
(51, 306793976868769692, 'nantapat.rungsiri', 'Nantapat@ku.th', '$2y$10$MMwCZCw6dnwgckVUGcFrfeU9P3VywBDOn5O.dx9PQZTrn9YvrzmV2', 'Nantapat', 'RungSiri', 'user', '', '', '2024-06-06 16:50:31');

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
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `tag_name` (`tag_name`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`,`user_id`),
  ADD KEY `report_count` (`report_count`);

--
-- Indexes for table `subtag`
--
ALTER TABLE `subtag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagname` (`tagname`),
  ADD KEY `category` (`category`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_likes`
--
ALTER TABLE `history_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subtag`
--
ALTER TABLE `subtag`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
