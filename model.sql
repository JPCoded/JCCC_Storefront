-- phpMyAdmin SQL Dump
-- version 3.3.9.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2011 at 09:30 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s406393_Storefront`
--

DROP DATABASE if exists `s406393_Storefront`;
CREATE DATABASE `s406393_Storefront` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `s406393_Storefront`;

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE IF NOT EXISTS `Customer` (
  `Customer_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` varchar(45) NOT NULL,
  `User_PWD` varchar(45) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `ShippingAddress` varchar(45) NOT NULL,
  `BillingAddress` varchar(45) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `PhoneNumber` varchar(45) NOT NULL,
  `ShippingCity` varchar(45) NOT NULL,
  `ShippingState` varchar(45) NOT NULL,
  `ShippingZip` varchar(45) NOT NULL,
  `BillingCity` varchar(45) NOT NULL,
  `BillingState` varchar(45) NOT NULL,
  `BillingZip` varchar(45) NOT NULL,
  PRIMARY KEY (`Customer_ID`),
  UNIQUE KEY `User_ID_UNIQUE` (`User_ID`),
  UNIQUE KEY `Email_UNIQUE` (`Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`Customer_ID`, `User_ID`, `User_PWD`, `FirstName`, `LastName`, `ShippingAddress`, `BillingAddress`, `Email`, `PhoneNumber`, `ShippingCity`, `ShippingState`, `ShippingZip`, `BillingCity`, `BillingState`, `BillingZip`) VALUES
(1, 'DamianPerry', 'pGT75NFO8DD', 'Winter', 'Palmer', 'Ap #327-7565 Auctor Road', 'Ap #196-5727 Erat Av.', 'nisl.Nulla.eu@nec.ca', '(975) 727-9237', 'Santa Fe Springs', 'CT', '52445', 'Sharon', 'AZ', '71310'),
(2, 'HopeJaden', 'osW31ffo9sA', 'Leslie', 'Pierce', 'P.O. Box 355, 3401 Gravida Road', 'P.O. Box 698, 722 Augue. Rd.', 'mauris@fringillami.edu', '(412) 932-1681', 'Corvallis', 'NV', '06243', 'La Mirada', 'WA', '72837'),
(3, 'McKenzieKeefe', 'RVm84cyd0Qc', 'William', 'Whitfield', '694-700 Placerat Avenue', 'P.O. Box 654, 270 Integer Rd.', 'tempus@Integer.com', '(699) 400-3713', 'Compton', 'SD', '62660', 'Saint Albans', 'WI', '17428'),
(4, 'OlgaRashad', 'vEq48lxj1NU', 'Brenden', 'Carpenter', 'P.O. Box 783, 8958 Scelerisque Rd.', '671-7100 Massa. Avenue', 'eu.tellus@fringillaornare.org', '(115) 858-6628', 'Casper', 'MA', '82669', 'Seward', 'NE', '71847'),
(5, 'YettaOscar', 'UfK32gox0Ja', 'Isadora', 'Stephenson', '444-9142 Magnis Street', 'Ap #176-3547 Cursus Rd.', 'magna.malesuada.vel@Ut.com', '(636) 968-4575', 'Buena Park', 'CT', '83465', 'Cortland', 'CO', '21370'),
(6, 'TanishaBreanna', 'xdU57slT2ZA', 'Laith', 'Montgomery', '583-9386 Nascetur Rd.', '729-4219 Elit Street', 'lectus.Nullam.suscipit@acturpisegestas.edu', '(748) 512-9991', 'Methuen', 'MD', '22889', 'Valencia', 'OH', '85094'),
(7, 'LaceyWhilemina', 'pCz38EKn1nM', 'Doris', 'Herrera', 'Ap #569-6973 Arcu Ave', '499 Molestie Rd.', 'dui.semper@neceuismod.com', '(997) 789-8283', 'Hoboken', 'MD', '52665', 'Somerville', 'WV', '57609'),
(8, 'HolmesElla', 'Jdb83oCW5Mg', 'Hedy', 'Knight', '991-9257 Urna. St.', '195-1181 Donec Av.', 'neque@ultricesposuerecubilia.com', '(916) 564-6131', 'Tok', 'TX', '75343', 'Thomasville', 'MS', '86472'),
(9, 'VielkaRooney', 'eFi61ind6aF', 'Walker', 'Whitaker', 'Ap #358-1042 Eu Rd.', '744-4246 Placerat Rd.', 'Quisque.libero.lacus@facilisiSed.edu', '(982) 213-6643', 'Rensselaer', 'MI', '28523', 'Eugene', 'TX', '72060'),
(10, 'KayeIllana', 'sdv78oFw2Mg', 'Isaac', 'Dyer', '856-3249 Enim. Rd.', 'Ap #608-6934 Elementum Street', 'at.auctor.ullamcorper@dictum.ca', '(966) 821-0502', 'Manhattan Beach', 'WV', '89118', 'Spokane', 'ND', '40063');

-- --------------------------------------------------------

--
-- Table structure for table `Favorite`
--

CREATE TABLE IF NOT EXISTS `Favorite` (
  `Customer_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  PRIMARY KEY (`Customer_ID`,`Product_ID`),
  KEY `fk_Customer_has_Product_Product1` (`Product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Favorite`
--

INSERT INTO `Favorite` (`Customer_ID`, `Product_ID`) VALUES
(1, 1),
(4, 1),
(8, 1),
(10, 1),
(1, 2),
(3, 2),
(5, 4),
(6, 4),
(9, 4),
(2, 5),
(4, 5),
(10, 5),
(1, 6),
(2, 6),
(7, 6),
(3, 7),
(9, 7),
(7, 9),
(3, 10),
(5, 10),
(7, 10);

-- --------------------------------------------------------

--
-- Table structure for table `LineItem`
--

CREATE TABLE IF NOT EXISTS `LineItem` (
  `Product_ID` int(11) NOT NULL,
  `Order_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ModRetail` decimal(10,2) unsigned NOT NULL COMMENT 'Retail minus discounts at time of purchase.',
  PRIMARY KEY (`Product_ID`,`Order_ID`),
  KEY `Order_ID` (`Order_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `LineItem`
--

INSERT INTO `LineItem` (`Product_ID`, `Order_ID`, `Quantity`, `ModRetail`) VALUES
(1, 106, 4, 0.00),
(1, 107, 3, 0.00),
(1, 109, 1, 0.00),
(2, 100, 1, 0.00),
(2, 102, 5, 0.00),
(3, 103, 3, 0.00),
(5, 103, 3, 0.00),
(6, 100, 1, 0.00),
(6, 101, 2, 0.00),
(6, 105, 1, 0.00),
(6, 109, 2, 0.00),
(7, 106, 2, 0.00),
(8, 103, 2, 0.00),
(8, 104, 2, 0.00),
(8, 107, 1, 0.00),
(8, 108, 5, 0.00),
(8, 109, 5, 0.00),
(9, 101, 2, 0.00),
(9, 107, 0, 0.00),
(10, 100, 2, 0.00),
(10, 101, 3, 0.00),
(10, 105, 3, 0.00),
(10, 107, 4, 0.00),
(10, 109, 5, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `Offer`
--

CREATE TABLE IF NOT EXISTS `Offer` (
  `Offer_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Description` text NOT NULL,
  `BeginDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `PercentOff` decimal(2,2) NOT NULL,
  PRIMARY KEY (`Offer_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `Offer`
--

INSERT INTO `Offer` (`Offer_ID`, `Description`, `BeginDate`, `EndDate`, `PercentOff`) VALUES
(1, 'varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem', '2010-06-14 05:06:11', '2011-03-22 00:05:16', 0.58),
(2, 'nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere', '2010-11-09 07:44:42', '2011-04-11 23:08:02', 0.69),
(3, 'Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a,', '2010-05-06 14:36:09', '2011-08-17 08:33:16', 0.40),
(4, 'sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id', '2010-12-01 09:46:54', '2011-06-13 02:50:54', 0.60),
(5, 'erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus', '2010-11-27 12:41:27', '2011-08-17 17:57:43', 0.93),
(6, 'ante ipsum primis in faucibus orci luctus et ultrices posuere', '2010-05-31 09:02:45', '2011-03-21 20:55:29', 0.17),
(7, 'erat semper rutrum. Fusce dolor quam, elementum at, egestas a,', '2010-03-29 12:03:16', '2011-05-13 14:07:18', 0.29),
(8, 'Cras sed leo. Cras vehicula aliquet libero. Integer in magna.', '2010-06-23 17:55:18', '2011-11-23 04:27:38', 0.12),
(9, 'enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin', '2010-09-30 05:07:26', '2011-12-29 16:06:24', 0.51),
(10, 'ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque', '2010-07-30 20:45:42', '2011-08-02 22:08:29', 0.43),
(11, 'Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat.', '2010-11-19 12:44:32', '2011-05-17 04:52:22', 0.28),
(12, 'amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat', '2010-12-24 00:38:40', '2011-12-24 22:07:34', 0.25),
(13, 'nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris', '2010-06-18 23:51:05', '2011-04-20 07:23:59', 0.29),
(14, 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices', '2010-03-06 18:07:34', '2011-08-15 11:34:35', 0.95),
(15, 'ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris', '2010-02-26 14:06:10', '2011-12-12 12:56:23', 0.35),
(16, 'pretium aliquet, metus urna convallis erat, eget tincidunt dui augue', '2010-09-24 18:04:29', '2011-10-09 13:39:10', 0.07),
(17, 'turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus.', '2010-06-10 15:11:11', '2011-05-06 20:31:21', 0.10),
(18, 'Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis', '2010-03-29 00:43:55', '2011-03-15 09:37:34', 0.52),
(19, 'sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum', '2010-06-09 23:26:47', '2011-07-03 08:43:30', 0.87),
(20, 'Seasonal Discount', '2011-02-02 12:51:20', '2012-02-04 17:18:44', 0.05);

-- --------------------------------------------------------

--
-- Table structure for table `Order`
--

CREATE TABLE IF NOT EXISTS `Order` (
  `Order_ID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderDate` datetime NOT NULL,
  `PackageTrackingNumber` varchar(45) NOT NULL,
  `OrderTotal` decimal(10,2) NOT NULL,
  `PaymentType` varchar(45) NOT NULL,
  `Customer_ID` int(11) NOT NULL,
  PRIMARY KEY (`Order_ID`),
  KEY `fk_Order_Customer` (`Customer_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123 ;

--
-- Dumping data for table `Order`
--

INSERT INTO `Order` (`Order_ID`, `OrderDate`, `PackageTrackingNumber`, `OrderTotal`, `PaymentType`, `Customer_ID`) VALUES
(100, '2011-08-18 08:05:29', '1174320297', 98.97, 'EBT', 3),
(101, '2011-05-28 10:18:15', '1982107770', 79.09, 'EBT', 4),
(102, '2012-02-14 09:00:03', '1470168144', 67.46, 'Check', 10),
(103, '2010-11-16 06:53:05', '3760740731', 67.77, 'Check', 8),
(104, '2011-01-02 07:12:34', '1655113580', 87.92, 'Credit', 3),
(105, '2010-08-23 14:26:46', '0303561233', 71.77, 'Check', 4),
(106, '2011-01-23 23:30:12', '3651638663', 38.52, 'EBT', 7),
(107, '2010-03-19 12:27:14', '1894166844', 17.34, 'Credit', 6),
(108, '2010-08-15 08:07:28', '3479708330', 89.80, 'Credit', 6),
(109, '2010-12-25 06:57:53', '4189597931', 89.31, 'EBT', 1),
(110, '2011-04-04 15:38:37', '9935819935', 117.29, 'credit', 1),
(111, '2011-04-04 15:43:01', '2262147918', 117.29, 'credit', 1),
(112, '2011-04-04 16:19:58', '5608400630', 117.29, 'credit', 1),
(113, '2011-04-04 16:20:11', '8992571715', 117.29, 'credit', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE IF NOT EXISTS `Product` (
  `Product_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Model` varchar(45) NOT NULL,
  `Manufacturer` varchar(45) NOT NULL,
  `Description` text NOT NULL,
  `OS` varchar(45) DEFAULT NULL,
  `Retail` decimal(10,2) NOT NULL,
  `Quantity` int(11) unsigned NOT NULL,
  `ReleaseDate` date DEFAULT NULL,
  PRIMARY KEY (`Product_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`Product_ID`, `Model`, `Manufacturer`, `Description`, `OS`, `Retail`, `Quantity`, `ReleaseDate`) VALUES
(1, 'Focus', 'Samsung', 'A smart phone with a touch-screen display and advanced Office capabilities that allow you to create and edit spreadsheets and text documents. It has Bluetooth support for wireless hands-free communication, a 4.9-megapixel camera, and a music player. It can also be used internationally. Navigation: finger-driven, multi-touch screen.\r\n', 'Windows', 99.99, 30, '2011-03-10'),
(2, 'T249', 'Samsung', 'A sliding cell phone with Bluetooth support for wireless hands-free communication, a 1.3-megapixel camera, and a music player. It can also be used internationally.\r\n', '-', 9.99, 17, '2011-02-14'),
(3, 'Quantum', 'LG', 'A smart phone with a touch-screen display and advanced Office capabilities that allow you to create and edit spreadsheets and text documents. It has Bluetooth support for wireless hands-free communication, a 5.0-megapixel camera, and a music player. It can also be used internationally. Navigation: finger-driven, multi-touch screen.\r\n', 'Windows', 99.99, 15, '2010-03-10'),
(4, 'Rugby II', 'Samsung', 'A folding cell phone with Bluetooth support for wireless hands-free communication, a 1.9-megapixel camera, and a music player. It can also be used internationally.\r\n', '-', 99.99, 8, '2010-11-17'),
(5, 'Droid 2 Global', 'Motorola', 'A smart phone with a touch-screen display and advanced Office capabilities that allow you to create and edit spreadsheets and text documents. It has Bluetooth support for wireless hands-free communication, a 5.0-megapixel camera, and a music player. It can also be used internationally. Navigation: finger-driven, multi-touch screen.\r\n', 'Android', 199.99, 19, '2010-07-05'),
(6, 'Solstice II', 'Samsung', 'A rectangular cell phone with a keyboard, a touch-screen display, Bluetooth support for wireless hands-free communication, a 1.9-megapixel camera, and a music player. It can also be used internationally.\r\n', '-', 29.99, 4, '2011-03-07'),
(7, 'Innuendo', 'Sanyo', 'A folding cell phone with a keyboard, a touch-screen display, Bluetooth support for wireless hands-free communication, a 3.1-megapixel camera, and a music player.\r\n', '-', 49.95, 14, '2009-03-04'),
(8, 'Taho', 'Sanyo', 'A folding cell phone with Bluetooth support for wireless hands-free communication, a 1.9-megapixel camera, and a music player.\r\n', '-', 99.99, 13, '2011-01-25'),
(9, 'HD7', 'HTC', 'A smart phone with a touch-screen display and advanced Office capabilities that allow you to create and edit spreadsheets and text documents. It has Bluetooth support for wireless hands-free communication, a 5.0-megapixel camera, and a music player. It can also be used internationally. Navigation: finger-driven, multi-touch screen.\r\n', 'Windows', 99.99, 5, '2010-12-02'),
(10, 'Nexus S', 'Samsung', 'A smart phone with a touch-screen display and a solid set of e-mail tools, though it won''t allow you to create or edit documents and spreadsheets. It has Bluetooth support for wireless hands-free communication, a 4.9-megapixel camera, and a music player. It can also be used internationally. Navigation: finger-driven, multi-touch screen.\r\n', 'Android', 199.99, 7, '2010-03-04'),
(11, 'i886', 'Motorola', 'Motorola''s first iDEN phone with a slide-out QWERTY keyboard. Other keys features include rugged housing, Push-To-Talk, 2-megapixel camera, memory card slot, music player, and 3.5mm audio jack. Other features include Exchange email and calendar, Bluetooth, and GPS.\r\n', '(proprietary)', 99.99, 5, '2011-01-26'),
(12, 'Atrix 4G', 'Motorola', 'This top-end Android smartphone sports a slew of business features, including dual-core processor, HSPA+ data, fingerprint reader, mobile hotspot, and the ability to dock to a desktop monitor, keyboard and mouse, or a shell that turns it into a full-size laptop. Media features include DLNA, HDMI TV-out, 5-megapixel camera, HD video capture, and front-facing camera with Qik video chat.\r\n', 'Android', 129.99, 1, '2011-02-25');

-- --------------------------------------------------------

--
-- Table structure for table `Product_has_Offer`
--

CREATE TABLE IF NOT EXISTS `Product_has_Offer` (
  `Product_ID` int(11) NOT NULL,
  `Offer_ID` int(11) NOT NULL,
  PRIMARY KEY (`Product_ID`,`Offer_ID`),
  KEY `fk_Product_has_Offer_Offer1` (`Offer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Product_has_Offer`
--

INSERT INTO `Product_has_Offer` (`Product_ID`, `Offer_ID`) VALUES
(10, 9),
(10, 18),
(10, 20);

-- --------------------------------------------------------

--
-- Table structure for table `Review`
--

CREATE TABLE IF NOT EXISTS `Review` (
  `Product_ID` int(11) NOT NULL,
  `Customer_ID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Subject` varchar(45) NOT NULL,
  `Body` text NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`Product_ID`,`Customer_ID`),
  KEY `fk_Review_Product1` (`Product_ID`),
  KEY `fk_Review_Customer1` (`Customer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Review`
--

INSERT INTO `Review` (`Product_ID`, `Customer_ID`, `Rating`, `Subject`, `Body`, `Date`) VALUES
(1, 5, 1, 'est ac facilisis', 'auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie', '2010-05-26 10:25:15'),
(1, 6, 1, 'metus. Vivamus euismod urna.', 'ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer', '2010-09-14 01:19:58'),
(1, 7, 4, 'erat, eget', 'Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus', '2011-05-22 02:46:23'),
(2, 7, 3, 'iaculis', 'feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede', '2011-10-21 08:20:08'),
(4, 1, 4, 'In mi pede, nonummy', 'dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur', '2010-07-06 20:13:01'),
(4, 2, 3, 'et nunc.', 'et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam', '2012-02-09 22:06:21'),
(4, 6, 5, 'ullamcorper viverra. Maecenas iaculis aliquet', 'In ornare sagittis felis. Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec', '2011-09-03 12:52:35'),
(5, 5, 2, 'vitae', 'libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec,', '2011-01-20 15:45:48'),
(5, 8, 2, 'est. Mauris', 'Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit', '2011-12-23 19:15:18'),
(5, 10, 2, 'ante. Vivamus non lorem', 'eu dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean', '2010-09-13 05:05:54'),
(7, 7, 5, 'fringilla', 'vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend.', '2010-06-23 02:04:35'),
(8, 1, 3, 'sagittis placerat. Cras dictum', 'massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut', '2011-08-18 06:35:38'),
(8, 4, 4, 'nonummy ac, feugiat non, lobortis', 'In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat', '2011-06-04 01:21:28'),
(10, 7, 3, 'at pretium aliquet, metus', 'tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non', '2011-07-19 00:08:20'),
(10, 9, 1, 'in consequat enim', 'lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus', '2010-08-29 06:43:45');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Favorite`
--
ALTER TABLE `Favorite`
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `Product` (`Product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `Customer` (`Customer_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `LineItem`
--
ALTER TABLE `LineItem`
  ADD CONSTRAINT `lineitem_ibfk_2` FOREIGN KEY (`Order_ID`) REFERENCES `Order` (`Order_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lineitem_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `Product` (`Product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `Customer` (`Customer_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `Product_has_Offer`
--
ALTER TABLE `Product_has_Offer`
  ADD CONSTRAINT `product_has_offer_ibfk_2` FOREIGN KEY (`Offer_ID`) REFERENCES `Offer` (`Offer_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `product_has_offer_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `Product` (`Product_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `Review`
--
ALTER TABLE `Review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `Customer` (`Customer_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Review_Product1` FOREIGN KEY (`Product_ID`) REFERENCES `Product` (`Product_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
