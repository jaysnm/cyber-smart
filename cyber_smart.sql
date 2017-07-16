-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 18, 2017 at 11:37 am
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cyber_smart`
--

-- --------------------------------------------------------

--
-- Table structure for table `prepaid_clients`
--
CREATE DATABASE cyber_smart;


CREATE TABLE `prepaid_clients` (
  `id` int(5) NOT NULL,
  `username` varchar(70) NOT NULL,
  `passcode` varchar(35) NOT NULL,
  `phone` bigint(13) NOT NULL,
  `amount` int(7) NOT NULL,
  `mac_address` varchar(20) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `airtime_hrs` int(3) NOT NULL,
  `airtime_mins` int(2) NOT NULL,
  `airtime_secs` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prepaid_clients`
--

INSERT INTO `prepaid_clients` (`id`, `username`, `passcode`, `phone`, `amount`, `mac_address`, `ip_address`, `airtime_hrs`, `airtime_mins`, `airtime_secs`) VALUES
(1, 'Jasonmury', '37fdf7b68d3926d86cddf6120b71c2ca', 254706959881, 500, ' 00:24:d7:23:e2:54  ', '192.168.1.160 ', 16, 40, 2),
(2, 'vkhwftite', 'bf6e4f972c45df7965cda8ed32073272', 254706959881, 500, '', '', 16, 40, 0),
(3, 'oydhzszw', '7635b7dcacb981c9eafb20ebc0c9715f', 254712252501, 300, ' 00:24:d7:23:e2:54  ', '192.168.1.160 ', 10, 0, 0),
(4, 'lsmlmgwprnzk', '2bd46567a6c7da5fc06bc34778748bed', 254712003061, 400, ' 00:24:d7:23:e2:54  ', '192.168.1.160 ', 13, 20, 0),
(6, 'RVPIOzv', '0e06870fa7838cbfb22eaf9162e55406', 254706959881, 260, '', '', 8, 40, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prepaid_clients`
--
ALTER TABLE `prepaid_clients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prepaid_clients`
--
ALTER TABLE `prepaid_clients`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
