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
-- Database: `cloudkeeperdb`
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


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
  `mrp` double NOT NULL,
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- Triggers `invoice_items`
--
DELIMITER //
CREATE TRIGGER `check_quantity` BEFORE INSERT ON `invoice_items`
 FOR EACH ROW BEGIN
 
     SET @res = (SELECT quantity FROM `owner_items` WHERE item_id = NEW.item_id);
     if @res <NEW.quantity THEN
         SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Insufficient Quantity in your inventory";
         
         END IF;
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `quantity_amount` AFTER INSERT ON `invoice_items`
 FOR EACH ROW BEGIN

SET @oi = getOwnerId(NEW.invoice_id);

UPDATE `invoices`
    SET `invoice_amount` = `invoice_amount` + NEW.quantity * NEW.price
    WHERE NEW.invoice_id = invoices.invoice_id;
    
UPDATE `owner_items`
    SET quantity = quantity - NEW.quantity
    WHERE item_id = NEW.item_id and owner_id = @oi;
END
//
DELIMITER ;
--
-- Indexes for dumped tables
--


INSERT INTO `items` (`item_id`, `name`, `description`, `mrp`, `image`) VALUES
(1, 'Lays American', 'Fritolay chips', 30, NULL),
(2, 'Lays Indian', 'Fritolay Chips', 30, NULL),
(3, 'Mother Dairy Chaach', 'Motherdairy salted buttermilk', 10, NULL),
(4, 'Mother Dairy Lassi', 'Motherdairy sweetened buttermilk', 10, NULL),
(5, 'O Yes!', 'Puff corns', 10, NULL),
(6, 'Aloo Pyaaz Paratha', 'Aloo Pyaaz Paratha', 20, NULL),
(7, 'Mountain Dew', 'Cold drink', 35, NULL),
(8, 'Coca Cola', 'Carbonated cold drink', 35, NULL),
(9, 'Pepsi', 'Carbonated cold drink', 35, NULL),
(10, 'Tiger Biscuit', 'Glucose biscuit', 10, NULL),
(11, 'Kurkure', 'Lehar Kurkure', 20, NULL),
(12, 'Uncle Chips', 'Salted chips', 20, NULL),
(13, 'Real Juice Mixed Fruit', '100% Natural juice', 15, NULL);

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
MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
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
