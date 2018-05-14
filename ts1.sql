-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: ts1
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ALLY`
--

DROP TABLE IF EXISTS `ALLY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ALLY` (
  `ALY_Id` int(10) unsigned NOT NULL,
  `ALY_Name` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ALY_Id`),
  UNIQUE KEY `ALY_Id_UNIQUE` (`ALY_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Map`
--

DROP TABLE IF EXISTS `Map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Map` (
  `MAP_X` int(11) NOT NULL,
  `MAP_Y` int(11) NOT NULL,
  `MAP_Kind` int(11) DEFAULT NULL,
  `MAP_Pop` int(11) NOT NULL DEFAULT '0',
  `MAP_Tribe` int(11) NOT NULL DEFAULT '0',
  `PLA_Id` int(10) unsigned DEFAULT NULL,
  `ALY_Id` int(10) unsigned DEFAULT NULL,
  UNIQUE KEY `index1` (`MAP_X`,`MAP_Y`),
  KEY `fk_Map_1_idx` (`PLA_Id`),
  KEY `fk_Map_2_idx` (`ALY_Id`),
  CONSTRAINT `fk_Map_1` FOREIGN KEY (`PLA_Id`) REFERENCES `PLAYER` (`PLA_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Map_2` FOREIGN KEY (`ALY_Id`) REFERENCES `ALLY` (`ALY_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Membres`
--

DROP TABLE IF EXISTS `Membres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Membres` (
  `MEM_Date` date NOT NULL,
  `PLA_Id` int(10) unsigned NOT NULL,
  `ALY_Id` int(10) unsigned NOT NULL,
  KEY `fk_Membres_1_idx` (`PLA_Id`),
  KEY `fk_Membres_2_idx` (`ALY_Id`),
  CONSTRAINT `fk_Membres_1` FOREIGN KEY (`PLA_Id`) REFERENCES `PLAYER` (`PLA_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Membres_2` FOREIGN KEY (`ALY_Id`) REFERENCES `ALLY` (`ALY_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PLAYER`
--

DROP TABLE IF EXISTS `PLAYER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PLAYER` (
  `PLA_Id` int(10) unsigned NOT NULL,
  `PLA_Name` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `PLA_Tribe` int(11) DEFAULT NULL,
  PRIMARY KEY (`PLA_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Pop`
--

DROP TABLE IF EXISTS `Pop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pop` (
  `POP_Date` datetime NOT NULL,
  `VIL_Id` int(10) unsigned NOT NULL,
  `PLA_Id` int(10) unsigned NOT NULL,
  `POP_Nb` int(10) unsigned NOT NULL,
  KEY `fk_Pop_1_idx` (`VIL_Id`),
  KEY `fk_Pop_2_idx` (`PLA_Id`),
  CONSTRAINT `fk_Pop_1` FOREIGN KEY (`VIL_Id`) REFERENCES `VILLAGE` (`VIL_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pop_2` FOREIGN KEY (`PLA_Id`) REFERENCES `PLAYER` (`PLA_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `VILLAGE`
--

DROP TABLE IF EXISTS `VILLAGE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `VILLAGE` (
  `VIL_Id` int(10) unsigned NOT NULL,
  `VIL_Name` varchar(64) COLLATE utf8_bin NOT NULL,
  `VIL_X` int(11) NOT NULL,
  `VIL_Y` int(11) NOT NULL,
  PRIMARY KEY (`VIL_Id`),
  UNIQUE KEY `VIL_Id_UNIQUE` (`VIL_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `x_world`
--

DROP TABLE IF EXISTS `x_world`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `x_world` (
  `id` int(9) unsigned NOT NULL DEFAULT '0',
  `x` smallint(3) NOT NULL DEFAULT '0',
  `y` smallint(3) NOT NULL DEFAULT '0',
  `tid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vid` int(9) unsigned NOT NULL DEFAULT '0',
  `village` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `uid` int(9) NOT NULL DEFAULT '0',
  `player` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `aid` int(9) unsigned NOT NULL DEFAULT '0',
  `alliance` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `population` smallint(5) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'ts1'
--

--
-- Dumping routines for database 'ts1'
--
/*!50003 DROP PROCEDURE IF EXISTS `Reset_Tables` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Reset_Tables`()
BEGIN

truncate table Membres;
truncate table Pop;
truncate table Map;
truncate table x_world;
delete from ALLY where ALY_Id<99999;
delete from PLAYER where PLA_Id<99999;
delete from VILLAGE where VIL_Id<99999;


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Update_Data` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_Data`()
BEGIN

# Ajout des nouvelles alliances
insert into ALLY (ALY_Id, ALY_Name)
select  x.aid, x.alliance from x_world x where x.aid not in
(select a.ALY_id from ALLY a) group by x.aid;

#Ajout des nouveaux joueurs
insert into PLAYER (PLA_Id, PLA_Name, PLA_Tribe)
select x.uid,x.player,x.tid from x_world x where x.uid not in
(select p.PLA_id from PLAYER p) group by x.uid;

#Ajout des nouveaux villages
insert into VILLAGE (VIL_Id, VIL_Name, VIL_X, VIL_Y)
select x.vid,x.village,x.x,x.y from x_world x where x.vid not in
(select v.VIL_id from VILLAGE v) group by x.vid;

# Au cas où le joueur a changé le nom du village
update VILLAGE v, x_world x
set v.VIL_Name=x.village
where v.VIL_Id=x.vid;

# MAJ de la population des vivis
insert into Pop (POP_Date, VIL_Id, PLA_Id, POP_Nb)
select now(), x.vid, x.uid, x.population from x_world x where x.vid not in
(select p.VIL_Id from Pop p where p.VIL_Id=x.vid and p.PLA_Id=x.uid and p.POP_Nb=x.population);

# Cas où le village est détruit/effacé : On met sa pop à 0
insert into Pop (POP_Date, VIL_Id, PLA_Id, POP_Nb)
select now(),v.VIL_Id, p.PLA_Id,0 from VILLAGE v,
(select max(POP_Date) as POP_date, VIL_Id, PLA_Id from Pop group by VIL_Id) p
where v.VIL_Id not in (select x.vid from x_world x) and p.VIL_Id=v.VIL_Id;

# MAJ des liens entre les joueurs et les alliances
insert into Membres (MEM_Date, PLA_Id, ALY_Id)
select now(), x.uid, x.aid from x_world x where x.uid not in
(select m.PLA_Id from Membres m where m.PLA_Id=x.uid and m.ALY_Id=x.aid group by m.PLA_ID,m.ALY_Id)
group by x.uid;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Update_Data_Date` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_Data_Date`(DATE_INSERT date)
BEGIN

# Ajout des nouvelles alliances
insert into ALLY (ALY_Id, ALY_Name)
select  x.aid, x.alliance from x_world x where x.aid not in
(select a.ALY_id from ALLY a) group by x.aid, x.alliance;

#Ajout des nouveaux joueurs
insert into PLAYER (PLA_Id, PLA_Name, PLA_Tribe)
select x.uid,x.player,x.tid from x_world x where x.uid not in
(select p.PLA_id from PLAYER p) group by x.uid,x.player,x.tid;

#Ajout des nouveaux villages
insert into VILLAGE (VIL_Id, VIL_Name, VIL_X, VIL_Y)
select x.vid,x.village,x.x,x.y from x_world x where x.vid not in
(select v.VIL_id from VILLAGE v) group by x.vid,x.village,x.x,x.y;

UPDATE VILLAGE v,
    x_world x 
SET 
    v.VIL_Name = x.village
WHERE
    v.VIL_Id = x.vid;

# MAJ de la population des vivis
insert into Pop (POP_Date, VIL_Id, PLA_Id, POP_Nb)
select DATE_INSERT, x.vid, x.uid, x.population from x_world x; /*where x.vid not in
(select p.VIL_Id from Pop p where p.VIL_Id=x.vid and p.PLA_Id=x.uid and p.POP_Nb=x.population);*/

# Cas où le village est détruit/effacé : On met sa pop à 0
insert into Pop (POP_Date, VIL_Id, PLA_Id, POP_Nb)
select now(),v.VIL_Id, p.PLA_Id,0 from VILLAGE v,
(select max(POP_Date) as POP_date, VIL_Id, PLA_Id from Pop group by VIL_Id) p
where v.VIL_Id not in (select x.vid from x_world x) and p.VIL_Id=v.VIL_Id;

# MAJ des liens entre les joueurs et les alliances
insert into Membres (MEM_Date, PLA_Id, ALY_Id)
select now(), x.uid, x.aid from x_world x where x.uid not in
(select m.PLA_Id from Membres m where m.PLA_Id=x.uid and m.ALY_Id=x.aid group by m.PLA_ID,m.ALY_Id)
group by x.uid;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-14 17:44:38
