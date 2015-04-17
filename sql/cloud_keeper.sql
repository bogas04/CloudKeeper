-- phpMyAdmin SQL Dump
-- version 4.2.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2015 at 12:47 PM
-- Server version: 5.6.22
-- PHP Version: 5.5.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cloud_keeper`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `person_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE IF NOT EXISTS `invoice_items` (
  `item_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
`item_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `MRP` double NOT NULL,
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
  `person_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `owner_items`
--

CREATE TABLE IF NOT EXISTS `owner_items` (
  `owner_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `cost_price` double NOT NULL,
  `sell_price` double NOT NULL,
  `quantity` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
`person_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `first_name`, `last_name`, `username`, `password`) VALUES
(6, 'divjot', 'singh', 'bogas04', '$2y$10$FpJXnOyfWB99fbSP.kGlT.d5BKpVJjyNN3c7TEk2RavzDWTFrb8I6'),
(11, 'astha', 'arya', 'aryaastha', '$2y$10$Oo5xQ4H2T/1x3prToTXU0OM8b85vGujzQ0a4RqHiYtCo/etLbqmJO');

-- --------------------------------------------------------

--
-- Table structure for table `phonenumbers`
--

CREATE TABLE IF NOT EXISTS `phonenumbers` (
  `person_id` int(11) NOT NULL,
  `phone_number` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE IF NOT EXISTS `shops` (
  `owner_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `pin_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shop_customers`
--

CREATE TABLE IF NOT EXISTS `shop_customers` (
  `customer_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`customer_id`), ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
 ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
 ADD PRIMARY KEY (`item_id`,`invoice_id`), ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
 ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
 ADD PRIMARY KEY (`owner_id`), ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `owner_items`
--
ALTER TABLE `owner_items`
 ADD PRIMARY KEY (`owner_id`,`item_id`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
 ADD PRIMARY KEY (`person_id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `phonenumbers`
--
ALTER TABLE `phonenumbers`
 ADD PRIMARY KEY (`person_id`,`phone_number`), ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
 ADD PRIMARY KEY (`shop_id`), ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `shop_customers`
--
ALTER TABLE `shop_customers`
 ADD PRIMARY KEY (`customer_id`,`shop_id`), ADD KEY `customer_id` (`customer_id`), ADD KEY `shop_id` (`shop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `owner`
--
ALTER TABLE `owner`
ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `owner_items`
--
ALTER TABLE `owner_items`
ADD CONSTRAINT `owner_items_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `owner_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phonenumbers`
--
ALTER TABLE `phonenumbers`
ADD CONSTRAINT `phonenumbers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shop_customers`
--
ALTER TABLE `shop_customers`
ADD CONSTRAINT `shop_customers_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `shop_customers_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
