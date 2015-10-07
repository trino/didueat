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
  `ID` int(11) NOT NULL,
  `RestaurantID` int(11) NOT NULL,
  `Day` int(11) NOT NULL,
  `Month` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `daysoff` */

/*Table structure for table `eventlog` */

DROP TABLE IF EXISTS `eventlog`;

CREATE TABLE `eventlog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Date` varchar(64) NOT NULL,
  `RestaurantID` int(11) NOT NULL,
  `Text` varchar(1024) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `eventlog` */

insert  into `eventlog`(`ID`,`UserID`,`Date`,`RestaurantID`,`Text`) values (1,1,'2015-08-26 09:45:38',1,'Edited restaurant: Test Restaurant, 1, justdoit2045@gmail.com, 1, , 1, , CA, , 1, 1, 1'),(2,1,'2015-08-26 09:45:38',1,'Edited hours: Array\n(\n    [1] => 1645 to 0920\n    [2] =>  to \n    [3] =>  to \n    [4] =>  to \n    [5] => 0345 to 0445\n    [6] => 0245 to \n    [7] =>  to \n)\n'),(3,1,'2015-09-03 06:50:43',1,'Set status to: 1'),(4,1,'2015-09-03 06:51:06',1,'Set status to: 0'),(5,1,'2015-09-08 04:47:39',1,'Edited restaurant: Restaurant One, 1, skpsoftech@gmail.com, 1, , 1, , CA, , 1, 1, 1'),(6,1,'2015-09-08 04:47:39',1,'Edited hours: Array\n(\n    [1] => 1645 to 0920\n    [2] => 0000 to 2359\n    [3] => 0000 to 2359\n    [4] => 0000 to 2359\n    [5] => 0345 to 0445\n    [6] => 0245 to 2359\n    [7] => 0000 to 2359\n)\n'),(7,1,'2015-09-08 05:31:17',1,'Edited restaurant: Restaurant One, 1, skpsoftech@gmail.com, 1, , 1, , CA, , 1, 1, 1'),(8,1,'2015-09-08 05:31:18',1,'Edited hours: Array\n(\n    [1] => 1645 to 0920\n    [2] => 0000 to 2359\n    [3] => 0000 to 2359\n    [4] => 0000 to 2359\n    [5] => 0345 to 0445\n    [6] => 0245 to 2359\n    [7] => 0000 to 2359\n)\n'),(9,1,'2015-09-08 06:32:07',1,'Created user: 6 (Waqar)'),(10,1,'2015-09-08 06:33:01',1,'Created user: 7 (Waqar Javed)'),(11,0,'2015-09-08 08:05:33',0,'Edited restaurant: , 1, , , , HAMILTON, ON, CA, , , 0, 0'),(12,0,'2015-09-08 08:05:33',0,'Edited hours: Array\n(\n    [1] =>  to \n    [2] =>  to \n    [3] =>  to \n    [4] =>  to \n    [5] =>  to \n    [6] =>  to \n    [7] =>  to \n)\n'),(13,0,'2015-09-08 08:09:34',0,'Edited restaurant: Restaurant Six, 1, skpsoftech@example.com, 123456789, 1230 Main Street East, HAMILTON, ON, CA, L9A1V7, , 2, 2'),(14,0,'2015-09-08 08:09:34',0,'Edited hours: Array\n(\n    [1] => 1710 to 1710\n    [2] =>  to \n    [3] =>  to \n    [4] =>  to \n    [5] => 1710 to 1710\n    [6] =>  to \n    [7] =>  to \n)\n');

/*Table structure for table `genres` */

DROP TABLE IF EXISTS `genres`;

CREATE TABLE `genres` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `genres` */

insert  into `genres`(`ID`,`Name`) values (1,'Asian');

/*Table structure for table `hours` */

DROP TABLE IF EXISTS `hours`;

CREATE TABLE `hours` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RestaurantID` int(11) DEFAULT NULL,
  `DayOfWeek` varchar(50) DEFAULT NULL,
  `Open` time DEFAULT NULL,
  `Close` time DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

/*Data for the table `hours` */

insert  into `hours`(`ID`,`RestaurantID`,`DayOfWeek`,`Open`,`Close`) values (15,1,'1','00:16:45','00:09:20'),(16,1,'2','00:00:00','00:23:59'),(17,1,'3','00:00:00','00:23:59'),(18,1,'4','00:00:00','00:23:59'),(19,1,'5','00:03:45','00:04:45'),(20,1,'6','00:02:45','00:23:59'),(21,1,'7','00:00:00','00:23:59'),(22,6,'1','00:17:10','00:17:10'),(23,6,'5','00:17:10','00:17:10'),(24,7,'Sunday','04:20:00','12:00:00'),(25,7,'Monday','08:40:00','12:00:00'),(26,7,'Tuesday','09:45:00','08:40:00'),(27,7,'Wednesday','09:45:00','09:45:00'),(28,7,'Thursday','12:00:00','11:55:00'),(29,7,'Friday','11:55:00','11:55:00'),(30,7,'Saturday','12:00:00','12:00:00'),(31,8,'Sunday','00:00:00','00:00:00'),(32,8,'Monday','00:00:00','00:00:00'),(33,8,'Tuesday','00:00:00','00:00:00'),(34,8,'Wednesday','00:00:00','00:00:00'),(35,8,'Thursday','00:00:00','00:00:00'),(36,8,'Friday','00:00:00','00:00:00'),(37,8,'Saturday','00:00:00','00:00:00'),(38,9,'Sunday','00:00:00','00:00:00'),(39,9,'Monday','00:00:00','00:00:00'),(40,9,'Tuesday','00:00:00','00:00:00'),(41,9,'Wednesday','00:00:00','00:00:00'),(42,9,'Thursday','00:00:00','00:00:00'),(43,9,'Friday','00:00:00','00:00:00'),(44,9,'Saturday','00:00:00','00:00:00'),(45,10,'Sunday','00:00:00','00:00:00'),(46,10,'Monday','00:00:00','00:00:00'),(47,10,'Tuesday','00:00:00','00:00:00'),(48,10,'Wednesday','00:00:00','00:00:00'),(49,10,'Thursday','00:00:00','00:00:00'),(50,10,'Friday','00:00:00','00:00:00'),(51,10,'Saturday','00:00:00','00:00:00');

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `restaurantId` int(11) DEFAULT NULL,
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
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1;

/*Data for the table `menus` */

insert  into `menus`(`ID`,`restaurantId`,`menu_item`,`description`,`price`,`additional`,`has_addon`,`image`,`type`,`parent`,`req_opt`,`sing_mul`,`exact_upto`,`exact_upto_qty`,`display_order`) values (1,1,'Menu 1','Menu 1 Description Here...',50,NULL,1,'20151007135957.jpg',NULL,0,NULL,NULL,NULL,NULL,1),(32,2,'Menu 2','Menu 2 Description Here...',60,NULL,1,'80cf1bb1.jpg',NULL,0,NULL,NULL,NULL,NULL,5),(33,2,'Addon Menu 2 Title 1','Addon Menu 2 Description 1',0,NULL,0,NULL,NULL,32,1,0,1,'6',6),(34,2,'sub item 1',NULL,5,NULL,0,NULL,NULL,33,NULL,NULL,NULL,NULL,7),(35,2,'sub item 2',NULL,10,NULL,0,NULL,NULL,33,NULL,NULL,NULL,NULL,7),(36,2,'sub item 3',NULL,15,NULL,0,NULL,NULL,33,NULL,NULL,NULL,NULL,7),(37,2,'Addon Menu 2 Title 2','Addon Menu 2 Description 2',0,NULL,0,NULL,NULL,32,1,0,0,'7',6),(38,2,'sub item 4',NULL,20,NULL,0,NULL,NULL,37,NULL,NULL,NULL,NULL,7),(39,2,'sub item 5',NULL,25,NULL,0,NULL,NULL,37,NULL,NULL,NULL,NULL,7),(40,2,'sub item 3',NULL,30,NULL,0,NULL,NULL,37,NULL,NULL,NULL,NULL,7),(46,7,'test','sdf',234,NULL,1,'20151001160959.png',NULL,0,NULL,NULL,NULL,NULL,1),(51,7,'test','test',0,NULL,0,NULL,NULL,46,0,1,0,'',1),(52,7,'tets','345',0,NULL,0,NULL,NULL,46,1,0,0,'',1),(53,7,'test',NULL,345,NULL,0,NULL,NULL,51,NULL,NULL,NULL,NULL,1),(54,7,'yrdfgfdg',NULL,0,NULL,0,NULL,NULL,51,NULL,NULL,NULL,NULL,1),(55,7,'dfgdfg',NULL,456,NULL,0,NULL,NULL,51,NULL,NULL,NULL,NULL,1),(56,7,'345',NULL,345,NULL,0,NULL,NULL,52,NULL,NULL,NULL,NULL,1),(57,7,'345',NULL,435,NULL,0,NULL,NULL,52,NULL,NULL,NULL,NULL,1),(58,7,'pop','',1,NULL,1,'20151002004724.jpeg',NULL,0,NULL,NULL,NULL,NULL,1),(63,7,'type','',0,NULL,0,NULL,NULL,58,0,1,0,'',1),(64,7,'sprite',NULL,0,NULL,0,NULL,NULL,63,NULL,NULL,NULL,NULL,1),(65,7,'pepsi',NULL,0,NULL,0,NULL,NULL,63,NULL,NULL,NULL,NULL,1),(66,7,'coke',NULL,0,NULL,0,NULL,NULL,63,NULL,NULL,NULL,NULL,1),(67,7,'big mac comb','',8.99,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,1),(68,7,'big mac comb','',8.99,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,1),(69,7,'','',0,NULL,0,NULL,NULL,67,0,1,0,'',1),(70,7,'side','',0,NULL,0,NULL,NULL,67,0,1,0,'',1),(71,7,'side','',0,NULL,0,NULL,NULL,68,0,1,0,'',1),(72,7,'drink','',0,NULL,0,NULL,NULL,67,0,1,0,'',1),(73,7,'','',0,NULL,0,NULL,NULL,67,0,1,0,'',1),(74,7,'drink','',0,NULL,0,NULL,NULL,68,0,1,0,'',1),(75,7,'','',0,NULL,0,NULL,NULL,68,0,1,0,'',1),(76,7,'','',0,NULL,0,NULL,NULL,68,0,1,0,'',1),(77,7,'salad',NULL,0,NULL,0,NULL,NULL,70,NULL,NULL,NULL,NULL,1),(78,7,'fries',NULL,0,NULL,0,NULL,NULL,70,NULL,NULL,NULL,NULL,1),(79,7,'rice',NULL,0,NULL,0,NULL,NULL,70,NULL,NULL,NULL,NULL,1),(80,7,'',NULL,0,NULL,0,NULL,NULL,69,NULL,NULL,NULL,NULL,1),(81,7,'salad',NULL,0,NULL,0,NULL,NULL,71,NULL,NULL,NULL,NULL,1),(82,7,'fries',NULL,0,NULL,0,NULL,NULL,71,NULL,NULL,NULL,NULL,1),(83,7,'rice',NULL,0,NULL,0,NULL,NULL,71,NULL,NULL,NULL,NULL,1),(84,7,'pepsi',NULL,0,NULL,0,NULL,NULL,72,NULL,NULL,NULL,NULL,1),(85,7,'coke',NULL,0,NULL,0,NULL,NULL,72,NULL,NULL,NULL,NULL,1),(86,7,'sprite',NULL,0,NULL,0,NULL,NULL,72,NULL,NULL,NULL,NULL,1),(87,7,'sprite',NULL,0,NULL,0,NULL,NULL,74,NULL,NULL,NULL,NULL,1),(88,7,'coke',NULL,0,NULL,0,NULL,NULL,74,NULL,NULL,NULL,NULL,1),(89,7,'',NULL,0,NULL,0,NULL,NULL,75,NULL,NULL,NULL,NULL,1),(90,7,'',NULL,0,NULL,0,NULL,NULL,73,NULL,NULL,NULL,NULL,1),(91,7,'pepsi',NULL,0,NULL,0,NULL,NULL,74,NULL,NULL,NULL,NULL,1),(92,7,'',NULL,0,NULL,0,NULL,NULL,76,NULL,NULL,NULL,NULL,1),(93,NULL,'','',0,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,1),(94,NULL,'','',0,NULL,0,NULL,NULL,93,0,1,0,'',1),(95,NULL,'',NULL,0,NULL,0,NULL,NULL,94,NULL,NULL,NULL,NULL,1),(96,NULL,'',NULL,0,NULL,0,NULL,NULL,94,NULL,NULL,NULL,NULL,1),(97,NULL,'',NULL,0,NULL,0,NULL,NULL,94,NULL,NULL,NULL,NULL,1),(98,NULL,'',NULL,0,NULL,0,NULL,NULL,94,NULL,NULL,NULL,NULL,1),(99,NULL,'345','345',345,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,2),(100,NULL,'','',0,NULL,0,NULL,NULL,99,0,1,0,'',1),(101,NULL,'hjk',NULL,567,NULL,0,NULL,NULL,100,NULL,NULL,NULL,NULL,1),(102,NULL,'',NULL,567,NULL,0,NULL,NULL,100,NULL,NULL,NULL,NULL,1),(103,NULL,'',NULL,345,NULL,0,NULL,NULL,100,NULL,NULL,NULL,NULL,1),(111,1,'Addon Title','Addon Description',0,NULL,0,NULL,NULL,1,0,0,1,'5',1),(112,1,'34','5435',0,NULL,0,NULL,NULL,1,0,1,0,'',2),(113,1,'345345',NULL,345,NULL,0,NULL,NULL,112,NULL,NULL,NULL,NULL,4),(114,1,'Sub Item 2',NULL,20,NULL,0,NULL,NULL,111,NULL,NULL,NULL,NULL,3),(115,1,'Sub Item 3',NULL,30,NULL,0,NULL,NULL,111,NULL,NULL,NULL,NULL,1),(116,1,'Sub Item 1',NULL,10,NULL,0,NULL,NULL,111,NULL,NULL,NULL,NULL,2),(117,1,'345',NULL,345,NULL,0,NULL,NULL,112,NULL,NULL,NULL,NULL,5);

/*Table structure for table `newsletter` */

DROP TABLE IF EXISTS `newsletter`;

CREATE TABLE `newsletter` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `GUID` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `newsletter` */

insert  into `newsletter`(`ID`,`Email`,`GUID`) values (1,'skpsoftech@gmail.com','');

/*Table structure for table `notification_addresses` */

DROP TABLE IF EXISTS `notification_addresses`;

CREATE TABLE `notification_addresses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RestaurantID` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Type` enum('Email','Phone') DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `notification_addresses` */

insert  into `notification_addresses`(`ID`,`RestaurantID`,`Address`,`Type`) values (1,1,'32424234234','Phone'),(2,1,'skpsoftech@gmail.com','Email'),(3,1,'1234','Phone');

/*Table structure for table `postalcodes` */

DROP TABLE IF EXISTS `postalcodes`;

CREATE TABLE `postalcodes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PostalCode` varchar(8) NOT NULL,
  `Number` int(11) NOT NULL,
  `Street` varchar(1024) NOT NULL,
  `City` varchar(255) NOT NULL,
  `Province` varchar(4) NOT NULL,
  `Lattitude` double NOT NULL,
  `Longitude` double NOT NULL,
  `ShortStreet` varchar(1024) NOT NULL,
  `ShortStreetType` varchar(255) NOT NULL,
  `ShortStreetDir` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `postalcodes` */

/*Table structure for table `profiles` */

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `profileType` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `subscribed` tinyint(4) DEFAULT NULL,
  `restaurantID` int(11) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `profiles` */

insert  into `profiles`(`ID`,`profileType`,`name`,`email`,`password`,`salt`,`phone`,`subscribed`,`restaurantID`,`createdBy`,`status`,`created_at`,`updated_at`,`deleted_at`) values (1,1,'Waqar Javed','skpsoftech@gmail.com','18Qr/j9fx/qBc','$2a$10$47X1TbNbxW2gnUN4MGFglw==','123456789',0,10,NULL,1,'2015-09-16 12:54:59','2015-10-07 14:26:43',NULL),(2,2,'Waqar2','waqar2@example.com','$2a$10$47X1TbNbxW2gnUN4MGFglui5cegPbvHP/hzv30g6n63Obxcl449yq','$2a$10$47X1TbNbxW2gnUN4MGFglw==','123456789',0,1,NULL,1,'2015-09-16 12:54:59','2015-09-20 12:26:20',NULL),(3,4,'Waqar3','waqar3@example.com','$2a$10$47X1TbNbxW2gnUN4MGFglui5cegPbvHP/hzv30g6n63Obxcl449yq','$2a$10$47X1TbNbxW2gnUN4MGFglw==','123456789',0,1,NULL,1,'2015-09-16 12:54:59','2015-09-20 12:26:20',NULL),(9,1,'Mohsan Iqbal','mohsaniqbal387@gmail.com','$2a$10$P/QlIosZyJ7p3zDo8oOAmuUjgzh3STjrffSSxczDnQIpbcn37YWF2','$2a$10$P/QlIosZyJ7p3zDo8oOAmw==','03124046616',1,10,NULL,1,'2015-09-22 14:09:26','2015-09-22 14:09:50',NULL),(13,2,'asda','warriorqbik@gmail.com','$1$ge4.pB..$TmhSOQE8E0gNfgDTPjjab0','$2a$10$A/lwkD80fNTvbR90vjMwjw==','123123',0,0,0,1,NULL,NULL,NULL),(14,2,'asda','asd@asd.com','$1$Pg4.sG..$I4C15SgfidXMbbkHsB2Fo1','$2a$10$A/lwkD80fNTvbR90vjMwjw==','123123',0,0,0,1,NULL,NULL,NULL),(15,2,'asdasd','a@a.com','$2a$10$A/lwkD80fNTvbR90vjMwjuWMiNbzczpOJHxRCSMN8tW6fC2lC3DJC','$2a$10$A/lwkD80fNTvbR90vjMwjw==','123123',0,1,0,1,NULL,NULL,NULL),(16,1,'warrior','justdoit.2045@yahoo.com','a',NULL,'123',NULL,NULL,NULL,0,'2015-09-30 15:13:52','2015-09-30 15:13:52',NULL),(17,2,'asdasd','a1@a.com','$2a$10$A/lwkD80fNTvbR90vjMwjufCzhyIACxICHJeW/VsZ5ntHw0v11uCa','$2a$10$A/lwkD80fNTvbR90vjMwjw==','112312',0,0,0,1,NULL,NULL,NULL),(18,1,'test','justdoist.2045@yahoo.com','18PWu2V7tXYLA',NULL,'2222222222',1,NULL,NULL,0,'2015-10-06 05:15:30','2015-10-06 05:15:30',NULL),(19,1,'warrior','warriorbik@gmail.com','18PWu2V7tXYLA',NULL,'2222222222',1,19,NULL,1,'2015-10-06 05:28:15','2015-10-06 05:28:38',NULL),(23,1,'d','info@trinoweb.com','18uEDhWDJwpoQ',NULL,'d',1,1,NULL,1,'2015-10-07 13:56:01','2015-10-07 13:58:12',NULL),(24,4,'test','test123@example.com','18GgKcb2FFBHM',NULL,'123456',NULL,NULL,NULL,0,'2015-10-07 15:27:02','2015-10-07 15:27:02',NULL);

/*Table structure for table `profiles_addresses` */

DROP TABLE IF EXISTS `profiles_addresses`;

CREATE TABLE `profiles_addresses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `Number` varchar(50) DEFAULT NULL,
  `Street` varchar(200) DEFAULT NULL,
  `Apt` varchar(200) DEFAULT NULL,
  `Buzz` varchar(200) DEFAULT NULL,
  `PostCode` varchar(50) DEFAULT NULL,
  `PhoneNo` varchar(50) DEFAULT NULL,
  `City` varchar(200) DEFAULT NULL,
  `Province` varchar(200) DEFAULT NULL,
  `Country` int(11) DEFAULT NULL,
  `Notes` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `profiles_addresses` */

insert  into `profiles_addresses`(`ID`,`UserID`,`Number`,`Street`,`Apt`,`Buzz`,`PostCode`,`PhoneNo`,`City`,`Province`,`Country`,`Notes`) values (1,1,'132456','Street Address','Street Address','123465','123456','897987','Hamilton','Province',40,'notes here');

/*Table structure for table `profiles_images` */

DROP TABLE IF EXISTS `profiles_images`;

CREATE TABLE `profiles_images` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `RestaurantID` int(11) DEFAULT NULL,
  `Filename` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `OrderID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `profiles_images` */

insert  into `profiles_images`(`ID`,`UserID`,`RestaurantID`,`Filename`,`Title`,`OrderID`) values (1,1,1,'69318f40.jpg','Testing image 1',NULL),(2,1,2,'20680777.jpg','Testing image 2',NULL),(3,1,3,'484ed3b2.jpg','Testing image 3',NULL),(4,1,4,'ad6994b7.jpg','Testing image 4',NULL),(5,1,5,'4763f359.jpg','Testing image 5',NULL),(6,1,6,'fbae66f2.jpg','Testing image 6',NULL),(7,11,2,'957ecfd5.png','567',NULL),(8,10,6,'ff49444a.png','34253543543',NULL),(9,1,1,'3f23a153.jpg','Testing image 1',NULL);

/*Table structure for table `profiletypes` */

DROP TABLE IF EXISTS `profiletypes`;

CREATE TABLE `profiletypes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(128) NOT NULL,
  `Hierarchy` int(11) NOT NULL,
  `CanCreateProfiles` tinyint(4) NOT NULL,
  `CanEditGlobalSettings` tinyint(4) NOT NULL,
  `CanHireOrFire` tinyint(4) NOT NULL,
  `CanPossess` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `profiletypes` */

insert  into `profiletypes`(`ID`,`Name`,`Hierarchy`,`CanCreateProfiles`,`CanEditGlobalSettings`,`CanHireOrFire`,`CanPossess`) values (1,'Super',0,1,1,1,1),(2,'User',999,0,0,0,0),(3,'Owner',1,1,0,1,0),(4,'Employee',10,0,0,0,0);

/*Table structure for table `reservations` */

DROP TABLE IF EXISTS `reservations`;

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurantId` int(11) DEFAULT NULL,
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

insert  into `reservations`(`id`,`restaurantId`,`menu_ids`,`prs`,`qtys`,`extras`,`listid`,`subtotal`,`g_total`,`cash_type`,`ordered_by`,`email`,`contact`,`payment_mode`,`address1`,`address2`,`city`,`province`,`postal_code`,`remarks`,`order_time`,`order_till`,`order_now`,`delivery_fee`,`tax`,`order_type`,`status`) values (3,19,'72,123','12210.00,16.00','111,1',' ccc: bb:bbb-% ccc: bb:bbb-% ccc:<br/> c%<br/> d% bb:<br/> b, Type:<br/> Milk% Flavors:<br/> Strawberry%<br/> Vanilla% Toppings:<br/> Honey','_72_72_72_117_119_120,_123_137_139_141_142',12226,13818.88,1,'aaa','aaa@aaa.com','33333','','','','','Ontario','','aaa','2015-08-08 00:00:00','2015-08-08 00:00:00',0,3.5,1589.38,'0.00','pending'),(4,19,'146','0.00','9','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'0.00','pending'),(5,1,'146','0.00','9','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(6,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(7,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(8,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(9,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(10,1,'146','0.00','8','','_146',0,3.5,1,'','','','','','','','','','',NULL,NULL,0,3.5,0,'1','pending'),(11,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(12,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(13,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(14,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(15,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(16,1,'148','20.00','5','','_148',20,26.1,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'1','pending'),(17,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(18,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(19,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(20,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(21,1,'148','20.00','5','','_148',20,22.6,1,'','','','','','','','','','',NULL,NULL,0,3.5,2.6,'0.00','pending'),(22,1,'148','4.00','1','','_148',4,8.02,1,'','','','','','','','','','',NULL,NULL,0,3.5,0.52,'0.00','pending'),(23,1,'148','4.00','1','','_148',4,8.02,1,'','','','','','','','','','',NULL,NULL,0,3.5,0.52,'1','pending'),(24,1,'148','4.00','1','','_148',4,4.52,1,'','','','','','','','','','',NULL,NULL,0,3.5,0.52,'0.00','pending'),(26,1,'72','37.00','1',' ccc:<br/> a% bb:<br/> c','_72_118_121',37,41.81,1,'','','','','','','','','','','2015-08-26 09:30:16',NULL,0,1,4.81,'0.00','pending'),(27,1,'72','37.00','1',' ccc:<br/> a% bb:<br/> c','_72_118_121',37,42.81,1,'Waqar','','','','','','','','','','2015-08-26 09:40:48',NULL,0,1,4.81,'1','approved'),(28,1,'122,72','12.00,78.00','3,2',', ccc:<br/> c%<br/> d','_122,_72_117_119',90,102.7,1,'Annonimus','','','','','','','','','','2015-08-26 14:21:41',NULL,0,1,11.7,'1','cancelled'),(29,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(30,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(31,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(32,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(33,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(34,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(35,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(36,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(37,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(38,1,'1','100.00','7','','_1',350,395.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,45.5,'0','pending'),(39,1,'1','50.00','1','','_1',50,56.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,6.5,'0','pending'),(40,1,'1','50.00','1','','_1',50,56.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,6.5,'0','pending'),(41,1,'1','50.00','1','','_1',50,56.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,6.5,'0','pending'),(42,1,'1','50.00','1','','_1',50,56.5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,6.5,'0','pending'),(43,7,'46','2106.00','9','','_46',2106,2380.78,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,273.78,'1','pending'),(45,7,'46','2772.00','3',' test:<br/> test% tets:<br/> 345','_46_53_56',2772,3132.36,1,'90210','bhills_7903@mailinator.com','Iegqn',NULL,NULL,'7903 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Twuszt lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,360.36,'0','pending'),(46,7,'46','669.00','1','% tets:<br/> 345','_46_57',669,755.97,1,'90210','bhills_8662@mailinator.com','Naiee',NULL,NULL,'8662 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Wxlcnm lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,86.97,'0','pending'),(47,7,'58','1.00','1','','_58',1,1.13,1,'','8@234.com','8',NULL,NULL,'','','Ontario',NULL,'8',NULL,'0000-00-00 00:00:00',0,1,0.13,'0','pending'),(48,7,'58','1.00','1',' type:<br/> pepsi','_58_65',1,1.13,1,'90210','bhills_5985@mailinator.com','Tgvbw',NULL,NULL,'5985 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Mfdhrj lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,0.13,'0','pending'),(49,7,'58','4.00','4',' type:<br/> sprite','_58_64',4,4.52,1,'90210','bhills_9863@mailinator.com','Lfqwt',NULL,NULL,'9863 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Gbyome lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,0.52,'0','pending'),(50,7,'58','1.00','1',' type:<br/> sprite','_58_64',1,1.13,1,'90210','bhills_1349@mailinator.com','Qappk',NULL,NULL,'1349 Beverly Dr','Beverly Hills','Nova Scotia',NULL,'Dpfpni lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0000-00-00 00:00:00',0,1,0.13,'0','pending'),(51,7,'58','1.00','1',' type:<br/> pepsi','_58_65',1,2.13,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0.13,'1','pending'),(52,7,'58','1.00','1',' type:<br/> pepsi','_58_65',1,2.13,1,'1','info+1234@trinoweb.com','1',NULL,NULL,'1','1','Ontario',NULL,'1',NULL,'0000-00-00 00:00:00',0,1,0.13,'1','pending'),(53,7,'58,58','1.00,1.00','1,1',', type:<br/> pepsi','_58,_58_65',2,2.26,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,0.26,'0','pending'),(54,7,'58,58','1.00,1.00','1,1',', type:<br/> pepsi','_58,_58_65',2,2.26,1,'','info@trinoweb.com','3',NULL,NULL,'','','Ontario',NULL,'3',NULL,'0000-00-00 00:00:00',0,1,0.26,'0','pending');

/*Table structure for table `restaurants` */

DROP TABLE IF EXISTS `restaurants`;

CREATE TABLE `restaurants` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Slug` varchar(255) NOT NULL,
  `Genre` int(11) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(32) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(128) DEFAULT NULL,
  `Province` varchar(5) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL,
  `PostalCode` varchar(16) DEFAULT NULL,
  `Description` varchar(4096) DEFAULT NULL,
  `Logo` varchar(255) DEFAULT NULL,
  `DeliveryFee` decimal(2,0) DEFAULT NULL,
  `Minimum` decimal(2,0) DEFAULT NULL,
  `Open` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `restaurants` */

insert  into `restaurants`(`ID`,`Name`,`Slug`,`Genre`,`Email`,`Phone`,`Address`,`City`,`Province`,`Country`,`PostalCode`,`Description`,`Logo`,`DeliveryFee`,`Minimum`,`Open`) values (1,'Restaurant One','one-restaurant',1,'skpsoftech@gmail.com','123456789',NULL,'1','','CA',NULL,'1','','1','1',1),(2,'Restaurant Two','two-restaurant',1,'skpsoftech@yahoo.com','123456789',NULL,'1',NULL,'CA',NULL,'1',NULL,'1','1',1),(3,'Restaurant Three','three-restaurant',1,'skpsoftech@yahoo.com','123456789',NULL,'1',NULL,'CA',NULL,'1',NULL,'1','1',1),(4,'Restaurant Four','four-restaurant',1,'skpsoftech@yahoo.com','123456789',NULL,'1',NULL,'CA',NULL,'1',NULL,'1','1',1),(5,'Restaurant Five','five-restaurant',1,'skpsoftech@yahoo.com','123456789',NULL,'1',NULL,'CA',NULL,'1',NULL,'1','1',1),(6,'Restaurant Six','',1,'skpsoftech@example.com','123456789','1230 Main Street East','HAMILTON','ON','CA','L9A1V7','',NULL,'2','2',1),(7,'pho','pho',0,'info@trinoweb.com','2342342344','123 anywhere st','anytown','on','1','l8e3z2','234','16de2823.png','99','99',1),(8,'Beverly Hills','',1,'bhills_2144@mailinator.com','3105552144','2144 Beverly Dr','Beverly Hills','CA','183','90210','Kgcxhl lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0','0',1),(9,'Beverly Hills','',1,'bhills_3568@mailinator.com','3105553568','3568 Beverly Dr','Beverly Hills','CA','183','90210','Gwmajl lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0','0',1),(10,'Beverly Hills','beverly hills',1,NULL,'3105559944','9944 Beverly Dr','Beverly Hills','CA','183','90210','Rujmvg lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',NULL,'0','0',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
