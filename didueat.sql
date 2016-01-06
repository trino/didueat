/*

SQLyog Ultimate v8.55 
MySQL - 5.6.26 : Database - didueat

*********************************************************************

*/



/*!40101 SET NAMES utf8 */;



/*!40101 SET SQL_MODE=''*/;



/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`didueat` /*!40100 DEFAULT CHARACTER SET latin1 */;



USE `didueat`;



/*Table structure for table `category` */



DROP TABLE IF EXISTS `category`;



CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT '1',
  `res_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



/*Data for the table `category` */



insert  into `category`(`id`,`title`,`display_order`,`res_id`) values (1,'pop',1,1),(2,'drinks',1,1),(3,'main',1,1);



/*Table structure for table `cities` */



DROP TABLE IF EXISTS `cities`;



CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(200) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1711 DEFAULT CHARSET=latin1;



/*Data for the table `cities` */



insert  into `cities`(`id`,`city`,`state_id`,`country_id`) values (1,'Acme',1,40),(2,'Airdrie',1,40),(3,'Alix',1,40),(4,'Amber Valley',1,40),(5,'Ardrossan',1,40),(6,'Athabasca',1,40),(7,'Balzac',1,40),(8,'Banff',1,40),(9,'Barrhead',1,40),(10,'Bashaw',1,40),(11,'Beaumont',1,40),(12,'Beiseker',1,40),(13,'Bellevue',1,40),(14,'Benalto',1,40),(15,'Bilby',1,40),(16,'Black Diamond',1,40),(17,'Blackfalds',1,40),(18,'Blackie',1,40),(19,'Blairmore',1,40),(20,'Bluesky',1,40),(21,'Bluffton',1,40),(22,'Bon Accord',1,40),(23,'Bonnyville',1,40),(24,'Bow Island',1,40),(25,'Bowness',1,40),(26,'Boyle',1,40),(27,'Breton',1,40),(28,'Brooks',1,40),(29,'Busby',1,40),(30,'Calgary',1,40),(31,'Calmar',1,40),(32,'Camrose',1,40),(33,'Canmore',1,40),(34,'Cardston',1,40),(35,'Caroline',1,40),(36,'Carseland',1,40),(37,'Carstairs',1,40),(38,'Champion',1,40),(39,'Cherhill',1,40),(40,'Chip Lake',1,40),(41,'Chipman',1,40),(42,'Clairmont',1,40),(43,'Claresholm',1,40),(44,'Clive',1,40),(45,'Coaldale',1,40),(46,'Cold Lake',1,40),(47,'Coleman',1,40),(48,'Coronation',1,40),(49,'Crossfield',1,40),(50,'Daysland',1,40),(51,'Delburne',1,40),(52,'Devon',1,40),(53,'Didsbury',1,40),(54,'Dowling',1,40),(55,'Drayton Valley',1,40),(56,'Drumheller',1,40),(57,'Duchess',1,40),(58,'Duffield',1,40),(59,'Eaglesham',1,40),(60,'Edmonton',1,40),(61,'Edson',1,40),(62,'Elk Point',1,40),(63,'Endiang',1,40),(64,'Entwistle',1,40),(65,'Fairview',1,40),(66,'Faust',1,40),(67,'Flatbush',1,40),(68,'Foremost',1,40),(69,'Forestburg',1,40),(70,'Fort Macleod',1,40),(71,'Fort McMurray',1,40),(72,'Fort Saskatchewan',1,40),(73,'Fort Vermilion',1,40),(75,'Girouxville',1,40),(76,'Gleichen',1,40),(77,'Glendon',1,40),(78,'Glenwood',1,40),(79,'Goodfish Lake',1,40),(80,'Grand Centre',1,40),(81,'Grande Prairie',1,40),(82,'Grimshaw',1,40),(83,'Halkirk',1,40),(84,'Hanna',1,40),(85,'Hardisty',1,40),(86,'Heisler',1,40),(87,'Helina',1,40),(88,'High Level',1,40),(89,'High Prairie',1,40),(90,'High River',1,40),(91,'Hinton',1,40),(92,'Hobbema',1,40),(93,'Horburg',1,40),(94,'Innisfail',1,40),(95,'Irricana',1,40),(96,'Irvine',1,40),(97,'Jarvie',1,40),(98,'Jasper',1,40),(99,'Joussard',1,40),(100,'Keoma',1,40),(101,'Killam',1,40),(102,'Kinuso',1,40),(103,'Kitscoty',1,40),(104,'Lac La Biche',1,40),(105,'Lacombe',1,40),(106,'Lake Louise',1,40),(107,'Lamont',1,40),(108,'Lancaster Park',1,40),(109,'Leduc',1,40),(110,'Legal',1,40),(111,'Lethbridge',1,40),(112,'Lloydminster',1,40),(113,'Looma',1,40),(114,'Mackay',1,40),(115,'Magrath',1,40),(116,'Mannville',1,40),(117,'Marwayne',1,40),(118,'McLennan',1,40),(119,'McMurray',1,40),(120,'Medicine Hat',1,40),(121,'Midnapore',1,40),(122,'Milk River',1,40),(123,'Millet',1,40),(124,'Monarch',1,40),(125,'Morinville',1,40),(126,'Munson',1,40),(127,'Nampa',1,40),(128,'Nanton',1,40),(129,'Nisku',1,40),(130,'Nobleford',1,40),(131,'North Vermilion',1,40),(132,'Obed',1,40),(133,'Okotoks',1,40),(134,'Olds',1,40),(135,'Onoway',1,40),(136,'Paradise Valley',1,40),(137,'Patricia',1,40),(138,'Peace River',1,40),(139,'Peers',1,40),(140,'Penhold',1,40),(141,'Pincher Creek',1,40),(142,'Plamondon',1,40),(143,'Ponoka',1,40),(144,'Provost',1,40),(145,'Radway',1,40),(146,'Ralston',1,40),(147,'Raymond',1,40),(148,'Red Deer',1,40),(149,'Redcliff',1,40),(150,'Rimbey',1,40),(151,'Rocky Mountain House',1,40),(152,'Rosalind',1,40),(153,'Rosedale',1,40),(154,'Rosemary',1,40),(155,'Rycroft',1,40),(156,'Saint Albert',1,40),(157,'Saint Paul',1,40),(158,'Saint Vincent',1,40),(159,'Sangudo',1,40),(160,'Scandia',1,40),(161,'Sexsmith',1,40),(162,'Sherwood Park',1,40),(163,'Slave Lake',1,40),(164,'Smith',1,40),(165,'Smoky Lake',1,40),(166,'Spedden',1,40),(167,'Spirit River',1,40),(168,'Spruce Grove',1,40),(169,'Standard',1,40),(170,'Stettler',1,40),(171,'Stony Plain',1,40),(172,'Suffield',1,40),(173,'Sylvan Lake',1,40),(174,'Taber',1,40),(175,'Thorhild',1,40),(176,'Three Hills',1,40),(177,'Tofield',1,40),(178,'Trochu',1,40),(179,'Two Hills',1,40),(180,'Valleyview',1,40),(181,'Vauxhall',1,40),(182,'Vegreville',1,40),(183,'Vermilion',1,40),(184,'Veteran',1,40),(185,'Viking',1,40),(186,'Vulcan',1,40),(187,'Wainwright',1,40),(188,'Watino',1,40),(189,'Webster',1,40),(190,'Wembley',1,40),(191,'Westlock',1,40),(192,'Wetaskiwin',1,40),(193,'Whitecourt',1,40),(194,'Widewater',1,40),(195,'Wildwood',1,40),(196,'Wrentham',1,40),(197,'Abbotsford',2,40),(198,'Abbottsford',2,40),(199,'Agassiz',2,40),(200,'Aiyansh',2,40),(201,'Albert Canyon',2,40),(202,'Alert Bay',2,40),(203,'Armstrong',2,40),(204,'Ashcroft',2,40),(205,'Atlin',2,40),(206,'Bamfield',2,40),(207,'Barriere',2,40),(208,'Bella Coola',2,40),(209,'Black Pines',2,40),(210,'Blucher Hall',2,40),(211,'Boswell',2,40),(212,'Brackendale',2,40),(213,'Brentwood Bay',2,40),(214,'Bridge Lake',2,40),(215,'Burnaby',2,40),(216,'Burns Lake',2,40),(217,'Campbell River',2,40),(218,'Canal Flats',2,40),(219,'Castlegar',2,40),(220,'Cecil Lake',2,40),(221,'Chase',2,40),(222,'Chemainus',2,40),(223,'Cherryville',2,40),(224,'Chief Lake',2,40),(225,'Chilliwack',2,40),(226,'Cinema',2,40),(227,'Clearwater',2,40),(228,'Clo-oose',2,40),(229,'Cloverdale',2,40),(230,'Coal Creek',2,40),(231,'Cobble Hill',2,40),(232,'Colebrook',2,40),(233,'Comox',2,40),(234,'Coquitlam',2,40),(235,'Cortes Bay',2,40),(236,'Courtenay',2,40),(237,'Cowichan Bay',2,40),(238,'Cranbrook',2,40),(239,'Creston',2,40),(240,'Crofton',2,40),(241,'Dawson Creek',2,40),(242,'Dease Lake',2,40),(243,'Delta',2,40),(244,'Deroche',2,40),(245,'Dot',2,40),(246,'Duncan',2,40),(247,'Edgewood',2,40),(248,'Elko',2,40),(249,'Enderby',2,40),(250,'Extension',2,40),(251,'Fairmont Hot Springs',2,40),(252,'Fernie',2,40),(253,'Finmoore',2,40),(254,'Fort Nelson',2,40),(255,'Fort Saint James',2,40),(256,'Fort Saint John',2,40),(257,'Fraser Lake',2,40),(258,'Fruitvale',2,40),(259,'Gabriola',2,40),(260,'Ganges',2,40),(261,'Garibaldi',2,40),(262,'Gibsons',2,40),(263,'Glacier',2,40),(264,'Gold Bridge',2,40),(265,'Golden',2,40),(266,'Grand Forks',2,40),(267,'Hagensborg',2,40),(268,'Hartley Bay',2,40),(269,'Hazelton',2,40),(270,'Hedley',2,40),(271,'Hixon',2,40),(272,'Houston',2,40),(273,'Invermere',2,40),(274,'Isle Pierre',2,40),(275,'Kamloops',2,40),(276,'Kelowna',2,40),(277,'Keremeos',2,40),(278,'Kimberley',2,40),(279,'Kimberly',2,40),(280,'Kincolith',2,40),(281,'Kitimat',2,40),(282,'Kitwanga',2,40),(283,'Ladner',2,40),(284,'Ladysmith',2,40),(285,'Lake Cowichan',2,40),(286,'Langley',2,40),(287,'Leon',2,40),(288,'Lillooet',2,40),(289,'Lumby',2,40),(290,'Lytton',2,40),(291,'Mackenzie',2,40),(292,'Maple Ridge',2,40),(293,'Marysville',2,40),(294,'Masset',2,40),(295,'Mayne',2,40),(296,'McBride',2,40),(297,'McMurphy',2,40),(298,'Merritt',2,40),(299,'Merville',2,40),(300,'Midway',2,40),(301,'Mission',2,40),(302,'Moberly Lake',2,40),(303,'Mud River',2,40),(304,'Nadu',2,40),(305,'Nakusp',2,40),(306,'Nanaimo',2,40),(307,'Nanoose Bay',2,40),(308,'Nelson',2,40),(309,'New Denver',2,40),(310,'New Westminster',2,40),(311,'Newgate',2,40),(312,'North Surrey',2,40),(313,'North Vancouver',2,40),(314,'Ocean Falls',2,40),(315,'Okanagan',2,40),(316,'Oliver',2,40),(317,'One Hundred Mile House',2,40),(318,'Osoyoos',2,40),(319,'Oyama',2,40),(320,'Pacific',2,40),(321,'Parksville',2,40),(322,'Peachland',2,40),(323,'Pemberton',2,40),(324,'Penticton',2,40),(325,'Pitt Meadows',2,40),(326,'Port Alberni',2,40),(327,'Port Alice',2,40),(328,'Port Clements',2,40),(329,'Port Coquitlam',2,40),(330,'Port Edward',2,40),(331,'Port Hardy',2,40),(332,'Port Mann',2,40),(333,'Port Mellon',2,40),(334,'Port Moody',2,40),(335,'Port Neville',2,40),(336,'Pouce Coupe',2,40),(337,'Powell River',2,40),(338,'Prince George',2,40),(339,'Prince Rupert',2,40),(340,'Princeton',2,40),(341,'Pritchard',2,40),(342,'Qualicum Beach',2,40),(343,'Quathiaski Cove',2,40),(344,'Queen Charlotte',2,40),(345,'Quesnel',2,40),(346,'Revelstoke',2,40),(347,'Richmond',2,40),(348,'Riondel',2,40),(349,'Roberts Creek',2,40),(350,'Rose Lake',2,40),(351,'Rossland',2,40),(352,'Salmon Arm',2,40),(353,'Salmon Valley',2,40),(354,'Savona',2,40),(355,'Sayward',2,40),(356,'Sechelt',2,40),(357,'Shere',2,40),(358,'Sicamous',2,40),(359,'Sidney',2,40),(360,'Skidegate',2,40),(361,'Slocan',2,40),(362,'Smithers',2,40),(363,'Sointula',2,40),(364,'Sooke',2,40),(365,'Sorrento',2,40),(366,'Squamish',2,40),(367,'Stephen',2,40),(368,'Stewart',2,40),(369,'Sturdies Bay',2,40),(370,'Summerland',2,40),(371,'Surrey',2,40),(372,'Tahsis',2,40),(373,'Tappen',2,40),(374,'Taylor',2,40),(375,'Telegraph Creek',2,40),(376,'Terrace',2,40),(377,'Tlell',2,40),(378,'Tofino',2,40),(379,'Trail',2,40),(380,'Tsawwassen',2,40),(381,'Ucluelet',2,40),(382,'Union Bay',2,40),(383,'Valemount',2,40),(384,'Vancouver',2,40),(385,'Vanderhoof',2,40),(386,'Vernon',2,40),(387,'Victoria',2,40),(388,'Whaletown',2,40),(389,'White Rock',2,40),(390,'Williams Lake',2,40),(391,'Windermere',2,40),(392,'Winfield',2,40),(393,'Wright',2,40),(394,'Youbou',2,40),(395,'Zeballos',2,40),(396,'Alexander',3,40),(397,'Altona',3,40),(398,'Arborg',3,40),(399,'Ashern',3,40),(400,'Austin',3,40),(401,'Beausejour',3,40),(402,'Brandon',3,40),(403,'Brochet',3,40),(404,'Carberry',3,40),(405,'Carman',3,40),(406,'Cranberry Portage',3,40),(407,'Cross Lake',3,40),(408,'Dauphin',3,40),(409,'Deer',3,40),(410,'Dufresne',3,40),(411,'Eriksdale',3,40),(412,'Flin Flon',3,40),(413,'Gillam',3,40),(414,'Gimli',3,40),(415,'Gods Lake',3,40),(416,'Griswold',3,40),(417,'Gypsumville',3,40),(418,'Hamiota',3,40),(419,'Inwood',3,40),(420,'Kemnay',3,40),(421,'Killarney',3,40),(422,'Langruth',3,40),(423,'Lazare',3,40),(424,'Macgregor',3,40),(425,'Malonton',3,40),(426,'Manitou',3,40),(427,'McCreary',3,40),(428,'Melita',3,40),(429,'Miami',3,40),(430,'Minitonas',3,40),(431,'Minnedosa',3,40),(432,'Morden',3,40),(433,'Morris',3,40),(434,'Neepawa',3,40),(435,'Nelson House',3,40),(436,'Norway House',3,40),(437,'Notre-Dame-de-Lourdes',3,40),(438,'Ochre River',3,40),(439,'Otterburne',3,40),(440,'Oxford House',3,40),(441,'Pilot Mound',3,40),(442,'Pinawa',3,40),(443,'Pine Falls',3,40),(444,'Portage La Prairie',3,40),(445,'Richer',3,40),(446,'Rivers',3,40),(447,'Rosenfeld',3,40),(448,'Saint Lazare',3,40),(449,'Sainte-Anne',3,40),(450,'Selkirk',3,40),(451,'Shoal Lake',3,40),(452,'Southport',3,40),(453,'Steinbach',3,40),(454,'Stonewall',3,40),(455,'Stony Mountain',3,40),(456,'Swan River',3,40),(457,'Teulon',3,40),(458,'The Pas',3,40),(459,'Thicket Portage',3,40),(460,'Thompson',3,40),(461,'Treherne',3,40),(462,'Virden',3,40),(463,'Wawanesa',3,40),(464,'Winkler',3,40),(465,'Winnipeg',3,40),(466,'Winnipegosis',3,40),(467,'Aldouane',4,40),(468,'Bathurst',4,40),(469,'Blackville',4,40),(470,'Buctouche',4,40),(471,'Burnsville',4,40),(472,'Burnt Church',4,40),(473,'Campbellton',4,40),(474,'Canterbury Station',4,40),(475,'Caraquet',4,40),(476,'Chatham',4,40),(477,'Dalhousie',4,40),(478,'Dieppe',4,40),(479,'Doaktown',4,40),(480,'Durham Bridge',4,40),(481,'Edmundston',4,40),(482,'Frederickton',4,40),(483,'Fredericton',4,40),(484,'Glassville',4,40),(485,'Grand Bay',4,40),(486,'Grand Falls',4,40),(487,'Hampton',4,40),(488,'Harvey',4,40),(489,'Hillsborough',4,40),(490,'Kedgwick',4,40),(491,'Kent Junction',4,40),(492,'L\'Etete',4,40),(493,'McAdam',4,40),(494,'Memramcook',4,40),(495,'Miramichi',4,40),(496,'Moncton',4,40),(497,'Moores Mills',4,40),(498,'Nauwigewauk',4,40),(499,'Neguac',4,40),(500,'Newcastle Bridge',4,40),(501,'Nigadoo',4,40),(502,'Notre Dame',4,40),(503,'Oromocto',4,40),(504,'Pennfield',4,40),(505,'Plaster Rock',4,40),(506,'Pointe-du-Chene',4,40),(507,'Prince William',4,40),(508,'Renous',4,40),(509,'Rexton',4,40),(510,'Richibucto',4,40),(511,'River Charlo',4,40),(512,'Rogersville',4,40),(513,'Rothesay',4,40),(514,'Sackville',4,40),(515,'Saint Andrews',4,40),(516,'Saint John',4,40),(517,'Saint Louis De Kent',4,40),(518,'Saint Margaret Bay',4,40),(519,'Salisbury',4,40),(520,'Shediac',4,40),(521,'South Nelson',4,40),(522,'Stanley',4,40),(523,'Sussex',4,40),(524,'Welsford',4,40),(525,'Woodstock',4,40),(526,'Baie Verte',5,40),(527,'Bauline',5,40),(528,'Bay Bulls',5,40),(529,'Bay De Verde',5,40),(530,'Bay Roberts',5,40),(531,'Belleoram',5,40),(532,'Birchy Bay',5,40),(533,'Bishops Falls',5,40),(534,'Bonavista',5,40),(535,'Botwood',5,40),(536,'Brigus',5,40),(537,'Burgeo',5,40),(538,'Burin',5,40),(539,'Burnside',5,40),(540,'Cape Ray',5,40),(541,'Carbonear',5,40),(542,'Catalina',5,40),(543,'Change Islands',5,40),(544,'Channel-Port Aux Basques',5,40),(545,'Chapel Arm',5,40),(546,'Clarenville',5,40),(547,'Colliers',5,40),(548,'Come By Chance',5,40),(549,'Corner Brook',5,40),(550,'Daniels Cove',5,40),(551,'Dildo',5,40),(552,'Doyles',5,40),(553,'Dunville',5,40),(554,'Fortune',5,40),(555,'Foxtrap',5,40),(556,'Francois',5,40),(557,'Gambo',5,40),(558,'Gander',5,40),(559,'Glenburnie',5,40),(560,'Glovertown',5,40),(561,'Goose Bay',5,40),(562,'Grand Bank',5,40),(563,'Grates Cove',5,40),(564,'Happy Valley',5,40),(565,'Harbour Grace',5,40),(566,'Holyrood',5,40),(567,'Kelligrews',5,40),(568,'La Scie',5,40),(569,'Lamaline',5,40),(570,'Lawn',5,40),(571,'Lewisporte',5,40),(572,'Little Bay Island',5,40),(573,'Little Harbour',5,40),(574,'Logy Bay',5,40),(575,'Loon Bay',5,40),(576,'Lourdes',5,40),(577,'Marystown',5,40),(578,'Middle Arm',5,40),(579,'Mount Pearl',5,40),(580,'Mount Pearl Park',5,40),(581,'Nippers Harbour',5,40),(582,'Norris Arm',5,40),(583,'Paradise',5,40),(584,'Parsons Pond',5,40),(585,'Petty Harbour',5,40),(586,'Placentia',5,40),(587,'Port Albert',5,40),(588,'Port Blandford',5,40),(589,'Port Saunders',5,40),(590,'Portugal Cove',5,40),(591,'Ramea',5,40),(592,'Rigolet',5,40),(593,'Saint Anthony',5,40),(594,'Saint George',5,40),(595,'Saint John\'s',5,40),(596,'Saint Jones Within',5,40),(597,'Silverdale',5,40),(598,'South Branch',5,40),(599,'Southern Bay',5,40),(600,'Spaniards Bay',5,40),(601,'Springdale',5,40),(602,'Stephenville',5,40),(603,'Topsail',5,40),(604,'Torbay',5,40),(605,'Twillingate',5,40),(606,'Wabana',5,40),(607,'Wabush',5,40),(608,'Whitbourne',5,40),(609,'Winterton',5,40),(610,'Witless Bay',5,40),(611,'York Harbour',5,40),(612,'Albany',6,40),(613,'Amherst',6,40),(614,'Annapolis',6,40),(615,'Annapolis Royal',6,40),(616,'Antigonish',6,40),(617,'Arichat',6,40),(618,'Barrington',6,40),(619,'Bear River',6,40),(620,'Beaver Harbour',6,40),(621,'Bedford',6,40),(622,'Berwick',6,40),(623,'Bridgetown',6,40),(624,'Bridgewater',6,40),(625,'Centreville',6,40),(626,'Chester',6,40),(627,'Church Point',6,40),(628,'Cornwallis',6,40),(629,'Cow Bay',6,40),(630,'Dartmouth',6,40),(631,'Debert',6,40),(632,'Digby',6,40),(633,'Dingwall',6,40),(634,'East Chezzetcook',6,40),(635,'Eastern Passage',6,40),(636,'Economy',6,40),(637,'Elmsdale',6,40),(638,'Glace Bay',6,40),(639,'Grand Narrows',6,40),(640,'Granville Ferry',6,40),(641,'Greenwood',6,40),(642,'Halifax',6,40),(643,'Hantsport',6,40),(644,'Hopewell',6,40),(645,'Hubbards',6,40),(646,'Inverness',6,40),(647,'Judique',6,40),(648,'Kennetcook',6,40),(649,'Kentville',6,40),(650,'Kingsport',6,40),(651,'Lawrencetown',6,40),(652,'Liverpool',6,40),(653,'Londonderry',6,40),(654,'Long Point',6,40),(655,'Lunenburg',6,40),(656,'Mabou',6,40),(657,'Mahone Bay',6,40),(658,'Marshy Hope',6,40),(659,'McKinnon Harbour',6,40),(660,'Merigomishe',6,40),(661,'Middleton',6,40),(662,'Mosherville',6,40),(663,'Mount Uniacke',6,40),(664,'Musquodoboit',6,40),(665,'Musquodoboit Harbour',6,40),(666,'New Germany',6,40),(667,'New Glasgow',6,40),(668,'New Waterford',6,40),(669,'Oxford',6,40),(670,'Oxford Junction',6,40),(671,'Parrsboro',6,40),(672,'Petit-Etang',6,40),(673,'Pictou',6,40),(674,'Port Hastings',6,40),(675,'Port Hawkesbury',6,40),(676,'Port Mouton',6,40),(677,'Port Williams',6,40),(678,'Pubnico',6,40),(679,'Sable River',6,40),(680,'Saint Peters',6,40),(681,'Scotsburn',6,40),(682,'Shubenacadie',6,40),(683,'Springhill',6,40),(684,'Stellarton',6,40),(685,'Sydney',6,40),(686,'Sydney Mines',6,40),(687,'Tatamagouche',6,40),(688,'Tenecape',6,40),(689,'Tracadie',6,40),(690,'Truro',6,40),(691,'Upper Musquodoboit',6,40),(692,'Wedgeport',6,40),(693,'Westville',6,40),(694,'Weymouth',6,40),(695,'Wolfville',6,40),(696,'Woods Harbour',6,40),(697,'Yarmouth',6,40),(698,'Aklavik',11,40),(699,'Apex',11,40),(700,'Arctic Bay',11,40),(701,'Arviat',11,40),(702,'Baker Lake',11,40),(703,'Broughton Island',11,40),(704,'Cambridge Bay',11,40),(705,'Cape Dorset',11,40),(706,'Chesterfield Inlet',11,40),(707,'Clyde River',11,40),(708,'Colville Lake',11,40),(709,'Coral Harbour',11,40),(710,'Deline',11,40),(711,'Fort Good Hope',11,40),(712,'Fort Liard',11,40),(713,'Fort McPherson',11,40),(714,'Fort Providence',11,40),(715,'Fort Resolution',11,40),(716,'Fort Simpson',11,40),(717,'Fort Smith',11,40),(718,'Gjoa Haven',11,40),(719,'Hall Beach',11,40),(720,'Hay River',11,40),(721,'Holman Island',11,40),(722,'Igloolik',11,40),(723,'Inuvik',11,40),(724,'Iqaluit',11,40),(725,'Jean Marie River',11,40),(726,'Kimmirut',11,40),(727,'Kugluktuk',11,40),(728,'Nahanni Butte',11,40),(729,'Norman Wells',11,40),(730,'Pangnirtung',11,40),(731,'Paulatuk',11,40),(732,'Pelly Bay',11,40),(733,'Pond Inlet',11,40),(734,'Providence',11,40),(735,'Rankin Inlet',11,40),(736,'Repulse Bay',11,40),(737,'Resolution',11,40),(738,'Sachs Harbour',11,40),(739,'Sanikiluaq',11,40),(740,'Snare Lake',11,40),(741,'Taloyoak',11,40),(742,'Trout Lake',11,40),(743,'Tsiigehtchic',11,40),(744,'Tuktoyaktuk',11,40),(745,'Tulita',11,40),(746,'Wha Ti',11,40),(747,'Wrigley',11,40),(748,'Yellowknife',11,40),(749,'Kugaaruk',7,40),(750,'Resolute',7,40),(751,'Acton',7,40),(752,'Agincourt',7,40),(753,'Ajax',7,40),(754,'Alexandria',7,40),(755,'Alfred',7,40),(756,'Algonquin Park',7,40),(757,'Allenford',7,40),(758,'Alliston',7,40),(759,'Almonte',7,40),(760,'Amherstburg',7,40),(761,'Angus',7,40),(762,'Apsley',7,40),(763,'Arnprior',7,40),(764,'Arthur',7,40),(765,'Atikokan',7,40),(766,'Attawapiskat',7,40),(767,'Aurora',7,40),(768,'Ayr',7,40),(769,'Ayton',7,40),(770,'Baden',7,40),(771,'Bala',7,40),(772,'Bancroft',7,40),(773,'Barrie',7,40),(774,'Bath',7,40),(775,'Bayfield',7,40),(776,'Beachburg',7,40),(777,'Beamsville',7,40),(778,'Bearskin Lake',7,40),(779,'Beaverton',7,40),(780,'Belle River',7,40),(781,'Belleville',7,40),(782,'Belmont',7,40),(783,'Bethany',7,40),(784,'Blenheim',7,40),(785,'Blind River',7,40),(786,'Bobcaygeon',7,40),(787,'Bolton',7,40),(788,'Borden',7,40),(789,'Bowmanville',7,40),(790,'Bracebridge',7,40),(791,'Bradford',7,40),(792,'Brampton',7,40),(793,'Brantford',7,40),(794,'Brechin',7,40),(795,'Brighton',7,40),(796,'Brimley',7,40),(797,'Britt',7,40),(798,'Brockville',7,40),(799,'Bruce Mines',7,40),(800,'Buckhorn',7,40),(801,'Burks Falls',7,40),(802,'Burlington',7,40),(803,'Calabogie',7,40),(804,'Caledon',7,40),(805,'Caledon East',7,40),(806,'Caledonia',7,40),(807,'Callander',7,40),(808,'Cambridge',7,40),(809,'Campbellford',7,40),(810,'Canfield',7,40),(811,'Cannington',7,40),(812,'Capreol',7,40),(813,'Cardinal',7,40),(814,'Carleton Place',7,40),(815,'Carp',7,40),(816,'Casselman',7,40),(817,'Chalk River',7,40),(818,'Chapleau',7,40),(819,'Chatsworth',7,40),(820,'Chelmsford',7,40),(821,'Cheminis',7,40),(822,'Chesley',7,40),(823,'Chesterville',7,40),(824,'Churchill',7,40),(825,'Clarkson',7,40),(826,'Clinton',7,40),(827,'Cobalt',7,40),(828,'Cobden',7,40),(829,'Cobourg',7,40),(830,'Cochrane',7,40),(831,'Colborne',7,40),(832,'Coldwater',7,40),(833,'Collingwood',7,40),(834,'Comber',7,40),(835,'Cornwall',7,40),(836,'Cottam',7,40),(837,'Courtright',7,40),(838,'Creemore',7,40),(839,'Creighton',7,40),(840,'Crystal Beach',7,40),(841,'Cumberland',7,40),(842,'Deep River',7,40),(843,'Deer Lake',7,40),(844,'Delhi',7,40),(845,'Denbigh',7,40),(846,'Denfield',7,40),(847,'Desbarats',7,40),(848,'Deseronto',7,40),(849,'Don Mills',7,40),(850,'Dorset',7,40),(851,'Downsview',7,40),(852,'Dresden',7,40),(853,'Drinkwater',7,40),(854,'Drumbo',7,40),(855,'Dryden',7,40),(856,'Dundalk',7,40),(857,'Dundas',7,40),(858,'Dunnville',7,40),(859,'Dunsford',7,40),(860,'Durham',7,40),(861,'Earlton',7,40),(862,'Echo Bay',7,40),(863,'Eganville',7,40),(864,'Elgin',7,40),(865,'Elk Lake',7,40),(866,'Elliot Lake',7,40),(867,'Elmira',7,40),(868,'Elmvale',7,40),(869,'Elora',7,40),(870,'Emerald',7,40),(871,'Emo',7,40),(872,'Englehart',7,40),(873,'Enterprise',7,40),(874,'Erin',7,40),(875,'Erindale',7,40),(876,'Espanola',7,40),(877,'Essex',7,40),(878,'Etobicoke',7,40),(879,'Exeter',7,40),(880,'Falconbridge',7,40),(881,'Fenelon Falls',7,40),(882,'Fergus',7,40),(883,'Flesherton',7,40),(884,'Fonthill',7,40),(885,'Forest',7,40),(886,'Fort Albany',7,40),(887,'Fort Erie',7,40),(888,'Fort Frances',7,40),(889,'Fort Hope',7,40),(890,'Fort Severn',7,40),(891,'Foymount',7,40),(892,'Frankford',7,40),(893,'Galt',7,40),(894,'Gananoque',7,40),(895,'Garden River',7,40),(896,'Garson',7,40),(897,'Georgetown',7,40),(898,'Geraldton',7,40),(899,'Glencoe',7,40),(900,'Gloucester',7,40),(901,'Goderich',7,40),(902,'Gogama',7,40),(903,'Golden Lake',7,40),(904,'Goldpines',7,40),(905,'Gooderham',7,40),(906,'Gore Bay',7,40),(907,'Grand Bend',7,40),(908,'Grand Valley',7,40),(909,'Gravenhurst',7,40),(910,'Grimsby',7,40),(911,'Guelph',7,40),(912,'Hagersville',7,40),(913,'Haileybury',7,40),(914,'Haley Station',7,40),(915,'Haliburton',7,40),(916,'Hamilton',7,40),(917,'Hanover',7,40),(918,'Harriston',7,40),(919,'Harrow',7,40),(920,'Hastings',7,40),(921,'Havelock',7,40),(922,'Hawk Junction',7,40),(923,'Hawkesbury',7,40),(924,'Hearst',7,40),(925,'Hensall',7,40),(926,'Heron Bay',7,40),(927,'Hespeler',7,40),(928,'Hindon',7,40),(929,'Holland',7,40),(930,'Hope',7,40),(931,'Hornepayne',7,40),(932,'Huntsville',7,40),(933,'Ignace',7,40),(934,'Ingersoll',7,40),(935,'Ingleside',7,40),(936,'Inglewood',7,40),(937,'Iroquois',7,40),(938,'Iroquois Falls',7,40),(939,'Kagawong',7,40),(940,'Kakabeka Falls',7,40),(941,'Kanata',7,40),(942,'Kapuskasing',7,40),(943,'Keene',7,40),(944,'Keewatin',7,40),(945,'Kemptville',7,40),(946,'Kenora',7,40),(947,'Keswick',7,40),(948,'Kincardine',7,40),(949,'King City',7,40),(950,'Kingston',7,40),(951,'Kingsville',7,40),(952,'Kirkland Lake',7,40),(953,'Kitchener',7,40),(954,'L\'Original',7,40),(955,'Lakefield',7,40),(956,'Lancaster',7,40),(957,'Lansdowne',7,40),(958,'Leamington',7,40),(959,'Leaside',7,40),(960,'Lefroy',7,40),(961,'Levack',7,40),(962,'Lindsay',7,40),(963,'Listowel',7,40),(964,'Little Current',7,40),(965,'Lively',7,40),(966,'London',7,40),(967,'Long Sault',7,40),(968,'Longlac',7,40),(969,'Lucan',7,40),(970,'Lucknow',7,40),(971,'Macdiarmid',7,40),(972,'Madoc',7,40),(973,'Magnetawan',7,40),(974,'Maitland',7,40),(975,'Malton',7,40),(976,'Manitouwadge',7,40),(977,'Manitowaning',7,40),(978,'Maple',7,40),(979,'Marathon',7,40),(980,'Markdale',7,40),(981,'Markham',7,40),(982,'Markstay',7,40),(983,'Marmora',7,40),(984,'Massey',7,40),(985,'Mattawa',7,40),(986,'Maxville',7,40),(987,'Maynooth',7,40),(988,'McGregor',7,40),(989,'Meaford',7,40),(990,'Merrickville',7,40),(991,'Michipicoten',7,40),(992,'Midhurst',7,40),(993,'Midland',7,40),(994,'Mildmay',7,40),(995,'Millbrook',7,40),(996,'Millhaven',7,40),(997,'Milton',7,40),(998,'Milverton',7,40),(999,'Mimico',7,40),(1000,'Minden',7,40),(1001,'Mississauga',7,40),(1002,'Mitchell',7,40),(1003,'Moose Factory',7,40),(1004,'Morrisburg',7,40),(1005,'Mount Forest',7,40),(1006,'Mountain Grove',7,40),(1007,'Nakina',7,40),(1008,'Napanee',7,40),(1009,'Nepean',7,40),(1010,'New Hamburg',7,40),(1011,'New Liskeard',7,40),(1012,'Newburgh',7,40),(1013,'Newcastle',7,40),(1014,'Newmarket',7,40),(1015,'Niagara',7,40),(1016,'Niagara Falls',7,40),(1017,'Niagara-on-the-Lake',7,40),(1018,'Nipigon',7,40),(1019,'Noelville',7,40),(1020,'North Bay',7,40),(1021,'Norwich',7,40),(1022,'Norwood',7,40),(1023,'Oakville',7,40),(1024,'Omemee',7,40),(1025,'Orangeville',7,40),(1026,'Orillia',7,40),(1027,'Orleans',7,40),(1028,'Oshawa',7,40),(1029,'Ottawa',7,40),(1030,'Otter Lake',7,40),(1031,'Owen Sound',7,40),(1032,'Paisley',7,40),(1033,'Pakenham',7,40),(1034,'Palmerston',7,40),(1035,'Paris',7,40),(1036,'Park Head',7,40),(1037,'Parkhill',7,40),(1038,'Parry Sound',7,40),(1039,'Pass Lake',7,40),(1040,'Pefferlaw',7,40),(1041,'Pembroke',7,40),(1042,'Penetanguishene',7,40),(1043,'Perth',7,40),(1044,'Petawawa',7,40),(1045,'Peterborough',7,40),(1046,'Petrolia',7,40),(1047,'Pickering',7,40),(1048,'Picton',7,40),(1049,'Pikangikum',7,40),(1050,'Pinewood',7,40),(1051,'Point Edward',7,40),(1052,'Pontypool',7,40),(1053,'Poplar Hill',7,40),(1054,'Port Colborne',7,40),(1055,'Port Credit',7,40),(1056,'Port Dover',7,40),(1057,'Port Elgin',7,40),(1058,'Port Hope',7,40),(1059,'Port McNicoll',7,40),(1060,'Port Perry',7,40),(1061,'Port Stanley',7,40),(1062,'Port Weller',7,40),(1063,'Powassan',7,40),(1064,'Prescott',7,40),(1065,'Preston',7,40),(1066,'Queenston',7,40),(1067,'Red Lake',7,40),(1068,'Red Rock',7,40),(1069,'Redwater',7,40),(1070,'Renfrew',7,40),(1071,'Rexdale',7,40),(1072,'Richan',7,40),(1073,'Richmond Hill',7,40),(1074,'Ridgetown',7,40),(1075,'River Valley',7,40),(1076,'Roblin',7,40),(1077,'Rockland',7,40),(1078,'Rodney',7,40),(1079,'Rossport',7,40),(1080,'Russell',7,40),(1081,'Saint Catharines',7,40),(1082,'Saint Catherines',7,40),(1083,'Saint Clair Beach',7,40),(1084,'Saint Marys',7,40),(1085,'Saint Thomas',7,40),(1086,'Saint-Charles',7,40),(1087,'Sarnia',7,40),(1088,'Sault Sainte Marie',7,40),(1089,'Scarborough',7,40),(1090,'Scarborough Junction',7,40),(1091,'Scarborough Township',7,40),(1092,'Schreiber',7,40),(1093,'Schumacher',7,40),(1094,'Scotia',7,40),(1095,'Seaforth',7,40),(1096,'Severn Bridge',7,40),(1097,'Sharbot Lake',7,40),(1098,'Shelburne',7,40),(1099,'Simcoe',7,40),(1100,'Sioux Lookout',7,40),(1101,'Smiths Falls',7,40),(1102,'Smithville',7,40),(1103,'Sombra',7,40),(1104,'South Porcupine',7,40),(1105,'South River',7,40),(1106,'Southampton',7,40),(1107,'Spanish',7,40),(1108,'Sparta',7,40),(1109,'Stamford',7,40),(1110,'Stayner',7,40),(1111,'Stirling',7,40),(1112,'Stittsville',7,40),(1113,'Stoney Creek',7,40),(1114,'Stouffville',7,40),(1115,'Stratford',7,40),(1116,'Strathroy',7,40),(1117,'Streetsville',7,40),(1118,'Sturgeon Falls',7,40),(1119,'Sudbury',7,40),(1120,'Sundridge',7,40),(1121,'Swansea',7,40),(1122,'Sydenham',7,40),(1123,'Tavistock',7,40),(1124,'Tecumseh',7,40),(1125,'Teeswater',7,40),(1126,'Terrace Bay',7,40),(1127,'Thedford',7,40),(1128,'Thessalon',7,40),(1129,'Thornbury',7,40),(1130,'Thornhill',7,40),(1131,'Thorold',7,40),(1132,'Thunder Bay',7,40),(1133,'Tichborne',7,40),(1134,'Tilbury',7,40),(1135,'Tillsonburg',7,40),(1136,'Tilsonburg',7,40),(1137,'Timmins',7,40),(1138,'Tiverton',7,40),(1139,'Tobermory',7,40),(1140,'Toronto',7,40),(1141,'Tottenham',7,40),(1142,'Trenton',7,40),(1143,'Tudhope',7,40),(1144,'Tweed',7,40),(1145,'Tyrone',7,40),(1146,'Uxbridge',7,40),(1147,'Vankleek Hill',7,40),(1148,'Verner',7,40),(1149,'Verona',7,40),(1150,'Victoria Harbour',7,40),(1151,'Walkerton',7,40),(1152,'Wallace',7,40),(1153,'Wallaceburg',7,40),(1154,'Warren',7,40),(1155,'Waterdown',7,40),(1156,'Waterford',7,40),(1157,'Waterloo',7,40),(1158,'Watford',7,40),(1159,'Wawa',7,40),(1160,'Webbwood',7,40),(1161,'Welland',7,40),(1162,'Wellington',7,40),(1163,'West Lorne',7,40),(1164,'Weston',7,40),(1165,'Westport',7,40),(1166,'Wheatley',7,40),(1167,'Whitby',7,40),(1168,'Whitchurch-Stouffville',7,40),(1169,'White River',7,40),(1170,'Whitefish',7,40),(1171,'Whitney',7,40),(1172,'Wiarton',7,40),(1173,'Wilberforce',7,40),(1174,'Willowdale',7,40),(1175,'Winchester',7,40),(1176,'Windsor',7,40),(1177,'Wingham',7,40),(1178,'Woodbridge',7,40),(1179,'Wyebridge',7,40),(1180,'Wyoming',7,40),(1181,'Yarker',7,40),(1182,'York',7,40),(1183,'Borden-Carleton',8,40),(1184,'Carleton',8,40),(1185,'Charlottetown',8,40),(1186,'Hunter River',8,40),(1187,'Kensington',8,40),(1188,'Montague',8,40),(1189,'Portage',8,40),(1190,'Rustico',8,40),(1191,'Souris',8,40),(1192,'Summerside',8,40),(1193,'Vernon River',8,40),(1194,'Abord a Plouffe',9,40),(1195,'Acton Vale',9,40),(1196,'Albanel',9,40),(1197,'Alma',9,40),(1198,'Amos',9,40),(1199,'Amqui',9,40),(1200,'Ancienne Lorette',9,40),(1201,'Anjou',9,40),(1202,'Anteuil',9,40),(1203,'Arthabaska',9,40),(1204,'Arvida',9,40),(1205,'Asbestos',9,40),(1206,'Aston Junction',9,40),(1207,'Auteuil',9,40),(1208,'Authier',9,40),(1209,'Ayers Cliff',9,40),(1210,'Aylmer',9,40),(1211,'Bagotville',9,40),(1212,'Baie-Comeau',9,40),(1213,'Baie-d\'Urfe',9,40),(1214,'Baie-Saint-Paul',9,40),(1215,'Barachois',9,40),(1216,'Barraute',9,40),(1217,'Batiscan',9,40),(1218,'Beaconsfield',9,40),(1219,'Beauceville',9,40),(1220,'Beauharnois',9,40),(1221,'Beauport',9,40),(1222,'Beaupre',9,40),(1223,'Beaver',9,40),(1224,'Becancour',9,40),(1225,'Beebe',9,40),(1226,'Beloeil',9,40),(1227,'Berthier',9,40),(1228,'Berthier-sur-Mer',9,40),(1229,'Berthierville',9,40),(1230,'Betsiamites',9,40),(1231,'Bois-des-Filion',9,40),(1232,'Boischatel',9,40),(1233,'Bonaventure',9,40),(1234,'Bromptonville',9,40),(1235,'Brossard',9,40),(1236,'Bryson',9,40),(1237,'Buckingham',9,40),(1238,'Cabano',9,40),(1239,'Cacouna',9,40),(1240,'Candiac',9,40),(1241,'Cap-aux-Meules',9,40),(1242,'Cap-Chat',9,40),(1243,'Cap-de-la-Madeleine',9,40),(1244,'Cap-Rouge',9,40),(1245,'Caughnawaga',9,40),(1246,'Chambly',9,40),(1247,'Chambord',9,40),(1248,'Champlain',9,40),(1249,'Chandler',9,40),(1250,'Chapais',9,40),(1251,'Charlemagne',9,40),(1252,'Charlesbourg',9,40),(1253,'Charny',9,40),(1254,'Chateauguay',9,40),(1255,'Chibougamau',9,40),(1256,'Chicoutimi',9,40),(1257,'Chicoutimi-Nord',9,40),(1258,'Chomedey',9,40),(1259,'Chute-aux-Outardes',9,40),(1260,'Chute-Shipshaw',9,40),(1261,'Clericy',9,40),(1262,'Clermont',9,40),(1263,'Coaticook',9,40),(1264,'Contrecoeur',9,40),(1265,'Cookshire',9,40),(1266,'Cote-Saint-Luc',9,40),(1267,'Cowansville',9,40),(1268,'Crabtree',9,40),(1269,'Danville',9,40),(1270,'De Lery',9,40),(1271,'Delson',9,40),(1272,'Derval',9,40),(1273,'Desbiens',9,40),(1274,'Deschambault',9,40),(1275,'Deux-Montagnes',9,40),(1276,'Disraeli',9,40),(1277,'Dolbeau',9,40),(1278,'Dollard-des-Ormeaux',9,40),(1279,'Donnacona',9,40),(1280,'Dorion',9,40),(1281,'Dorion-Vaudreuil',9,40),(1282,'Dorval',9,40),(1283,'Drummondville',9,40),(1284,'Dubuisson',9,40),(1285,'Duvernay',9,40),(1286,'East Angus',9,40),(1287,'Eastmain',9,40),(1288,'Eastman',9,40),(1289,'Etang-du-Nord',9,40),(1290,'Fabreville',9,40),(1291,'Farnham',9,40),(1292,'Ferme-Neuve',9,40),(1293,'Forestville',9,40),(1294,'Gaspe',9,40),(1295,'Gatineau',9,40),(1296,'Godbout',9,40),(1297,'Granby',9,40),(1298,'Grande-Riviere',9,40),(1299,'Greenfield Park',9,40),(1300,'Grosses-Roches',9,40),(1301,'Guigues',9,40),(1302,'Hebertville',9,40),(1303,'Hemmingford',9,40),(1304,'Hudson',9,40),(1305,'Hudson Heights',9,40),(1306,'Hull',9,40),(1307,'Huntingdon',9,40),(1308,'Iberville',9,40),(1309,'Ile-Perrot',9,40),(1310,'Jacques-Cartier',9,40),(1311,'Joliette',9,40),(1312,'Jonquiere',9,40),(1313,'Knowlton',9,40),(1314,'Kuujjuaq',9,40),(1315,'L\'Assomption',9,40),(1316,'L\'Epiphanie',9,40),(1317,'La Baie',9,40),(1318,'La Guadeloupe',9,40),(1319,'La Macaza',9,40),(1320,'La Malbaie',9,40),(1321,'La Salle',9,40),(1322,'La Sarre',9,40),(1323,'La Tuque',9,40),(1324,'Labelle',9,40),(1325,'Lac-Megantic',9,40),(1326,'Lachine',9,40),(1327,'Lachute',9,40),(1328,'Lacolle',9,40),(1329,'Lafontaine',9,40),(1330,'Lanoraie',9,40),(1331,'Laprairie',9,40),(1332,'Laurentides',9,40),(1333,'Lauzon',9,40),(1334,'Laval',9,40),(1335,'Laval-des-Rapides',9,40),(1336,'Laval-Ouest',9,40),(1337,'Lavaltrie',9,40),(1338,'Lennoxville',9,40),(1339,'Lery',9,40),(1340,'Les Escoumins',9,40),(1341,'Levis',9,40),(1342,'Liniere',9,40),(1343,'Longueuil',9,40),(1344,'Loretteville',9,40),(1345,'Louiseville',9,40),(1346,'Luceville',9,40),(1347,'Luskville',9,40),(1348,'Lyster',9,40),(1349,'Macamic',9,40),(1350,'Magog',9,40),(1351,'Magpie',9,40),(1352,'Malartic',9,40),(1353,'Maniwaki',9,40),(1354,'Manseau',9,40),(1355,'Maple Grove',9,40),(1356,'Marieville',9,40),(1357,'Masson',9,40),(1358,'Matagami',9,40),(1359,'Matane',9,40),(1360,'Mauricie',9,40),(1361,'McMasterville',9,40),(1362,'McWatters',9,40),(1363,'Melocheville',9,40),(1364,'Metabetchouan',9,40),(1365,'Millstream',9,40),(1366,'Mirabel',9,40),(1367,'Mont-Apica',9,40),(1368,'Mont-Joli',9,40),(1369,'Mont-Laurier',9,40),(1370,'Mont-Royal',9,40),(1371,'Mont-Saint-Hilaire',9,40),(1372,'Mont-Tremblant',9,40),(1373,'Montebello',9,40),(1374,'Montmagny',9,40),(1375,'Montreal',9,40),(1376,'Montreal-Est',9,40),(1377,'Montreal-Nord',9,40),(1378,'Mount-Royal',9,40),(1379,'Murdochville',9,40),(1380,'Napierville',9,40),(1381,'Natashquan',9,40),(1382,'Neuville',9,40),(1383,'New Richmond',9,40),(1384,'Nicolet',9,40),(1385,'Noranda',9,40),(1386,'Normandin',9,40),(1387,'Notre-Dame-des-Monts',9,40),(1388,'Notre-Dame-du-Lac',9,40),(1389,'Notre-Dame-du-Laus',9,40),(1390,'Notre-Dame-du-Nord',9,40),(1391,'Omerville',9,40),(1392,'Ormstown',9,40),(1393,'Otterburn Park',9,40),(1394,'Outremont',9,40),(1395,'Papineauville',9,40),(1396,'Parent',9,40),(1397,'Pierrefonds',9,40),(1398,'Pierreville',9,40),(1399,'Pincourt',9,40),(1400,'Plessisville',9,40),(1401,'Point Claire',9,40),(1402,'Pointe-aux-Trembles',9,40),(1403,'Pointe-Calumet',9,40),(1404,'Pointe-Claire',9,40),(1405,'Pointe-Lebel',9,40),(1406,'Pont-Rouge',9,40),(1407,'Port-Cartier',9,40),(1408,'Portneuf',9,40),(1409,'Price',9,40),(1410,'Princeville',9,40),(1411,'Puvirnituq',9,40),(1412,'Rawdon',9,40),(1413,'Repentigny',9,40),(1414,'Richelieu',9,40),(1415,'Rigaud',9,40),(1416,'Rimouski',9,40),(1417,'Ripon',9,40),(1418,'Riviere-des-Prairies',9,40),(1419,'Riviere-du-Loup',9,40),(1420,'Riviere-Pigou',9,40),(1421,'Roberval',9,40),(1422,'Rosemere',9,40),(1423,'Rouyn',9,40),(1424,'Roxboro',9,40),(1425,'Sacre-Coeur',9,40),(1426,'Saint Antoine',9,40),(1427,'Saint Bruno',9,40),(1428,'Saint Georges De Beauce',9,40),(1429,'Saint Guillaume',9,40),(1430,'Saint Isidore',9,40),(1431,'Saint Leonard',9,40),(1432,'Saint-Agapit',9,40),(1433,'Saint-Ambroise',9,40),(1434,'Saint-Anselme',9,40),(1435,'Saint-Augustin',9,40),(1436,'Saint-Basile',9,40),(1437,'Saint-Bruno-de-Montarville',9,40),(1438,'Saint-Cesaire',9,40),(1439,'Saint-Denis',9,40),(1440,'Saint-Eustache',9,40),(1441,'Saint-Fabien',9,40),(1442,'Saint-Felicien',9,40),(1443,'Saint-Felix-de-Valois',9,40),(1444,'Saint-Francois',9,40),(1445,'Saint-Gabriel',9,40),(1446,'Saint-Gedeon',9,40),(1447,'Saint-Georges',9,40),(1448,'Saint-Germain-de-Grantham',9,40),(1449,'Saint-Henri-de-Levis',9,40),(1450,'Saint-Henri-de-Taillon',9,40),(1451,'Saint-Hilaire',9,40),(1452,'Saint-Honore',9,40),(1453,'Saint-Hubert',9,40),(1454,'Saint-Hyacinthe',9,40),(1455,'Saint-Jacques',9,40),(1456,'Saint-Jean',9,40),(1457,'Saint-Jean-Eudes',9,40),(1458,'Saint-Jerome',9,40),(1459,'Saint-Joseph-de-Beauce',9,40),(1460,'Saint-Joseph-de-Kamouraska',9,40),(1461,'Saint-Jovite',9,40),(1462,'Saint-Lambert',9,40),(1463,'Saint-Lambert-Chambly',9,40),(1464,'Saint-Laurent',9,40),(1465,'Saint-Lazare',9,40),(1466,'Saint-Leonard',9,40),(1467,'Saint-Malo',9,40),(1468,'Saint-Marc-des-Carrieres',9,40),(1469,'Saint-Michel-des-Saints',9,40),(1470,'Saint-Nicolas',9,40),(1471,'Saint-Pascal',9,40),(1472,'Saint-Pie',9,40),(1473,'Saint-Prosper',9,40),(1474,'Saint-Raphael',9,40),(1475,'Saint-Raymond',9,40),(1476,'Saint-Remi',9,40),(1477,'Saint-Roch-de-Richelieu',9,40),(1478,'Saint-Romuald',9,40),(1479,'Saint-Sauveur',9,40),(1480,'Saint-Sauveur-des-Monts',9,40),(1481,'Saint-Stanislas-de-Kostka',9,40),(1482,'Saint-Tite',9,40),(1483,'Saint-Tite-des-Caps',9,40),(1484,'Saint-Vallier',9,40),(1485,'Saint-Vincent-de-Paul',9,40),(1486,'Saint-Zotique',9,40),(1487,'Sainte-Adele',9,40),(1488,'Sainte-Agathe',9,40),(1489,'Sainte-Agathe-des-Monts',9,40),(1490,'Sainte-Anne-de-Beaupre',9,40),(1491,'Sainte-Anne-de-Bellevue',9,40),(1492,'Sainte-Anne-des-Monts',9,40),(1493,'Sainte-Catherine',9,40),(1494,'Sainte-Cecile-de-Masham',9,40),(1495,'Sainte-Claire',9,40),(1496,'Sainte-Dorothee',9,40),(1497,'Sainte-Foy',9,40),(1498,'Sainte-Genevieve-de-Batiscan',9,40),(1499,'Sainte-Julienne',9,40),(1500,'Sainte-Marie',9,40),(1501,'Sainte-Martine',9,40),(1502,'Sainte-Rose',9,40),(1503,'Sainte-Therese',9,40),(1504,'Sainte-Therese-de-Blainville',9,40),(1505,'Salaberry-de-Valleyfield',9,40),(1506,'Sayabec',9,40),(1507,'Senneterre',9,40),(1508,'Senneville',9,40),(1509,'Sept-Iles',9,40),(1510,'Shawinigan',9,40),(1511,'Shawinigan-Sud',9,40),(1512,'Shawville',9,40),(1513,'Shefford',9,40),(1514,'Sheldrake',9,40),(1515,'Sherbrook',9,40),(1516,'Sherbrooke',9,40),(1517,'Shipshaw',9,40),(1518,'Sillery',9,40),(1519,'Sorel',9,40),(1520,'Stanstead',9,40),(1521,'Stoneham',9,40),(1522,'Sutton',9,40),(1523,'Tadoussac',9,40),(1524,'Taschereau',9,40),(1525,'Temiscaming',9,40),(1526,'Templeton',9,40),(1527,'Terrebonne',9,40),(1528,'Thetford Mines',9,40),(1529,'Thurso',9,40),(1530,'Tracy',9,40),(1531,'Trois-Pistoles',9,40),(1532,'Trois-Rivieres',9,40),(1533,'Val-Barrette',9,40),(1534,'Val-d\'Or',9,40),(1535,'Val-David',9,40),(1536,'Valcourt',9,40),(1537,'Vallee-Jonction',9,40),(1538,'Valleyfield',9,40),(1539,'Varennes',9,40),(1540,'Vaudreuil',9,40),(1541,'Vercheres',9,40),(1542,'Verdun',9,40),(1543,'Victoriaville',9,40),(1544,'Ville-Marie',9,40),(1545,'Wakefield',9,40),(1546,'Warwick',9,40),(1547,'Waswanipi',9,40),(1548,'Waterville',9,40),(1549,'Weedon',9,40),(1550,'Westmount',9,40),(1551,'Yamachiche',9,40),(1552,'Yamaska',9,40),(1553,'Aberdeen',10,40),(1554,'Allan',10,40),(1555,'Arborfield',10,40),(1556,'Arcola',10,40),(1557,'Asquith',10,40),(1558,'Assiniboia',10,40),(1559,'Avonlea',10,40),(1560,'Big River',10,40),(1561,'Biggar',10,40),(1562,'Birsay',10,40),(1563,'Blaine Lake',10,40),(1564,'Brancepeth',10,40),(1565,'Broderick',10,40),(1566,'Bruno',10,40),(1567,'Buffalo Narrows',10,40),(1568,'Cabri',10,40),(1569,'Canoe Narrows',10,40),(1570,'Canora',10,40),(1571,'Carlyle',10,40),(1572,'Carnduff',10,40),(1573,'Caronport',10,40),(1574,'Carrot River',10,40),(1575,'Chamberlain',10,40),(1576,'Chaplin',10,40),(1577,'Clair',10,40),(1578,'Coderre',10,40),(1579,'Colonsay',10,40),(1580,'Cote',10,40),(1581,'Crooked River',10,40),(1582,'Cumberland House',10,40),(1583,'Cut Knife',10,40),(1584,'Dalmeny',10,40),(1585,'Denare Beach',10,40),(1586,'Dillon',10,40),(1587,'Dinsmore',10,40),(1588,'Dodsland',10,40),(1589,'Domremy',10,40),(1590,'Dorintosh',10,40),(1591,'Duck Lake',10,40),(1592,'Dundurn',10,40),(1593,'Dunfermline',10,40),(1594,'Edam',10,40),(1595,'Elbow',10,40),(1596,'Esterhazy',10,40),(1597,'Estevan',10,40),(1598,'Eston',10,40),(1599,'Fielding',10,40),(1600,'Foam Lake',10,40),(1601,'Fort Qu\'Appelle',10,40),(1602,'Fox Valley',10,40),(1603,'Govan',10,40),(1604,'Gravelbourg',10,40),(1605,'Grenfell',10,40),(1606,'Griffin',10,40),(1607,'Gull Lake',10,40),(1608,'Hafford',10,40),(1609,'Hague',10,40),(1610,'Hanley',10,40),(1611,'Herschel',10,40),(1612,'Hudson Bay',10,40),(1613,'Humboldt',10,40),(1614,'Ile-a-la-Crosse',10,40),(1615,'Indian Head',10,40),(1616,'Kamsack',10,40),(1617,'Kelvington',10,40),(1618,'Kennedy',10,40),(1619,'Kerrobert',10,40),(1620,'Kindersley',10,40),(1621,'Kinistino',10,40),(1622,'La Ronge',10,40),(1623,'Lampman',10,40),(1624,'Lang',10,40),(1625,'Langbank',10,40),(1626,'Langham',10,40),(1627,'Lanigan',10,40),(1628,'Lashburn',10,40),(1629,'Leader',10,40),(1630,'Lipton',10,40),(1631,'Livelong',10,40),(1632,'Loon Lake',10,40),(1633,'Lumsden',10,40),(1634,'Macklin',10,40),(1635,'Maidstone',10,40),(1636,'Maple Creek',10,40),(1637,'Meadow Lake',10,40),(1638,'Melfort',10,40),(1639,'Melville',10,40),(1640,'Michel',10,40),(1641,'Midale',10,40),(1642,'Milden',10,40),(1643,'Montmartre',10,40),(1644,'Montreal Lake',10,40),(1645,'Moose Jaw',10,40),(1646,'Moosomin',10,40),(1647,'Mortlach',10,40),(1648,'Mossbank',10,40),(1649,'Naicam',10,40),(1650,'Naisberry',10,40),(1651,'Neilburg',10,40),(1652,'Netherhill',10,40),(1653,'New Osgoode',10,40),(1654,'Nipawin',10,40),(1655,'North Battleford',10,40),(1656,'North Portal',10,40),(1657,'Onion Lake',10,40),(1658,'Outlook',10,40),(1659,'Oxbow',10,40),(1660,'Pascal',10,40),(1661,'Pilot Butte',10,40),(1662,'Plunkett',10,40),(1663,'Preeceville',10,40),(1664,'Prince',10,40),(1665,'Prince Albert',10,40),(1666,'Quill Lake',10,40),(1667,'Radisson',10,40),(1668,'Radville',10,40),(1669,'Redvers',10,40),(1670,'Regina',10,40),(1671,'Revenue',10,40),(1672,'Rockglen',10,40),(1673,'Rosetown',10,40),(1674,'Saint Brieux',10,40),(1675,'Saint Gregor',10,40),(1676,'Saint Louis',10,40),(1677,'Saint Walberg',10,40),(1678,'Saint Walburg',10,40),(1679,'Saint-Isidore-de-Bellevue',10,40),(1680,'Sandy Lake',10,40),(1681,'Saskatoon',10,40),(1682,'Shaunavon',10,40),(1683,'Shellbrook',10,40),(1684,'Silton',10,40),(1685,'Simmie',10,40),(1686,'Spiritwood',10,40),(1687,'Springwater',10,40),(1688,'Stranraer',10,40),(1689,'Swift Current',10,40),(1690,'Turtleford',10,40),(1691,'Unity',10,40),(1692,'Wadena',10,40),(1693,'Warman',10,40),(1694,'Watrous',10,40),(1695,'Watson',10,40),(1696,'Weyburn',10,40),(1697,'Whitewood',10,40),(1698,'Wilkie',10,40),(1699,'Willowbrook',10,40),(1700,'Wolseley',10,40),(1701,'Wymark',10,40),(1702,'Wynyard',10,40),(1703,'Yorkton',10,40),(1704,'Young',10,40),(1705,'Carmacks',12,40),(1706,'Dawson City',12,40),(1707,'Kaslo',12,40),(1708,'Old Crow',12,40),(1709,'Pelly Crossing',12,40),(1710,'Whitehorse',12,40);



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



/*Table structure for table `credit_cards` */



DROP TABLE IF EXISTS `credit_cards`;



CREATE TABLE `credit_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` varbinary(50) DEFAULT NULL,
  `profile_id` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `card_type` varchar(30) DEFAULT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `expiry_date` int(2) DEFAULT NULL,
  `expiry_month` int(2) DEFAULT NULL,
  `expiry_year` int(4) DEFAULT NULL,
  `ccv` decimal(5,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;



/*Data for the table `credit_cards` */



insert  into `credit_cards`(`id`,`user_type`,`profile_id`,`first_name`,`last_name`,`card_type`,`card_number`,`expiry_date`,`expiry_month`,`expiry_year`,`ccv`) values (1,NULL,NULL,'ali','raza','mastercard','12345678912345678912',12,12,2016,'12345'),(2,NULL,NULL,'ra','dad','visa','2465421654',11,10,2020,'99999'),(7,NULL,NULL,'test','test','americanExpress','4654',3,5,2016,'354'),(8,NULL,NULL,'test','test','discover','4654',3,6,2016,'354'),(17,NULL,NULL,'test up','test up','mastercard','46542313123',28,12,2020,'12345'),(25,NULL,NULL,'ajhkjh','h','americanExpress','-1564564564',6,3,2017,'4546'),(34,NULL,NULL,'ajhkjh','h','americanExpress','-1564564564',6,3,2017,'4546'),(35,NULL,NULL,'ali','raza','mastercard','12345678912345678912',12,12,2016,'12345'),(38,NULL,NULL,'jhasdasd','sadasd','americanExpress','4',3,3,2016,'4465'),(39,NULL,NULL,'test','test','discover','3215132',13,1,2016,'3154'),(40,NULL,NULL,'ali','test','americanExpress','-1564354351',3,1,2016,'3654'),(42,NULL,NULL,'ali raza','ali raza','americanExpress','5161560',3,1,2016,'3654'),(45,NULL,NULL,'test ali','test ali','mastercard','465456156',2,1,2016,'63415');



/*Table structure for table `cuisine` */



DROP TABLE IF EXISTS `cuisine`;



CREATE TABLE `cuisine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;



/*Data for the table `cuisine` */



insert  into `cuisine`(`id`,`name`,`is_active`) values (1,'Canadian',1),(2,'American',1),(3,'Italian',1),(4,'Italian/Pizza',1),(5,'Chinese',1),(6,'Vietnamese',1),(7,'Japanese',1),(8,'Thai',1),(9,'French',1),(10,'Greek',1),(11,'Pizza',1),(12,'Desserts',1),(13,'Pub',1),(14,'Sports',1),(15,'Burgers',1),(16,'Vegan',1),(17,'German',1),(18,'Fish & Chips',1);



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
  `user_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `text` varchar(1024) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;



/*Data for the table `eventlog` */



insert  into `eventlog`(`id`,`user_id`,`restaurant_id`,`type`,`text`,`created_at`,`updated_at`) values (1,0,0,'Restaurant Created','{\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"City\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"20151118023537.jpg\",\"delivery_fee\":\"10\",\"minimum\":\"50\",\"id\":1}','2015-11-18 02:36:38','2015-11-18 02:36:38'),(2,0,0,'User Created','{\"profile_type\":2,\"name\":\"Waqar\",\"email\":\"skpsoftech+786@gmail.com\",\"subscribed\":\"1\",\"restaurant_id\":1,\"updated_at\":\"2015-11-18 02:36:38\",\"created_at\":\"2015-11-18 02:36:38\",\"id\":2}','2015-11-18 02:36:38','2015-11-18 02:36:38'),(3,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"City\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"100\",\"minimum\":\"50\",\"open\":1}','2015-11-18 02:43:06','2015-11-18 02:43:06'),(4,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"City\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"12\",\"minimum\":\"50\",\"open\":1}','2015-11-18 02:43:23','2015-11-18 02:43:23'),(5,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"City\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"111\",\"minimum\":\"50\",\"open\":1}','2015-11-18 02:45:50','2015-11-18 02:45:50'),(6,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"City\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"111\",\"minimum\":\"50\",\"open\":1}','2015-11-18 02:47:49','2015-11-18 02:47:49'),(7,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"City\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"111\",\"minimum\":\"50\",\"open\":1}','2015-11-18 06:02:55','2015-11-18 06:02:55'),(8,1,1,'User updated','{\"id\":2,\"profile_type\":\"2\",\"name\":\"Waqar\",\"email\":\"skpsoftech+786@gmail.com\",\"photo\":null,\"subscribed\":\"1\",\"restaurant_id\":\"1\",\"created_by\":0,\"status\":0,\"created_at\":\"2015-11-18 02:36:38\",\"updated_at\":\"2015-11-18 09:34:20\",\"deleted_at\":null}','2015-11-18 09:34:20','2015-11-18 09:34:20'),(9,1,1,'User updated','{\"id\":2,\"profile_type\":\"2\",\"name\":\"Waqar\",\"email\":\"skpsoftech+786@gmail.com\",\"photo\":null,\"subscribed\":\"1\",\"restaurant_id\":\"1\",\"created_by\":0,\"status\":0,\"created_at\":\"2015-11-18 02:36:38\",\"updated_at\":\"2015-11-18 09:35:52\",\"deleted_at\":null}','2015-11-18 09:35:52','2015-11-18 09:35:52'),(10,1,1,'User updated','{\"id\":2,\"profile_type\":\"2\",\"name\":\"Waqar\",\"email\":\"skpsoftech+786@gmail.com\",\"photo\":null,\"subscribed\":\"1\",\"restaurant_id\":\"1\",\"created_by\":0,\"status\":0,\"created_at\":\"2015-11-18 02:36:38\",\"updated_at\":\"2015-11-18 09:46:26\",\"deleted_at\":null}','2015-11-18 09:46:26','2015-11-18 09:46:26'),(11,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"111\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:42:14','2015-11-19 08:42:14'),(12,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"111\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:45:00','2015-11-19 08:45:00'),(13,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"111\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:46:25','2015-11-19 08:46:25'),(14,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"111\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:47:47','2015-11-19 08:47:47'),(15,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"11\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:48:00','2015-11-19 08:48:00'),(16,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"1\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:48:05','2015-11-19 08:48:05'),(17,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"1\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:48:09','2015-11-19 08:48:09'),(18,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"0\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:49:17','2015-11-19 08:49:17'),(19,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"1\",\"minimum\":\"50\",\"open\":1}','2015-11-19 08:49:38','2015-11-19 08:49:38'),(20,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"0\",\"minimum\":\"0\",\"open\":1}','2015-11-19 08:51:36','2015-11-19 08:51:36'),(21,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":\"1\",\"minimum\":\"10\",\"open\":1}','2015-11-19 08:51:59','2015-11-19 08:51:59'),(22,1,1,'Restaurant Updated','{\"id\":1,\"name\":\"Restaurant 1\",\"slug\":\"restaurant-1\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"250\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adjfakldf aklsdj fklas \",\"logo\":\"restaurant-1.jpg\",\"delivery_fee\":0,\"minimum\":0,\"open\":1}','2015-11-19 08:52:04','2015-11-19 08:52:04'),(23,0,0,'Restaurant Created','{\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"genre\":\"1\",\"phone\":\"01234\",\"address\":\"test Address5\",\"city\":\"15\",\"province\":\"1\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"ajldk fjaksd fjlaks djfklas \",\"delivery_fee\":\"10\",\"minimum\":\"50\",\"id\":2}','2015-11-19 09:07:36','2015-11-19 09:07:36'),(24,0,0,'User Created','{\"profile_type\":2,\"name\":\"waqar2\",\"email\":\"skpsoftech+3@gmail.com\",\"restaurant_id\":2,\"updated_at\":\"2015-11-19 09:07:36\",\"created_at\":\"2015-11-19 09:07:36\",\"id\":3}','2015-11-19 09:07:36','2015-11-19 09:07:36'),(25,1,1,'Restaurant Created','{\"name\":\"Test Restaurant4\",\"slug\":\"test-restaurant4\",\"genre\":\"1\",\"phone\":\"01234\",\"address\":\"test Address2\",\"city\":\"1\",\"province\":\"1\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"ajksdlf asjdklf jasl\",\"delivery_fee\":\"10\",\"minimum\":\"15\",\"id\":3}','2015-11-19 10:04:37','2015-11-19 10:04:37'),(26,1,1,'User Created','{\"profile_type\":2,\"name\":\"Waqar Javed\",\"email\":\"skpsoftech+4@gmail.com\",\"subscribed\":\"1\",\"restaurant_id\":3,\"updated_at\":\"2015-11-19 10:04:38\",\"created_at\":\"2015-11-19 10:04:38\",\"id\":4}','2015-11-19 10:04:38','2015-11-19 10:04:38'),(27,0,0,'Restaurant Created','{\"name\":\"Restaurant 2\",\"slug\":\"restaurant-2\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"198\",\"province\":\"2\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"adsjfkla sdjfkla skdkjf klasd fkjlas djflaksd fjklas\",\"delivery_fee\":0,\"minimum\":0,\"open\":1,\"id\":2}','2015-11-25 09:44:53','2015-11-25 09:44:53'),(28,0,0,'User Created','{\"profile_type\":2,\"name\":\"Waqar\",\"email\":\"skpsoftech+5@gmail.com\",\"subscribed\":\"1\",\"restaurant_id\":2,\"updated_at\":\"2015-11-25 09:44:53\",\"created_at\":\"2015-11-25 09:44:53\",\"id\":5}','2015-11-25 09:44:53','2015-11-25 09:44:53'),(29,0,0,'Restaurant Created','{\"name\":\"Restaurant 3\",\"slug\":\"restaurant-3\",\"genre\":\"1\",\"phone\":\"123456789\",\"address\":\"Street Address\",\"city\":\"198\",\"province\":\"2\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"ahsdkfa sdkjfh asdkjfh akjashdfkj asdhk\\r\\nsdfhaskjdfh akjsd fhakj\\r\\nasdfhaskjdfh akjsd h\",\"delivery_fee\":\"10\",\"minimum\":\"50\",\"tags\":\"canadian, american, italian, italian\\/pizza, chinese, vietnamese, japanese, thai, french, greek, pizza, desserts, pub, sports, burgers, vegan, german, waqar, vicky\",\"open\":1,\"id\":3}','2015-11-25 10:24:00','2015-11-25 10:24:00'),(30,0,0,'User Created','{\"profile_type\":2,\"name\":\"Waqar\",\"email\":\"skpsoftech+6@gmail.com\",\"subscribed\":\"1\",\"restaurant_id\":3,\"updated_at\":\"2015-11-25 10:24:01\",\"created_at\":\"2015-11-25 10:24:01\",\"id\":6}','2015-11-25 10:24:01','2015-11-25 10:24:01'),(31,0,0,'Restaurant Created','{\"name\":\"Test Restaurant1\",\"slug\":\"test-restaurant1\",\"phone\":\"123456\",\"address\":\"test Address5\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"ashdafkjsdh fakjs dhfkja \",\"delivery_fee\":\"10\",\"minimum\":\"100\",\"tags\":\"test1, test2\",\"open\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\",\"id\":14}','2015-12-09 15:08:17','2015-12-09 15:08:17'),(32,0,0,'User Created','{\"profile_type\":2,\"name\":\"Waqar 7\",\"email\":\"skpsoftech+7@gmail.com\",\"subscribed\":\"1\",\"restaurant_id\":14,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\",\"updated_at\":\"2015-12-09 15:08:18\",\"created_at\":\"2015-12-09 15:08:18\",\"id\":7}','2015-12-09 15:08:18','2015-12-09 15:08:18'),(33,0,0,'Restaurant Created','{\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"cuisine\":\"3\",\"phone\":\"123456\",\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"ajsdklf asjdlf alksdjflka \",\"logo\":\"20151209151538.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":\"10\",\"minimum\":\"100\",\"tags\":\"test1, test2, test3, test4\",\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\",\"id\":15}','2015-12-09 15:17:10','2015-12-09 15:17:10'),(34,0,0,'User Created','{\"profile_type\":2,\"name\":\"Waqar 8\",\"email\":\"skpsoftech+8@gmail.com\",\"subscribed\":\"1\",\"restaurant_id\":15,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\",\"updated_at\":\"2015-12-09 15:17:11\",\"created_at\":\"2015-12-09 15:17:11\",\"id\":8}','2015-12-09 15:17:12','2015-12-09 15:17:12'),(35,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"\'test1\', \'test2\', \'test3\', \'test4\', \",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":0,\"minimum\":0,\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:31:00','2015-12-09 15:31:00'),(36,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"\'\'test1\'\', \'\'test2\'\', \'\'test3\'\', \'\'test4\'\', \'\', \",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":0,\"is_pickup\":1,\"delivery_fee\":0,\"minimum\":0,\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:36:47','2015-12-09 15:36:47'),(37,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"test1, test2, test3, test4 \",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":0,\"minimum\":0,\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:43:53','2015-12-09 15:43:53'),(38,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"test1, test2, test3, test4, test5\",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":0,\"minimum\":0,\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:44:11','2015-12-09 15:44:11'),(39,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"test1, test2, test3, test4, test5\",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":\"10\",\"minimum\":\"100\",\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:45:11','2015-12-09 15:45:11'),(40,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"test1, test2, test3, test4, test5\",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":0,\"is_pickup\":1,\"delivery_fee\":0,\"minimum\":0,\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:45:16','2015-12-09 15:45:16'),(41,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"test1, test2, test3, test4, test5\",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":0,\"is_pickup\":1,\"delivery_fee\":0,\"minimum\":0,\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:46:52','2015-12-09 15:46:52'),(42,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"test1, test2, test3, test4, test5\",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":\"10\",\"minimum\":\"100\",\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:47:03','2015-12-09 15:47:03'),(43,1,15,'Restaurant Updated','{\"id\":15,\"cuisine\":\"3\",\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant2\",\"email\":\"skpsoftech+8@gmail.com\",\"website\":null,\"phone\":\"123456\",\"formatted_address\":null,\"address\":\"test Address2\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"123456\",\"lat\":null,\"lng\":null,\"description\":\"ajsdklf asjdlf alksdjflka \",\"tags\":\"test1, test2, test3, test4, test5\",\"logo\":\"test-restaurant2.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":\"10\",\"minimum\":\"99\",\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":null,\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\"}','2015-12-09 15:47:28','2015-12-09 15:47:28'),(44,1,15,'Restaurant Created','{\"name\":\"Test Restaurant2\",\"slug\":\"test-restaurant20\",\"email\":\"skpsoftech+9@gmail.com\",\"cuisine\":\"4\",\"phone\":\"01234\",\"address\":\"test Address5\",\"city\":\"Hamilton\",\"province\":\"10\",\"country\":\"40\",\"postal_code\":\"123456\",\"description\":\"admiasdfnaskjd faskjd fakjs \",\"logo\":\"20151209160300.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":\"10\",\"minimum\":\"19\",\"tags\":\"11, 222, 3333, 44444\",\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"46.0.2490.86\",\"browser_platform\":\"Windows 10\",\"id\":16}','2015-12-09 16:07:30','2015-12-09 16:07:30'),(45,0,0,'Restaurant Created','{\"name\":\"Restaurant Name3\",\"slug\":\"restaurant-name3\",\"email\":\"skpsoftech+9@gmail.com\",\"cuisine\":\"1\",\"phone\":\"123456789\",\"mobile\":\"123456789\",\"formatted_address\":\"Al Hafeez Shopping Mall, Main Boulevard Gulberg, Lahore, Punjab, Pakistan\",\"address\":\"321, Main Boulevard Gulberg\",\"city\":\"Lahore\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"54660\",\"lat\":\"31.51404149999999\",\"lng\":\"74.34346949999997\",\"description\":\"ajksdf laskdj fakl\",\"logo\":\"20151216062348.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"delivery_fee\":\"20\",\"minimum\":\"100\",\"tags\":\"test1, test2\",\"open\":1,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"47.0.2526.80\",\"browser_platform\":\"Windows 10\",\"id\":17}','2015-12-16 06:24:34','2015-12-16 06:24:34'),(46,0,0,'User Created','{\"profile_type\":2,\"name\":\"Waqar 8\",\"email\":\"skpsoftech+9@gmail.com\",\"subscribed\":\"1\",\"restaurant_id\":17,\"status\":1,\"ip_address\":\"::1\",\"browser_name\":\"Google Chrome\",\"browser_version\":\"47.0.2526.80\",\"browser_platform\":\"Windows 10\",\"updated_at\":\"2015-12-16 06:24:35\",\"created_at\":\"2015-12-16 06:24:35\",\"id\":9}','2015-12-16 06:24:35','2015-12-16 06:24:35'),(47,1,1,'Restaurant Updated','{\"id\":1,\"cuisine\":\"15\",\"name\":\"Chuck\'s Burger Bar\",\"slug\":\"chuck-burger-bar\",\"email\":\"paulduncanbentley@gmail.com\",\"website\":\"chucksburgerbar.com\",\"phone\":\"905-525-5682\",\"mobile\":null,\"formatted_address\":\"194 Locke St N, Hamilton, ON L8R 3A9\",\"address\":\"194 Locke St South\",\"city\":\"Hamilton\",\"province\":\"7\",\"country\":\"40\",\"postal_code\":\"L8P 4B4\",\"lat\":43.253571419708,\"lng\":-79.884521569709,\"description\":\"My restaurant is great!\",\"tags\":\"\",\"logo\":\"thumb_296.jpg\",\"is_delivery\":1,\"is_pickup\":1,\"max_delivery_distance\":\"10\",\"delivery_fee\":\"6\",\"minimum\":\"10\",\"hours\":null,\"days\":null,\"holidays\":null,\"rating\":3.5,\"open\":1,\"status\":1,\"ip_address\":null,\"browser_name\":null,\"browser_version\":null,\"browser_platform\":null}','2015-12-16 06:31:03','2015-12-16 06:31:03'),(48,0,0,'User Created','{\"profile_type\":2,\"name\":\"Waqar 9\",\"email\":\"skpsoftech+10@gmail.com\",\"subscribed\":0,\"restaurant_id\":0,\"created_by\":0,\"updated_at\":\"2015-12-16 10:35:28\",\"created_at\":\"2015-12-16 10:35:28\",\"id\":10}','2015-12-16 10:35:28','2015-12-16 10:35:28'),(49,0,0,'Order Created','{\"id\":1,\"restaurant_id\":\"1\",\"menu_ids\":\"1\",\"prs\":\"10.00\",\"qtys\":\"1\",\"extras\":\"\",\"listid\":\"_1\",\"subtotal\":10,\"g_total\":0,\"cash_type\":1,\"ordered_by\":\"Waqar 9\",\"contact\":\"123456789\",\"payment_mode\":null,\"address1\":null,\"address2\":null,\"city\":\"Lahore\",\"province\":\"3\",\"postal_code\":\"54660\",\"remarks\":\"afklasjdfklasdjfkla j alksdfj laks\",\"order_time\":\"2015-12-16 10:35:28\",\"order_till\":\"Dec 16, 11:15 - Dec 16, 11:30\",\"order_now\":0,\"delivery_fee\":6,\"tax\":0,\"order_type\":\"1\",\"status\":\"pending\",\"note\":\"\",\"user_id\":10}','2015-12-16 10:35:32','2015-12-16 10:35:32');



/*Table structure for table `hours` */



DROP TABLE IF EXISTS `hours`;



CREATE TABLE `hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `day_of_week` varchar(50) DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;



/*Data for the table `hours` */



insert  into `hours`(`id`,`restaurant_id`,`day_of_week`,`open`,`close`) values (1,1,'Sunday','12:00:00','12:00:00'),(2,1,'Monday','12:00:00','12:00:00'),(3,1,'Tuesday','12:20:00','12:25:00'),(4,1,'Wednesday','12:00:00','12:00:00'),(5,1,'Thursday','12:00:00','12:00:00'),(6,1,'Friday','12:00:00','12:00:00'),(7,1,'Saturday','12:00:00','12:00:00'),(8,2,'Sunday','12:00:00','12:00:00'),(9,2,'Monday','12:00:00','12:00:00'),(10,2,'Tuesday','12:00:00','12:00:00'),(11,2,'Wednesday','12:00:00','12:00:00'),(12,2,'Thursday','12:00:00','12:00:00'),(13,2,'Friday','12:00:00','12:00:00'),(14,2,'Saturday','12:00:00','12:00:00'),(15,3,'Sunday','12:00:00','12:00:00'),(16,3,'Monday','12:00:00','12:00:00'),(17,3,'Tuesday','12:00:00','12:00:00'),(18,3,'Wednesday','12:00:00','12:00:00'),(19,3,'Thursday','12:00:00','12:00:00'),(20,3,'Friday','12:00:00','12:00:00'),(21,3,'Saturday','12:00:00','12:00:00'),(22,2,'Sunday','12:00:00','12:00:00'),(23,2,'Monday','12:00:00','12:00:00'),(24,2,'Tuesday','12:00:00','12:00:00'),(25,2,'Wednesday','12:00:00','12:00:00'),(26,2,'Thursday','12:00:00','12:00:00'),(27,2,'Friday','12:00:00','12:00:00'),(28,2,'Saturday','12:00:00','12:00:00'),(29,3,'Sunday','12:00:00','12:00:00'),(30,3,'Monday','12:00:00','12:00:00'),(31,3,'Tuesday','12:00:00','12:00:00'),(32,3,'Wednesday','12:00:00','12:00:00'),(33,3,'Thursday','12:00:00','12:00:00'),(34,3,'Friday','12:00:00','12:00:00'),(35,3,'Saturday','12:00:00','12:00:00'),(36,14,'Sunday','12:00:00','12:00:00'),(37,14,'Monday','12:00:00','12:00:00'),(38,14,'Tuesday','12:00:00','12:00:00'),(39,14,'Wednesday','12:00:00','12:00:00'),(40,14,'Thursday','12:00:00','12:00:00'),(41,14,'Friday','12:00:00','12:00:00'),(42,14,'Saturday','12:00:00','12:00:00'),(43,15,'Sunday','12:00:00','12:00:00'),(44,15,'Monday','12:00:00','12:00:00'),(45,15,'Tuesday','13:00:00','12:00:00'),(46,15,'Wednesday','14:00:00','12:00:00'),(47,15,'Thursday','12:00:00','12:00:00'),(48,15,'Friday','12:00:00','12:00:00'),(49,15,'Saturday','12:00:00','12:00:00'),(50,16,'Sunday','12:00:00','12:00:00'),(51,16,'Monday','12:00:00','12:00:00'),(52,16,'Tuesday','12:00:00','12:00:00'),(53,16,'Wednesday','12:00:00','12:00:00'),(54,16,'Thursday','12:00:00','12:00:00'),(55,16,'Friday','12:00:00','12:00:00'),(56,16,'Saturday','12:00:00','12:00:00'),(57,17,'Sunday','12:00:00','12:00:00'),(58,17,'Monday','12:00:00','12:00:00'),(59,17,'Tuesday','12:00:00','12:00:00'),(60,17,'Wednesday','12:00:00','12:00:00'),(61,17,'Thursday','12:00:00','12:00:00'),(62,17,'Friday','12:00:00','12:00:00'),(63,17,'Saturday','12:00:00','12:00:00');



/*Table structure for table `menus` */



DROP TABLE IF EXISTS `menus`;



CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `menu_item` varchar(255) DEFAULT NULL,
  `description` text,
  `price` double DEFAULT '0',
  `rating` float DEFAULT NULL,
  `additional` int(11) DEFAULT NULL,
  `has_addon` int(11) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1:veg 2:spicy',
  `parent` int(11) DEFAULT NULL,
  `req_opt` int(11) DEFAULT NULL COMMENT '1=>r,0=>o',
  `sing_mul` int(11) DEFAULT NULL COMMENT '1=>s,0=>m',
  `exact_upto` int(11) DEFAULT NULL COMMENT '1=>e,0=>u',
  `exact_upto_qty` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT '1',
  `cat_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



/*Data for the table `menus` */



insert  into `menus`(`id`,`restaurant_id`,`menu_item`,`description`,`price`,`rating`,`additional`,`has_addon`,`image`,`type`,`parent`,`req_opt`,`sing_mul`,`exact_upto`,`exact_upto_qty`,`display_order`,`cat_id`) values (1,1,'Item pop1','ahdkjfah kjfah sdkjfh akjsdh fkjads hfkjasd hfakjs dhfkja sdhkjf ahkdsj fhakjsd hfkjas dhfkja dshfkj hasdkjfh askjdh kjas hfkjas dhfkja shdfkj ahsdkjf hadskj fhakjsd hfkjasd hfkja sdhfkjasdhkjfahs dkjfh ads fa dskj fhakjsdh fkjasdh kjfha',10,4.5,NULL,0,'1.jpg',NULL,0,NULL,NULL,NULL,NULL,1,1),(2,1,'Item pop2','ahsdfkj ahsdkjf hadskjf hakjds fhakjds ',20,NULL,NULL,1,'undefined',NULL,0,NULL,NULL,NULL,NULL,1,1),(3,1,'addons','adkahd fkjah sdkjf hakjsd hfkja shdkj',0,NULL,NULL,0,NULL,NULL,2,0,1,0,'',1,0),(4,1,'item2',NULL,10,NULL,NULL,0,NULL,NULL,3,NULL,NULL,NULL,NULL,2,0),(5,1,'item1',NULL,5,NULL,NULL,0,NULL,NULL,3,NULL,NULL,NULL,NULL,1,0),(6,1,'Item pop3','hakjd fhakjds hfakjds fhakjs dhk',10,NULL,NULL,0,'undefined',NULL,0,NULL,NULL,NULL,NULL,1,1),(7,1,'Item pop 1','ahdsfka sdfjh askdfh akjsd ',20,NULL,NULL,0,'undefined',NULL,0,NULL,NULL,NULL,NULL,1,1),(8,1,'test main','ajdfkal sdjflka sjdl fjaskl',10,NULL,NULL,0,'undefined',NULL,0,NULL,NULL,NULL,NULL,1,3);



/*Table structure for table `newsletter` */



DROP TABLE IF EXISTS `newsletter`;



CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `guid` varchar(64) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



/*Data for the table `newsletter` */



insert  into `newsletter`(`id`,`email`,`status`,`guid`,`created_at`,`updated_at`,`deleted_at`) values (1,'skpsoftech@gmail.com',1,NULL,'2015-11-18 04:34:24','2015-11-18 04:34:24',NULL);



/*Table structure for table `notification_addresses` */



DROP TABLE IF EXISTS `notification_addresses`;



CREATE TABLE `notification_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_default` tinyint(2) DEFAULT '0',
  `is_call` tinyint(1) DEFAULT '0',
  `is_sms` tinyint(1) DEFAULT '0',
  `type` enum('Email','Phone') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;



/*Data for the table `notification_addresses` */



insert  into `notification_addresses`(`id`,`user_id`,`address`,`is_default`,`is_call`,`is_sms`,`type`) values (1,2,'skpsoftech+786@gmail.com',1,0,0,'Email'),(2,2,'123456789',1,0,0,'Phone'),(3,1,'skpsoftech@gmail.com',0,0,0,'Email'),(4,1,'03225892509',0,0,0,'Phone'),(5,3,'skpsoftech+3@gmail.com',1,0,0,'Email'),(6,3,'01234',1,0,0,'Phone'),(7,4,'skpsoftech+4@gmail.com',1,0,0,'Email'),(8,4,'01234',1,0,0,'Phone'),(9,5,'skpsoftech+5@gmail.com',1,0,0,'Email'),(10,5,'123456789',1,0,0,'Phone'),(11,6,'skpsoftech+6@gmail.com',1,0,0,'Email'),(12,6,'123456789',1,0,0,'Phone'),(13,7,'skpsoftech+7@gmail.com',1,0,0,'Email'),(14,7,'123456',1,0,0,'Phone'),(15,8,'skpsoftech+8@gmail.com',1,0,0,'Email'),(16,8,'123456',1,0,0,'Phone'),(27,1,'skpsoftech+9@gmail.com',1,0,0,'Email'),(28,1,'11111111',0,0,0,'Phone'),(29,1,'2222222',0,0,0,'Phone'),(30,1,'333333',0,1,1,'Phone'),(31,1,'44444',1,1,1,'Phone'),(32,9,'skpsoftech+9@gmail.com',1,0,0,'Email'),(33,9,'123456789',1,0,0,'Phone'),(34,10,'skpsoftech+10@gmail.com',1,0,0,'Email'),(35,10,'123456789',1,0,0,'Phone');



/*Table structure for table `page_views` */



DROP TABLE IF EXISTS `page_views`;



CREATE TABLE `page_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `browser_name` varchar(100) NOT NULL,
  `browser_version` varchar(100) NOT NULL,
  `browser_platform` varchar(100) NOT NULL,
  `type` enum('menu','order','restaurant','user') DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;



/*Data for the table `page_views` */



insert  into `page_views`(`id`,`user_id`,`target_id`,`ip_address`,`browser_name`,`browser_version`,`browser_platform`,`type`,`created_at`,`updated_at`) values (1,1,1,'::1','Mozilla Firefox','42.0','Windows 10','restaurant','2015-11-18 05:44:31','2015-11-18 05:44:31'),(2,1,1,'::1','Google Chrome','46.0.2490.86','Windows 10','restaurant','2015-11-18 12:08:03','2015-11-18 12:08:03'),(3,1,1,'::1','Google Chrome','46.0.2490.86','Windows 10','menu','2015-11-18 12:08:44','2015-11-18 12:08:44'),(4,0,1,'::1','Google Chrome','46.0.2490.86','Windows 10','restaurant','2015-11-19 08:19:33','2015-11-19 08:19:33'),(5,0,1,'::1','Google Chrome','46.0.2490.86','Windows 10','menu','2015-11-19 08:19:50','2015-11-19 08:19:50'),(6,0,2,'::1','Google Chrome','46.0.2490.86','Windows 10','menu','2015-11-20 01:57:20','2015-11-20 01:57:20'),(7,1,8,'::1','Google Chrome','46.0.2490.86','Windows 10','menu','2015-11-20 02:00:21','2015-11-20 02:00:21'),(8,0,1,'::1','Mozilla Firefox','42.0','Windows 10','restaurant','2015-11-20 02:12:41','2015-11-20 02:12:41'),(9,0,1,'::1','Mozilla Firefox','42.0','Windows 10','menu','2015-11-20 02:12:49','2015-11-20 02:12:49'),(10,0,6,'::1','Mozilla Firefox','42.0','Windows 10','menu','2015-11-20 02:20:16','2015-11-20 02:20:16'),(11,0,6,'::1','Mozilla Firefox','42.0','Windows 10','menu','2015-11-20 02:20:16','2015-11-20 02:20:16'),(12,0,6,'::1','Mozilla Firefox','42.0','Windows 10','menu','2015-11-20 02:20:16','2015-11-20 02:20:16'),(13,0,2,'::1','Mozilla Firefox','42.0','Windows 10','menu','2015-11-20 02:23:19','2015-11-20 02:23:19'),(14,1,1,'::1','Mozilla Firefox','42.0','Windows 10','menu','2015-11-20 13:04:46','2015-11-20 13:04:46'),(15,1,2,'::1','Mozilla Firefox','42.0','Windows 10','menu','2015-11-20 13:04:56','2015-11-20 13:04:56'),(16,2,1,'::1','Google Chrome','46.0.2490.86','Windows 10','restaurant','2015-12-09 09:40:43','2015-12-09 09:40:43'),(17,3,1,'::1','Google Chrome','46.0.2490.86','Windows 10','restaurant','2015-12-09 09:43:07','2015-12-09 09:43:07'),(18,1,2,'::1','Google Chrome','46.0.2490.86','Windows 10','menu','2015-12-09 09:49:04','2015-12-09 09:49:04'),(19,1,16,'::1','Google Chrome','47.0.2526.80','Windows 10','restaurant','2015-12-15 12:41:14','2015-12-15 12:41:14'),(20,1,13,'::1','Google Chrome','47.0.2526.80','Windows 10','restaurant','2015-12-15 12:56:28','2015-12-15 12:56:28'),(21,1,15,'::1','Google Chrome','47.0.2526.80','Windows 10','restaurant','2015-12-15 12:58:08','2015-12-15 12:58:08'),(22,1,2,'::1','Google Chrome','47.0.2526.80','Windows 10','restaurant','2015-12-15 13:05:55','2015-12-15 13:05:55'),(23,1,14,'::1','Google Chrome','47.0.2526.80','Windows 10','restaurant','2015-12-15 13:06:23','2015-12-15 13:06:23'),(24,0,1,'::1','Unknown','?','Windows 10','restaurant','2015-12-15 13:12:02','2015-12-15 13:12:02'),(25,0,2,'::1','Google Chrome','47.0.2526.80','Windows 10','restaurant','2015-12-16 06:32:32','2015-12-16 06:32:32'),(26,0,6,'::1','Google Chrome','47.0.2526.80','Windows 10','menu','2015-12-16 09:51:01','2015-12-16 09:51:01');



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
  `photo` varchar(50) DEFAULT NULL,
  `subscribed` tinyint(4) DEFAULT '0',
  `restaurant_id` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT '0',
  `ip_address` varchar(100) DEFAULT NULL,
  `browser_name` varchar(100) DEFAULT NULL,
  `browser_version` varchar(100) DEFAULT NULL,
  `browser_platform` varchar(100) DEFAULT NULL,
  `is_email_varified` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;



/*Data for the table `profiles` */



insert  into `profiles`(`id`,`profile_type`,`name`,`email`,`password`,`photo`,`subscribed`,`restaurant_id`,`created_by`,`ip_address`,`browser_name`,`browser_version`,`browser_platform`,`is_email_varified`,`status`,`created_at`,`updated_at`,`deleted_at`) values (1,1,'Waqar Javed','skpsoftech@gmail.com','$2y$10$xBMJJ5dMaHjZfrNJ4FJ2quPFeded7DWO8ldgStzPQRP0F5xADYjd6','20151112112433.png',1,1,29,NULL,NULL,NULL,NULL,1,1,'2015-10-08 22:31:39','2015-11-12 16:24:35',NULL),(2,2,'Waqar','skpsoftech+2@gmail.com','$2y$10$F0yUpqu36aSz0/FahVy2ieU0mIHiAuVBmvqvZMUhSgqiywDQIhS0.',NULL,1,2,0,NULL,NULL,NULL,NULL,1,1,'2015-11-18 02:36:38','2015-11-18 09:46:26',NULL),(3,2,'waqar2','skpsoftech+3@gmail.com','$2y$10$1rvhNN.ZPH3vCLc6ZVudmOBgAU9pMG8JcYYH6pIQG1948zpOLl6ee',NULL,0,3,0,NULL,NULL,NULL,NULL,1,1,'2015-11-19 09:07:36','2015-11-19 09:07:36',NULL),(4,2,'Waqar Javed','skpsoftech+4@gmail.com','$2y$10$UC332elK75hRVk7XaA3uX.xl8B.rAfeqFIPW6degG8jCSh0E0ZZuO',NULL,1,4,0,NULL,NULL,NULL,NULL,1,1,'2015-11-19 10:04:38','2015-11-19 10:04:38',NULL),(5,2,'Waqar','skpsoftech+5@gmail.com','$2y$10$9Hr5MHVOZgdGH4K/ydXTAu6uUgkfS5n//A8wND3dOFzMhs9jKYsXm',NULL,1,5,0,NULL,NULL,NULL,NULL,1,1,'2015-11-25 09:44:53','2015-11-25 09:44:53',NULL),(6,2,'Waqar','skpsoftech+6@gmail.com','$2y$10$31HGUrlq1sgkRXmaXAQeU.7wwwVfxGysWGdpNiMK72yvNuTtOCquy',NULL,1,6,0,NULL,NULL,NULL,NULL,1,1,'2015-11-25 10:24:01','2015-11-25 10:24:01',NULL),(7,2,'Waqar 7','skpsoftech+7@gmail.com','$2y$10$rIryR/KOn5G9rg0cqN.1cunCXtjyV6A64z14aMXzXXlFFX4Nho5AG',NULL,1,14,0,'::1','Google Chrome','46.0.2490.86','Windows 10',0,1,'2015-12-09 15:08:18','2015-12-09 15:08:18',NULL),(8,2,'Waqar 8','skpsoftech+8@gmail.com','$2y$10$4sni2lvZkFsOGTdcvuRl0OhAPCxmW8Ie1CgjMkdZORxSWkIyYZU7K',NULL,1,15,0,'::1','Google Chrome','46.0.2490.86','Windows 10',0,1,'2015-12-09 15:17:11','2015-12-09 15:17:11',NULL),(9,2,'Waqar 8','skpsoftech+9@gmail.com','$2y$10$TRTKwFcnUUXFF3y.d/xNLe2n6K5kEqo3vHbL1mzaHrJm6oZQTePw2',NULL,1,17,0,'::1','Google Chrome','47.0.2526.80','Windows 10',0,1,'2015-12-16 06:24:35','2015-12-16 06:24:35',NULL),(10,2,'Waqar 9','skpsoftech+10@gmail.com','$2y$10$VYuw19A1v.RtHSTRMn8UeOqdfIOZq9d9trspWPtRRwlcppqxsVW7W',NULL,0,0,0,NULL,NULL,NULL,NULL,0,0,'2015-12-16 10:35:28','2015-12-16 10:35:28',NULL);



/*Table structure for table `profiles_addresses` */



DROP TABLE IF EXISTS `profiles_addresses`;



CREATE TABLE `profiles_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `location` varchar(300) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile` varbinary(32) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `apartment` varchar(100) DEFAULT NULL,
  `buzz` varchar(100) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `province` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;



/*Data for the table `profiles_addresses` */



insert  into `profiles_addresses`(`id`,`user_id`,`location`,`address`,`phone`,`mobile`,`postal_code`,`apartment`,`buzz`,`city`,`province`,`country`) values (1,2,NULL,'Street Address','123456789',NULL,'123456',NULL,NULL,'1553',2,40),(2,1,'Test Location','Street Address','123456789',NULL,'123456',NULL,NULL,'201',2,40),(3,1,'Location Name5','test Address5','01234',NULL,'123456','appartment','123456','15',1,40),(4,1,'Location Name6','test Address6','01234',NULL,'123456','appartment2','123456','1185',8,40),(5,4,NULL,'test Address2','01234',NULL,'123456',NULL,NULL,'1',1,40),(6,5,NULL,'Street Address','123456789',NULL,'123456',NULL,NULL,'198',2,40),(7,6,NULL,'Street Address','123456789',NULL,'123456',NULL,NULL,'198',2,40),(8,7,NULL,'test Address5','123456',NULL,'123456',NULL,NULL,'Hamilton',7,40),(9,8,NULL,'test Address2','123456',NULL,'123456',NULL,NULL,'Hamilton',7,40),(10,9,NULL,'321, Main Boulevard Gulberg','123456789','123456789','54660',NULL,NULL,'Lahore',7,40),(11,10,NULL,NULL,'123456789',NULL,NULL,NULL,NULL,NULL,NULL,NULL);



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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



/*Data for the table `profiles_images` */



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



/*Table structure for table `rating_define` */



DROP TABLE IF EXISTS `rating_define`;



CREATE TABLE `rating_define` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `type` enum('menu','restaurant') DEFAULT 'restaurant',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;



/*Data for the table `rating_define` */



insert  into `rating_define`(`id`,`title`,`type`,`is_active`) values (1,'Service','restaurant',1),(2,'Quality','restaurant',0),(3,'Pricing','restaurant',0),(4,'Taste','menu',1),(5,'Price','menu',0),(6,'Quality','menu',0);



/*Table structure for table `rating_users` */



DROP TABLE IF EXISTS `rating_users`;



CREATE TABLE `rating_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `rating_id` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `comments` varchar(500) DEFAULT NULL,
  `type` enum('menu','restaurant') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



/*Data for the table `rating_users` */



insert  into `rating_users`(`id`,`user_id`,`target_id`,`rating_id`,`rating`,`comments`,`type`,`created_at`,`updated_at`,`deleted_at`) values (1,3,1,1,1.5,'test 1','restaurant','2015-12-09 09:45:35','2015-12-09 09:45:35',NULL),(2,1,1,1,3.5,'test 2','restaurant','2015-12-09 09:46:10','2015-12-09 09:46:10',NULL),(3,2,1,1,5,'test 3','restaurant','2015-12-09 09:47:32','2015-12-09 09:47:32',NULL),(4,2,1,4,4,'test 1','menu','2015-12-09 09:48:27','2015-12-09 09:48:27',NULL),(5,1,1,4,5,'test 2','menu','2015-12-09 09:49:45','2015-12-09 09:49:45',NULL);



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
  `contact` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `remarks` text,
  `order_time` varchar(255) DEFAULT NULL,
  `order_till` datetime DEFAULT NULL,
  `order_now` int(11) DEFAULT '0',
  `delivery_fee` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL,
  `status` enum('approved','cancelled','pending') DEFAULT 'pending',
  `note` varchar(5000) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



/*Data for the table `reservations` */



insert  into `reservations`(`id`,`restaurant_id`,`menu_ids`,`prs`,`qtys`,`extras`,`listid`,`subtotal`,`g_total`,`cash_type`,`ordered_by`,`contact`,`payment_mode`,`address1`,`address2`,`city`,`province`,`country`,`postal_code`,`remarks`,`order_time`,`order_till`,`order_now`,`delivery_fee`,`tax`,`order_type`,`status`,`note`,`user_id`) values (1,1,'1','10.00','1','','_1',10,0,1,'Waqar 9','123456789',NULL,NULL,NULL,'Lahore','3',NULL,'54660','afklasjdfklasdjfkla j alksdfj laks','2015-12-16 10:35:28','0000-00-00 00:00:00',0,6,0,'1','pending','',10);



/*Table structure for table `restaurants` */



DROP TABLE IF EXISTS `restaurants`;



CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuisine` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `mobile` varchar(32) DEFAULT NULL,
  `formatted_address` varchar(200) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `province` varchar(5) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(16) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `tags` text,
  `logo` varchar(255) DEFAULT NULL,
  `is_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `is_pickup` tinyint(1) NOT NULL DEFAULT '0',
  `max_delivery_distance` int(10) DEFAULT NULL,
  `delivery_fee` decimal(2,0) DEFAULT NULL,
  `minimum` decimal(2,0) DEFAULT NULL,
  `hours` varchar(100) DEFAULT NULL,
  `days` varchar(150) DEFAULT NULL,
  `holidays` varchar(250) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `open` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `browser_name` varchar(100) DEFAULT NULL,
  `browser_version` varchar(100) DEFAULT NULL,
  `browser_platform` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;



/*Data for the table `restaurants` */



insert  into `restaurants`(`id`,`cuisine`,`name`,`slug`,`email`,`website`,`phone`,`mobile`,`formatted_address`,`address`,`city`,`province`,`country`,`postal_code`,`lat`,`lng`,`description`,`tags`,`logo`,`is_delivery`,`is_pickup`,`max_delivery_distance`,`delivery_fee`,`minimum`,`hours`,`days`,`holidays`,`rating`,`open`,`status`,`ip_address`,`browser_name`,`browser_version`,`browser_platform`) values (1,15,'Chuck\'s Burger Bar','chuck-burger-bar','paulduncanbentley@gmail.com','chucksburgerbar.com','905-525-5682',NULL,'194 Locke St N, Hamilton, ON L8R 3A9','194 Locke St South','Hamilton','7','40','L8P 4B4',43.2535714197085,-79.88452156970851,'My restaurant is great!','','thumb_296.jpg',1,1,10,'6','10',NULL,NULL,NULL,3.5,1,1,NULL,NULL,NULL,NULL),(2,1,'The Harbour Diner','Eat Here','paulduncanbentley@gmail.com','harbourdiner.com','905-525-5682',NULL,'486 James St N, Hamilton, ON L8L 1J1','486 James St N','Hamilton','7','40','L8L 1J1',43.2680583697085,-79.86194006970851,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'10','15',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(3,3,'La Cantina RISTORANTE ITALIANO','Eat Here','paulduncanbentley@gmail.com','lacantinahamilton.ca','905-525-5682',NULL,'60 Walnut St S, Hamilton, ON L8N 2L1','60 Walnut St S','Hamilton','7','40','L8N 2L1',43.2518660197085,-79.86268811970848,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'35','50',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(4,1,'Sarcoa Restaurant and Bar','Eat Here','paulduncanbentley@gmail.com','sarcoa.ca','905-525-5682',NULL,'57 Discovery Dr, Hamilton, ON L8L 8K4','57 Discovery Dr','Hamilton','7','40','L8L 8B4',43.2762030197085,-79.85965001970851,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'30','45',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(5,2,'Purple Pear','Eat Here','paulduncanbentley@gmail.com','','905-525-5682',NULL,'946 Barton St E, Hamilton, ON L8L 3C5','946 Barton St E','Hamilton','7','40','L8L 3C5',43.25172291970849,-79.8219415197085,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'10','20',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(6,4,'Chicago Style Pizza','Eat Here','paulduncanbentley@gmail.com','','905-525-5682',NULL,'534 Upper Sherman Ave, Hamilton, ON L8V 3M1','534 Upper Sherman Ave','Hamilton','7','40','L8V 3M1',43.2307434197085,-79.84617691970851,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'8','10',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(7,5,'The Express Restaurant','Eat Here','paulduncanbentley@gmail.com','expressrestaurant.com','905-525-5682',NULL,'349 Grays Rd, Stoney Creek, ON L8E 2Z1','349 Grays Rd','Stoney Creek','7','40','L8E 2Z1',43.2320673197085,-79.7388205197085,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'8','20',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(8,5,'Kings Buffet','Eat Here','paulduncanbentley@gmail.com','kingsbuffet.com','905-525-5682',NULL,'200 Centennial Pkwy N, Hamilton, ON L8E 4A1','200 Centennial Pkwy N','Hamilton','7','40','L8E 4A2',43.2334947197085,-79.7592514197085,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'13','25',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(9,5,'Shanghai Chinese Food','Eat Here','paulduncanbentley@gmail.com','didueat.ca','905-525-5682',NULL,'856 Lawrence Rd, Hamilton, ON L8K 2A2','856 Lawrence Rd','Hamilton','7','40','L8K 3G9',43.2275946197085,-79.8024814197085,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'7','15',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(10,15,'Parkdale Fish & Chips','Eat Here','paulduncanbentley@gmail.com','parkdalefishandchips.com','905-525-5682',NULL,'55 Parkdale Ave N, Hamilton, ON L8H 5W7','55 Parkdale Ave N','Hamilton','7','40','L8H 7R5',43.2364119197085,-79.7904498197085,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'9','8',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(11,6,'Pho Dau Bo','Eat Here','paulduncanbentley@gmail.com','pho-daubo.ca','905-525-5682',NULL,'800 Queenston Rd #18, Stoney Creek, ON L8G 2N4','800 Queenston Rd #18','Stoney Creek','7','40','L8G 1A7',43.2261835197085,-79.76396721970849,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'6','10',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(12,1,'The Powerhouse','Eat Here','paulduncanbentley@gmail.com','thepowerhouse.ca','905-525-5682',NULL,'21 Jones St, Stoney Creek, ON L8G 3H9','21 Jones St','Stoney Creek','7','40','L8G 3H9',43.2155420197085,-79.75303101970849,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'15','25',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(13,15,'Chuggy&#39;s','Eat-Here13','paulduncanbentley@gmail.com','didueat.ca','905-525-5682',NULL,'388 Barton St, Stoney Creek, ON L8E 2K9','388 Barton St','Stoney Creek','7','40','L8E 2K9',43.22585571970849,-79.71849806970846,'My restaurant is great!',NULL,'thumb_296.jpg',1,1,NULL,'10','20',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(14,1,'Test Restaurant1','test-restaurant1','paulduncanbentley@gmail.com',NULL,'123456',NULL,NULL,'test Address5','Hamilton','7','40','123456',NULL,NULL,'ashdafkjsdh fakjs dhfkja ','test1, test2',NULL,1,1,NULL,'10','99',NULL,NULL,NULL,NULL,1,1,'::1','Google Chrome','46.0.2490.86','Windows 10'),(15,3,'Test Restaurant2','test-restaurant2','skpsoftech+8@gmail.com',NULL,'123456',NULL,NULL,'test Address2','Hamilton','7','40','123456',NULL,NULL,'ajsdklf asjdlf alksdjflka ','test1, test2, test3, test4, test5','test-restaurant2.jpg',1,1,NULL,'10','99',NULL,NULL,NULL,NULL,1,1,'::1','Google Chrome','46.0.2490.86','Windows 10'),(16,4,'Test Restaurant3','restaurant-name3','skpsoftech+9@gmail.com',NULL,'01234',NULL,NULL,'test Address5','Hamilton','10','40','123456',NULL,NULL,'admiasdfnaskjd faskjd fakjs ','11, 222, 3333, 44444','test-restaurant20.jpg',1,1,NULL,'10','19',NULL,NULL,NULL,NULL,1,1,'::1','Google Chrome','46.0.2490.86','Windows 10'),(17,1,'Restaurant Name4','restaurant-name4','skpsoftech+9@gmail.com',NULL,'123456789','123456789','Al Hafeez Shopping Mall, Main Boulevard Gulberg, Lahore, Punjab, Pakistan','321, Main Boulevard Gulberg','Lahore','7','40','54660',31.51404149999999,74.34346949999997,'ajksdf laskdj fakl','test1, test2','restaurant-name3.jpg',1,1,10,'20','99',NULL,NULL,NULL,NULL,1,1,'::1','Google Chrome','47.0.2526.80','Windows 10');



/*Table structure for table `states` */



DROP TABLE IF EXISTS `states`;



CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `abbreviation` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;



/*Data for the table `states` */



insert  into `states`(`id`,`name`,`abbreviation`,`country_id`,`type`,`is_active`) values (1,'Alberta','AB',40,'province','Yes'),(2,'British Columbia','BC',40,'province','Yes'),(3,'Manitoba','MB',40,'province','Yes'),(4,'New Brunswick','NB',40,'province','Yes'),(5,'Newfoundland and Labrador','NL',40,'province','Yes'),(6,'Nova Scotia','NS',40,'province','Yes'),(7,'Ontario','ON',40,'province','Yes'),(8,'Prince Edward Island','PE',40,'province','Yes'),(9,'Quebec','QC',40,'province','Yes'),(10,'Saskatchewan','SK',40,'province','Yes'),(11,'Northwest Territories','NT',40,'province','Yes'),(12,'Yukon','YT',40,'province','Yes');



/*Table structure for table `tags` */



DROP TABLE IF EXISTS `tags`;



CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `is_active` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



/*Data for the table `tags` */



insert  into `tags`(`id`,`name`,`is_active`) values (1,'test1',1),(2,'test2',1),(3,'test3',1),(4,'test4',1),(5,'test5',1);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

