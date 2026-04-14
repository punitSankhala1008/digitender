-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2019 at 10:18 AM
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
-- Table structure for table `bidding`
--

CREATE TABLE `bidding` (
  `bid_id` int(3) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `charge` varchar(30) NOT NULL,
  `days` varchar(50) NOT NULL,
  `category` varchar(60) NOT NULL DEFAULT 'General',
  `tenderid` int(3) NOT NULL,
  `userid` int(3) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bidding`
--

INSERT INTO `bidding` (`bid_id`, `name`, `email`, `mobile`, `charge`, `days`, `category`, `tenderid`, `userid`, `status`) VALUES
(1, 'anshu', 'anshu@gmail.com', '9752376639', '20000', '20', 'IT Services', 3, 2, b'1'),
(2, 'anshu', 'anshu@gmail.com', '7412589632', '20000', '5 month', 'Infrastructure', 5, 2, b'1');

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
(2, 'marketinghead@gmail.com', 'password', 'marketing'),
(3, 'admin.new@digitender.com', 'Admin@123', 'operations');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mobile VARCHAR(15) UNIQUE NOT NULL,
    aadhaar VARCHAR(12) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);


--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `mobile`, `email`, `aadhaar`, `password`) VALUES
(1, 'admin', '7896547896', 'admin@gmail.com', '123456789012', 'password'),
(2, 'anshu', '7745990607', 'punit@gmail.com', '123456789013', '111111');

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
-- Table structure for table `tender`
--

CREATE TABLE `tender` (
  `id` int(3) NOT NULL,
  `TID` int(30) NOT NULL,
  `sector_name` varchar(50) NOT NULL,
  `category` varchar(60) NOT NULL DEFAULT 'General',
  `discription` varchar(50) NOT NULL,
  `fileone` varchar(150) NOT NULL,
  `filetwo` varchar(150) NOT NULL,
  `city` varchar(60) NOT NULL,
  `INR` varchar(50) NOT NULL,
  `due_date` date NOT NULL,
  `time` varchar(34) NOT NULL,
  `allot` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tender`
--

INSERT INTO `tender` (`id`, `TID`, `sector_name`, `category`, `discription`, `fileone`, `filetwo`, `city`, `INR`, `due_date`, `time`, `allot`) VALUES
(3, 741258963, 'sector 1', 'IT Services', 'testing', 'img/a_resume.docx', 'img/a_resume.docx', 'bhopal', '78000', '2019-02-23', '2 year', b'1'),
(5, 78965478, 'Nager Nigam', 'Infrastructure', 'hyrtoi rioyp w tuiryo', 'img/77f379c3fccbdd51b7b71df70aac485e_23-7-18 final report.doc', 'img/0_civil-engineerin-final-year-project-52.jpg', 'mumbai', '80000', '2019-02-22', '2 year', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidding`
--
ALTER TABLE `bidding`
  ADD PRIMARY KEY (`bid_id`);

--
-- Indexes for table `head`
--
ALTER TABLE `head`
  ADD PRIMARY KEY (`headid`);

--
-- Indexes for table `registration`
--
-- Primary key is already defined in CREATE TABLE for `registration`.

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`teamid`);

--
-- Indexes for table `tender`
--
ALTER TABLE `tender`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidding`
--
ALTER TABLE `bidding`
  MODIFY `bid_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `head`
--
ALTER TABLE `head`
  MODIFY `headid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `teamid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tender`
--
ALTER TABLE `tender`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
