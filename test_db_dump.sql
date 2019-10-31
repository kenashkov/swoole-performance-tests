-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2019 at 03:28 PM
-- Server version: 5.5.64-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `swoole_tests`
--

-- --------------------------------------------------------

--
-- Table structure for table `test1`
--

CREATE TABLE IF NOT EXISTS `test1` (
  `test1_id` int(10) unsigned NOT NULL,
  `test1_timestamp` int(10) unsigned NOT NULL,
  `test1_data` varchar(2000) NOT NULL,
  `test1_some_fk` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test1`
--

INSERT INTO `test1` (`test1_id`, `test1_timestamp`, `test1_data`, `test1_some_fk`) VALUES
(1, 1572448636, '1RmUhmZyDJdrDCJQoDjI\r\ndE6ufBmMVEsHTWj1NJON\r\nZFgwVFaoYhfgdfha6XLd\r\nzzmOCfIpOvkHp51WTgAC\r\nS8G75rs9R1f0STvvqEJV\r\nLxTiBh5erPbekjeWIqeI\r\nRD2Qtsco7oxkCZHwiedW\r\nd1m2NQBEgXGYmsElg3rp\r\nzIpqKTiOv4DhiocH8sKB\r\nPqJKzGBH5MAJEcxR2cJC', 33),
(2, 1572448639, 'j7gcSP6ieqcRYgRFHw8H\r\nxngh61mwtkUg93tGm3Uk\r\ncmTNMV3QlJ2fFGpFGl39\r\n1HWEWQPBgQZL1tkqjpUr\r\n1rpHa996rZUgSsebcNSR\r\n5gQ2qfdaMYe7u8MmkduS\r\nS0dyi20nPKBaRDjBk1As\r\nGqyLyL6RwInHNoucj6wB\r\nTz5M6yIC1oosLXs8Qaoh\r\nDSaRYmht1bE3hrPd1m4h', 35);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `test1`
--
ALTER TABLE `test1`
  ADD PRIMARY KEY (`test1_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `test1`
--
ALTER TABLE `test1`
  MODIFY `test1_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;