
------------------------------------------LOGIN DETAILS-------------------------------------------------

-Manager
username: dnb
password: dnb


-User (examples, since there are multiple)
username: ye
password: ye

username: mishi
password: mishi

most of the usernames are the same as the password for simplicity of remembering.
you can also register for a new account on my website, only as a User.


------------------------------------------SCRIPT FOR DATABASE (imported from phpMyAdmin)-------------------------------------------------


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jan 19, 2025 at 07:57 PM
-- Server version: 11.6.2-MariaDB-ubu2404
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `exercise_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`exercise_id`, `user_id`, `name`) VALUES
(12, NULL, 'Barbell Bench Press'),
(14, 12, 'Cool Cable Row'),
(46, 12, 'Hack Squat'),
(99, NULL, 'Straight Leg Deadlift'),
(100, NULL, 'Push-Up'),
(101, NULL, 'Pull-Up'),
(102, NULL, 'Squat'),
(103, NULL, 'Deadlift'),
(104, NULL, 'Bench Press'),
(105, NULL, 'Overhead Press'),
(107, NULL, 'Bicep Curl'),
(108, NULL, 'Tricep Dip'),
(109, NULL, 'Lunges'),
(110, NULL, 'Plank'),
(111, NULL, 'Leg Press'),
(112, NULL, 'Shoulder Fly'),
(113, NULL, 'Lat Pulldown'),
(114, NULL, 'Chest Fly'),
(115, NULL, 'Seated Row'),
(116, NULL, 'Calf Raise'),
(117, NULL, 'Incline Bench Press'),
(118, NULL, 'Decline Bench Press'),
(119, NULL, 'Hip Thrust'),
(121, 17, 'Sigma Curl'),
(129, 12, 'Yo Yo Test'),
(134, NULL, 'Unilateral Cable Row'),
(139, 2, 'Zombie Front Squat'),
(140, 2, 'The Dragon Squat'),
(141, 2, 'Shrugs'),
(142, 2, 'Unilateral Leg Extension'),
(145, 12, 'Unilateral Leg Extension'),
(147, 19, 'You\'re'),
(148, 19, 'The'),
(149, 19, 'Bay'),
(150, 19, 'Harbour'),
(151, 19, 'Butcher'),
(153, NULL, 'Barbell Lunge'),
(156, 2, 'Backpack Push-Up'),
(162, 12, 'Plate Loaded Chest Press'),
(167, 12, 'Curl Cable Row'),
(172, 20, 'Thai Curl'),
(173, 20, 'Thai Leg Press'),
(175, NULL, 'One Arm Push Up');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `type` varchar(20) NOT NULL,
  `password` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `type`, `password`) VALUES
(1, 'dnb', 'dnb@gmail.com', 'Manager', '$2y$12$wSao3h6VaijFhdx3A9x9Pehnyj0o2amTp2MVV/KU/dJrU1OTUUQDC'),
(2, 'mishi', 'mishi@gmail.com', 'User', '$2y$12$cSTcLKWNHfRdtwdLVQSe..noFQaPFFJuR7VztUzqUot2UIrdTMlTC'),
(3, 'kayn', 'kayn@gmail.com', 'User', '$2y$12$Z1EGQfPba4QkrR5IP8HZE.Te0sasP/JfhvoGBN784Uv8k2Hm/BdnK'),
(4, 'hello', 'hello@gmail.com', 'User', '$2y$12$Hzibdj84t/9r7GFVl2PH/eiozmaPzh0PKCObzbYQHACdaiUzG2pVC'),
(10, 'wazap', 'wazap@gmail.com', 'User', '$2y$12$Axu9hL3PDpLlHArhNqTbh.62M1jSEzvSVC955rdfFN8qstKG4v4ZC'),
(11, 'shib', 'shib@gmail.com', 'User', '$2y$12$1igp2YwUVuneJrEWhnHoRupByKTSO42P2a9RjQqDIy2ucWA/For/C'),
(12, 'ye', 'imcool@yahoo.com', 'User', '$2y$12$y4aJy.efdgsv4tH/DPKl8OK3yeKvHj4S/njKbecvgbmlvv3pqYp4C'),
(13, 'Dexter Morgan', 'patrickbateman@yahoo.com', 'User', '$2y$12$saC9l7Oath9ldYTJyNRC1eeI/onQZxVi00aGcPO3MLejqk72SaHmq'),
(15, 'test', 'test@test.test', 'User', '$2y$12$fpQ4U8mkqP7XhXDC81LLmuEhgFxhuDYeyzaQ5NClj4VsWN5d3apwW'),
(16, 'hi', 'hi@hi.hi', 'User', '$2y$12$5.3iV3zQHrKn8qa8GSx87up/0y3KAsZh8vaHeStOiBaSVadaqsoLu'),
(17, 'Alun', 'yikwinglun@gmail.com', 'User', '$2y$12$06a975MaEhTfbdgfNk9.QeNR6txQip5Yze9a.J5u2ukcECNQCyCj6'),
(18, 'New User', 'newuser1@yahoo.com', 'User', '$2y$12$NDuoNyUDxH5AnKc7bgMsFOAzI0tcefEX/oIfxcNX9jgm2nPdhhq/O'),
(19, 'Mister Man', 'misterman@yahoo.com', 'User', '$2y$12$/GDE36vIXLqyikwE1JzcmuNXaAdYaTASb1aha9b3hqoDmtxABxa3O'),
(20, 'thainoodleboii', 'thai@gmail.com', 'User', '$2y$12$SQFggLGgmGCA/QalVYIFBOb3hTlahJ9ljpJbf6oN6eKRpFXcLm.xy');

-- --------------------------------------------------------

--
-- Table structure for table `workout`
--

CREATE TABLE `workout` (
  `workout_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(254) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `workout`
--

INSERT INTO `workout` (`workout_id`, `user_id`, `name`, `date`) VALUES
(65, 18, 'Upper Day A', '2025-01-20'),
(66, 2, 'Chest Workout', '2025-01-26'),
(67, 2, 'Mishi Workout 1', '2025-01-26'),
(68, 2, 'Sunday Workout!', '2025-01-19'),
(69, 2, 'Test', '2025-01-25'),
(70, 2, 'Lat Workout', '2025-01-01'),
(71, 12, 'Ye Workout', '2025-01-21'),
(72, 19, 'Jesus Christ Morgan', '2025-01-25'),
(84, 2, 'Yo Mishi', '2025-06-10'),
(85, 2, 'Workout A', '2025-02-01'),
(87, 12, 'Lock In', '2025-01-25'),
(88, 12, 'Yo Workout', '2025-01-25'),
(92, 12, 'YO', '2025-01-21'),
(98, 12, 'Yest', '2025-01-30'),
(99, 20, 'Thai Workout', '2025-01-25');

-- --------------------------------------------------------

--
-- Table structure for table `workout_exercise`
--

CREATE TABLE `workout_exercise` (
  `id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `workout_id` int(11) NOT NULL,
  `set_number` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `weight` decimal(65,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `workout_exercise`
--

INSERT INTO `workout_exercise` (`id`, `exercise_id`, `workout_id`, `set_number`, `reps`, `weight`) VALUES
(198, 114, 65, 1, 6, 56.30),
(199, 114, 65, 2, 4, 67.80),
(200, 115, 65, 1, 5, 66.70),
(201, 115, 65, 2, 4, 70.50),
(204, 139, 67, 1, 5, 0.00),
(205, 139, 67, 2, 5, 10.00),
(206, 114, 66, 1, 5, 60.00),
(207, 114, 66, 2, 6, 60.00),
(208, 12, 66, 1, 8, 60.00),
(209, 12, 66, 2, 8, 70.00),
(226, 114, 69, 1, 5, 98.00),
(237, 113, 70, 1, 4, 65.00),
(238, 115, 70, 1, 8, 60.00),
(239, 115, 70, 2, 8, 67.50),
(258, 147, 72, 1, 10, 70.00),
(259, 148, 72, 1, 6, 75.00),
(260, 148, 72, 2, 5, 76.00),
(261, 149, 72, 1, 4, 78.00),
(262, 150, 72, 1, 5, 45.00),
(263, 150, 72, 2, 5, 67.00),
(264, 151, 72, 1, 3, 96.40),
(296, 99, 84, 1, 7, 90.00),
(297, 113, 85, 1, 5, 70.00),
(298, 113, 85, 2, 5, 70.00),
(299, 113, 85, 3, 4, 70.00),
(300, 117, 85, 1, 4, 60.00),
(301, 117, 85, 2, 4, 60.00),
(318, 103, 68, 1, 8, 140.00),
(319, 103, 68, 2, 6, 180.00),
(320, 112, 68, 1, 10, 120.00),
(321, 140, 68, 1, 6, 80.30),
(322, 140, 68, 2, 4, 77.40),
(323, 141, 68, 1, 6, 97.87),
(324, 141, 68, 2, 6, 97.87),
(348, 113, 71, 1, 5, 55.00),
(349, 113, 71, 2, 4, 60.00),
(350, 114, 71, 1, 4, 44.00),
(351, 113, 88, 1, 2, 45.00),
(352, 113, 88, 2, 4, 52.00),
(354, 14, 87, 1, 4, 50.80),
(377, 113, 92, 1, 34, 34.00),
(378, 114, 92, 1, 3333, 34.00),
(409, 46, 98, 2, 5, 4.00),
(421, 172, 99, 1, 2, 4.00),
(422, 172, 99, 2, 5, 53.00),
(423, 173, 99, 1, 55, 55.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`exercise_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `workout`
--
ALTER TABLE `workout`
  ADD PRIMARY KEY (`workout_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `workout_exercise`
--
ALTER TABLE `workout_exercise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exercise_id` (`exercise_id`),
  ADD KEY `workout_id` (`workout_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `workout`
--
ALTER TABLE `workout`
  MODIFY `workout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `workout_exercise`
--
ALTER TABLE `workout_exercise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=424;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `exercise_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `workout`
--
ALTER TABLE `workout`
  ADD CONSTRAINT `workout_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `workout_exercise`
--
ALTER TABLE `workout_exercise`
  ADD CONSTRAINT `workout_exercise_ibfk_1` FOREIGN KEY (`exercise_id`) REFERENCES `exercise` (`exercise_id`),
  ADD CONSTRAINT `workout_exercise_ibfk_2` FOREIGN KEY (`workout_id`) REFERENCES `workout` (`workout_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



