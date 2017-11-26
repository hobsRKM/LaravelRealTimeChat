CREATE DATABASE  IF NOT EXISTS `iprofile_crm` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `iprofile_crm`;
-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: 203.129.219.196    Database: iprofile_crm
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

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
-- Table structure for table `speaker_evaluations`
--

DROP TABLE IF EXISTS `speaker_evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `speaker_evaluations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kol_id` int(11) DEFAULT NULL,
  `evaluator` varchar(255) DEFAULT NULL,
  `evaluator_name` varchar(255) DEFAULT NULL,
  `program_date` date DEFAULT NULL,
  `no_of_attendees` int(11) DEFAULT NULL,
  `speaker_detail` varchar(255) DEFAULT NULL,
  `speaker_name` varchar(255) DEFAULT NULL,
  `speaker_background` varchar(255) DEFAULT NULL,
  `speaker_text` varchar(255) DEFAULT NULL,
  `moderated_program` varchar(255) DEFAULT NULL,
  `venu` varchar(255) DEFAULT NULL,
  `venu_city` varchar(255) DEFAULT NULL,
  `venu_presentation` varchar(255) DEFAULT NULL,
  `venu_presentation_comments` varchar(255) DEFAULT NULL,
  `audio_setup` varchar(255) DEFAULT NULL,
  `audio_setup_comments` varchar(255) DEFAULT NULL,
  `program_topic` varchar(255) DEFAULT NULL,
  `abilify_maintena` varchar(255) DEFAULT NULL,
  `rexulti` varchar(255) DEFAULT NULL,
  `nuedexta` varchar(255) DEFAULT NULL,
  `samsca` varchar(255) DEFAULT NULL,
  `disease_state` varchar(255) DEFAULT NULL,
  `psychu` varchar(255) DEFAULT NULL,
  `topic_presented` varchar(255) DEFAULT NULL,
  `action` tinytext,
  `speaker_stay` varchar(255) DEFAULT NULL,
  `saftey_info` varchar(255) DEFAULT NULL,
  `mirf_other` text,
  `mirf` varchar(255) DEFAULT NULL,
  `adverse_event` varchar(255) DEFAULT NULL,
  `adverse_event_report` varchar(255) DEFAULT NULL,
  `speaker_articulation` varchar(255) DEFAULT NULL,
  `speaker_articulation_comment` text,
  `mirf_doc` varchar(255) DEFAULT NULL,
  `mirf_comment` text,
  `guideline` varchar(255) DEFAULT NULL,
  `scale` varchar(255) DEFAULT NULL,
  `msl_follow_up` varchar(255) DEFAULT NULL,
  `msl_follow_up_comment` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `generic_id` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `speaker_excel_msl` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speaker_evaluations`
--

LOCK TABLES `speaker_evaluations` WRITE;
/*!40000 ALTER TABLE `speaker_evaluations` DISABLE KEYS */;
INSERT INTO `speaker_evaluations` VALUES (1,30308,'MSL','Edwin brewer','2016-02-24',15,'External Speaker','Mark Aaron','Hospital/Inpatient','MSL','No','Out of Office','Nashville tn','Yes','','Yes','','Samsca','','','','Hyponatremia in Heart Failure:  Treating Beyo','','','Yes','Sign in ',NULL,'Yes','No','','No','','Yes','','No','No off label questions ','Yes','4. Likely','No','',151,'0000-00-00 00:00:00','','',0,'',0,'',0,'Edwin brewer'),(2,1201,'MSL','Walter Lawhorn','2016-02-24',20,'External Speaker','Carmen Pinto','Community Clinic/Outpatient','MSL','No','Out of Office','Atlanta GA','Yes','A bit tight and noisy outside the room','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','AM invitation only.',NULL,'Yes','No','','No','','Yes','Coached speaker on appropriate sharing of per','Yes','','Yes','4. Likely','Yes','Speaker has questions about several points an',219,'0000-00-00 00:00:00','','',0,'',0,'',0,'Walter Lawhorn'),(3,906,'MSL','Julleah Johnson','2016-02-23',9,'External Speaker','Steven Kory','Private Practice/Office','MSL','No','Out of Office','Saint Louis, M O','Yes','','Yes','','Nuedexta','','','The Diagnosing and Treatment of PBA','','','','Yes','Sign in sheet, approved invitations with rsvp',NULL,'Yes','No','','No','','Yes','','Yes','No off label questions','Yes','5. Extremely likely','No','',157,'0000-00-00 00:00:00','','',0,'',0,'',0,'Julleah Johnson'),(4,2993,'MSL','Jehan Marino','2016-02-08',5,'External Speaker','Roy Kremberg','Private Practice/Office','MSL','No','Out of Office','New York, NY','Yes','','Yes','','Nuedexta','','','The Diagnosing and Treatment of PBA','','','','Yes','Accoubt Mangager in charge of attendee list',NULL,'Yes','No','','No','','Yes','N/A','Yes','N/A','Yes','4. Likely','No','',143,'0000-00-00 00:00:00','','',0,'',0,'',0,'Jehan Marino'),(5,18901,'MSL','Lisa strouss','2016-02-18',12,'External Speaker','Michelle Barwell','Hospital/Inpatient','MSL','No','Out of Office','Indiana, PA','Yes','','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','AM',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','4. Likely','No','',138,'0000-00-00 00:00:00','','',0,'',0,'',0,'Lisa strouss'),(6,1082,'MSL','Andrew Meyer','2016-02-17',10,'External Speaker','Rifaat El-Mallakh','Academic,Community Clinic/Outpatient','MSL','No','Out of Office','Lexington, KY','Yes','Private, quiet room','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','Account managers invited appropriate individu',NULL,'Yes','No','','No','','Yes','','Yes','All discussion was on label','Yes','5. Extremely likely','No','',12352,'0000-00-00 00:00:00','','',0,'',0,'',0,'Andrew Meyer'),(7,1201,'MSL','Andrew Meyer','2016-02-16',5,'External Speaker','Carmen Pinto','Academic,Private Practice/Office,Community Clinic/Outpatient','MSL','No','Out of Office','Bardstown, KY','Yes','Private room, modest venue. ','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','Orator populated and account manager review. ',NULL,'Yes','No','','No','','Yes','','Yes','No off label discussion. ','Yes','5. Extremely likely','No','Speaker engaged the audience, had a thorough ',12352,'0000-00-00 00:00:00','','',0,'',0,'',0,'Andrew Meyer'),(8,31105,'MSL','Becky Wong','2016-02-10',12,'External Speaker','Askshay Patel','Private Practice/Office,Hospital/Inpatient,Community Clinic/Outpatient','MSL','No','Out of Office','Fair Haven, NJ','Yes','','Yes','','Nuedexta','','','The Diagnosing and Treatment of PBA','','','','Yes','Only registered guests were attending',NULL,'Yes','No','','No','','Yes','Related to personal clinical practice','Yes','','Yes','4. Likely','No','',239,'0000-00-00 00:00:00','','',0,'',0,'',0,'Becky Wong'),(9,1235,'MSL','John Battisti','2016-02-09',3,'External Speaker','Michael Measom, MD (Utah)','Private Practice/Office','MSL','No','Out of Office','Denver, CO','Yes','','Yes','','Abilify Maintena','Beyond Maintenance Therapy: Abilify Maintena ','','','','','','Yes','Sign-in sheet,, AM knew Audience',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','4. Likely','No','',254,'0000-00-00 00:00:00','','',0,'',0,'',0,'John Battisti'),(10,5812,'MSL','','2016-02-09',2,'External Speaker','Pamela Marini, NP','Private Practice/Office,Hospital/Inpatient','MSL','No','Out of Office','Farmington, NY','Yes','','Yes','','Rexulti','','Introducing Rexulti: A New Therapy for Schizo','','','','','Yes','AMs recruited specific attendees and monitore',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','5. Extremely likely','No','',NULL,'0000-00-00 00:00:00','','',0,'',0,'',0,''),(11,1052,'MSL','Gwen Morris','2016-02-10',16,'External Speaker','Suhayl Nasr','Private Practice/Office,Hospital/Inpatient','MSL','No','Out of Office','Fort Wayne, IN','Yes','room was appropriate but when the servers ent','Yes','','Abilify Maintena','Abilify Maintena for Early and Ongoing Treatm','','','','','','Yes','preregistration for program and practice loca',NULL,'Yes','No','','No','','Yes','','Yes','MIRF by MSL with one question around head-to-','Yes','5. Extremely likely','Yes','MSL to support Dr Nasr in any way possible.  ',144,'0000-00-00 00:00:00','','',0,'',0,'',0,'Gwen Morris'),(12,2018,'MSL','Saba Gidey','2016-02-05',27,'External Speaker','John PhilipMiller','Hospital/Inpatient','MSL','No','In Office','Princeton, NJ','Yes','','Yes','','Samsca','','','','Hyponatremia in Heart Failure:  Treating Beyo','','','Yes','Pre-registration',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','5. Extremely likely','No','',238,'0000-00-00 00:00:00','','',0,'',0,'',0,'Saba Gidey'),(13,10659,'MSL','Deidra Couch','2016-01-27',5,'External Speaker','Georgia Stevens','Private Practice/Office','MSL','No','Out of Office','Washington, DC','Yes','','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','Sales driven program. Audience was appropriat',NULL,'Yes','No','','Yes','Yes','Yes','','Yes','','Yes','5. Extremely likely','No','',129,'0000-00-00 00:00:00','','',0,'',0,'',0,'Deidra Couch'),(14,2018,'MSL','bob Pitasi','2016-01-28',15,'External Speaker','John Miller, MD','Community Clinic/Outpatient','MSL','No','Out of Office','Chestnut Hill, MA','Yes','','Yes','','Nuedexta','','','The Diagnosing and Treatment of PBA','','','','Yes','Account managers recruitment and screening',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','5. Extremely likely','No','',137,'0000-00-00 00:00:00','','',0,'',0,'',0,'bob Pitasi'),(15,28163,'MSL','Nicole Meade','2016-01-14',18,'External Speaker','Yadagiri Chepuru','Private Practice/Office','MSL','Yes','Out of Office','Hastings on Hudson','Yes','','Yes','','PsychU','','','','','','Pathophysiology of MDD','Yes','Invites sent to mental health HCPS',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','5. Extremely likely','No','',241,'0000-00-00 00:00:00','','',0,'',0,'',0,'Nicole Meade'),(16,667,'MSL','Carolyn Tyler','2016-01-20',9,'External Speaker','Muhammad Cheema, MD','Private Practice/Office,Hospital/Inpatient','MSL','No','Out of Office','Rochester, NY','Yes','','Yes','','Abilify Maintena','Abilify Maintena: A Treatment Option for Pati','','','','','','Yes','Account manager recruited specific attendees ',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','5. Extremely likely','No','',242,'0000-00-00 00:00:00','','',0,'',0,'',0,'Carolyn Tyler'),(17,946,'MSL','Becky Wong','2016-01-20',16,'External Speaker','Ramon Solhkhah','Academic,Private Practice/Office,Hospital/Inpatient,Community Clinic/Outpatient','MSL','No','In Office','Lakewood, NJ','Yes','','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','Only clinic employees attended',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','5. Extremely likely','No','',239,'0000-00-00 00:00:00','','',0,'',0,'',0,'Becky Wong'),(18,21378,'MSL','Gwen Morris','2016-01-20',10,'External Speaker','Larry Lambertson ','Private Practice/Office,Hospital/Inpatient,Community Clinic/Outpatient','MSL','No','Out of Office','','Yes','','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','Pre-registered',NULL,'Yes','No','','No','','Yes','','Yes','N/A','Yes','5. Extremely likely','No','Quarterly support appropriate for this speake',144,'0000-00-00 00:00:00','','',0,'',0,'',0,'Gwen Morris'),(19,0,'MML','','2000-12-12',5,'MSL Speaker','','Community Clinic/Outpatient','MML','No','In Office','','Yes','','Yes','','Disease State','','','','','','','','',NULL,'','','','','','','','','','','','','',NULL,'0000-00-00 00:00:00','','',0,'',0,'',0,''),(20,0,'MSL','','2000-11-22',5,'External Speaker','','Private Practice/Office','MSL','No','In Office','','No','','No','','Abilify Maintena','','','','','','','','',NULL,'','','','','','','','','','','','','',NULL,'0000-00-00 00:00:00','','',0,'',0,'',0,''),(21,0,'MSL','anea ','2016-01-02',0,'MSL Speaker','','Hospital/Inpatient','MSL','Yes','In Office','','Yes','','Yes','','Disease State','','','','','','','','',NULL,'','','','','','','','','','','','','',12367,'0000-00-00 00:00:00','','',0,'',0,'',0,'anea '),(22,1710,'MSL','Aneta Fornal ','2016-01-20',15,'External Speaker','Linda Lefler ','Community Clinic/Outpatient','MSL','No','In Office','Tampa, FL ','Yes','','Yes','','Nuedexta','','','The Diagnosing and Treatment of PBA','','','','Yes','this was an in-office presentation ',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','1. Extremely unlikely','No','Dr. Lefler did a great job with this presenta',130,'0000-00-00 00:00:00','','',0,'',0,'',0,'Aneta Fornal '),(23,21703,'MSL','Aneta Fornal ','2016-01-13',12,'External Speaker','Hardeep Singh, MD ','Private Practice/Office','MSL','No','In Office','St. Petersburg, FL ','Yes','','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','this was an in-office presentation at local C',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','1. Extremely unlikely','No','dr. Singh did a great job with his Rexulti pr',130,'0000-00-00 00:00:00','','',0,'',0,'',0,'Aneta Fornal '),(24,1052,'MSL','Gwen Morris','2016-01-19',16,'External Speaker','Suhayl Nasr','Private Practice/Office,Hospital/Inpatient','MSL','No','Out of Office','Fort Wayne, IN','Yes','','Yes','','Rexulti','','Introducing Rexulti: A New Adjunctive Therapy','','','','','Yes','Pre-registration',NULL,'Yes','No','','No','','Yes','','Yes','N/a','Yes','5. Extremely likely','No','Quarterly support appropriate',144,'0000-00-00 00:00:00','','',0,'',0,'',0,'Gwen Morris'),(25,32982,'MSL','Becky Wong','2016-01-13',30,'External Speaker','Steven Bromley','Private Practice/Office,Hospital/Inpatient','MSL','No','Out of Office','Cape May, NJ','Yes','','Yes','','Nuedexta','','','The Diagnosing and Treatment of PBA','','','','Yes','Only registered guests attended.',NULL,'Yes','No','','No','','Yes','','Yes','','Yes','5. Extremely likely','No','',239,'0000-00-00 00:00:00','','',0,'',0,'',0,'Becky Wong'),(26,1444,'MSL','Becky Wong','2016-01-13',750,'External Speaker','James McCreath','Hospital/Inpatient','MSL','No','Out of Office','Elizabeth, NJ','Yes','Hub and spoke conducted in the office','Yes','','PsychU','','','','','','A collaborative approach to care coordination','Yes','They had to be registered for webinar linked ',NULL,'Yes','No','','No','','Yes','Unbranded psychu program','Yes','','Yes','5. Extremely likely','No','',239,'0000-00-00 00:00:00','','',0,'',0,'',0,'Becky Wong');
/*!40000 ALTER TABLE `speaker_evaluations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'iprofile_crm'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-28 16:07:08
