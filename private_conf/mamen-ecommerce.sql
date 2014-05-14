-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 14, 2014 at 09:49 PM
-- Server version: 5.5.37
-- PHP Version: 5.3.10-1ubuntu3.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mamen-ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `Address`
--

CREATE TABLE IF NOT EXISTS `Address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `main` tinyint(1) DEFAULT '0',
  `updated` datetime DEFAULT NULL,
  `deleted` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C2F3561DA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Bill`
--

CREATE TABLE IF NOT EXISTS `Bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `updated` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` date DEFAULT NULL,
  `useInIndex` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`id`, `name`, `slug`, `updated`, `created`, `deleted`, `useInIndex`) VALUES
(1, 'Pulseras', 'pulseras', '2014-05-10 00:19:56', '2014-05-07 12:02:48', NULL, 0),
(2, 'Collares', 'collares', '2014-05-07 12:17:03', '2014-05-07 12:03:02', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Image`
--

CREATE TABLE IF NOT EXISTS `Image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `createDate` date DEFAULT NULL,
  `updated` date DEFAULT NULL,
  `dateRemove` date DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `main` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_4FC2B5B126F525E` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Image`
--

INSERT INTO `Image` (`id`, `item_id`, `createDate`, `updated`, `dateRemove`, `image`, `description`, `type`, `main`) VALUES
(1, 1, '2014-05-13', '2014-05-13', NULL, '1.jpg', NULL, 'item', 1),
(2, 2, '2014-05-13', '2014-05-13', NULL, '2.jpg', NULL, 'item', 1),
(3, 3, '2014-05-13', '2014-05-13', NULL, '3.jpg', NULL, 'item', 1),
(4, 3, '2014-05-13', '2014-05-13', NULL, '4.png', NULL, 'item', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ImageCopy`
--

CREATE TABLE IF NOT EXISTS `ImageCopy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `imageName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateRemove` date DEFAULT NULL,
  `subclase` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7AF85FB63DA5256D` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ImageCopy`
--

INSERT INTO `ImageCopy` (`id`, `image_id`, `imageName`, `dateRemove`, `subclase`) VALUES
(1, 1, '1-thumb.jpg', NULL, 'imagethumbnail'),
(2, 1, '1-box.jpg', NULL, 'imageitembox'),
(3, 1, '1-boxw.jpg', NULL, 'imageitemboxw'),
(4, 2, '2-thumb.jpg', NULL, 'imagethumbnail'),
(5, 2, '2-box.jpg', NULL, 'imageitembox'),
(6, 2, '2-boxw.jpg', NULL, 'imageitemboxw'),
(7, 3, '3-thumb.jpg', NULL, 'imagethumbnail'),
(8, 3, '3-box.jpg', NULL, 'imageitembox'),
(9, 3, '3-boxw.jpg', NULL, 'imageitemboxw'),
(10, 4, '4-thumb.png', NULL, 'imagethumbnail'),
(11, 4, '4-box.png', NULL, 'imageitembox'),
(12, 4, '4-boxw.png', NULL, 'imageitemboxw');

-- --------------------------------------------------------

--
-- Table structure for table `Item`
--

CREATE TABLE IF NOT EXISTS `Item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategory_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` date DEFAULT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BF298A205DC6FE57` (`subcategory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Item`
--

INSERT INTO `Item` (`id`, `subcategory_id`, `name`, `description`, `price`, `slug`, `updated`, `created`, `deleted`, `stock`) VALUES
(1, 1, 'Collar de plastilina con 16gb de memoria ram y muy chica', 'addsa', 123, 'collar-de-plastilina', '2014-05-13 18:28:39', '2014-05-10 10:53:27', NULL, 12),
(2, 3, 'Pulsera cool', 'Una pulsera rompedora con la que dejaras a tus amigas con la boca abierta. Ya veras que envidia les das.', 12, 'pulsera-cool', '2014-05-13 17:39:15', '2014-05-13 17:39:15', NULL, 5),
(3, 2, 'Collar de plastidecores', 'Mu bonitos señores mu bonitos', 12, 'collar-de-plastidecores', '2014-05-13 22:24:52', '2014-05-13 22:24:52', NULL, 56);

-- --------------------------------------------------------

--
-- Table structure for table `item_manufacturer`
--

CREATE TABLE IF NOT EXISTS `item_manufacturer` (
  `item_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`,`manufacturer_id`),
  KEY `IDX_F2501B1D126F525E` (`item_id`),
  KEY `IDX_F2501B1DA23B42D` (`manufacturer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Manufacturer`
--

CREATE TABLE IF NOT EXISTS `Manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Manufacturer`
--

INSERT INTO `Manufacturer` (`id`, `name`, `slug`) VALUES
(1, 'Nestle', 'nestle');

-- --------------------------------------------------------

--
-- Table structure for table `Order`
--

CREATE TABLE IF NOT EXISTS `Order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_34E8BC9C9395C3F3` (`customer_id`),
  KEY `IDX_34E8BC9CF5B7AF75` (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `OrderItem`
--

CREATE TABLE IF NOT EXISTS `OrderItem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_33E85E19126F525E` (`item_id`),
  KEY `IDX_33E85E198D9F6D38` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE IF NOT EXISTS `Payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date NOT NULL,
  `total` double NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Subcategory`
--

CREATE TABLE IF NOT EXISTS `Subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` date DEFAULT NULL,
  `useInIndex` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_8B402B9F12469DE2` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Subcategory`
--

INSERT INTO `Subcategory` (`id`, `category_id`, `name`, `slug`, `updated`, `created`, `deleted`, `useInIndex`) VALUES
(1, 2, 'Collares de mantequilla', 'collares-de-mantequilla', '2014-05-11 12:48:17', '2014-05-10 10:13:41', NULL, 0),
(2, 2, 'Collares de macarrones', 'collares-de-macarrones', '2014-05-11 12:47:58', '2014-05-11 12:47:58', NULL, 0),
(3, 1, 'Pulseras de transistores', 'pulseras-de-transistores', '2014-05-11 12:48:33', '2014-05-11 12:48:33', NULL, 0),
(4, 2, 'Collares de vestir', 'collares-de-vestir', '2014-05-11 22:13:11', '2014-05-11 22:13:11', NULL, 0),
(5, 2, 'Collares casuales', 'collares-casuales', '2014-05-11 22:13:17', '2014-05-11 22:13:17', NULL, 0),
(6, 2, 'Tus collares', 'tus-collares', '2014-05-11 22:24:52', '2014-05-11 22:24:52', NULL, 0),
(7, 2, 'Mis collares', 'mis-collares', '2014-05-11 22:24:59', '2014-05-11 22:24:59', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime DEFAULT NULL,
  `registeredDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DA17977E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Address`
--
ALTER TABLE `Address`
  ADD CONSTRAINT `FK_C2F3561DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

--
-- Constraints for table `Image`
--
ALTER TABLE `Image`
  ADD CONSTRAINT `FK_4FC2B5B126F525E` FOREIGN KEY (`item_id`) REFERENCES `Item` (`id`);

--
-- Constraints for table `ImageCopy`
--
ALTER TABLE `ImageCopy`
  ADD CONSTRAINT `FK_7AF85FB63DA5256D` FOREIGN KEY (`image_id`) REFERENCES `Image` (`id`);

--
-- Constraints for table `Item`
--
ALTER TABLE `Item`
  ADD CONSTRAINT `FK_BF298A205DC6FE57` FOREIGN KEY (`subcategory_id`) REFERENCES `Subcategory` (`id`);

--
-- Constraints for table `item_manufacturer`
--
ALTER TABLE `item_manufacturer`
  ADD CONSTRAINT `FK_F2501B1D126F525E` FOREIGN KEY (`item_id`) REFERENCES `Item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F2501B1DA23B42D` FOREIGN KEY (`manufacturer_id`) REFERENCES `Manufacturer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `FK_34E8BC9C9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `FK_34E8BC9CF5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `Address` (`id`);

--
-- Constraints for table `OrderItem`
--
ALTER TABLE `OrderItem`
  ADD CONSTRAINT `FK_33E85E19126F525E` FOREIGN KEY (`item_id`) REFERENCES `Item` (`id`),
  ADD CONSTRAINT `FK_33E85E198D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `Order` (`id`);

--
-- Constraints for table `Subcategory`
--
ALTER TABLE `Subcategory`
  ADD CONSTRAINT `FK_8B402B9F12469DE2` FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
