-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db_server
-- Generation Time: Jun 23, 2026 at 10:43 AM
-- Server version: 9.6.0
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stegoctf`
--

-- --------------------------------------------------------

--
-- Table structure for table `challenge`
--

CREATE TABLE `challenge` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(256) NOT NULL,
  `flag` varchar(64) NOT NULL,
  `category` varchar(32) NOT NULL,
  `score` int NOT NULL,
  `filepath` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `challenge`
--

INSERT INTO `challenge` (`id`, `name`, `description`, `flag`, `category`, `score`, `filepath`) VALUES
(1, 'Emptiness', 'nothing to see here.', 'KDCTF{wh4t_4_n1c3_qr_c0d3}', 'file', 100, 'challenge_files/emptiness/emptiness.txt'),
(2, 'Morse Code', 'This is definitely meaningful Morse code btw', 'flag(70ld_y0u_17_w45_m0r53_c0d3_btw..)', 'audio', 100, 'challenge_files/morse_code/morse_code.wav'),
(3, 'Jingle Bells', 'A classic! The lyrics are about bells and also some guy riding in a carriage', 'FLAG{j1ngl3_b3lls_b4tm4n_sm3lls}', 'file', 300, 'challenge_files/jingle_bells/jingle_bells'),
(4, 'Elliot', '02:48 -!- Topic for #fsociety: Preparing for Stage 2 | Evil Corp must burn!', 'KDCTF{ev1l_c0rp_1s_n0t_y0ur_fr13nd}', 'image', 300, 'challenge_files/elliot/Elliot.png'),
(100, 'easy test', 'Lorem ipsum dolor sit amet...', 'flag{test}', 'image', 100, 'challenge_files/test/test.png'),
(101, 'hard test', 'Lorem ipsum dolor sit amet...', 'flag{test}', 'image', 500, 'challenge_files/test/test.png');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `total_score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `total_score`) VALUES
(1, 'team1', 0),
(2, 'a', 0),
(3, 'b', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `password_hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_deleted` tinyint NOT NULL,
  `last_login` date NOT NULL,
  `solved` int NOT NULL,
  `score` int NOT NULL,
  `team_id` int NOT NULL,
  `imgpath` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password_hash`, `user_deleted`, `last_login`, `solved`, `score`, `team_id`, `imgpath`) VALUES
(1, 'a', '$2y$10$MqKJoW1sVEfj8JJrccQED.huT8QWKx92kQbhhHcpY9Y1VWnWZXKNy', 0, '2026-06-23', 2, 400, 3, 'img/profile/user_1_ea628d3682cad727.png'),
(3, 'b', '$2y$10$ezmUY4/UE1gwtLIx1DHWFebWrDnvt.tBV.f6n8mRPld4RF2lUwGjK', 0, '2026-06-23', 1, 300, 0, 'img/profile/user_3_e5785cf2c7428ccc.webp'),
(4, 'c', '$2y$10$Yw5S8rf1jtxOZha4uPgIseFqHNwuPxH.2g1Ti7gxfiF1k/W2wd0KS', 0, '2026-06-23', 0, 0, 0, 'img/default.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_challenges`
--

CREATE TABLE `user_challenges` (
  `user_id` int NOT NULL,
  `challenge_id` int NOT NULL,
  `solve_date` date NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_challenges`
--

INSERT INTO `user_challenges` (`user_id`, `challenge_id`, `solve_date`, `rating`, `comment`) VALUES
(1, 4, '2026-06-16', 4, 'Good!'),
(3, 4, '2026-06-16', 5, 'abc'),
(1, 100, '2026-06-23', 2, '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `challenge`
--
ALTER TABLE `challenge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `challenge`
--
ALTER TABLE `challenge`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
