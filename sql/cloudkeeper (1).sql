-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2015 at 06:41 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cloudkeeper`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
`invoice_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `invoice_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_amount` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `shop_id`, `invoice_time`, `invoice_amount`) VALUES
(2, 24, '2015-04-27 08:33:32', 550),
(3, 25, '2015-04-27 09:04:10', 240),
(4, 24, '2015-04-27 09:57:14', 1175),
(5, 24, '2015-04-27 15:56:47', 540);

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

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`item_id`, `invoice_id`, `quantity`, `price`) VALUES
(2, 2, 5, 98),
(2, 5, 30, 99),
(3, 4, 10, 110),
(4, 3, 10, 22),
(4, 4, 3, 25),
(5, 2, 3, 20),
(5, 3, 1, 20);

--
-- Triggers `invoice_items`
--
DELIMITER //
CREATE TRIGGER `check_quantity` BEFORE INSERT ON `invoice_items`
 FOR EACH ROW BEGIN
	 
     SET @res = (SELECT quantity FROM `owner_items` WHERE item_id = NEW.item_id);
     if @res <	NEW.quantity THEN
         SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Not Sufficient Quantity in your inventory";
         
         END IF;
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `quantity_amount` AFTER INSERT ON `invoice_items`
 FOR EACH ROW BEGIN
	UPDATE `invoices`
    SET `invoice_amount` = `invoice_amount` + NEW.quantity * 					NEW.price
    WHERE NEW.invoice_id = `invoice_id`;
    
	UPDATE `owner_items`
    SET quantity = quantity - NEW.quantity
    WHERE item_id = NEW.item_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
`item_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(140) DEFAULT NULL,
  `mrp` float NOT NULL,
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `mrp`, `image`) VALUES
(2, 'Item one', 'This is my item one', 100, NULL),
(3, 'Item two', 'This is my item two', 150, NULL),
(4, 'Item three', 'This is my item three', 25, NULL),
(5, 'Item four', 'This is my item four', 20, NULL),
(6, 'Item five', 'This is my item five', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
`owner_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `first_name`, `last_name`, `username`, `password`) VALUES
(1, 'divjot', 'singh', 'divjot94', '$2y$10$gHLVsksfQIcRrgDkhhbB.OZa.6WFlf/VODBuaykzppRjXMg3iMvjy');

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

--
-- Dumping data for table `owner_items`
--

INSERT INTO `owner_items` (`owner_id`, `item_id`, `cost_price`, `sell_price`, `quantity`) VALUES
(1, 2, 90, 98, 55),
(1, 3, 100, 108, 70),
(1, 4, 20, 24, 87),
(1, 5, 15, 18, 196),
(1, 6, 3.98, 4, 300);

-- --------------------------------------------------------

--
-- Table structure for table `phonenumbers`
--

CREATE TABLE IF NOT EXISTS `phonenumbers` (
  `owner_id` int(11) NOT NULL,
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
  `country` varchar(50) NOT NULL DEFAULT 'INDIA',
  `pin_code` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`owner_id`, `shop_id`, `name`, `address`, `state`, `country`, `pin_code`) VALUES
(1, 24, 'shop one', 'address one', 'state one', 'India', '000001'),
(1, 25, 'shop two', 'address two', 'state two', 'India', '000002'),
(1, 26, 'shop three', 'address three', 'state three', 'India', '000003'),
(1, 27, 'shop four', 'address four', 'state four', 'India', '000004');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
 ADD PRIMARY KEY (`invoice_id`), ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
 ADD PRIMARY KEY (`item_id`,`invoice_id`), ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
 ADD PRIMARY KEY (`item_id`), ADD UNIQUE KEY `name` (`name`,`description`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
 ADD PRIMARY KEY (`owner_id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `owner_items`
--
ALTER TABLE `owner_items`
 ADD PRIMARY KEY (`owner_id`,`item_id`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `phonenumbers`
--
ALTER TABLE `phonenumbers`
 ADD PRIMARY KEY (`owner_id`,`phone_number`), ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
 ADD PRIMARY KEY (`shop_id`), ADD KEY `owner_id` (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
ADD CONSTRAINT `phonenumbers_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
