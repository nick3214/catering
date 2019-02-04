/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.13-MariaDB : Database - st
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`st` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `st`;

/*Table structure for table `additional_choice` */

DROP TABLE IF EXISTS `additional_choice`;

CREATE TABLE `additional_choice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `additional_choice` */

insert  into `additional_choice`(`id`,`name`,`price`) values (4,'Coke','25'),(7,'Ice Tea','20');

/*Table structure for table `additional_pax` */

DROP TABLE IF EXISTS `additional_pax`;

CREATE TABLE `additional_pax` (
  `pax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tcode` int(11) NOT NULL,
  `pax_name` varchar(255) NOT NULL,
  `pax_price` int(11) NOT NULL,
  `pax_person` int(11) NOT NULL,
  `pax_type` int(11) NOT NULL,
  PRIMARY KEY (`pax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

/*Data for the table `additional_pax` */

insert  into `additional_pax`(`pax_id`,`tcode`,`pax_name`,`pax_price`,`pax_person`,`pax_type`) values (27,33249251,'Additional 100 PAX (Package: 0',0,100,0),(28,33249251,'Additional 20 PAX (Package: 0',0,20,0),(29,250602296,'Additional 2 PAX (Package: 0',0,2,0),(30,1568234633,'Additional 2 PAX (Package: 0',0,2,0),(31,1568234633,'Additional 2 PAX (Package: 0',0,2,0),(33,1568234633,'Additional 3 PAX',0,3,0),(34,1660350808,'Additional 2 PAX',0,2,0),(35,146656,'Additional 10 PAX',0,10,0),(36,854088409,'Additional 3 PAX',0,3,0),(37,1033308374,'Additional 5 PAX',0,5,0),(38,1586889691,'Additional 2 PAX',0,2,0),(39,40550502,'Additional 2 PAX',0,2,0),(40,548697773,'Additional 2 PAX',0,2,0),(41,1628307862,'Additional 20 PAX',0,20,0),(42,1451791215,'Additional 2 PAX',0,2,0),(43,834961733,'Additional 15 PAX',0,15,0),(44,2030837629,'Additional 2 PAX',0,2,0),(45,1310813105,'Additional 10 PAX',0,10,0),(46,346192632,'Additional 2 PAX',0,2,0),(47,1865050245,'Additional 20 PAX',0,20,0),(48,1984482102,'Additional 5 PAX',0,5,0),(49,8833456,'Additional 5 PAX',0,5,0),(50,868809584,'Additional 10 PAX',0,10,0),(51,2084463048,'Additional 100 PAX',0,100,0),(52,100267825,'Additional 10 PAX',0,10,0),(53,502595970,'Additional 10 PAX',0,10,0),(54,78967062,'Additional 20 PAX',0,20,0),(55,1928892366,'Additional 30 PAX',0,30,0),(56,2025601245,'Additional 100 PAX',0,100,0),(57,685410759,'Additional 20 PAX',0,20,0),(58,368118050,'Additional 10 PAX',0,10,0),(59,359576455,'Additional 20 PAX',0,20,0),(61,1429754844,'Additional 69 PAX',0,69,0),(62,1402901701,'Additional 3 PAX',0,3,0),(63,756386127,'Additional 10 PAX',0,10,0);

/*Table structure for table `amenities` */

DROP TABLE IF EXISTS `amenities`;

CREATE TABLE `amenities` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_name` varchar(255) NOT NULL,
  `a_type` text NOT NULL,
  `a_price` int(11) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modified` text NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*Data for the table `amenities` */

insert  into `amenities`(`a_id`,`a_name`,`a_type`,`a_price`,`date_modified`,`last_modified`) values (3,'Choices of menu','Standard',0,'2018-01-15 06:39:38','earviems@gmail.com'),(4,'Unlimited Iced Tea','Standard',0,'2018-01-15 06:39:58','earviems@gmail.com'),(5,'Well Trained and Uniformed Waiters','Standard',0,'2018-01-15 06:40:25','earviems@gmail.com'),(6,'Buffet Set up with Floral Centerpieces','Standard',0,'2018-02-20 09:37:36','earviems@gmail.com'),(7,'Table with Floor Length Cover with Floral Centerpiece and Chairs','Standard',0,'2018-02-20 09:37:58','earviems@gmail.com'),(8,'Purified Drinking Water','Standard',0,'2018-01-15 06:44:21','earviems@gmail.com'),(9,'Ice for Beverage','Standard',0,'2018-01-15 06:44:47','earviems@gmail.com'),(31,'Paper Plates','Standard',0,'2018-02-09 17:58:22','earviems@gmail.com'),(33,'Spoon','Standard',0,'2018-02-23 12:04:59','earviems@gmail.com'),(35,'Food','Standard',0,'2018-10-15 22:08:33','earviems@gmail.com'),(36,'Live Bands','Other',15000,'2018-10-17 14:26:57','tratskitchen@gmail.com'),(37,'Magicians','Other',2000,'2018-10-19 04:39:52','tratskitchen@gmail.com'),(38,'Emcee','Other',15000,'2018-10-19 04:39:42','tratskitchen@gmail.com'),(39,'Videoke','Other',2000,'2018-10-17 23:26:10','tratskitchen@gmail.com'),(40,'Mascot','Other',3000,'2019-01-14 00:21:40','tratskitchen@gmail.com'),(41,'Disco Ball','Other',1500,'2019-01-14 11:55:29','tratskitchen@gmail.com');

/*Table structure for table `cancel_resched` */

DROP TABLE IF EXISTS `cancel_resched`;

CREATE TABLE `cancel_resched` (
  `cancel_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tcode` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status_type` int(11) NOT NULL,
  `request_status` int(11) NOT NULL COMMENT '0 = Waiting for approval, 1= Cancelled, 2= Rejected',
  `resched_date` date NOT NULL,
  `resched_time` time NOT NULL,
  PRIMARY KEY (`cancel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `cancel_resched` */

insert  into `cancel_resched`(`cancel_id`,`user_id`,`tcode`,`reason`,`status_type`,`request_status`,`resched_date`,`resched_time`) values (4,40,'487220059','asd',1,1,'2019-01-23','12:59:00'),(5,40,'20946216','asd',0,1,'0000-00-00','00:00:00'),(6,38,'2077288219','yfyfy',1,1,'2019-03-12','15:00:00'),(7,38,'2077288219','yuyuy',1,1,'2019-03-13','00:00:00'),(8,38,'2077288219','qwrwqrqwrqw',0,1,'0000-00-00','00:00:00');

/*Table structure for table `city_location` */

DROP TABLE IF EXISTS `city_location`;

CREATE TABLE `city_location` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_location` varchar(255) NOT NULL,
  `fee` text NOT NULL,
  `created_by` text NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `city_location` */

insert  into `city_location`(`city_id`,`city_location`,`fee`,`created_by`) values (2,'Valenzuela City','0','earviems@gmail.com'),(3,'Makati City','1500','earviems@gmail.com'),(4,'Marikina City','1500','earviems@gmail.com'),(5,'Pasig City','1500','earviems@gmail.com'),(7,'Navotas City','1500','earviems@gmail.com'),(8,'Paranaque City','1500','earviems@gmail.com'),(9,'Mandaluyong City','1500','earviems@gmail.com'),(10,'Central City','1500','earviems@gmail.com');

/*Table structure for table `contact_us` */

DROP TABLE IF EXISTS `contact_us`;

CREATE TABLE `contact_us` (
  `contact_address` text NOT NULL,
  `contact_mobile` varchar(255) NOT NULL,
  `contact_tel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `contact_us` */

insert  into `contact_us`(`contact_address`,`contact_mobile`,`contact_tel`) values ('103 interior, maysan road delacruz alley street valenzuela city','0908-4233076/ 0916-2612417','432-3681');

/*Table structure for table `food_categories` */

DROP TABLE IF EXISTS `food_categories`;

CREATE TABLE `food_categories` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `date_modified` varchar(255) NOT NULL,
  `created_by` text NOT NULL,
  `last_modified` varchar(255) NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `food_categories` */

insert  into `food_categories`(`f_id`,`f_name`,`date_created`,`date_modified`,`created_by`,`last_modified`) values (16,'Viands','2018-10-17 11:29:05','','tratskitchen@gmail.com',''),(17,'Pasta or Vegetables','2018-10-17 11:29:15','2019-01-11 01:39:29','tratskitchen@gmail.com','tratskitchen@gmail.com'),(18,'Drinks','2018-10-17 11:29:25','','tratskitchen@gmail.com',''),(19,'Dessert','2018-10-19 01:25:21','','tratskitchen@gmail.com',''),(20,'Rice','2018-10-19 02:23:02','','tratskitchen@gmail.com','');

/*Table structure for table `food_items` */

DROP TABLE IF EXISTS `food_items`;

CREATE TABLE `food_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_category` int(11) NOT NULL,
  `sub_category` int(11) NOT NULL,
  `itm_image` varchar(255) NOT NULL,
  `cost_per_head` int(11) NOT NULL,
  `menu_type` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

/*Data for the table `food_items` */

insert  into `food_items`(`item_id`,`item_code`,`item_name`,`item_category`,`sub_category`,`itm_image`,`cost_per_head`,`menu_type`) values (43,'FI-676','Carbonara',17,8,'carbo.jpg',50,0),(44,'FI-231','Java Rice',20,13,'java.jpg',30,0),(45,'FI-225','Regular Rice',20,14,'regu.jpg',20,0),(46,'FI-962','Tuna Linguini',16,4,'tuna ling.jpg',50,0),(47,'FI-586','Spaghetti with Longganisang Hubad',17,8,'Spaghetti with Longganisa.jpg',50,0),(48,'FI-562','Pork Porchetta',16,4,'',60,0),(49,'FI-873','Beef Broccoli',16,5,'',60,0),(50,'FI-200','Lemon Chicken',16,6,'',60,0),(51,'FI-86','Butter Prawns',16,7,'',60,0),(52,'FI-574','Creme Brulee',19,11,'',40,0),(53,'FI-130','Softdrinks',18,9,'',20,0),(54,'FI-291','Pork Sinigang',16,4,'',60,0),(55,'FI-854','Ice Tea',18,9,'',15,0),(56,'FI-889','Gulaman',18,9,'',15,0),(57,'FI-764','Ice Cream',19,11,'',20,0),(58,'FI-327','Buko Pandan',19,11,'',30,0),(59,'FI-475','Cheesy Macaroni',17,8,'',35,0),(60,'FI-582','Garlic Rice',20,12,'',25,0),(61,'FI-281','Pasta Pesto',17,8,'',60,0),(62,'FI-426','Fettuccini Alfredo',17,8,'',55,0),(63,'FI-111','Lasagna Beef or Vegetables',17,8,'',55,0),(64,'FI-482','Roast Beef',16,5,'',70,0),(65,'FI-926','Lengua Pastel',16,5,'',60,0),(66,'FI-730','Beef Stroganoff',16,5,'',75,0),(67,'FI-110','Cordon Blue',16,6,'',60,0),(68,'FI-544','Portuguese Chicken Peri-Peri',16,6,'',70,0);

/*Table structure for table `freebies` */

DROP TABLE IF EXISTS `freebies`;

CREATE TABLE `freebies` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `freebie_name` varchar(255) NOT NULL,
  `f_price` float(10,2) NOT NULL,
  `freebie_type` int(11) NOT NULL,
  `date_modified` datetime NOT NULL,
  `last_modified` varchar(255) NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `freebies` */

insert  into `freebies`(`f_id`,`freebie_name`,`f_price`,`freebie_type`,`date_modified`,`last_modified`) values (13,'Mango float',0.00,0,'2018-10-17 11:45:11','tratskitchen@gmail.com'),(15,'Cupcakes',0.00,0,'2018-10-19 02:16:49','tratskitchen@gmail.com'),(17,'Graham cake',0.00,0,'2019-01-02 10:19:47','tratskitchen@gmail.com'),(18,'Mug',0.00,0,'2019-01-09 03:08:17','tratskitchen@gmail.com'),(19,'Chocolate',0.00,1,'2019-01-09 03:08:43','tratskitchen@gmail.com');

/*Table structure for table `gallery` */

DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `gallery` (
  `g_id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_photo` varchar(255) NOT NULL,
  `photo_desc` varchar(255) NOT NULL,
  `occasion_name` varchar(255) NOT NULL,
  `uploaded_by` varchar(255) NOT NULL,
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `gallery` */

insert  into `gallery`(`g_id`,`gallery_photo`,`photo_desc`,`occasion_name`,`uploaded_by`) values (5,'gal1.jpg','Trats Catering Entrance','Wedding','tratskitchen@gmail.com'),(6,'gal2.jpg','Trats Catering Band','Wedding','tratskitchen@gmail.com'),(7,'gal3.jpg','Trats Catering View','Wedding','tratskitchen@gmail.com'),(8,'gal5.jpg','Trats Catering Flowers','Wedding','tratskitchen@gmail.com'),(9,'gal6.jpg','Trats Catering Tables and chairs','Wedding','tratskitchen@gmail.com'),(10,'gal9.jpg','Trats Catering Birthday Venue','Birthday','tratskitchen@gmail.com'),(11,'funeral1.png','Trats Catering Funeral Venue','Funeral','tratskitchen@gmail.com');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `date_modified` datetime NOT NULL,
  `last_modified` text NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`menu_id`,`menu_name`,`date_modified`,`last_modified`) values (1,'Menu w/ Beef','0000-00-00 00:00:00','earviems@gmail.com'),(2,'Menu Without Beef','0000-00-00 00:00:00','earviems@gmail.com'),(3,'Menu Without Pork','0000-00-00 00:00:00','earviems@gmail.com');

/*Table structure for table `menu_list_information` */

DROP TABLE IF EXISTS `menu_list_information`;

CREATE TABLE `menu_list_information` (
  `listID` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `menu_code` int(11) NOT NULL,
  PRIMARY KEY (`listID`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=latin1;

/*Data for the table `menu_list_information` */

insert  into `menu_list_information`(`listID`,`item_id`,`menu_code`) values (1,5,1320339711),(2,6,1320339711),(3,7,1320339711),(4,17,1320339711),(5,5,1021297968),(6,6,1021297968),(7,7,1021297968),(8,11,1021297968),(9,12,1021297968),(10,13,1021297968),(11,17,1021297968),(12,5,897458431),(13,6,897458431),(14,7,897458431),(15,11,897458431),(16,12,897458431),(17,13,897458431),(18,17,897458431),(19,11,1320339711),(20,12,1320339711),(21,8,1805652127),(22,9,1805652127),(23,10,1805652127),(24,14,1805652127),(25,16,1805652127),(26,5,1682288300),(27,6,1682288300),(28,7,1682288300),(29,11,1682288300),(30,12,1682288300),(31,5,2015549914),(32,6,2015549914),(33,7,2015549914),(34,11,2015549914),(35,12,2015549914),(36,8,1814942311),(37,9,1814942311),(38,10,1814942311),(39,14,1814942311),(40,16,1814942311),(41,5,2013853357),(42,6,2013853357),(43,7,2013853357),(44,11,2013853357),(45,12,2013853357),(46,5,264575886),(47,6,264575886),(48,7,264575886),(49,11,264575886),(50,12,264575886),(51,5,720313935),(52,6,720313935),(53,7,720313935),(54,11,720313935),(55,12,720313935),(56,5,1956000342),(57,6,1956000342),(58,7,1956000342),(59,11,1956000342),(60,12,1956000342),(61,5,219847778),(62,6,219847778),(63,7,219847778),(64,11,219847778),(65,12,219847778),(66,8,1210304929),(67,9,1210304929),(68,10,1210304929),(69,14,1210304929),(70,5,134981402),(71,6,134981402),(72,7,134981402),(73,11,134981402),(74,12,134981402),(75,5,1601627082),(76,6,1601627082),(77,7,1601627082),(78,11,1601627082),(79,12,1601627082),(80,5,2034476790),(81,6,2034476790),(82,7,2034476790),(83,11,2034476790),(84,12,2034476790),(85,10,1551477987),(86,14,1551477987),(87,16,1551477987),(88,5,1551477987),(89,7,1551477987),(90,5,198403433),(91,6,198403433),(92,7,198403433),(93,11,198403433),(94,12,198403433),(95,5,1996098985),(96,6,1996098985),(97,7,1996098985),(98,11,1996098985),(99,12,1996098985),(100,5,366720842),(101,7,366720842),(102,11,366720842),(103,12,366720842),(104,17,366720842),(105,8,1250364426),(106,9,1250364426),(107,10,1250364426),(108,14,1250364426),(109,16,1250364426),(110,10,1301419580),(111,14,1301419580),(112,16,1301419580),(113,5,1301419580),(114,6,1301419580),(115,8,648889254),(116,9,648889254),(117,10,648889254),(118,14,648889254),(119,16,648889254),(120,5,502943661),(121,6,502943661),(122,7,502943661),(123,11,502943661),(124,12,502943661);

/*Table structure for table `menu_price` */

DROP TABLE IF EXISTS `menu_price`;

CREATE TABLE `menu_price` (
  `mp_id` int(11) NOT NULL AUTO_INCREMENT,
  `no_menu` int(11) NOT NULL,
  `menu_price` float(10,2) NOT NULL,
  `head_type` int(11) NOT NULL,
  `pack_type` int(11) NOT NULL,
  PRIMARY KEY (`mp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `menu_price` */

insert  into `menu_price`(`mp_id`,`no_menu`,`menu_price`,`head_type`,`pack_type`) values (1,4,200.00,0,0),(2,5,250.00,0,0),(3,6,300.00,0,0),(4,7,350.00,0,0),(5,8,400.00,0,0),(6,9,450.00,0,0),(10,4,100.00,1,0),(12,6,129.00,1,0),(13,7,540.00,1,0),(15,8,120.00,1,0),(16,9,120.00,1,0);

/*Table structure for table `menu_selection` */

DROP TABLE IF EXISTS `menu_selection`;

CREATE TABLE `menu_selection` (
  `ms_id` int(11) NOT NULL AUTO_INCREMENT,
  `tcode` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `pax_type` int(11) NOT NULL,
  PRIMARY KEY (`ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

/*Data for the table `menu_selection` */

insert  into `menu_selection`(`ms_id`,`tcode`,`item_id`,`pax_type`) values (1,1748381208,4,0),(2,1814524891,6,0),(3,577517799,3,1),(4,577517799,14,2),(5,2095705141,3,0),(6,97104560,6,0),(7,97104560,8,0),(8,1614634564,12,0),(9,1614634564,10,0),(10,1232788464,4,1),(11,1232788464,12,2),(12,1232788464,8,1),(13,1232788464,16,1),(14,1232788464,11,2),(15,1419328777,3,0),(16,1320339711,7,0),(17,2015549914,11,0),(18,1814942311,6,0),(19,2013853357,17,0),(20,264575886,13,0),(21,720313935,12,0),(22,1956000342,12,0),(23,219847778,17,0),(24,134981402,5,0),(25,1601627082,6,0),(26,2034476790,5,0),(27,1551477987,7,0),(28,1551477987,4,0),(29,198403433,11,0),(30,1996098985,12,0),(31,366720842,12,0),(32,1250364426,4,0),(33,1301419580,10,0),(34,648889254,21,0),(35,1834118853,17,0),(36,502943661,6,0),(37,502943661,7,0),(38,502943661,21,0);

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_from` int(11) NOT NULL,
  `msg_status` int(11) NOT NULL,
  `msg_to` int(11) NOT NULL,
  `msg_title` varchar(25) NOT NULL,
  `msg_content` varchar(255) NOT NULL,
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `message` */

/*Table structure for table `motif` */

DROP TABLE IF EXISTS `motif`;

CREATE TABLE `motif` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `occasion_id` int(11) NOT NULL,
  `motif` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motif_decs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motif_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_modified` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `motif` */

insert  into `motif`(`id`,`occasion_id`,`motif`,`motif_decs`,`motif_type`,`last_modified`,`date_modified`) values (1,6,'Test','test','0','tratskitchen@gmail.com','2019-02-02 05:37:30'),(10,7,'Garden','Sample Description','1','','2019-02-02 17:33:32'),(11,7,'Princess','sample only','1','','2019-02-02 17:33:32'),(12,8,'Black Panther Motif','Black panther motif po','1','','2019-02-02 17:33:32'),(17,7,'motif_type','asasasas','1','tratskitchen@gmail.com','2019-02-02 05:42:25'),(18,7,'motif_type','halo','1','tratskitchen@gmail.com','2019-02-02 05:42:03'),(19,9,'Crying Angels','asd','1','tratskitchen@gmail.com','2019-02-02 17:33:32'),(20,9,'Patay','patayto','1','tratskitchen@gmail.com','2019-02-02 17:33:32'),(21,9,'patay tayo jan','asd','1','tratskitchen@gmail.com','2019-02-02 17:33:32'),(22,6,'Iron Man','Hey','1','tratskitchen@gmail.com','2019-02-02 17:33:32'),(23,6,'Batman','w','0','tratskitchen@gmail.com','2019-02-02 05:43:08'),(24,6,'Zoo Park','grrrr','1','tratskitchen@gmail.com','2019-02-02 17:33:32'),(25,9,'Dead on the spot','baba','1','tratskitchen@gmail.com','2019-02-02 17:33:32');

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `n_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `n_logs` text NOT NULL,
  `n_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `read_logs` int(11) NOT NULL,
  `read_logs_admin` int(11) NOT NULL,
  PRIMARY KEY (`n_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

/*Data for the table `notifications` */

insert  into `notifications`(`n_id`,`user_id`,`user_type`,`n_logs`,`n_date`,`read_logs`,`read_logs_admin`) values (1,30,0,'Customer: Agnes Yba&ntilde;ez paid the reservation worth: 43530.00 transaction ID: 1301419580','2018-02-23 13:24:55',1,1),(2,27,0,'Customer: leo pugal paid initial deposit worth: 37524.00 transaction ID: 1250364426','2018-02-23 13:24:50',0,1),(3,27,0,'Customer: leo pugal paid the reservation worth: 25016.00 transaction ID: 1250364426','2018-02-23 13:34:51',0,1),(4,10,0,'Customer: Meynard Parinas paid initial deposit worth: 16800.00 transaction ID: 1672064832','2018-03-01 10:59:16',1,1),(5,33,0,'Customer: Carlex Jalmascot paid initial deposit worth: 124350.00 transaction ID: 648889254','2018-02-26 11:52:54',0,1),(6,33,0,'Customer: Carlex Jalmascot has requested to reschedule his/her event on 2018-02-28 / 11:49 Trasaction Code 648889254','2018-02-26 11:52:57',1,1),(7,33,0,'Transaction Code: 648889254 reschedule has been rejected','2018-03-01 08:10:26',0,1),(8,10,0,'Customer: Meynard Parinas paid initial deposit worth: 16800.00 transaction ID: 455830236','2018-03-02 21:10:06',1,1),(9,10,0,'Customer: Meynard Parinas paid the reservation worth: 11200.00 transaction ID: 455830236','2018-03-02 21:10:11',1,1),(10,10,0,'Customer: Meynard Parinas paid initial deposit worth: 16800.00 transaction ID: 616551553','2018-03-02 21:10:17',1,1),(11,10,0,'Customer: Meynard Parinas paid the reservation worth: 11200.00 transaction ID: 616551553','2018-03-02 21:10:21',1,1),(12,10,0,'Customer: Meynard Parinas paid initial deposit worth: 17700.00 transaction ID: 599171679','2018-10-15 17:30:48',1,1),(13,10,0,'Customer: Meynard Parinas paid the reservation worth: 11800.00 transaction ID: 599171679','2018-10-18 14:55:47',1,1),(14,10,0,'Customer: Meynard Parinas paid initial deposit worth: 18900.00 transaction ID: 1675536198','2018-10-18 09:06:14',1,1),(15,10,0,'Customer: Meynard Parinas paid the reservation worth: 52700.00 transaction ID: 1660350808','2018-10-18 14:55:43',0,1),(16,38,0,'Customer: Benjie Marquez paid the reservation worth: 30000.00 transaction ID: 1286060146','2018-10-19 04:36:51',1,1),(17,38,0,'Customer: Benjie Marquez paid initial deposit worth: 16800.00 transaction ID: 146656','2019-01-09 01:31:27',1,1),(18,38,0,'Customer: Benjie Marquez paid the reservation worth: 35000.00 transaction ID: 1203813185','2019-01-09 01:31:39',1,1),(19,38,0,'Customer: Benjie Marquez paid initial deposit worth: 13650.00 transaction ID: 257121547','2018-10-19 00:57:22',1,0),(20,38,0,'Customer: Benjie Marquez paid initial deposit worth: 12600.00 transaction ID: 549863680','2018-10-19 01:01:59',0,0),(21,38,0,'Customer: Benjie Marquez has requested to cancel his/her event. Trasaction Code 146656 reason: asd','2018-10-19 04:01:58',0,0),(22,38,0,'Customer: Benjie Marquez has requested to reschedule his/her event on 10/31/2018 / 12:59 Trasaction Code 549863680','2018-10-19 04:03:08',0,0),(23,38,0,'Customer: Benjie Marquez has requested to reschedule his/her event on 10/31/2018 / 12:59 Trasaction Code 549863680','2018-10-19 04:03:09',0,0),(24,36,0,'Customer: Therese Boltron paid initial deposit worth: 26068.20 transaction ID: 854088409','2019-01-09 01:33:59',1,0),(25,36,0,'Customer: Therese Boltron paid initial deposit worth: 25858.80 transaction ID: 40550502','2018-10-19 08:22:19',0,0),(26,36,0,'Customer: Therese Boltron paid the reservation worth: 90684.00 transaction ID: 548697773','2018-10-19 08:25:22',0,0),(27,36,0,'Customer: Therese Boltron paid initial deposit worth: 25440.00 transaction ID: 1376459885','2018-10-19 08:30:42',0,0),(28,36,0,'Customer: Therese Boltron paid the reservation worth: 69800.00 transaction ID: 157556082','2018-10-19 08:34:31',0,0),(29,38,0,'Transaction Code: 146656 cancellation has been approved','2018-10-19 09:21:35',0,0),(30,38,0,'Transaction Code: 549863680 reschedule has been rejected','2018-10-19 09:21:44',0,0),(31,38,0,'Transaction Code: 549863680 reschedule has been rejected','2018-10-19 09:21:52',0,0),(32,41,0,'Customer: Maricar Bugtong paid initial deposit worth: 13500.00 transaction ID: 1628307862','2018-10-19 11:03:18',0,0),(33,41,0,'Customer: Maricar Bugtong paid the reservation worth: 31500.00 transaction ID: 1628307862','2018-10-19 11:10:50',0,0),(34,41,0,'Customer: Maricar Bugtong paid initial deposit worth: 7500.00 transaction ID: 1550590565','2018-10-19 12:33:56',0,0),(35,36,0,'Customer: Therese Boltron paid initial deposit worth: 7500.00 transaction ID: 779370726','2018-10-19 12:55:45',0,0),(36,36,0,'Customer: Therese Boltron paid initial deposit worth: 12150.00 transaction ID: 1451791215','2018-10-19 13:04:49',0,0),(37,36,0,'Customer: Therese Boltron paid the reservation worth: 28350.00 transaction ID: 1451791215','2018-10-19 13:14:34',0,0),(38,41,0,'Customer: Maricar Bugtong paid initial deposit worth: 7500.00 transaction ID: 7969988','2018-10-19 13:57:25',0,0),(39,41,0,'Customer: Maricar Bugtong paid initial deposit worth: 7500.00 transaction ID: 234862270','2018-10-19 14:07:13',0,0),(40,41,0,'Customer: Maricar Bugtong paid initial deposit worth: 13125.00 transaction ID: 834961733','2018-10-19 14:31:03',0,0),(41,36,0,'Customer: Therese Boltron paid initial deposit worth: 7500.00 transaction ID: 1662849549','2018-10-19 14:36:52',0,0),(42,36,0,'Customer: Therese Boltron paid the reservation worth: 17500.00 transaction ID: 1662849549','2018-10-19 14:37:46',0,0),(43,41,0,'Customer: Maricar Bugtong paid initial deposit worth: 8850.00 transaction ID: 1310813105','2018-10-19 14:42:08',0,0),(44,36,0,'Customer: Therese Boltron paid initial deposit worth: 16650.00 transaction ID: 346192632','2018-10-19 14:54:44',0,0),(45,38,0,'Customer: Benjie Marquez paid initial deposit worth: 10200.00 transaction ID: 1865050245','2018-10-20 21:25:43',0,0),(46,37,0,'Customer: murck dela cruz paid initial deposit worth: 20625.00 transaction ID: 1984482102','2019-01-06 19:57:37',1,0),(47,36,0,'Customer: Therese Boltron paid the reservation worth: 17500.00 transaction ID: 779370726','2019-01-09 15:07:32',0,0),(48,40,0,'Customer: Ian Mora paid initial deposit worth: 7200.00 transaction ID: 305695966','2019-01-09 15:32:13',0,0),(49,40,0,'Customer: Ian Mora paid the reservation worth: 16800.00 transaction ID: 305695966','2019-01-09 15:36:56',0,0),(50,40,0,'Customer: Ian Mora paid the reservation worth: 25000.00 transaction ID: 1723806995','2019-01-09 15:40:33',0,0),(51,37,0,'Customer: murck dela cruz paid the reservation worth: 42500.00 transaction ID: 368118050','2019-01-09 20:57:27',1,0),(52,40,0,'Customer: Ian Mora paid initial deposit worth: 7500.00 transaction ID: 1585720094','2019-01-09 21:33:42',0,0),(53,40,0,'Customer: Ian Mora has requested to reschedule his/her event on 01/22/2019 / 12:59 Trasaction Code 1585720094','2019-01-09 21:34:22',0,0),(54,40,0,'Transaction Code: 1585720094 reschedule has been approved','2019-01-09 21:35:13',0,0),(55,40,0,'Customer: Ian Mora has requested to reschedule his/her event on 01/25/2019 / 08:00 Trasaction Code 305695966','2019-01-10 10:06:10',0,0),(56,40,0,'Transaction Code: 305695966 reschedule has been approved','2019-01-10 10:12:32',0,0),(57,40,0,'Customer: Ian Mora has requested to reschedule his/her event on 01/19/2019 / 08:00 Trasaction Code 305695966','2019-01-10 10:15:59',0,0),(58,40,0,'Customer: Ian Mora paid the reservation worth: 24000.00 transaction ID: 1007156428','2019-01-10 22:31:49',0,0),(59,40,0,'Customer: Ian Mora paid the reservation worth: 24000.00 transaction ID: 487220059','2019-01-10 22:34:12',0,0),(60,40,0,'Customer: Ian Mora has requested to reschedule his/her event on 2019-01-23 / 12:59 Trasaction Code 487220059','2019-01-10 22:35:48',0,0),(61,40,0,'Transaction Code: 487220059 reschedule has been approved','2019-01-10 22:39:22',0,0),(62,40,0,'Customer: Ian Mora paid the reservation worth: 24500.00 transaction ID: 20946216','2019-01-10 22:48:09',0,0),(63,40,0,'Customer: Ian Mora has requested to cancel his/her event. Trasaction Code 20946216 reason: asd','2019-01-10 22:50:46',0,0),(64,40,0,'Transaction Code: 20946216 cancellation has been approved','2019-01-10 23:02:07',0,0),(65,38,0,'Customer: Benjie Marquez paid the reservation worth: 36000.00 transaction ID: 359576455','2019-01-11 01:10:02',0,0),(66,38,0,'Customer: Benjie Marquez paid initial deposit worth: 16500.00 transaction ID: 2077288219','2019-01-13 22:42:39',0,0),(67,40,0,'Customer: Ian Mora paid initial deposit worth: 21675.00 transaction ID: 1429754844','2019-01-14 00:07:50',0,0),(68,37,0,'Customer: murck dela cruz paid initial deposit worth: 9300.00 transaction ID: 359311241','2019-01-14 12:21:56',0,0),(69,38,0,'Customer: Benjie Marquez has requested to reschedule his/her event on 2019-03-12 / 15:00 Trasaction Code 2077288219','2019-01-14 23:17:35',0,0),(70,38,0,'Transaction Code: 2077288219 reschedule has been approved','2019-01-14 23:38:21',0,0),(71,38,0,'Customer: Benjie Marquez has requested to reschedule his/her event on 2019-03-13 / 00:00 Trasaction Code 2077288219','2019-01-14 23:41:12',0,0),(72,38,0,'Transaction Code: 2077288219 reschedule has been approved','2019-01-14 23:41:27',0,0),(73,38,0,'Customer: Benjie Marquez has requested to cancel his/her event. Trasaction Code 2077288219 reason: qwrwqrqwrqw','2019-01-14 23:42:56',0,0),(74,38,0,'Transaction Code: 2077288219 cancellation has been approved','2019-01-14 23:43:12',0,0),(75,36,0,'Customer: Therese Boltron paid initial deposit worth: 29250.00 transaction ID: 1687910355','2019-01-18 13:04:05',0,0),(76,36,0,'Customer: Therese Boltron paid initial deposit worth: 7800.00 transaction ID: 1739562778','2019-01-21 11:41:38',0,0),(77,36,0,'Customer: Therese Boltron paid initial deposit worth: 7416.00 transaction ID: 2036048437','2019-01-21 19:52:52',0,0),(78,36,0,'Customer: Therese Boltron paid initial deposit worth: 13725.00 transaction ID: 1402901701','2019-01-21 20:04:45',0,0),(79,36,0,'Customer: Therese Boltron paid the reservation worth: 32025.00 transaction ID: 1402901701','2019-01-21 20:15:18',0,0),(80,45,0,'Customer: Ian Manay paid the reservation worth: 25000.00 transaction ID: 838132480','2019-01-22 17:55:06',0,0),(81,40,0,'Customer: Ian Mora paid initial deposit worth: 12750.00 transaction ID: 756386127','2019-01-22 20:27:45',0,0),(82,36,0,'Customer: Therese Boltron Reserve for Short Order Paluto','2019-02-02 17:45:47',1,1);

/*Table structure for table `occasion` */

DROP TABLE IF EXISTS `occasion`;

CREATE TABLE `occasion` (
  `occasion_id` int(11) NOT NULL AUTO_INCREMENT,
  `occasion_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_modified` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`occasion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `occasion` */

insert  into `occasion`(`occasion_id`,`occasion_name`,`last_modified`,`date_modified`) values (6,'Birthday','tratskitchen@gmail.com','2018-10-17 03:36:26'),(7,'Wedding','tratskitchen@gmail.com','2018-10-17 03:37:48'),(8,'Kids Party','tratskitchen@gmail.com','2018-10-17 03:37:45'),(9,'Funeral','tratskitchen@gmail.com','2018-10-17 19:45:30');

/*Table structure for table `package_extension` */

DROP TABLE IF EXISTS `package_extension`;

CREATE TABLE `package_extension` (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_name` text NOT NULL,
  `ex_price` float(10,2) NOT NULL,
  `ex_qty` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `food_type` varchar(255) NOT NULL,
  `package_sync` int(11) NOT NULL,
  `package_menu` int(11) NOT NULL,
  `ex_standard` int(11) NOT NULL,
  PRIMARY KEY (`ex_id`)
) ENGINE=InnoDB AUTO_INCREMENT=611 DEFAULT CHARSET=latin1;

/*Data for the table `package_extension` */

insert  into `package_extension`(`ex_id`,`ex_name`,`ex_price`,`ex_qty`,`code`,`food_type`,`package_sync`,`package_menu`,`ex_standard`) values (1,'Beef Broccoli',60.00,0,'1156649859','Viands',0,0,0),(243,'lkjjkl',78.00,0,'483203068','Dessert',0,0,0),(244,'asnkd',50.00,0,'483203068','Rice',0,0,0),(245,'kjkljkl',435.00,0,'483203068','Viands',0,0,0),(246,'sagfhgjhgj',34.00,0,'483203068','Viands',0,0,0),(247,'uire',56.00,0,'483203068','Pasta',0,0,0),(249,'kjkljkl',435.00,0,'1393728699','Viands',0,0,0),(250,'sagfhgjhgj',34.00,0,'1393728699','Viands',0,0,0),(251,'kjkljkl',435.00,0,'338488895','Viands',0,0,0),(252,'sagfhgjhgj',34.00,0,'338488895','Viands',0,0,0),(253,'zczxcxzc',45.00,0,'338488895','Drinks',0,0,0),(254,'uire',56.00,0,'338488895','Pasta',0,0,0),(255,'lkjjkl',78.00,0,'338488895','Dessert',0,0,0),(256,'asnkd',50.00,0,'338488895','Rice',0,0,0),(276,'kjkljkl',435.00,0,'958658252','Viands',0,0,0),(277,'sagfhgjhgj',34.00,0,'958658252','Viands',0,0,0),(278,'uire',56.00,0,'958658252','Pasta',0,0,0),(279,'zczxcxzc',45.00,0,'958658252','Drinks',0,0,0),(280,'lkjjkl',78.00,0,'958658252','Dessert',0,0,0),(281,'asnkd',50.00,0,'958658252','Rice',0,0,0),(288,'kjkljkl',435.00,0,'246700455','Viands',0,0,0),(289,'sagfhgjhgj',34.00,0,'246700455','Viands',0,0,0),(290,'uire',56.00,0,'246700455','Pasta',0,0,0),(291,'zczxcxzc',45.00,0,'246700455','Drinks',0,0,0),(292,'lkjjkl',78.00,0,'246700455','Dessert',0,0,0),(293,'asnkd',50.00,0,'246700455','Rice',0,0,0),(294,'kjkljkl',435.00,0,'893840066','Viands',0,0,0),(295,'kjkljkl',435.00,0,'632475600','Viands',0,0,0),(296,'Chicken Mami Pasta',100.00,0,'632475600','Pasta',0,0,0),(297,'asnkd',50.00,0,'632475600','Rice',0,0,0),(298,'lkjjkl',78.00,0,'632475600','Dessert',0,0,0),(299,'zczxcxzc',45.00,0,'632475600','Drinks',0,0,0),(300,'sagfhgjhgj',34.00,0,'632475600','Viands',0,0,0),(301,'Coffee Mug With pictures',0.00,0,'29356234','',0,0,0),(302,'Mango float',0.00,17,'854088409','',0,0,0),(303,'Cupcakes',0.00,4,'854088409','',0,0,0),(304,'Mango float',0.00,45,'1033308374','',0,0,0),(305,'Mango float',0.00,3,'548697773','',0,0,0),(306,'Beef Broccoli',50.00,0,'1157683965','Viands',0,0,0),(307,'Beef Broccoli',60.00,0,'469084450','Viands',0,0,0),(309,'Lemon Chicken',60.00,0,'469084450','Viands',0,0,0),(310,'Spaghetti with Longganisang Hubad',50.00,0,'469084450','Pasta',0,0,0),(311,'Softdrinks',20.00,0,'469084450','Drinks',0,0,0),(312,'Regular Rice',20.00,0,'469084450','Rice',0,0,0),(313,'Creme Brulee',40.00,0,'469084450','Dessert',0,0,0),(314,'Mango float',0.00,1,'1628307862','',0,0,0),(315,'Cupcakes',0.00,1,'1628307862','',0,0,0),(324,'Mango float',0.00,2,'779370726','',1,0,0),(326,'Cupcakes',0.00,0,'1451791215','',1,0,0),(328,'',0.00,0,'148519210','',1,0,0),(329,'Cupcakes',0.00,0,'1723806995','',1,0,0),(331,'Mango float',0.00,0,'1662849549','',1,0,0),(332,'Coffee Mug With pictures',0.00,0,'834961733','',1,0,0),(333,'Mango float',0.00,0,'2030837629','',1,0,0),(334,'Coffee Mug With pictures',0.00,0,'1310813105','',1,0,0),(335,'Mango float',0.00,0,'346192632','',1,0,0),(336,'Cupcakes',0.00,0,'1865050245','',1,0,0),(337,'Mango float',0.00,0,'1984482102','',1,0,0),(338,'Coffee Mug With pictures',0.00,0,'432006074','',1,0,0),(339,'Beef Broccoli',60.00,0,'1979216618','Viands',0,0,0),(340,'Butter Prawns',60.00,0,'1979216618','Viands',0,0,0),(341,'Carbonara',50.00,0,'1979216618','Pasta',0,0,0),(342,'Softdrinks',20.00,0,'1979216618','Drinks',0,0,0),(343,'Regular Rice',20.00,0,'1979216618','Rice',0,0,0),(344,'Java Rice',30.00,0,'1979216618','Rice',0,0,0),(353,'Beef Broccoli',60.00,0,'1244539206','Viands',0,0,0),(354,'Lemon Chicken',60.00,0,'1244539206','Viands',0,0,0),(355,'Java Rice',30.00,0,'1244539206','Rice',0,0,0),(356,'Softdrinks',20.00,0,'1244539206','Drinks',0,0,0),(357,'Creme Brulee',40.00,0,'1244539206','Dessert',0,0,0),(358,'Spaghetti with Longganisang Hubad',50.00,0,'1244539206','Pasta',0,0,0),(359,'Butter Prawns',60.00,0,'1949229346','Viands',0,0,0),(360,'Lemon Chicken',60.00,0,'1949229346','Viands',0,0,0),(361,'Carbonara',50.00,0,'1949229346','Pasta',0,0,0),(362,'Softdrinks',20.00,0,'1949229346','Drinks',0,0,0),(363,'Creme Brulee',40.00,0,'1949229346','Dessert',0,0,0),(364,'Java Rice',30.00,0,'1949229346','Rice',0,0,0),(365,'Balloons',0.00,0,'934326416','',1,0,0),(366,'Mango float',0.00,0,'868809584','',1,0,0),(367,'Beef Broccoli',60.00,0,'2056369412','Viands',0,0,0),(368,'Spaghetti with Longganisang Hubad',50.00,0,'2056369412','Pasta',0,0,0),(369,'Softdrinks',20.00,0,'2056369412','Drinks',0,0,0),(370,'Creme Brulee',40.00,0,'2056369412','Dessert',0,0,0),(371,'Java Rice',30.00,0,'2056369412','Rice',0,0,0),(372,'Butter Prawns',60.00,0,'2056369412','Viands',0,0,0),(373,'Cupcakes',0.00,0,'2084463048','',1,0,0),(374,'Cupcakes',0.00,0,'502595970','',1,0,0),(375,'Lemon Chicken',60.00,0,'2109263598','Viands',0,0,0),(376,'Tuna Linguini',50.00,0,'2109263598','Viands',0,0,0),(377,'Spaghetti with Longganisang Hubad',50.00,0,'2109263598','Pasta',0,0,0),(378,'Softdrinks',20.00,0,'2109263598','Drinks',0,0,0),(379,'Creme Brulee',40.00,0,'2109263598','Dessert',0,0,0),(381,'Regular Rice',20.00,0,'2109263598','Rice',0,0,0),(382,'Graham cake',0.00,0,'78967062','',1,0,0),(383,'Beef Broccoli',60.00,0,'641825997','Viands',0,0,0),(384,'Pork Porchetta',60.00,0,'641825997','Viands',0,0,0),(385,'Carbonara',50.00,0,'641825997','Pasta',0,0,0),(386,'Softdrinks',20.00,0,'641825997','Drinks',0,0,0),(387,'Creme Brulee',40.00,0,'641825997','Dessert',0,0,0),(388,'Regular Rice',20.00,0,'641825997','Rice',0,0,0),(389,'Graham cake',0.00,0,'1928892366','',1,0,0),(390,'Cupcakes',0.00,0,'2025601245','',1,0,0),(391,'Cupcakes',0.00,0,'685410759','',1,0,0),(392,'Mug',0.00,0,'368118050','',1,0,0),(394,'Carbonara',50.00,0,'1142854503','Pasta',0,0,0),(395,'Buko Pandan',30.00,0,'1142854503','Dessert',0,0,0),(396,'Garlic Rice',25.00,0,'1142854503','Rice',0,0,0),(397,'Beef Broccoli',60.00,0,'1142854503','Viands',0,0,0),(398,'Beef Broccoli',60.00,0,'252958474','Viands',0,0,0),(399,'Butter Prawns',60.00,0,'252958474','Viands',0,0,0),(400,'Regular Rice',20.00,0,'252958474','Rice',0,0,0),(401,'Ice Tea',15.00,0,'252958474','Drinks',0,0,0),(402,'Spaghetti with Longganisang Hubad',50.00,0,'252958474','Pasta',0,0,0),(403,'Creme Brulee',40.00,0,'252958474','Dessert',0,0,0),(404,'Mug',0.00,0,'359576455','',1,0,0),(405,'Beef Stroganoff',75.00,0,'1868645627','Viands',0,0,0),(406,'Cordon Blue',60.00,0,'1868645627','Viands',0,0,0),(408,'Ice Tea',15.00,0,'1868645627','Drinks',0,0,0),(409,'Ice Cream',20.00,0,'1868645627','Dessert',0,0,0),(410,'Garlic Rice',25.00,0,'1868645627','Rice',0,0,0),(411,'Lasagna Beef or Vegetables',55.00,0,'1868645627','Pasta or Vegetables',0,0,0),(413,'Roast Beef',70.00,0,'1115827740','Viands',0,0,0),(414,'Lasagna Beef or Vegetables',55.00,0,'1115827740','Pasta or Vegetables',0,0,0),(415,'Gulaman',15.00,0,'1115827740','Drinks',0,0,0),(416,'Buko Pandan',30.00,0,'1115827740','Dessert',0,0,0),(417,'Java Rice',30.00,0,'1115827740','Rice',0,0,0),(418,'Beef Broccoli',60.00,0,'1115827740','Viands',0,0,0),(421,'Butter Prawns',60.00,0,'1948220008','Viands',0,0,0),(422,'Beef Stroganoff',75.00,0,'1948220008','Viands',0,0,0),(423,'Carbonara',50.00,0,'1948220008','Pasta or Vegetables',0,0,0),(424,'Ice Tea',15.00,0,'1948220008','Drinks',0,0,0),(425,'Creme Brulee',40.00,0,'1948220008','Dessert',0,0,0),(426,'Java Rice',30.00,0,'1948220008','Rice',0,0,0),(435,'Beef Broccoli',60.00,0,'1688125956','Viands',0,0,0),(436,'Beef Stroganoff',75.00,0,'1688125956','Viands',0,0,0),(437,'Carbonara',50.00,0,'1688125956','Pasta or Vegetables',0,0,0),(438,'Gulaman',15.00,0,'1688125956','Drinks',0,0,0),(439,'Buko Pandan',30.00,0,'1688125956','Dessert',0,0,0),(440,'Garlic Rice',25.00,0,'1688125956','Rice',0,0,0),(441,'Garlic Rice',25.00,0,'1688125956','Rice',0,0,0),(464,'Beef Broccoli',60.00,0,'555198401','Viands',0,0,0),(465,'Beef Stroganoff',75.00,0,'555198401','Viands',0,0,0),(466,'Carbonara',50.00,0,'555198401','Pasta or Vegetables',0,0,0),(467,'Cheesy Macaroni',35.00,0,'555198401','Pasta or Vegetables',0,0,0),(468,'Ice Tea',15.00,0,'555198401','Drinks',0,0,0),(469,'Gulaman',15.00,0,'555198401','Drinks',0,0,0),(470,'Buko Pandan',30.00,0,'555198401','Dessert',0,0,0),(471,'Ice Cream',20.00,0,'555198401','Dessert',0,0,0),(472,'Java Rice',30.00,0,'555198401','Rice',0,0,0),(473,'Regular Rice',20.00,0,'555198401','Rice',0,0,0),(474,'Mug',0.00,0,'2077288219','',1,0,0),(475,'Beef Broccoli',60.00,0,'162617576','Viands',0,0,0),(477,'Cheesy Macaroni',35.00,0,'162617576','Pasta or Vegetables',0,0,0),(478,'Ice Tea',15.00,0,'162617576','Drinks',0,0,0),(479,'Creme Brulee',40.00,0,'162617576','Dessert',0,0,0),(480,'Java Rice',30.00,0,'162617576','Rice',0,0,0),(481,'Lemon Chicken',60.00,0,'162617576','Viands',0,0,0),(482,'Cordon Blue',60.00,0,'1053573532','Viands',0,0,0),(483,'Lemon Chicken',60.00,0,'1053573532','Viands',0,0,0),(484,'Cheesy Macaroni',35.00,0,'1053573532','Pasta or Vegetables',0,0,0),(485,'Ice Tea',15.00,0,'1053573532','Drinks',0,0,0),(486,'Ice Cream',20.00,0,'1053573532','Dessert',0,0,0),(487,'Regular Rice',20.00,0,'1053573532','Rice',0,0,0),(488,'Graham cake',0.00,0,'1429754844','',1,0,0),(489,'Butter Prawns',60.00,0,'398830578','Viands',0,0,0),(491,'Fettuccini Alfredo',55.00,0,'398830578','Pasta or Vegetables',0,0,0),(492,'Gulaman',15.00,0,'398830578','Drinks',0,0,0),(493,'Ice Cream',20.00,0,'398830578','Dessert',0,0,0),(494,'Java Rice',30.00,0,'398830578','Rice',0,0,0),(495,'Butter Prawns',60.00,0,'398830578','Viands',0,0,0),(496,'Beef Broccoli',60.00,0,'554307321','Viands',0,0,0),(497,'Butter Prawns',60.00,0,'554307321','Viands',0,0,0),(498,'Regular Rice',20.00,0,'554307321','Rice',0,0,0),(499,'Ice Tea',15.00,0,'554307321','Drinks',0,0,0),(500,'Spaghetti with Longganisang Hubad',50.00,0,'554307321','Pasta or Vegetables',0,0,0),(501,'Creme Brulee',40.00,0,'554307321','Dessert',0,0,0),(508,'Beef Broccoli',60.00,0,'245057346','Viands',0,0,0),(509,'Lengua Pastel',60.00,0,'245057346','Viands',0,0,0),(510,'Fettuccini Alfredo',55.00,0,'245057346','Pasta or Vegetables',0,0,0),(511,'Ice Tea',15.00,0,'245057346','Drinks',0,0,0),(512,'Buko Pandan',30.00,0,'245057346','Dessert',0,0,0),(513,'Java Rice',30.00,0,'245057346','Rice',0,0,0),(514,'Beef Broccoli',60.00,0,'939784245','Viands',0,0,0),(515,'Butter Prawns',60.00,0,'939784245','Viands',0,0,0),(516,'Cheesy Macaroni',35.00,0,'939784245','Pasta or Vegetables',0,0,0),(517,'Ice Tea',15.00,0,'939784245','Drinks',0,0,0),(518,'Ice Cream',20.00,0,'939784245','Dessert',0,0,0),(519,'Regular Rice',20.00,0,'939784245','Rice',0,0,0),(520,'Beef Broccoli',60.00,0,'1427247943','Viands',0,0,0),(521,'Butter Prawns',60.00,0,'1427247943','Viands',0,0,0),(522,'Fettuccini Alfredo',55.00,0,'1427247943','Pasta or Vegetables',0,0,0),(523,'Ice Tea',15.00,0,'1427247943','Drinks',0,0,0),(524,'Buko Pandan',30.00,0,'1427247943','Dessert',0,0,0),(525,'Java Rice',30.00,0,'1427247943','Rice',0,0,0),(526,'Beef Broccoli',60.00,0,'513668422','Viands',0,0,0),(527,'Butter Prawns',60.00,0,'513668422','Viands',0,0,0),(529,'Spaghetti with Longganisang Hubad',50.00,0,'513668422','Pasta or Vegetables',0,0,0),(530,'Ice Tea',15.00,0,'513668422','Drinks',0,0,0),(532,'Creme Brulee',40.00,0,'513668422','Dessert',0,0,0),(533,'Regular Rice',20.00,0,'513668422','Rice',0,0,0),(534,'Beef Broccoli',60.00,0,'137524022','Viands',0,0,0),(535,'Beef Stroganoff',75.00,0,'137524022','Viands',0,0,0),(536,'Lasagna Beef or Vegetables',55.00,0,'137524022','Pasta or Vegetables',0,0,0),(537,'Ice Tea',15.00,0,'137524022','Drinks',0,0,0),(538,'Creme Brulee',40.00,0,'137524022','Dessert',0,0,0),(539,'Java Rice',30.00,0,'137524022','Rice',0,0,0),(541,'Beef Broccoli',60.00,0,'2039317033','Viands',0,0,0),(542,'Carbonara',50.00,0,'2039317033','Pasta or Vegetables',0,0,0),(543,'Ice Tea',15.00,0,'2039317033','Drinks',0,0,0),(544,'Creme Brulee',40.00,0,'2039317033','Dessert',0,0,0),(545,'Java Rice',30.00,0,'2039317033','Rice',0,0,0),(546,'Cordon Blue',60.00,0,'2039317033','Viands',0,0,0),(547,'Beef Broccoli',60.00,0,'2039317033','Viands',0,0,0),(548,'Cordon Blue',60.00,0,'2039317033','Viands',0,0,0),(549,'Beef Stroganoff',75.00,0,'534349916','Viands',0,0,0),(550,'Beef Broccoli',60.00,0,'534349916','Viands',0,0,0),(551,'Fettuccini Alfredo',55.00,0,'534349916','Pasta or Vegetables',0,0,0),(552,'Ice Tea',15.00,0,'534349916','Drinks',0,0,0),(553,'Ice Cream',20.00,0,'534349916','Dessert',0,0,0),(554,'Java Rice',30.00,0,'534349916','Rice',0,0,0),(555,'Beef Broccoli',60.00,0,'1141424833','Viands',0,0,0),(556,'Butter Prawns',60.00,0,'1141424833','Viands',0,0,0),(557,'Spaghetti with Longganisang Hubad',50.00,0,'1141424833','Pasta or Vegetables',0,0,0),(558,'Ice Tea',15.00,0,'1141424833','Drinks',0,0,0),(559,'Creme Brulee',40.00,0,'1141424833','Dessert',0,0,0),(560,'Regular Rice',20.00,0,'1141424833','Rice',0,0,0),(561,'Beef Broccoli',60.00,0,'1703200187','Viands',0,0,0),(562,'Butter Prawns',60.00,0,'1703200187','Viands',0,0,0),(563,'Cheesy Macaroni',35.00,0,'1703200187','Pasta or Vegetables',0,0,0),(564,'Ice Tea',15.00,0,'1703200187','Drinks',0,0,0),(565,'Creme Brulee',40.00,0,'1703200187','Dessert',0,0,0),(566,'Java Rice',30.00,0,'1703200187','Rice',0,0,0),(567,'Butter Prawns',60.00,0,'1899640030','Viands',0,0,0),(568,'Lemon Chicken',60.00,0,'1899640030','Viands',0,0,0),(569,'Spaghetti with Longganisang Hubad',50.00,0,'1899640030','Pasta or Vegetables',0,0,0),(570,'Softdrinks',20.00,0,'1899640030','Drinks',0,0,0),(571,'Java Rice',30.00,0,'1899640030','Rice',0,0,0),(572,'Beef Broccoli',60.00,0,'1509382105','Viands',0,0,0),(573,'Beef Stroganoff',75.00,0,'1509382105','Viands',0,0,0),(574,'Fettuccini Alfredo',55.00,0,'1509382105','Pasta or Vegetables',0,0,0),(575,'Gulaman',15.00,0,'1509382105','Drinks',0,0,0),(576,'Ice Tea',15.00,0,'1509382105','Drinks',0,0,0),(577,'Creme Brulee',40.00,0,'1509382105','Dessert',0,0,0),(578,'Regular Rice',20.00,0,'1509382105','Rice',0,0,0),(579,'Beef Broccoli',60.00,0,'1304763234','Viands',0,0,0),(580,'Beef Stroganoff',75.00,0,'1304763234','Viands',0,0,0),(581,'Cheesy Macaroni',35.00,0,'1304763234','Pasta or Vegetables',0,0,0),(582,'Softdrinks',20.00,0,'1304763234','Drinks',0,0,0),(583,'Creme Brulee',40.00,0,'1304763234','Dessert',0,0,0),(584,'Java Rice',30.00,0,'1304763234','Rice',0,0,0),(585,'Beef Broccoli',60.00,0,'781485747','Viands',0,0,0),(586,'Beef Stroganoff',75.00,0,'781485747','Viands',0,0,0),(587,'Carbonara',50.00,0,'781485747','Pasta or Vegetables',0,0,0),(588,'Gulaman',15.00,0,'781485747','Drinks',0,0,0),(589,'Buko Pandan',30.00,0,'781485747','Dessert',0,0,0),(590,'Garlic Rice',25.00,0,'781485747','Rice',0,0,0),(591,'Carbonara',50.00,0,'393601486','Pasta or Vegetables',0,0,0),(592,'Carbonara',50.00,0,'393601486','Pasta or Vegetables',0,0,0),(593,'Beef Stroganoff',75.00,0,'393601486','Viands',0,0,0),(594,'Beef Broccoli',60.00,0,'393601486','Viands',0,0,0),(596,'Gulaman',15.00,0,'393601486','Drinks',0,0,0),(597,'Buko Pandan',30.00,0,'393601486','Dessert',0,0,0),(598,'Garlic Rice',25.00,0,'393601486','Rice',0,0,0),(599,'Graham cake',0.00,0,'1402901701','',1,0,0),(600,'Beef Broccoli',60.00,0,'592468093','Viands',0,0,0),(601,'Beef Stroganoff',75.00,0,'592468093','Viands',0,0,0),(603,'Beef Broccoli',60.00,0,'716161985','Viands',0,0,0),(604,'Cordon Blue',60.00,0,'716161985','Viands',0,0,0),(605,'Pasta Pesto',60.00,0,'716161985','Pasta or Vegetables',0,0,0),(606,'Softdrinks',20.00,0,'716161985','Drinks',0,0,0),(607,'Creme Brulee',40.00,0,'716161985','Dessert',0,0,0),(608,'Regular Rice',20.00,0,'716161985','Rice',0,0,0),(609,'Cupcakes',0.00,0,'756386127','',1,0,0),(610,'Beef Broccoli',60.00,0,'126227257','Viands',0,0,0);

/*Table structure for table `package_type` */

DROP TABLE IF EXISTS `package_type`;

CREATE TABLE `package_type` (
  `pt_id` int(11) NOT NULL AUTO_INCREMENT,
  `pt_code` text NOT NULL,
  `pt_name` text NOT NULL,
  `date_created` text NOT NULL,
  `date_modified` varchar(255) NOT NULL,
  `created_by` text NOT NULL,
  `last_modified` text NOT NULL,
  PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `package_type` */

/*Table structure for table `packages` */

DROP TABLE IF EXISTS `packages`;

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_type` int(11) NOT NULL COMMENT 'Package type',
  `p_user` int(11) NOT NULL COMMENT 'user who created the package',
  `custom_user` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `package_photo` varchar(255) NOT NULL,
  `package_code` varchar(255) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_desc` varchar(255) NOT NULL,
  `package_type` varchar(255) NOT NULL,
  `menu_type` int(11) NOT NULL,
  `no_menu` int(11) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `no_person` int(11) NOT NULL,
  `no_kids` varchar(255) NOT NULL,
  `no_adults` varchar(255) NOT NULL,
  `suggest_total` int(11) NOT NULL,
  `per_head` int(11) NOT NULL,
  `total_price` float(10,2) NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

/*Data for the table `packages` */

insert  into `packages`(`package_id`,`p_type`,`p_user`,`custom_user`,`code`,`package_photo`,`package_code`,`package_name`,`package_desc`,`package_type`,`menu_type`,`no_menu`,`service_type`,`no_person`,`no_kids`,`no_adults`,`suggest_total`,`per_head`,`total_price`) values (47,1,2,0,'469084450','bap1.jpg','FULL-632','Package 1','My Package','',0,0,'',0,'','',250,0,250.00),(49,1,36,1,'1949229346','photo.jpg','CUSTOM-342','Baptismal Package','none','',0,0,'',0,'','',260,0,260.00),(50,1,38,1,'2056369412','photo.jpg','CUSTOM-848','Ownow','cc','',0,0,'',0,'','',260,0,260.00),(51,1,2,0,'2109263598','beefroulade.jpg','FULL-539','Package 2','wawa','',0,0,'',0,'','',240,0,240.00),(52,1,2,0,'641825997','porkroulade.jpg','FULL-260','Package 3','Minghao','',0,0,'',0,'','',250,0,250.00),(53,1,40,1,'252958474','photo.jpg','CUSTOM-860','ian test ','ian test\r\n','',0,0,'',0,'','',245,0,245.00),(54,1,2,0,'137524022','Jellyfish.jpg','FULL-778','test package','TEsting lang po','',0,0,'',0,'','',275,0,275.00),(55,1,2,0,'1141424833','Mongolian-Beef-4.jpg','FULL-93','Package test 1','asd','',0,0,'',0,'','',245,0,245.00),(56,1,2,0,'1509382105','istockphoto-914970250-612x612.jpg','FULL-24','package 1 test','package 1','',0,0,'',0,'','',280,0,280.00),(57,1,2,0,'1304763234','butteredCorn-Carrot.jpg','FULL-314','Package b test','baba','',0,0,'',0,'','',260,0,260.00),(58,1,2,0,'781485747','36698456_1045015912331159_1900634740579368960_o.jpg','PACKAGE-011','Package G','a','',0,0,'',0,'','',255,0,255.00),(59,1,2,0,'393601486','regu.jpg','PACKAGE-012','PACKAGE G','a','',0,0,'',0,'','',305,0,305.00),(60,1,2,0,'716161985','m.png','PACKAGE-013','test package jan22','test','',0,0,'',0,'','',260,0,260.00);

/*Table structure for table `paluto_choice` */

DROP TABLE IF EXISTS `paluto_choice`;

CREATE TABLE `paluto_choice` (
  `paluto_id` int(11) NOT NULL AUTO_INCREMENT,
  `paluto_photo` varchar(255) NOT NULL,
  `paluto_name` varchar(255) NOT NULL,
  `paluto_price` varchar(255) NOT NULL,
  `paluto_type` varchar(255) NOT NULL,
  PRIMARY KEY (`paluto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `paluto_choice` */

insert  into `paluto_choice`(`paluto_id`,`paluto_photo`,`paluto_name`,`paluto_price`,`paluto_type`) values (1,'5147351.jpg','Adobo with Java Rice / Plain Rice and drinks','100','Breakfast'),(3,'carbo.jpg','Carbonara with ice tea','50','Breakfast');

/*Table structure for table `paluto_menu` */

DROP TABLE IF EXISTS `paluto_menu`;

CREATE TABLE `paluto_menu` (
  `paluto_id` int(11) NOT NULL AUTO_INCREMENT,
  `paluto_photo` varchar(255) NOT NULL,
  `paluto_name` varchar(255) NOT NULL,
  `paluto_price` float(10,2) NOT NULL,
  `paluto_type` varchar(255) NOT NULL,
  PRIMARY KEY (`paluto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `paluto_menu` */

insert  into `paluto_menu`(`paluto_id`,`paluto_photo`,`paluto_name`,`paluto_price`,`paluto_type`) values (1,'beeftapa1a.jpg','Beef Tapa',60.00,'Breakfast'),(2,'Longganisa-Sausage.jpg','Longganisa',50.00,'Breakfast'),(3,'Crispy-Fried-Chicken_exps6445_PSG143429D03_05_5b_RMS-1-696x696.jpg','Fried Chicken',50.00,'Breakfast'),(4,'5147351.jpg','Chicken Adobo',50.00,'Breakfast'),(6,'java.jpg','Java Rice',50.00,'Breakfast');

/*Table structure for table `paluto_order` */

DROP TABLE IF EXISTS `paluto_order`;

CREATE TABLE `paluto_order` (
  `paluto_id` int(11) NOT NULL AUTO_INCREMENT,
  `paluto_transaction_id` varchar(255) NOT NULL,
  `paluto_name` varchar(255) NOT NULL,
  `paluto_item_name` varchar(255) NOT NULL,
  `paluto_price` varchar(255) NOT NULL,
  `paluto_pax` varchar(255) NOT NULL,
  `paluto_total_price` varchar(255) NOT NULL,
  `paluto_method` varchar(255) NOT NULL,
  PRIMARY KEY (`paluto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `paluto_order` */

insert  into `paluto_order`(`paluto_id`,`paluto_transaction_id`,`paluto_name`,`paluto_item_name`,`paluto_price`,`paluto_pax`,`paluto_total_price`,`paluto_method`) values (12,'9','thereseboltron@gmail.com','Adobo with Java Rice / Plain Rice and drinks','100','50','5000','pack'),(13,'9','thereseboltron@gmail.com','Carbonara with ice tea','50','50','2500','pack'),(14,'10','thereseboltron@gmail.com','Beef Tapa','60.00','50','3000','meal'),(15,'11','thereseboltron@gmail.com','Fried Chicken','50.00','50','2500','meal'),(16,'12','thereseboltron@gmail.com','Adobo with Java Rice / Plain Rice and drinks','100','100','10000','pack'),(17,'13','thereseboltron@gmail.com','Carbonara','50','10','500','meal'),(18,'14','thereseboltron@gmail.com','Coke','25','10','250','meal'),(19,'14','thereseboltron@gmail.com','Carbonara','50','10','500','meal');

/*Table structure for table `paluto_reservation` */

DROP TABLE IF EXISTS `paluto_reservation`;

CREATE TABLE `paluto_reservation` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pr_status` varchar(255) NOT NULL,
  `pr_type` int(11) NOT NULL COMMENT '0=short order, 1=custom',
  `date_created` date NOT NULL,
  `pr_code` varchar(255) NOT NULL,
  `pr_name` varchar(255) NOT NULL,
  `pr_price` float(10,2) NOT NULL,
  `pr_person` int(11) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `total_paid` float(10,2) NOT NULL,
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

/*Data for the table `paluto_reservation` */

insert  into `paluto_reservation`(`pr_id`,`user_id`,`pr_status`,`pr_type`,`date_created`,`pr_code`,`pr_name`,`pr_price`,`pr_person`,`delivery_address`,`total_paid`) values (51,37,'',0,'2019-01-14','','Tuna Linguini',50.00,10,'',0.00),(52,45,'',0,'2019-01-22','','Tuna Linguini',50.00,10,'',0.00),(53,45,'',0,'2019-01-22','','Pork Porchetta',60.00,10,'',0.00),(54,45,'',0,'2019-01-22','','Tuna Linguini',50.00,10,'',0.00),(55,40,'',1,'2019-01-22','','Beef Tapa',60.00,10,'',0.00);

/*Table structure for table `paluto_reservation_package` */

DROP TABLE IF EXISTS `paluto_reservation_package`;

CREATE TABLE `paluto_reservation_package` (
  `paluto_id` int(11) NOT NULL AUTO_INCREMENT,
  `paluto_name` varchar(255) NOT NULL,
  `paluto_item_name` varchar(255) NOT NULL,
  `paluto_pax` varchar(255) NOT NULL,
  `paluto_price` varchar(255) NOT NULL,
  `paluto_total_price` varchar(255) NOT NULL,
  `paluto_status` int(255) NOT NULL,
  `paluto_method` varchar(255) NOT NULL,
  PRIMARY KEY (`paluto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*Data for the table `paluto_reservation_package` */

insert  into `paluto_reservation_package`(`paluto_id`,`paluto_name`,`paluto_item_name`,`paluto_pax`,`paluto_price`,`paluto_total_price`,`paluto_status`,`paluto_method`) values (25,'thereseboltron@gmail.com','Adobo with Java Rice / Plain Rice and drinks','100','100','10000',0,'pack'),(26,'thereseboltron@gmail.com','Carbonara with ice tea','50','50','2500',0,'pack'),(28,'thereseboltron@gmail.com','Beef Tapa','50','60.00','3000',0,'meal'),(29,'thereseboltron@gmail.com','Fried Chicken','50','50.00','2500',0,'meal'),(30,'thereseboltron@gmail.com','Adobo with Java Rice / Plain Rice and drinks','100','100','10000',0,'pack'),(31,'thereseboltron@gmail.com','Carbonara','10','50','500',0,'meal'),(32,'thereseboltron@gmail.com','Coke','10','25','250',0,'meal'),(33,'thereseboltron@gmail.com','Carbonara','10','50','500',0,'meal');

/*Table structure for table `paluto_transaction` */

DROP TABLE IF EXISTS `paluto_transaction`;

CREATE TABLE `paluto_transaction` (
  `paluto_id` int(11) NOT NULL AUTO_INCREMENT,
  `paluto_name` varchar(255) NOT NULL,
  `paluto_total_price` varchar(255) NOT NULL,
  `paluto_type_deliver` varchar(255) NOT NULL,
  `paluto_address` varchar(255) NOT NULL,
  `paluto_date` varchar(255) NOT NULL,
  `paluto_method` varchar(255) NOT NULL,
  `paluto_status` varchar(255) NOT NULL,
  PRIMARY KEY (`paluto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `paluto_transaction` */

insert  into `paluto_transaction`(`paluto_id`,`paluto_name`,`paluto_total_price`,`paluto_type_deliver`,`paluto_address`,`paluto_date`,`paluto_method`,`paluto_status`) values (9,'thereseboltron@gmail.com','7500','pickup','none','[object Object]','pack','1'),(10,'thereseboltron@gmail.com','3,000.00','pickup','none','02/20/2019','meal','0'),(11,'thereseboltron@gmail.com','2,500.00','pickup','none','02/06/2019','meal','0'),(12,'thereseboltron@gmail.com','10000','pickup','none','01/31/2019','pack','0'),(13,'thereseboltron@gmail.com','500.00','pickup','none','02/07/2019','meal','0'),(14,'thereseboltron@gmail.com','750.00','pickup','none','02/07/2019','meal','0');

/*Table structure for table `per_person` */

DROP TABLE IF EXISTS `per_person`;

CREATE TABLE `per_person` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_name` varchar(255) NOT NULL,
  `person_price` float(10,2) NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `per_person` */

insert  into `per_person`(`person_id`,`person_name`,`person_price`) values (1,'Adults',130.00),(2,'Kids',100.00);

/*Table structure for table `reply` */

DROP TABLE IF EXISTS `reply`;

CREATE TABLE `reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `reply_from` int(11) NOT NULL,
  `reply_content` text NOT NULL,
  `reply_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reply_status` int(11) NOT NULL,
  PRIMARY KEY (`reply_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `reply` */

insert  into `reply`(`reply_id`,`msg_id`,`reply_from`,`reply_content`,`reply_date`,`reply_status`) values (1,2,2,'yes po','2018-10-01 10:19:05',0),(2,2,2,'ano ba yan?','2018-10-01 10:23:07',0),(3,2,38,'la naman po sir heheh','2018-10-01 10:23:15',0),(4,2,2,'what the F','2018-10-18 09:59:10',0),(5,2,2,'asdasd','2018-10-18 09:59:15',0),(6,4,2,'ano un bro?','2018-10-18 10:17:39',0),(7,4,10,'sir ask ko lang ung about sa package','2018-10-18 10:17:51',0),(8,7,20,'yes boss','2018-10-19 07:30:24',0),(9,5,36,'sadasd','2018-10-19 07:30:41',0),(10,7,2,'asdsad','2018-10-19 07:30:55',0),(11,5,2,'aa','2018-10-19 07:54:57',0),(12,5,36,'ok login mo ung ibng account check natin if nbabasa nya ung kay there','2018-10-19 07:55:30',0);

/*Table structure for table `reservation_others` */

DROP TABLE IF EXISTS `reservation_others`;

CREATE TABLE `reservation_others` (
  `ro_id` int(11) NOT NULL AUTO_INCREMENT,
  `tcode` int(11) NOT NULL,
  `amenity_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sub_total` float(10,2) NOT NULL,
  KEY `ro_id` (`ro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `reservation_others` */

insert  into `reservation_others`(`ro_id`,`tcode`,`amenity_name`,`quantity`,`sub_total`) values (1,1402901701,'Live Bands',1,15000.00),(2,756386127,'Live Bands',1,15000.00),(3,23004,'Live Bands',1,15000.00);

/*Table structure for table `reservations` */

DROP TABLE IF EXISTS `reservations`;

CREATE TABLE `reservations` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reservation_type` int(11) NOT NULL,
  `reservation_name` varchar(255) NOT NULL,
  `reservation_contact` varchar(255) NOT NULL,
  `tcode` int(11) NOT NULL,
  `package_code` int(11) NOT NULL,
  `package_name` text NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_city` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_theme` text NOT NULL,
  `event_time` time NOT NULL,
  `event_color` varchar(255) NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_instructions` varchar(255) NOT NULL,
  `city_location` varchar(255) NOT NULL,
  `reservation_status` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pax` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL COMMENT 'occasion_id',
  `sub_id` int(11) NOT NULL COMMENT 'motif_id',
  KEY `r_id` (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `reservations` */

insert  into `reservations`(`r_id`,`user_id`,`reservation_type`,`reservation_name`,`reservation_contact`,`tcode`,`package_code`,`package_name`,`event_name`,`event_city`,`event_date`,`event_theme`,`event_time`,`event_color`,`event_venue`,`event_instructions`,`city_location`,`reservation_status`,`date_created`,`pax`,`type`,`cat_id`,`sub_id`) values (1,36,0,'','',1402901701,469084450,'Package 1','PBA 40th Season Basketball','','2019-01-29','','09:00:00','','123 Lot 5 Phase 3 Domalandan East Pangasinan','none','','Full Paid','2019-01-21 20:15:18',120,'buffet',6,22),(2,45,0,'','',838132480,469084450,'Package 1','Test jan22','','2019-01-26','','09:53:00','','asd asd asd','none','','Full Paid','2019-01-22 17:55:06',100,'buffet',6,22),(3,40,0,'','',756386127,469084450,'Package 1','Test event jan22','','2019-01-26','','19:01:00','','asd asd asd','none','','Paid Initially','2019-01-22 20:27:45',100,'buffet',6,22),(4,36,0,'','',23004,2109263598,'Package 2','Trip lang','','2019-02-07','','12:00:00','','valenzuela decastro valenzuela','none','','Draft','2019-02-02 19:33:14',100,'buffet',6,22);

/*Table structure for table `service_type` */

DROP TABLE IF EXISTS `service_type`;

CREATE TABLE `service_type` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_type` varchar(255) NOT NULL,
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `service_type` */

insert  into `service_type`(`service_id`,`service_type`) values (1,'Major Event'),(2,'Minor Event');

/*Table structure for table `site_settings` */

DROP TABLE IF EXISTS `site_settings`;

CREATE TABLE `site_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `setting_content` text NOT NULL,
  `setting_value` int(11) NOT NULL,
  `date_modified` datetime NOT NULL,
  `last_modified` varchar(255) NOT NULL,
  KEY `setting_id` (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `site_settings` */

insert  into `site_settings`(`setting_id`,`setting_name`,`setting_content`,`setting_value`,`date_modified`,`last_modified`) values (1,'Customization Fee','<p>jgkjl</p>\r\n',0,'2018-10-15 09:04:42','earviems@gmail.com'),(2,'Downpayment(%)','                    ',30,'2018-10-19 12:16:59','tratskitchen@gmail.com'),(3,'Maximum reservation per day','',5,'2018-10-19 12:58:55','tratskitchen@gmail.com'),(4,'Reservation Fee','',0,'2018-02-23 09:15:52','earviems@gmail.com'),(5,'Transportation Fee','',0,'2018-02-23 09:16:06','earviems@gmail.com'),(6,'Our Story','<p>&nbsp;</p>\r\n\r\n<p><strong>Welcome to Earviems Catering Services</strong></p>\r\n\r\n<p><strong>&ldquo;For more than 9 years of catering events, we have been blessed to be part of thousands of weddings, debuts, corporate events, and private celebrations. These events gave given us valuable insights and ideas that inspire our continouseffeort to provide better and improved services to wider set of client.</strong></p>\r\n\r\n<p><br />\r\n<strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </strong></p>\r\n\r\n<p><strong>But what really matters to us is our relationship with our customers. We consider ourselves not only a caterer, but also a partner that will assist you during the process of conceptualizing, planning, and on the day of your event. We are here to help your dream event possible.&rdquo;</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n',0,'2018-03-01 10:37:30','earviems@gmail.com'),(7,'Terms and Conditions','<ul>\r\n	<li>The contents of this contract must remain confidential.</li>\r\n	<li>Failure to comply with the terms and conditions in this agreement invalidates the contract.</li>\r\n	<li>Catering is within the area of Metro Manila.</li>\r\n	<li>Minimum pax 100pax.</li>\r\n	<li>The management will call the customer about the payment details.</li>\r\n	<li>Sessions will be held in 3 hours (min) &ndash; 5 hours (max)</li>\r\n	<li>&ldquo;Five event per day&rdquo; policy.</li>\r\n	<li>For instances, if there is other food that is not include by the Trattoria&rsquo;s Kitchenette the customer must read and agree to the waiver statement that will be given so the company will not be responsible for any food poisoning, issues, etc.</li>\r\n	<li>Does not include LCD Projector and screen.</li>\r\n	<li>All set items will remain as property of Trattoria&rsquo;s Kitchenette.</li>\r\n	<li>All materials are subject to availability.</li>\r\n	<li>If the materials that was use in the event had broken or lost by the client, the client are responsible for the additional charges.</li>\r\n	<li>For the add-ons, price is subject to quotations.</li>\r\n</ul>\r\n\r\n<ul style=\"list-style-type:square\">\r\n	<li>For every main course, additional Php 60.00</li>\r\n	<li>For every pasta, additional Php 50.00</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Added services may apply&rsquo;s extra fees.</li>\r\n	<li>The client can make its own package if it doesn&rsquo;t like the offer packages.</li>\r\n</ul>\r\n\r\n<p><em>Cancellations&nbsp; &amp; Refunds&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em></p>\r\n\r\n<ul>\r\n	<li>Customer must pay minimum 30% of down-payment.</li>\r\n	<li>The 70% will be paid on the exact date of the event (after the event handle)</li>\r\n	<li>If the customer wants to cancel its confirmed reservation due to personal reason after two days of the reserved date, the management will get 30% from the advance payment of the customer made as charge for the incurred expenses.</li>\r\n	<li>You may cancel this agreement for any reasons.</li>\r\n	<li>Refunds will only be given through walk-in and meet-up.</li>\r\n</ul>\r\n',0,'2018-10-19 02:55:23','tratskitchen@gmail.com');

/*Table structure for table `sub_category` */

DROP TABLE IF EXISTS `sub_category`;

CREATE TABLE `sub_category` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `itm_image` varchar(255) NOT NULL,
  `sub_name` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_desc` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `sub_id` (`sub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `sub_category` */

insert  into `sub_category`(`sub_id`,`itm_image`,`sub_name`,`cat_id`,`sub_desc`,`date_created`) values (4,'','Pork',16,'','2018-10-19 00:05:19'),(5,'','Beef',16,'','2018-10-19 00:05:33'),(6,'','Chicken',16,'','2018-10-19 00:05:51'),(7,'','Fish',16,'','2018-10-19 00:06:07'),(8,'','Pasta',17,'','2018-10-19 00:08:08'),(9,'','Cold Drinks',18,'','2018-10-19 00:08:29'),(10,'','Hot Drinks',16,'','2018-10-19 00:08:51'),(11,'','Dessert',19,'','2018-10-19 01:27:24'),(12,'','Fried Rice',20,'','2018-10-19 02:24:03'),(13,'','Java Rice',20,'','2018-10-19 02:24:24'),(14,'','Regular Rice',20,'','2018-10-19 02:25:12');

/*Table structure for table `themes` */

DROP TABLE IF EXISTS `themes`;

CREATE TABLE `themes` (
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(255) NOT NULL,
  `theme_price` float(10,2) NOT NULL,
  `theme_img` text NOT NULL,
  `date_modified` datetime NOT NULL,
  `last_modified` varchar(255) NOT NULL,
  KEY `theme_id` (`theme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `themes` */

insert  into `themes`(`theme_id`,`theme_name`,`theme_price`,`theme_img`,`date_modified`,`last_modified`) values (2,'Classic',1500.00,'cater (9).jpg','2018-01-15 08:55:21','earviems@gmail.com'),(3,'Rustic',1500.00,'cater (4).jpg','0000-00-00 00:00:00','earviems@gmail.com'),(4,'batman',1500.00,'batman.jpg','0000-00-00 00:00:00','earviems@gmail.com'),(5,'Spider',1500.00,'spider2.jpg','0000-00-00 00:00:00','earviems@gmail.com');

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `tcode` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tx` text NOT NULL,
  `amt` float NOT NULL,
  `tdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `t_status` int(11) NOT NULL,
  KEY `t_id` (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

/*Data for the table `transactions` */

insert  into `transactions`(`t_id`,`tcode`,`user_id`,`tx`,`amt`,`tdate`,`t_status`) values (1,1748381208,0,'',28380,'2018-01-29 15:57:33',0),(2,1846976671,15,'93571410398025845',22710,'2018-02-05 10:37:14',0),(3,2095705141,0,'',227650,'2018-02-08 09:07:37',1),(4,97104560,0,'',7900,'2018-02-08 09:20:07',1),(5,1614634564,0,'',27800,'2018-02-08 09:31:44',1),(6,97104560,0,'',7900,'2018-02-08 13:51:26',1),(7,1419328777,0,'',62200,'2018-02-08 14:27:06',1),(8,1320339711,10,'5GC7174138173844N',33960,'2018-02-09 19:02:43',0),(9,1805652127,10,'4CM05834AM663623H',23700,'2018-02-10 16:22:07',0),(10,826213276,10,'2FV13684G29566838',17100,'2018-02-10 16:24:43',0),(11,1448698664,10,'47461496JG367873C',17100,'2018-02-10 16:26:46',0),(12,1814942311,10,'4MP78366LM838444A',28260,'2018-02-10 17:05:34',0),(13,2013853357,10,'3BE48784ES495914V',22080,'2018-02-10 17:13:52',0),(14,264575886,10,'95N71042XB369680U',24300,'2018-02-10 17:29:55',0),(15,720313935,10,'88303185C4760703G',30270,'2018-02-10 17:33:32',0),(16,219847778,10,'49D75447R5198894M',25350,'2018-02-10 17:44:31',0),(17,642689644,10,'9K570796MD1376216',17100,'2018-02-10 17:59:44',0),(18,813840142,10,'5B77683577508964R',17100,'2018-02-10 18:20:54',0),(19,1601627082,0,'',38250,'2018-02-10 23:00:19',1),(20,198403433,10,'5LD54521RH457001N',24540,'2018-02-22 14:19:34',0),(21,198403433,10,'85C08854JV5928500',16360,'2018-02-22 14:38:51',1),(22,1996098985,10,'6D405042FV670741N',23760,'2018-02-22 14:40:57',0),(23,1996098985,10,'9R8575258E972604B',15840,'2018-02-22 14:45:56',1),(24,813840142,10,'9PR36151D0592832X',11400,'2018-02-22 15:34:23',1),(25,1814942311,10,'04290895N43453507',18840,'2018-02-22 15:36:14',1),(26,1814942311,10,'04290895N43453507',18840,'2018-02-22 15:52:21',1),(27,936966211,10,'98F98566E4306800T',28500,'2018-02-22 15:55:35',1),(28,562537076,10,'6FP74045YK259025N',30100,'2018-02-22 17:34:59',1),(29,366720842,10,'50X74181YN961982U',25680,'2018-02-23 04:24:40',0),(30,366720842,10,'8YG37355PE852332B',17120,'2018-02-23 04:32:17',1),(31,1301419580,30,'92J57188PA773783F',43530,'2018-02-23 13:14:53',1),(32,1250364426,27,'45K52611WJ516245F',37524,'2018-02-23 13:19:05',0),(33,1250364426,27,'19720332D9882962S',25016,'2018-02-23 13:33:56',1),(34,1672064832,10,'34096062DU1243242',16800,'2018-02-25 14:00:02',0),(35,648889254,33,'2AY796926V753933S',124350,'2018-02-26 11:39:30',0),(36,455830236,10,'3J476414FG8441112',16800,'2018-03-01 18:49:30',0),(37,455830236,10,'7WV88071P94078312',11200,'2018-03-02 18:56:02',1),(38,616551553,10,'7DS93849BT119934W',16800,'2018-03-02 20:58:03',0),(39,616551553,10,'8FM01557DY985354H',11200,'2018-03-02 21:06:48',1),(40,599171679,10,'4NM9117940194453S',17700,'2018-03-02 21:19:24',0),(41,599171679,10,'7LW66128EX5985807',11800,'2018-03-02 21:24:24',1),(42,1675536198,10,'1M985776R1779013Y',18900,'2018-03-02 21:38:49',0),(43,1660350808,10,'75M57594TW9704721',52700,'2018-10-17 23:03:15',1),(44,1286060146,38,'72S21055RG490091L',30000,'2018-10-18 23:35:18',1),(45,146656,38,'14X75326VV320710U',16800,'2018-10-18 23:50:38',0),(46,1203813185,38,'3BA42471CF3186319',35000,'2018-10-19 00:49:59',1),(47,257121547,38,'5AY57005WK2059040',13650,'2018-10-19 00:52:37',0),(48,549863680,38,'180790828H633484W',12600,'2018-10-19 01:01:59',0),(49,854088409,36,'18110041EF8287300',26068.2,'2018-10-19 08:08:40',0),(50,40550502,36,'6NL846189M469105X',25858.8,'2018-10-19 08:22:18',0),(51,548697773,36,'54688293AW3486500',90684,'2018-10-19 08:25:22',1),(52,1376459885,36,'6DC649139B678030V',25440,'2018-10-19 08:30:42',0),(53,157556082,36,'11L72311328853924',69800,'2018-10-19 08:34:31',1),(54,1628307862,41,'8LE53111MN7207840',13500,'2018-10-19 11:03:18',0),(55,1628307862,41,'9E603318AM8596418',31500,'2018-10-19 11:10:50',1),(56,1550590565,41,'6CD01869N75403541',7500,'2018-10-19 12:33:56',0),(57,779370726,36,'2DJ40306DK715052P',7500,'2018-10-19 12:55:45',0),(58,1451791215,36,'5B101924NU1360448',12150,'2018-10-19 13:04:49',0),(59,1451791215,36,'52U88022YS625884F',28350,'2018-10-19 13:14:34',1),(60,7969988,41,'3YT75673DH2494542',7500,'2018-10-19 13:57:25',0),(61,234862270,41,'4HG89110GU485154A',7500,'2018-10-19 14:07:13',0),(62,834961733,41,'78400362JB673200N',13125,'2018-10-19 14:31:03',0),(63,1662849549,36,'6P6917550K3414102',7500,'2018-10-19 14:36:52',0),(64,1662849549,36,'5Y2139811E073073R',17500,'2018-10-19 14:37:46',1),(65,1310813105,41,'5AU75183BD6118113',8850,'2018-10-19 14:42:08',0),(66,346192632,36,'36328739WL6628049',16650,'2018-10-19 14:54:44',0),(67,1865050245,38,'9TU174278B5237542',10200,'2018-10-20 21:25:43',0),(68,1984482102,37,'6L955556RH5960800',20625,'2018-11-26 21:19:36',0),(69,779370726,36,'1P228070JE8228028',17500,'2019-01-09 15:07:32',1),(70,305695966,40,'41E61075SN954834M',7200,'2019-01-09 15:32:13',0),(71,305695966,40,'51676252EY374221A',16800,'2019-01-09 15:36:56',1),(72,1723806995,40,'7LT96592AA637410W',25000,'2019-01-09 15:40:33',1),(73,368118050,37,'7V65467834531210T',42500,'2019-01-09 20:55:38',1),(74,1585720094,40,'0PE89947Y8657071B',7500,'2019-01-09 21:33:42',0),(75,1007156428,40,'9EX85414A5736542Y',24000,'2019-01-10 22:31:49',1),(76,487220059,40,'98641768M23676128',24000,'2019-01-10 22:34:12',1),(77,20946216,40,'4B487124LN865713F',24500,'2019-01-10 22:48:09',1),(78,359576455,38,'05103477RS203801M',36000,'2019-01-11 01:10:02',1),(79,2077288219,38,'9Y4549344A8177042',16500,'2019-01-13 22:42:39',0),(80,1429754844,40,'3X553560WY3437829',21675,'2019-01-14 00:07:50',0),(81,359311241,37,'3UG4889143208582D',9300,'2019-01-14 12:21:56',0),(82,1687910355,36,'23Y81535C9216432U',29250,'2019-01-18 13:04:05',0),(83,1739562778,36,'8Y551018C3062384D',7800,'2019-01-21 11:41:38',0),(84,2036048437,36,'47D03300UJ353945G',7416,'2019-01-21 19:52:52',0),(85,1402901701,36,'8VP42563TC592751V',13725,'2019-01-21 20:04:45',0),(86,1402901701,36,'2DY403479N329853R',32025,'2019-01-21 20:15:18',1),(87,838132480,45,'6V281799D89566048',25000,'2019-01-22 17:55:06',1),(88,756386127,40,'79X009734E8535523',12750,'2019-01-22 20:27:45',0);

/*Table structure for table `user_account` */

DROP TABLE IF EXISTS `user_account`;

CREATE TABLE `user_account` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `full_name` text NOT NULL,
  `contact_num` text NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_role` int(11) NOT NULL COMMENT '0=admin,1=customer, 2=staff',
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

/*Data for the table `user_account` */

insert  into `user_account`(`user_id`,`user_email`,`user_pass`,`full_name`,`contact_num`,`age`,`gender`,`user_status`,`user_role`) values (2,'tratskitchen@gmail.com','21232f297a57a5a743894a0e4a801fc3','Jose Angelo Cerdon','09084233078',23,'Male',1,0),(36,'thereseboltron@gmail.com','21232f297a57a5a743894a0e4a801fc3','Therese Boltron','9456233',20,'Female',1,1),(37,'murckizta@gmail.com','e10adc3949ba59abbe56e057f20f883e','murck dela cruz','09358120977',24,'Male',1,1),(38,'bmarcmarquez022@gmail.com','8359b10e30dfabd587a5661e52249101','Benjie Marquez','09486655984',21,'Male',1,1),(40,'ianjerwin14@yahoo.com','bfae9a012f38235921cf8c51e55e38d3','Ian Mora','09351702807',69,'Male',1,1),(42,'murckrayner@gmail.com','e10adc3949ba59abbe56e057f20f883e','murck rayner dela cruz','09322369271',24,'Male',1,1),(45,'ianjerwin69@gmail.com','bfae9a012f38235921cf8c51e55e38d3','Ian Manay','09356969696',69,'Male',1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
