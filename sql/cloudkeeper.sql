-- phpMyAdmin SQL Dump
-- version 4.2.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2015 at 03:01 PM
-- Server version: 5.6.24
-- PHP Version: 5.5.20

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `description` varchar(250) DEFAULT NULL,
  `mrp` double NOT NULL,
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
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
  `country` varchar(50) NOT NULL DEFAULT 'india',
  `pin_code` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
 ADD PRIMARY KEY (`item_id`);

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
MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `invoice_items_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `owner_items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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


--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `first_name`, `last_name`, `username`, `password`) VALUES
(1, 'divjot', 'singh', 'divjot94', '$2y$10$gHLVsksfQIcRrgDkhhbB.OZa.6WFlf/VODBuaykzppRjXMg3iMvjy');

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`owner_id`, `shop_id`, `name`, `address`, `state`, `country`, `pin_code`) VALUES
(1, 1, 'JUST Cafe', 'NSIT, Sector 3, Dwarka', 'New Delhi', 'india', '110078');

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `mrp`, `image`) VALUES
(1, 'Mother Dairy Chaach', 'Salted Butter Milk', 10, NULL),
(2, 'Cholle Samose', 'Samose with Cholle and Onions', 25, NULL),
(3, 'Campa Orange', 'Campa Cola Orange Flavoured Drink', 10, NULL),
(4, 'Mother Dairy Lassi', 'Sugared Buttermilk ', 15, NULL),
(5, 'Campa Soda', 'Campa Cola Soda Falvoured Drink', 10, NULL),
(6, 'Lays American', 'Fritolay Lays American Chips', 30, NULL),
(7, 'Lays Indian', 'Fritolay Lays American Chips', 30, NULL),
(8, 'Pasta', 'Red sauce pasta', 40, NULL),
(9, 'Fun Flips Pudina', 'Fun Flips puff corns', 10, NULL);

--
-- Dumping data for table `owner_items`
--

INSERT INTO `owner_items` (`owner_id`, `item_id`, `cost_price`, `sell_price`, `quantity`) VALUES
(1, 1, 8, 10, 100),
(1, 2, 15, 25, 50),
(1, 3, 5, 10, 100),
(1, 4, 13, 15, 100),
(1, 5, 5, 10, 100),
(1, 6, 25, 30, 75),
(1, 7, 25, 30, 75),
(1, 8, 25, 40, 25),
(1, 9, 5, 10, 25);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
