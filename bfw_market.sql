-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 03:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bfw_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `anzeige`
--

CREATE TABLE `anzeige` (
  `aid` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `picture` varchar(255) DEFAULT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anzeige`
--

INSERT INTO `anzeige` (`aid`, `titel`, `description`, `date`, `picture`, `uid`) VALUES
(19, 'Test', 'dsadsa', '2024-04-18', NULL, 1),
(20, 'Test', 'dsadsa', '2024-04-18', NULL, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `anzeigeview`
-- (See below for the actual view)
--
CREATE TABLE `anzeigeview` (
`aid` int(11)
,`uid` int(11)
,`titel` varchar(255)
,`date` date
,`description` varchar(500)
,`display_name` varchar(255)
,`email` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `bid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `aid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `fullview`
-- (See below for the actual view)
--
CREATE TABLE `fullview` (
`titel` varchar(255)
,`date` date
,`description` varchar(500)
,`display_name` varchar(255)
,`email` varchar(255)
,`name` varchar(25)
);

-- --------------------------------------------------------

--
-- Table structure for table `rubrik`
--

CREATE TABLE `rubrik` (
  `rid` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rubrik`
--

INSERT INTO `rubrik` (`rid`, `name`) VALUES
(2, 'Kleidung'),
(4, 'Elektronik'),
(5, 'B&uuml;cher'),
(6, 'M&oumlbel');

-- --------------------------------------------------------

--
-- Stand-in structure for view `rubrikview`
-- (See below for the actual view)
--
CREATE TABLE `rubrikview` (
`name` varchar(25)
,`aid` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rolle` varchar(15) NOT NULL DEFAULT 'Nein'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `display_name`, `email`, `rolle`) VALUES
(1, 'Daniel Pinck', 'testmail@website.de', 'Nein'),
(4, 'Civan Adam', 'mail@mailtest.de', 'Nein'),
(5, 'daniel', 'example@testmail.com', 'Nein'),
(6, 'fsdfsdfsdfsdf', 'fsdfsd', 'Nein'),
(7, 'DanielTest', 'hkjhkjhkjhjk', 'Nein'),
(8, 'test', 'gfdgdfgfdgdfg', 'Nein'),
(9, 'urtzrtz', 'jfgtrhrth', 'Nein'),
(10, 'qwqwqw', 'qrqrqrqr', 'Nein'),
(11, '1124fsdf', '32fdsr3', 'Nein'),
(12, 'Daniel fasfasf', 'testmail@website.asfasfas', 'Nein'),
(13, 'Daniel fasfasffdsf', 'testmail@wesdfsbsite.asfasfas', 'Nein'),
(14, 'Daniel fasfsfffasffdsf', 'testmail@wessdfsdfdfsbsite.asfasfas', 'Nein'),
(15, 'Daniel Pinckfsdf', 'testmail@websitsdfsfsdfe.de', 'Nein'),
(16, 'sdfsdf', 'fsdfdsf', 'Nein'),
(17, 'fsdfds', '325gt', 'Nein');

-- --------------------------------------------------------

--
-- Table structure for table `veroeffentlicht`
--

CREATE TABLE `veroeffentlicht` (
  `rid` int(11) NOT NULL,
  `aid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veroeffentlicht`
--

INSERT INTO `veroeffentlicht` (`rid`, `aid`) VALUES
(2, 19),
(4, 19),
(2, 20),
(4, 20);

-- --------------------------------------------------------

--
-- Structure for view `anzeigeview`
--
DROP TABLE IF EXISTS `anzeigeview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `anzeigeview`  AS SELECT `a`.`aid` AS `aid`, `u`.`uid` AS `uid`, `a`.`titel` AS `titel`, `a`.`date` AS `date`, `a`.`description` AS `description`, `u`.`display_name` AS `display_name`, `u`.`email` AS `email` FROM (`anzeige` `a` join `user` `u` on(`u`.`uid` = `a`.`uid`)) ;

-- --------------------------------------------------------

--
-- Structure for view `fullview`
--
DROP TABLE IF EXISTS `fullview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fullview`  AS SELECT `a`.`titel` AS `titel`, `a`.`date` AS `date`, `a`.`description` AS `description`, `u`.`display_name` AS `display_name`, `u`.`email` AS `email`, `r`.`name` AS `name` FROM (((`anzeige` `a` join `user` `u` on(`a`.`uid` = `u`.`uid`)) join `veroeffentlicht` `v` on(`a`.`aid` = `v`.`aid`)) join `rubrik` `r` on(`v`.`rid` = `r`.`rid`)) ;

-- --------------------------------------------------------

--
-- Structure for view `rubrikview`
--
DROP TABLE IF EXISTS `rubrikview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rubrikview`  AS SELECT `r`.`name` AS `name`, `v`.`aid` AS `aid` FROM (`rubrik` `r` join `veroeffentlicht` `v` on(`r`.`rid` = `v`.`rid`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anzeige`
--
ALTER TABLE `anzeige`
  ADD PRIMARY KEY (`aid`),
  ADD KEY `uid` (`uid`) USING BTREE;

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`bid`),
  ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `rubrik`
--
ALTER TABLE `rubrik`
  ADD PRIMARY KEY (`rid`);
ALTER TABLE `rubrik` ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `veroeffentlicht`
--
ALTER TABLE `veroeffentlicht`
  ADD KEY `rid` (`rid`) USING BTREE,
  ADD KEY `aid` (`aid`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anzeige`
--
ALTER TABLE `anzeige`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rubrik`
--
ALTER TABLE `rubrik`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anzeige`
--
ALTER TABLE `anzeige`
  ADD CONSTRAINT `anzeige_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `anzeige` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `veroeffentlicht`
--
ALTER TABLE `veroeffentlicht`
  ADD CONSTRAINT `veroeffentlicht_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `rubrik` (`rid`),
  ADD CONSTRAINT `veroeffentlicht_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `anzeige` (`aid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
