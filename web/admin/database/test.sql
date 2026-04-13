-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2019 at 10:16 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `head`
--

CREATE TABLE `head` (
  `headid` int(3) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `head`
--

INSERT INTO `head` (`headid`, `email`, `password`, `department`) VALUES
(1, 'saleshead@gmail.com', 'password', 'sales'),
(2, 'marketinghead@gmail.com', 'password', 'marketing');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(3) NOT NULL,
  `name` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `mobile`, `email`, `password`) VALUES
(1, 'client1', '7896547896', 'client1@gmail.com', '111111'),
(2, 'newclient', '7896547896', 'newclient@gmail.com', '111111'),
(3, 'anshu baghel', '7745990607', 'anshu@gmail.com', '111111');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `teamid` int(3) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`teamid`, `name`, `email`, `mobile`, `department`, `password`) VALUES
(1, 'mamber1', 'mamber1@gmail.com', '9874589632', 'sales', '111111'),
(2, 'mamber2', 'mamber2@gmail.com', '7458965896', 'marketing', '111111'),
(3, 'mamber3', 'mamber3@gmail.com', '7896547412', 'marketing', '111111'),
(4, 'mamber4', 'mamber4@gmail.com', '7412589632', 'sells', '111111');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(3) NOT NULL,
  `priority` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `discription` varchar(50) NOT NULL,
  `fileone` varchar(60) NOT NULL,
  `filetwo` varchar(60) NOT NULL,
  `clientid` int(3) NOT NULL,
  `assign_id` varchar(3) NOT NULL DEFAULT '---',
  `reply` varchar(50) NOT NULL DEFAULT '0',
  `close` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `priority`, `department`, `title`, `discription`, `fileone`, `filetwo`, `clientid`, `assign_id`, `reply`, `close`) VALUES
(1, 'Low', 'Sales', 'title 1 testing', 'testing 1Text area...', 'img/a_resume.docx', 'img/ad0fb2d9cc179c2b72815b630c0e5c02_ME PROJECT_copy.docx', 1, '1', 'good good 1 testing', 1),
(2, 'High', 'Marketing', 'title 2 testing', 'testing 2 Text area...', 'img/a_resume.docx', 'img/ad0fb2d9cc179c2b72815b630c0e5c02_ME PROJECT_copy.docx', 1, '---', '0', 0),
(3, 'High', 'Marketing', 'title marketing testing', ' marketing testing Text area...', 'img/a_resume.docx', 'img/ad0fb2d9cc179c2b72815b630c0e5c02_ME PROJECT_copy.docx', 2, '2', 'reply testing very poor', 0),
(4, 'Medium', 'Sales', 'title sales testing', ' sales testing Text area...', 'img/a_resume.docx', 'img/ad0fb2d9cc179c2b72815b630c0e5c02_ME PROJECT_copy.docx', 2, '---', '0', 0),
(5, 'High', 'Marketing', 'marketing anshu title testing', 'marketing anshu title testing Text area...', 'img/a_resume.docx', 'img/ad0fb2d9cc179c2b72815b630c0e5c02_ME PROJECT_copy.docx', 3, '3', 'good reply testing', 1),
(6, 'High', 'Sales', 'anshu sales title testing ', ' anshu sales title testing Text area...', 'img/a_resume.docx', 'img/ad0fb2d9cc179c2b72815b630c0e5c02_ME PROJECT_copy.docx', 3, '1', 'reply anshu testing good', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `head`
--
ALTER TABLE `head`
  ADD PRIMARY KEY (`headid`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`teamid`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `head`
--
ALTER TABLE `head`
  MODIFY `headid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `teamid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
