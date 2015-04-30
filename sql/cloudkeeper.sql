-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2015 at 07:13 PM
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

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getCostPrice`(`item_id` INT UNSIGNED, `owner_id` INT UNSIGNED) RETURNS double unsigned
    DETERMINISTIC
BEGIN
DECLARE costPrice DOUBLE;

SET costPrice = (Select cost_price from owner_items where owner_items.owner_id = owner_id and owner_items.item_id = item_id);

RETURN (costPrice);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getName`(`item_id` INT UNSIGNED) RETURNS varchar(50) CHARSET latin1
    DETERMINISTIC
BEGIN
DECLARE itemName VARCHAR(50);
SET itemName = (SELECT name 
FROM items 
WHERE items.item_id = item_id);

RETURN (itemName);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getOwnerId`(`invoice_id` INT UNSIGNED) RETURNS int(11) unsigned
    DETERMINISTIC
BEGIN
DECLARE ownerID INT(11);
SET ownerID = 1;

SET ownerID = (SELECT owner_id 
FROM `shops`,`invoices`
WHERE shops.shop_id = invoices.shop_id and invoices.invoice_id = invoice_id);

RETURN (ownerID);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getProfit`(`invoice_id` INT(11) UNSIGNED, `item_id` INT(11) UNSIGNED) RETURNS int(11)
    DETERMINISTIC
BEGIN
DECLARE profit INT(11);
SET profit = 1;

SET profit = (SELECT owner_id 
FROM `shops`,`invoices`
WHERE shops.shop_id = invoices.shop_id and invoices.invoice_id = invoice_id);

RETURN (profit);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
`invoice_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `invoice_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_amount` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `shop_id`, `invoice_time`, `invoice_amount`) VALUES
(1, 1, '2015-04-01 15:35:18', 80),
(2, 1, '2015-04-09 15:59:33', 140),
(3, 1, '2015-04-09 16:01:13', 150),
(4, 1, '2015-04-12 19:39:57', 100),
(5, 1, '2015-04-17 20:58:00', 20),
(6, 1, '2015-04-26 21:05:18', 250),
(7, 1, '2015-04-14 21:05:32', 1140),
(8, 1, '2015-04-16 21:07:09', 420),
(9, 1, '2015-04-28 21:08:31', 50),
(10, 1, '2015-04-28 21:08:50', 300),
(11, 1, '2015-04-28 21:09:06', 60),
(12, 1, '2015-04-11 21:09:30', 1500),
(13, 1, '2015-04-19 21:09:52', 750),
(14, 1, '2015-04-28 21:10:25', 300);

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
(1, 1, 1, 10),
(1, 8, 5, 10),
(1, 11, 3, 10),
(2, 6, 5, 25),
(2, 8, 2, 25),
(2, 9, 1, 25),
(3, 4, 1, 10),
(3, 5, 1, 10),
(3, 8, 3, 10),
(4, 3, 5, 15),
(4, 12, 50, 15),
(4, 13, 25, 15),
(4, 14, 10, 15),
(7, 1, 1, 30),
(7, 2, 1, 30),
(7, 7, 19, 30),
(7, 10, 5, 30),
(8, 2, 1, 40),
(8, 4, 1, 40),
(8, 8, 2, 40);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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
(9, 'Fun Flips Pudina', 'Fun Flips puff corns', 10, NULL),
(10, '', '', 0, NULL);

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
(1, 1, 8, 10, 91),
(1, 2, 15, 25, 42),
(1, 3, 5, 10, 95),
(1, 4, 13, 15, 10),
(1, 5, 5, 10, 100),
(1, 6, 25, 30, 75),
(1, 7, 25, 30, 49),
(1, 8, 25, 40, 21),
(1, 9, 5, 10, 25),
(1, 10, 0, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`owner_id`, `shop_id`, `name`, `address`, `state`, `country`, `pin_code`) VALUES
(1, 1, 'JUST Cafe', 'NSIT, Sector 3, Dwarka', 'New Delhi', 'india', '110078');

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
MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
