/*
SQLyog Ultimate v8.55 
MySQL - 5.6.16 : Database - didueat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `alpha_2` varchar(2) DEFAULT NULL,
  `alpha_3` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=250 DEFAULT CHARSET=utf8;

/*Data for the table `countries` */

insert  into `countries`(`id`,`name`,`alpha_2`,`alpha_3`) values (1,'Afghanistan','af','afg'),(2,'Aland Islands','ax','ala'),(3,'Albania','al','alb'),(4,'Algeria','dz','dza'),(5,'American Samoa','as','asm'),(6,'Andorra','ad','and'),(7,'Angola','ao','ago'),(8,'Anguilla','ai','aia'),(9,'Antarctica','aq',''),(10,'Antigua and Barbuda','ag','atg'),(11,'Argentina','ar','arg'),(12,'Armenia','am','arm'),(13,'Aruba','aw','abw'),(14,'Australia','au','aus'),(15,'Austria','at','aut'),(16,'Azerbaijan','az','aze'),(17,'Bahamas','bs','bhs'),(18,'Bahrain','bh','bhr'),(19,'Bangladesh','bd','bgd'),(20,'Barbados','bb','brb'),(21,'Belarus','by','blr'),(22,'Belgium','be','bel'),(23,'Belize','bz','blz'),(24,'Benin','bj','ben'),(25,'Bermuda','bm','bmu'),(26,'Bhutan','bt','btn'),(27,'Bolivia, Plurinational State of','bo','bol'),(28,'Bonaire, Sint Eustatius and Saba','bq','bes'),(29,'Bosnia and Herzegovina','ba','bih'),(30,'Botswana','bw','bwa'),(31,'Bouvet Island','bv',''),(32,'Brazil','br','bra'),(33,'British Indian Ocean Territory','io',''),(34,'Brunei Darussalam','bn','brn'),(35,'Bulgaria','bg','bgr'),(36,'Burkina Faso','bf','bfa'),(37,'Burundi','bi','bdi'),(38,'Cambodia','kh','khm'),(39,'Cameroon','cm','cmr'),(40,'Canada','ca','can'),(41,'Cape Verde','cv','cpv'),(42,'Cayman Islands','ky','cym'),(43,'Central African Republic','cf','caf'),(44,'Chad','td','tcd'),(45,'Chile','cl','chl'),(46,'China','cn','chn'),(47,'Christmas Island','cx',''),(48,'Cocos (Keeling) Islands','cc',''),(49,'Colombia','co','col'),(50,'Comoros','km','com'),(51,'Congo','cg','cog'),(52,'Congo, The Democratic Republic of the','cd','cod'),(53,'Cook Islands','ck','cok'),(54,'Costa Rica','cr','cri'),(55,'Cote d\'Ivoire','ci','civ'),(56,'Croatia','hr','hrv'),(57,'Cuba','cu','cub'),(58,'Curacao','cw','cuw'),(59,'Cyprus','cy','cyp'),(60,'Czech Republic','cz','cze'),(61,'Denmark','dk','dnk'),(62,'Djibouti','dj','dji'),(63,'Dominica','dm','dma'),(64,'Dominican Republic','do','dom'),(65,'Ecuador','ec','ecu'),(66,'Egypt','eg','egy'),(67,'El Salvador','sv','slv'),(68,'Equatorial Guinea','gq','gnq'),(69,'Eritrea','er','eri'),(70,'Estonia','ee','est'),(71,'Ethiopia','et','eth'),(72,'Falkland Islands (Malvinas)','fk','flk'),(73,'Faroe Islands','fo','fro'),(74,'Fiji','fj','fji'),(75,'Finland','fi','fin'),(76,'France','fr','fra'),(77,'French Guiana','gf','guf'),(78,'French Polynesia','pf','pyf'),(79,'French Southern Territories','tf',''),(80,'Gabon','ga','gab'),(81,'Gambia','gm','gmb'),(82,'Georgia','ge','geo'),(83,'Germany','de','deu'),(84,'Ghana','gh','gha'),(85,'Gibraltar','gi','gib'),(86,'Greece','gr','grc'),(87,'Greenland','gl','grl'),(88,'Grenada','gd','grd'),(89,'Guadeloupe','gp','glp'),(90,'Guam','gu','gum'),(91,'Guatemala','gt','gtm'),(92,'Guernsey','gg','ggy'),(93,'Guinea','gn','gin'),(94,'Guinea-Bissau','gw','gnb'),(95,'Guyana','gy','guy'),(96,'Haiti','ht','hti'),(97,'Heard Island and McDonald Islands','hm',''),(98,'Holy See (Vatican City State)','va','vat'),(99,'Honduras','hn','hnd'),(100,'Hong Kong','hk','hkg'),(101,'Hungary','hu','hun'),(102,'Iceland','is','isl'),(103,'India','in','ind'),(104,'Indonesia','id','idn'),(105,'Iran, Islamic Republic of','ir','irn'),(106,'Iraq','iq','irq'),(107,'Ireland','ie','irl'),(108,'Isle of Man','im','imn'),(109,'Israel','il','isr'),(110,'Italy','it','ita'),(111,'Jamaica','jm','jam'),(112,'Japan','jp','jpn'),(113,'Jersey','je','jey'),(114,'Jordan','jo','jor'),(115,'Kazakhstan','kz','kaz'),(116,'Kenya','ke','ken'),(117,'Kiribati','ki','kir'),(118,'Korea, Democratic People\'s Republic of','kp','prk'),(119,'Korea, Republic of','kr','kor'),(120,'Kuwait','kw','kwt'),(121,'Kyrgyzstan','kg','kgz'),(122,'Lao People\'s Democratic Republic','la','lao'),(123,'Latvia','lv','lva'),(124,'Lebanon','lb','lbn'),(125,'Lesotho','ls','lso'),(126,'Liberia','lr','lbr'),(127,'Libyan Arab Jamahiriya','ly','lby'),(128,'Liechtenstein','li','lie'),(129,'Lithuania','lt','ltu'),(130,'Luxembourg','lu','lux'),(131,'Macao','mo','mac'),(132,'Macedonia, The former Yugoslav Republic of','mk','mkd'),(133,'Madagascar','mg','mdg'),(134,'Malawi','mw','mwi'),(135,'Malaysia','my','mys'),(136,'Maldives','mv','mdv'),(137,'Mali','ml','mli'),(138,'Malta','mt','mlt'),(139,'Marshall Islands','mh','mhl'),(140,'Martinique','mq','mtq'),(141,'Mauritania','mr','mrt'),(142,'Mauritius','mu','mus'),(143,'Mayotte','yt','myt'),(144,'Mexico','mx','mex'),(145,'Micronesia, Federated States of','fm','fsm'),(146,'Moldova, Republic of','md','mda'),(147,'Monaco','mc','mco'),(148,'Mongolia','mn','mng'),(149,'Montenegro','me','mne'),(150,'Montserrat','ms','msr'),(151,'Morocco','ma','mar'),(152,'Mozambique','mz','moz'),(153,'Myanmar','mm','mmr'),(154,'Namibia','na','nam'),(155,'Nauru','nr','nru'),(156,'Nepal','np','npl'),(157,'Netherlands','nl','nld'),(158,'New Caledonia','nc','ncl'),(159,'New Zealand','nz','nzl'),(160,'Nicaragua','ni','nic'),(161,'Niger','ne','ner'),(162,'Nigeria','ng','nga'),(163,'Niue','nu','niu'),(164,'Norfolk Island','nf','nfk'),(165,'Northern Mariana Islands','mp','mnp'),(166,'Norway','no','nor'),(167,'Oman','om','omn'),(168,'Pakistan','pk','pak'),(169,'Palau','pw','plw'),(170,'Palestinian Territory, Occupied','ps','pse'),(171,'Panama','pa','pan'),(172,'Papua New Guinea','pg','png'),(173,'Paraguay','py','pry'),(174,'Peru','pe','per'),(175,'Philippines','ph','phl'),(176,'Pitcairn','pn','pcn'),(177,'Poland','pl','pol'),(178,'Portugal','pt','prt'),(179,'Puerto Rico','pr','pri'),(180,'Qatar','qa','qat'),(181,'Reunion','re','reu'),(182,'Romania','ro','rou'),(183,'Russian Federation','ru','rus'),(184,'Rwanda','rw','rwa'),(185,'Saint Barthelemy','bl','blm'),(186,'Saint Helena, Ascension and Tristan Da Cunha','sh','shn'),(187,'Saint Kitts and Nevis','kn','kna'),(188,'Saint Lucia','lc','lca'),(189,'Saint Martin (French Part)','mf','maf'),(190,'Saint Pierre and Miquelon','pm','spm'),(191,'Saint Vincent and The Grenadines','vc','vct'),(192,'Samoa','ws','wsm'),(193,'San Marino','sm','smr'),(194,'Sao Tome and Principe','st','stp'),(195,'Saudi Arabia','sa','sau'),(196,'Senegal','sn','sen'),(197,'Serbia','rs','srb'),(198,'Seychelles','sc','syc'),(199,'Sierra Leone','sl','sle'),(200,'Singapore','sg','sgp'),(201,'Sint Maarten (Dutch Part)','sx','sxm'),(202,'Slovakia','sk','svk'),(203,'Slovenia','si','svn'),(204,'Solomon Islands','sb','slb'),(205,'Somalia','so','som'),(206,'South Africa','za','zaf'),(207,'South Georgia and The South Sandwich Islands','gs',''),(208,'South Sudan','ss','ssd'),(209,'Spain','es','esp'),(210,'Sri Lanka','lk','lka'),(211,'Sudan','sd','sdn'),(212,'Suriname','sr','sur'),(213,'Svalbard and Jan Mayen','sj','sjm'),(214,'Swaziland','sz','swz'),(215,'Sweden','se','swe'),(216,'Switzerland','ch','che'),(217,'Syrian Arab Republic','sy','syr'),(218,'Taiwan, Province of China','tw',''),(219,'Tajikistan','tj','tjk'),(220,'Tanzania, United Republic of','tz','tza'),(221,'Thailand','th','tha'),(222,'Timor-Leste','tl','tls'),(223,'Togo','tg','tgo'),(224,'Tokelau','tk','tkl'),(225,'Tonga','to','ton'),(226,'Trinidad and Tobago','tt','tto'),(227,'Tunisia','tn','tun'),(228,'Turkey','tr','tur'),(229,'Turkmenistan','tm','tkm'),(230,'Turks and Caicos Islands','tc','tca'),(231,'Tuvalu','tv','tuv'),(232,'Uganda','ug','uga'),(233,'Ukraine','ua','ukr'),(234,'United Arab Emirates','ae','are'),(235,'United Kingdom','gb','gbr'),(236,'United States','us','usa'),(237,'United States Minor Outlying Islands','um',''),(238,'Uruguay','uy','ury'),(239,'Uzbekistan','uz','uzb'),(240,'Vanuatu','vu','vut'),(241,'Venezuela, Bolivarian Republic of','ve','ven'),(242,'Viet Nam','vn','vnm'),(243,'Virgin Islands, British','vg','vgb'),(244,'Virgin Islands, U.S.','vi','vir'),(245,'Wallis and Futuna','wf','wlf'),(246,'Western Sahara','eh','esh'),(247,'Yemen','ye','yem'),(248,'Zambia','zm','zmb'),(249,'Zimbabwe','zw','zwe');

/*Table structure for table `daysoff` */

DROP TABLE IF EXISTS `daysoff`;

CREATE TABLE `daysoff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `daysoff` */

/*Table structure for table `eventlog` */

DROP TABLE IF EXISTS `eventlog`;

CREATE TABLE `eventlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` varchar(64) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `text` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `eventlog` */

insert  into `eventlog`(`id`,`user_id`,`date`,`restaurant_id`,`text`) values (1,1,'2015-08-26 09:45:38',1,'Edited restaurant: Test Restaurant, 1, justdoit2045@gmail.com, 1, , 1, , CA, , 1, 1, 1'),(2,1,'2015-08-26 09:45:38',1,'Edited hours: Array\n(\n    [1] => 1645 to 0920\n    [2] =>  to \n    [3] =>  to \n    [4] =>  to \n    [5] => 0345 to 0445\n    [6] => 0245 to \n    [7] =>  to \n)\n'),(3,1,'2015-09-03 06:50:43',1,'Set status to: 1'),(4,1,'2015-09-03 06:51:06',1,'Set status to: 0'),(5,1,'2015-09-08 04:47:39',1,'Edited restaurant: Restaurant One, 1, skpsoftech@gmail.com, 1, , 1, , CA, , 1, 1, 1'),(6,1,'2015-09-08 04:47:39',1,'Edited hours: Array\n(\n    [1] => 1645 to 0920\n    [2] => 0000 to 2359\n    [3] => 0000 to 2359\n    [4] => 0000 to 2359\n    [5] => 0345 to 0445\n    [6] => 0245 to 2359\n    [7] => 0000 to 2359\n)\n'),(7,1,'2015-09-08 05:31:17',1,'Edited restaurant: Restaurant One, 1, skpsoftech@gmail.com, 1, , 1, , CA, , 1, 1, 1'),(8,1,'2015-09-08 05:31:18',1,'Edited hours: Array\n(\n    [1] => 1645 to 0920\n    [2] => 0000 to 2359\n    [3] => 0000 to 2359\n    [4] => 0000 to 2359\n    [5] => 0345 to 0445\n    [6] => 0245 to 2359\n    [7] => 0000 to 2359\n)\n'),(9,1,'2015-09-08 06:32:07',1,'Created user: 6 (Waqar)'),(10,1,'2015-09-08 06:33:01',1,'Created user: 7 (Waqar Javed)'),(11,0,'2015-09-08 08:05:33',0,'Edited restaurant: , 1, , , , HAMILTON, ON, CA, , , 0, 0'),(12,0,'2015-09-08 08:05:33',0,'Edited hours: Array\n(\n    [1] =>  to \n    [2] =>  to \n    [3] =>  to \n    [4] =>  to \n    [5] =>  to \n    [6] =>  to \n    [7] =>  to \n)\n'),(13,0,'2015-09-08 08:09:34',0,'Edited restaurant: Restaurant Six, 1, skpsoftech@example.com, 123456789, 1230 Main Street East, HAMILTON, ON, CA, L9A1V7, , 2, 2'),(14,0,'2015-09-08 08:09:34',0,'Edited hours: Array\n(\n    [1] => 1710 to 1710\n    [2] =>  to \n    [3] =>  to \n    [4] =>  to \n    [5] => 1710 to 1710\n    [6] =>  to \n    [7] =>  to \n)\n');

/*Table structure for table `genres` */

DROP TABLE IF EXISTS `genres`;

CREATE TABLE `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `genres` */

insert  into `genres`(`id`,`name`) values (1,'Asian');

/*Table structure for table `hours` */

DROP TABLE IF EXISTS `hours`;

CREATE TABLE `hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `day_of_week` varchar(50) DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `hours` */

insert  into `hours`(`id`,`restaurant_id`,`day_of_week`,`open`,`close`) values (1,1,'Monday','02:30:00','03:30:00'),(2,1,'Saturday','12:10:00','01:10:00');

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `menu_item` varchar(255) DEFAULT NULL,
  `description` text,
  `price` double DEFAULT '0',
  `additional` int(11) DEFAULT NULL,
  `has_addon` int(11) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1:veg 2:spicy',
  `parent` int(11) DEFAULT NULL,
  `req_opt` int(11) DEFAULT NULL COMMENT '1=>r,0=>o',
  `sing_mul` int(11) DEFAULT NULL COMMENT '1=>s,0=>m',
  `exact_upto` int(11) DEFAULT NULL COMMENT '1=>e,0=>u',
  `exact_upto_qty` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

/*Data for the table `menus` */

insert  into `menus`(`id`,`restaurant_id`,`menu_item`,`description`,`price`,`additional`,`has_addon`,`image`,`type`,`parent`,`req_opt`,`sing_mul`,`exact_upto`,`exact_upto_qty`,`display_order`) values (1,1,'Menu 1','Menu 1 Description Here...',50,NULL,1,'20151007135957.jpg',NULL,0,NULL,NULL,NULL,NULL,1),(32,2,'Menu 2','Menu 2 Description Here...',60,NULL,1,'80cf1bb1.jpg',NULL,0,NULL,NULL,NULL,NULL,5),(33,2,'Addon Menu 2 Title 1','Addon Menu 2 Description 1',0,NULL,0,NULL,NULL,32,1,0,1,'6',6),(34,2,'sub item 1',NULL,5,NULL,0,NULL,NULL,33,NULL,NULL,NULL,NULL,7),(35,2,'sub item 2',NULL,10,NULL,0,NULL,NULL,33,NULL,NULL,NULL,NULL,7),(36,2,'sub item 3',NULL,15,NULL,0,NULL,NULL,33,NULL,NULL,NULL,NULL,7),(37,2,'Addon Menu 2 Title 2','Addon Menu 2 Description 2',0,NULL,0,NULL,NULL,32,1,0,0,'7',6),(38,2,'sub item 4',NULL,20,NULL,0,NULL,NULL,37,NULL,NULL,NULL,NULL,7),(39,2,'sub item 5',NULL,25,NULL,0,NULL,NULL,37,NULL,NULL,NULL,NULL,7),(40,2,'sub item 3',NULL,30,NULL,0,NULL,NULL,37,NULL,NULL,NULL,NULL,7),(46,7,'test','sdf',234,NULL,1,'20151001160959.png',NULL,0,NULL,NULL,NULL,NULL,1),(51,7,'test','test',0,NULL,0,NULL,NULL,46,0,1,0,'',1),(52,7,'tets','345',0,NULL,0,NULL,NULL,46,1,0,0,'',1),(53,7,'test',NULL,345,NULL,0,NULL,NULL,51,NULL,NULL,NULL,NULL,1),(54,7,'yrdfgfdg',NULL,0,NULL,0,NULL,NULL,51,NULL,NULL,NULL,NULL,1),(55,7,'dfgdfg',NULL,456,NULL,0,NULL,NULL,51,NULL,NULL,NULL,NULL,1),(56,7,'345',NULL,345,NULL,0,NULL,NULL,52,NULL,NULL,NULL,NULL,1),(57,7,'345',NULL,435,NULL,0,NULL,NULL,52,NULL,NULL,NULL,NULL,1),(58,7,'pop','',1,NULL,1,'20151002004724.jpeg',NULL,0,NULL,NULL,NULL,NULL,1),(63,7,'type','',0,NULL,0,NULL,NULL,58,0,1,0,'',1),(64,7,'sprite',NULL,0,NULL,0,NULL,NULL,63,NULL,NULL,NULL,NULL,1),(65,7,'pepsi',NULL,0,NULL,0,NULL,NULL,63,NULL,NULL,NULL,NULL,1),(66,7,'coke',NULL,0,NULL,0,NULL,NULL,63,NULL,NULL,NULL,NULL,1),(67,7,'big mac comb','',8.99,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,1),(68,7,'big mac comb','',8.99,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,1),(69,7,'','',0,NULL,0,NULL,NULL,67,0,1,0,'',1),(70,7,'side','',0,NULL,0,NULL,NULL,67,0,1,0,'',1),(71,7,'side','',0,NULL,0,NULL,NULL,68,0,1,0,'',1),(72,7,'drink','',0,NULL,0,NULL,NULL,67,0,1,0,'',1),(73,7,'','',0,NULL,0,NULL,NULL,67,0,1,0,'',1),(74,7,'drink','',0,NULL,0,NULL,NULL,68,0,1,0,'',1),(75,7,'','',0,NULL,0,NULL,NULL,68,0,1,0,'',1),(76,7,'','',0,NULL,0,NULL,NULL,68,0,1,0,'',1),(77,7,'salad',NULL,0,NULL,0,NULL,NULL,70,NULL,NULL,NULL,NULL,1),(78,7,'fries',NULL,0,NULL,0,NULL,NULL,70,NULL,NULL,NULL,NULL,1),(79,7,'rice',NULL,0,NULL,0,NULL,NULL,70,NULL,NULL,NULL,NULL,1),(80,7,'',NULL,0,NULL,0,NULL,NULL,69,NULL,NULL,NULL,NULL,1),(81,7,'salad',NULL,0,NULL,0,NULL,NULL,71,NULL,NULL,NULL,NULL,1),(82,7,'fries',NULL,0,NULL,0,NULL,NULL,71,NULL,NULL,NULL,NULL,1),(83,7,'rice',NULL,0,NULL,0,NULL,NULL,71,NULL,NULL,NULL,NULL,1),(84,7,'pepsi',NULL,0,NULL,0,NULL,NULL,72,NULL,NULL,NULL,NULL,1),(85,7,'coke',NULL,0,NULL,0,NULL,NULL,72,NULL,NULL,NULL,NULL,1),(86,7,'sprite',NULL,0,NULL,0,NULL,NULL,72,NULL,NULL,NULL,NULL,1),(87,7,'sprite',NULL,0,NULL,0,NULL,NULL,74,NULL,NULL,NULL,NULL,1),(88,7,'coke',NULL,0,NULL,0,NULL,NULL,74,NULL,NULL,NULL,NULL,1),(89,7,'',NULL,0,NULL,0,NULL,NULL,75,NULL,NULL,NULL,NULL,1),(90,7,'',NULL,0,NULL,0,NULL,NULL,73,NULL,NULL,NULL,NULL,1),(91,7,'pepsi',NULL,0,NULL,0,NULL,NULL,74,NULL,NULL,NULL,NULL,1),(92,7,'',NULL,0,NULL,0,NULL,NULL,76,NULL,NULL,NULL,NULL,1),(93,NULL,'','',0,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,1),(94,NULL,'','',0,NULL,0,NULL,NULL,93,0,1,0,'',1),(95,NULL,'',NULL,0,NULL,0,NULL,NULL,94,NULL,NULL,NULL,NULL,1),(96,NULL,'',NULL,0,NULL,0,NULL,NULL,94,NULL,NULL,NULL,NULL,1),(97,NULL,'',NULL,0,NULL,0,NULL,NULL,94,NULL,NULL,NULL,NULL,1),(98,NULL,'',NULL,0,NULL,0,NULL,NULL,94,NULL,NULL,NULL,NULL,1),(99,NULL,'345','345',345,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,2),(100,NULL,'','',0,NULL,0,NULL,NULL,99,0,1,0,'',1),(101,NULL,'hjk',NULL,567,NULL,0,NULL,NULL,100,NULL,NULL,NULL,NULL,1),(102,NULL,'',NULL,567,NULL,0,NULL,NULL,100,NULL,NULL,NULL,NULL,1),(103,NULL,'',NULL,345,NULL,0,NULL,NULL,100,NULL,NULL,NULL,NULL,1),(111,1,'Addon Title','Addon Description',0,NULL,0,NULL,NULL,1,0,0,1,'5',1),(112,1,'34','5435',0,NULL,0,NULL,NULL,1,0,1,0,'',2),(113,1,'345345',NULL,345,NULL,0,NULL,NULL,112,NULL,NULL,NULL,NULL,4),(114,1,'Sub Item 2',NULL,20,NULL,0,NULL,NULL,111,NULL,NULL,NULL,NULL,3),(115,1,'Sub Item 3',NULL,30,NULL,0,NULL,NULL,111,NULL,NULL,NULL,NULL,1),(116,1,'Sub Item 1',NULL,10,NULL,0,NULL,NULL,111,NULL,NULL,NULL,NULL,2),(117,1,'345',NULL,345,NULL,0,NULL,NULL,112,NULL,NULL,NULL,NULL,5),(118,1,'Test2','testafnajdfan',10,NULL,0,'20151010114624.jpg',NULL,0,NULL,NULL,NULL,NULL,0),(119,1,'Test2','testafnajdfan',10,NULL,0,'20151010114624.jpg',NULL,0,NULL,NULL,NULL,NULL,0),(120,1,'Test2','testafnajdfan',10,NULL,0,'20151010114624.jpg',NULL,0,NULL,NULL,NULL,NULL,0),(121,1,'Test2','testafnajdfan',10,NULL,0,'20151010114624.jpg',NULL,0,NULL,NULL,NULL,NULL,0),(122,1,'Test2','testafnajdfan',10,NULL,0,'20151010114624.jpg',NULL,0,NULL,NULL,NULL,NULL,0),(123,1,'Test2','testafnajdfan',10,NULL,0,'20151010114624.jpg',NULL,0,NULL,NULL,NULL,NULL,0),(124,1,'Test2','testafnajdfan',10,NULL,0,'20151010114624.jpg',NULL,0,NULL,NULL,NULL,NULL,0),(125,1,'Test2','testafnajdfan',10,NULL,0,'20151010114624.jpg',NULL,0,NULL,NULL,NULL,NULL,0);

/*Table structure for table `newsletter` */

DROP TABLE IF EXISTS `newsletter`;

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `guid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `newsletter` */

insert  into `newsletter`(`id`,`email`,`guid`) values (1,'skpsoftech@gmail.com','');

/*Table structure for table `notification_addresses` */

DROP TABLE IF EXISTS `notification_addresses`;

CREATE TABLE `notification_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `type` enum('Email','Phone') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `notification_addresses` */

insert  into `notification_addresses`(`id`,`restaurant_id`,`address`,`type`) values (1,1,'32424234234','Phone'),(2,1,'skpsoftech@gmail.com','Email'),(5,1,'12346546579','Phone');

/*Table structure for table `postalcodes` */

DROP TABLE IF EXISTS `postalcodes`;

CREATE TABLE `postalcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postal_code` varchar(8) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `street` varchar(1024) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(4) DEFAULT NULL,
  `lattitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `short_street` varchar(1024) DEFAULT NULL,
  `short_street_type` varchar(255) DEFAULT NULL,
  `short_street_dir` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `postalcodes` */

/*Table structure for table `profiles` */

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_type` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `subscribed` tinyint(4) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `profiles` */

insert  into `profiles`(`id`,`profile_type`,`name`,`email`,`password`,`phone`,`subscribed`,`restaurant_id`,`created_by`,`status`,`created_at`,`updated_at`,`deleted_at`) values (1,1,'Waqar Javed','skpsoftech@gmail.com','$2y$10$c7RHum8L2bsSleb2UTv6sejCRdYenCoz/AN7tMH5p4j1hgiIDhQxK','12345678',0,1,0,1,'2015-10-08 22:31:39','2015-10-10 11:22:32',NULL),(3,2,'Testing Name','testing@gmail.com','$2y$10$SrIKzcEgiqv2XntSwpdt0eRcUm2xoIwy5zGDwZsDxE6Of0LVamfKq','123456',0,1,1,0,'2015-10-09 12:29:01','2015-10-09 12:29:01',NULL),(4,2,'Testing Name2','test@example.com','$2y$10$crclmMUv37jYXXtQ00wnNuzfGu.SpYFE6mavC0qq/FMBQeQeG55Me','123456',0,1,1,0,'2015-10-10 11:23:31','2015-10-10 11:23:31',NULL);

/*Table structure for table `profiles_addresses` */

DROP TABLE IF EXISTS `profiles_addresses`;

CREATE TABLE `profiles_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `street` varchar(200) DEFAULT NULL,
  `apt` varchar(200) DEFAULT NULL,
  `buzz` varchar(200) DEFAULT NULL,
  `post_code` varchar(50) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `province` varchar(200) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `notes` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `profiles_addresses` */

insert  into `profiles_addresses`(`id`,`user_id`,`number`,`street`,`apt`,`buzz`,`post_code`,`phone_no`,`city`,`province`,`country`,`notes`) values (1,1,'1234566','Street Address1','Street Address1','123456','123456','123654','Hamilton','Province',40,'Notes here...'),(2,1,'1234567','Street Address2','Street Address2','123456','123456','123654','Hamilton','Province',40,'Notes here...'),(3,1,'1234568','Street Address3','Street Address3','123456','123456','123654','Hamilton','Province',168,'Notes here...');

/*Table structure for table `profiles_images` */

DROP TABLE IF EXISTS `profiles_images`;

CREATE TABLE `profiles_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `profiles_images` */

insert  into `profiles_images`(`id`,`user_id`,`restaurant_id`,`filename`,`title`,`order_id`) values (1,1,1,'69318f40.jpg','Testing image 1',NULL),(2,1,2,'20680777.jpg','Testing image 2',NULL),(3,1,3,'484ed3b2.jpg','Testing image 3',NULL),(4,1,4,'ad6994b7.jpg','Testing image 4',NULL),(5,1,5,'4763f359.jpg','Testing image 5',NULL),(6,1,6,'fbae66f2.jpg','Testing image 6',NULL),(7,11,2,'957ecfd5.png','567',NULL),(8,10,6,'ff49444a.png','34253543543',NULL),(9,1,1,'3f23a153.jpg','Testing image 1',NULL),(10,1,2,'34a6a025.jpg','Testing image',NULL),(11,1,1,'09c74d90.jpg','tests3',NULL),(12,1,1,'d34d9670.png','tests213',NULL);

/*Table structure for table `profiletypes` */

DROP TABLE IF EXISTS `profiletypes`;

CREATE TABLE `profiletypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `hierarchy` int(11) DEFAULT NULL,
  `can_create_profiles` tinyint(4) DEFAULT NULL,
  `can_edit_global_settings` tinyint(4) DEFAULT NULL,
  `can_hire_or_fire` tinyint(4) DEFAULT NULL,
  `can_possess` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `profiletypes` */

insert  into `profiletypes`(`id`,`name`,`hierarchy`,`can_create_profiles`,`can_edit_global_settings`,`can_hire_or_fire`,`can_possess`) values (1,'Super',0,1,1,1,1),(2,'User',999,0,0,0,0),(3,'Owner',1,1,0,1,0),(4,'Employee',10,0,0,0,0);

/*Table structure for table `reservations` */

DROP TABLE IF EXISTS `reservations`;

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `menu_ids` text,
  `prs` text,
  `qtys` text,
  `extras` text,
  `listid` text,
  `subtotal` double DEFAULT NULL,
  `g_total` double DEFAULT NULL,
  `cash_type` int(11) DEFAULT '1',
  `ordered_by` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `remarks` text,
  `order_time` datetime DEFAULT NULL,
  `order_till` datetime DEFAULT NULL,
  `order_now` int(11) DEFAULT '0',
  `delivery_fee` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL,
  `status` enum('approved','cancelled','pending') DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

/*Data for the table `reservations` */

insert  into `reservations`(`id`,`restaurant_id`,`menu_ids`,`prs`,`qtys`,`extras`,`listid`,`subtotal`,`g_total`,`cash_type`,`ordered_by`,`email`,`contact`,`payment_mode`,`address1`,`address2`,`city`,`province`,`postal_code`,`remarks`,`order_time`,`order_till`,`order_now`,`delivery_fee`,`tax`,`order_type`,`status`) values (3,19,'72,123','12210.00,16.00','111,1',' ccc: bb:bbb-% ccc: bb:bbb-% ccc:<br/> c%<br/> d% bb:<br/> b, Type:<br/> Milk% Flavors:<br/> Strawberry%<br/> Vanilla% Toppings:<br/> Honey','_72_72_72_117_119_120,_123_137_139_141_142',12226,13818.88,1,'aaa','aaa@aaa.com','33333','','','','','Ontario','','aaa','2015-08-08 00:00:00','2015-08-08 00:00:00',0,3.5,1589.38,'0.00','pending'),(4,19,'146','0.00','9','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'0.00','pending'),(6,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(7,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(8,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(9,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(10,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(11,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(12,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(13,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(14,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(15,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(16,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(17,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(18,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(19,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(20,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(21,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(22,1,'148','4.00','1','','_148',4,8.02,1,'','','','','','','','','','',NULL,NULL,0,3.5,0.52,'0.00','pending'),(23,1,'148','4.00','1','','_148',4,8.02,1,'','','','','','','','','','',NULL,NULL,0,3.5,0.52,'1','pending'),(24,1,'148','4.00','1','','_148',4,4.52,1,'','','','','','','','','','',NULL,NULL,0,3.5,0.52,'0.00','pending'),(26,1,'72','37.00','1',' ccc:<br/> a% bb:<br/> c','_72_118_121',37,41.81,1,'','','','','','','','','','','2015-08-26 09:30:16',NULL,0,1,4.81,'0.00','pending'),(27,1,'72','37.00','1',' ccc:<br/> a% bb:<br/> c','_72_118_121',37,42.81,1,'Waqar','','','','','','','','','','2015-08-26 09:40:48',NULL,0,1,4.81,'1','approved'),(28,1,'122,72','12.00,78.00','3,2',', ccc:<br/> c%<br/> d','_122,_72_117_119',90,102.7,1,'Annonimus','','','','','','','','','','2015-08-26 14:21:41',NULL,0,1,11.7,'1','cancelled'),(29,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(30,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(31,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(32,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(33,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(34,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(35,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(36,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(37,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(38,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(39,1,'1','50.00','1','','_1',50,56.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,6.5,'0','pending'),(40,1,'1','50.00','1','','_1',50,56.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,6.5,'0','pending'),(41,1,'1','50.00','1','','_1',50,56.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,6.5,'0','pending'),(42,1,'1','50.00','1','','_1',50,56.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,6.5,'0','pending'),(43,7,'46','2106.00','9','','_46',2106,2380.78,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,273.78,'1','pending'),(45,7,'46','2772.00','3',' test:<br/> test% tets:<br/> 345','_46_53_56',2772,3132.36,1,'90210','bhills_7903@mailinator.com','Iegqn',NULL,NULL,'7903 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Twuszt lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,360.36,'0','pending'),(46,7,'46','669.00','1','% tets:<br/> 345','_46_57',669,755.97,1,'90210','bhills_8662@mailinator.com','Naiee',NULL,NULL,'8662 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Wxlcnm lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,86.97,'0','pending'),(47,7,'58','1.00','1','','_58',1,1.13,1,'','8@234.com','8',NULL,NULL,'','','Ontario',NULL,'8',NULL,'0000-00-00 00:00:00',0,1,0.13,'0','pending'),(48,7,'58','1.00','1',' type:<br/> pepsi','_58_65',1,1.13,1,'90210','bhills_5985@mailinator.com','Tgvbw',NULL,NULL,'5985 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Mfdhrj lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,0.13,'0','pending'),(49,7,'58','4.00','4',' type:<br/> sprite','_58_64',4,4.52,1,'90210','bhills_9863@mailinator.com','Lfqwt',NULL,NULL,'9863 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Gbyome lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,0.52,'0','pending'),(50,7,'58','1.00','1',' type:<br/> sprite','_58_64',1,1.13,1,'90210','bhills_1349@mailinator.com','Qappk',NULL,NULL,'1349 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Dpfpni lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,0.13,'0','pending'),(51,7,'58','1.00','1',' type:<br/> pepsi','_58_65',1,2.13,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0.13,'1','pending'),(52,7,'58','1.00','1',' type:<br/> pepsi','_58_65',1,2.13,1,'1','info+1234@trinoweb.com','1',NULL,NULL,'1','1','Ontario',NULL,'1',NULL,'0000-00-00 00:00:00',0,1,0.13,'1','pending'),(53,7,'58,58','1.00,1.00','1,1',', type:<br/> pepsi','_58,_58_65',2,2.26,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0.26,'0','pending'),(54,7,'58,58','1.00,1.00','1,1',', type:<br/> pepsi','_58,_58_65',2,2.26,1,'','info@trinoweb.com','3',NULL,NULL,'','','Ontario',NULL,'3',NULL,'0000-00-00 00:00:00',0,1,0.26,'0','pending');

/*Table structure for table `restaurants` */

DROP TABLE IF EXISTS `restaurants`;

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `genre` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `province` varchar(5) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(16) DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `delivery_fee` decimal(2,0) DEFAULT NULL,
  `minimum` decimal(2,0) DEFAULT NULL,
  `open` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `restaurants` */

insert  into `restaurants`(`id`,`name`,`slug`,`genre`,`email`,`phone`,`address`,`city`,`province`,`country`,`postal_code`,`description`,`logo`,`delivery_fee`,`minimum`,`open`) values (1,'Restaurant Seven','restaurant-seven',1,'skpsoftech@gmail.com','123456789','Gulberg 3','Lahore','Punja','17','54606','ajdsklfajsdklfasdfasdfasdfasd',NULL,'99','99',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
