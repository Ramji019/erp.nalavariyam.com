-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: localhost    Database: nalavariyam_out
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `service_payment` varchar(10) DEFAULT NULL,
  `additional_url` varchar(50) DEFAULT NULL,
  `next_url` int DEFAULT NULL,
  `nexts` varchar(100) DEFAULT NULL,
  `from_image` varchar(500) DEFAULT NULL,
  `from_pdf` varchar(200) DEFAULT NULL,
  `download` varchar(5000) DEFAULT NULL,
  `upload` varchar(5000) DEFAULT NULL,
  `submitting_url` varchar(1000) DEFAULT NULL,
  `marge_right` varchar(10) DEFAULT NULL,
  `marge_bottom` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,'புதிய பதிவு','120','edit',1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_81312415200423',NULL,NULL,'1.Upload the filled application form</br>\r\n2.Click \"SUBMIT\"</br>\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION</br>\r\n4.Click the link to apply \"LABOUR IDENTITY CARD\".</br>(நலவாரியம்  அடையாள அட்டை)','https://tnuwwb.tn.gov.in/applications/register','100','120','Active'),(2,'கல்வி உதவித்தொகை 6, 7, 8 & 9 பயிலும் குழந்தைகள்','90','scholarship1',1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_12183916191222',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to Renewal your labour Identity Card.','https://tnuwwb.tn.gov.in/renewalhistories/login','100','90','Active'),(3,'கல்வி உதவித்தொகை 10,11&12 பயிலும் பெண் குழந்தைகள்','120','scholarship2',1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_44423916191222',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply  Educational Scholarship','https://tnuwwb.tn.gov.in/users/login','100','90','Active'),(4,'கல்வி உதவித்தொகை 10 & 12 தேர்ச்சி','120','scholarship3',1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_14583916191222',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply Marriage Welfare Benifits.','https://tnuwwb.tn.gov.in/users/login','100','90','Active'),(5,'உயர்க்கல்வி (பட்டம் மற்றும் பட்ட மேற்படிப்பு)','120','scholarship4',1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_61284016191222',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply Marriage Welfare Benifits.','https://tnuwwb.tn.gov.in/users/login','100','90','Active'),(6,'புதுப்பித்தல் & Updation (Feburary-2024) ','120','renewal',1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/6.pdf',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply MarernityWelfare Benifits.','https://tnuwwb.tn.gov.in/users/login','450','100','Active'),(7,'திருமணம் உதவி தொகை (கட்டுமானம்)','120','naturaldeath',1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_51143615170323',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply NATURAL DEADTH  Welfare BENEFITS.','https://tnuwwb.tn.gov.in/claims/claimlogin/SkcxTnQ5TDd2dk9yMEN0YUxReVhZdz09','100','90','Active'),(8,'திருமணம் உதவி தொகை (உடலுழைப்பு வாரியம்)','120','naturaldeath2',1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_50265015170323',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply NATURAL DEADTH  Welfare BENEFITS.','https://tnuwwb.tn.gov.in/claims/claimlogin/ZFlYRHg3RDFpcmxZZTQrZjZtamdLZz09','100','90','Active'),(11,'திருமணம் உதவி தொகை (ஓட்டுநர் வாரியம்)','120',NULL,1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_53035215170323',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply ACCIDENTIAL DEADTH  Welfare BENEFITS.','https://tnuwwb.tn.gov.in/claims/claimlogin/R3JNY0JNeWF4bWVOSi8yU1JHZXlxZz09','100','90','Active'),(12,'மகபேறு உதவித்தொகை','120',NULL,1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_4038595200323',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply ACCIDENTIAL DEADTH  Welfare BENEFITS.','https://tnuwwb.tn.gov.in/claims/claimlogin/MVF6ME4rUVF2aFJYQm5yTG1TdmZ1UT09','100','90','Active'),(13,'மாத ஓய்வூதியம்','120',NULL,1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_47280116170323',NULL,'1.Dowload The Application Form\r\n2.Fill The Application form correctly (Use only blue ink)\r\n3.Payment.','1.Upload the filled application form\r\n2.Click \"SUBMIT\"\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION\r\n4.Click the link to apply ACCIDENTIAL DEADTH  Welfare BENEFITS.','https://tnuwwb.tn.gov.in/claims/claimlogin/SmNDeldrTTc1VkE5bGM4ZEhRQUlYUT09','450','100','Active'),(14,'இயற்கை மரண நிதி உதவித்தொகை','120',NULL,1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/14.pdf',NULL,'1.Dowload The Application Form</br>\r\n2.Fill The Application form correctly (Use only blue ink)</br>\r\n3.Payment.','1.Upload the filled application form</br>\r\n2.Click \"SUBMIT\"</br>\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION</br>\r\n4.Click the link to apply Monthly Pension  Welfare BENEFITS.','https://tnuwwb.tn.gov.in/claims/claimlogin/K1pLNHNRYzUybnM5NXNNdzNmdnUzUT09','100','100','Inactive'),(16,'கண்கண்ணாடி உதவி தொகை','50',NULL,1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_79354416191222',NULL,'1.Dowload The Application Form</br>\r\n2.Fill The Application form correctly (Use only blue ink)</br>\r\n3.Payment.','1.Upload the filled application form</br>\r\n2.Click \"SUBMIT\"</br>\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION</br>\r\n4.Click the link to apply Monthly Pension  Welfare BENEFITS.','https://tnuwwb.tn.gov.in/claims/claimlogin/M2lQYmxXdi84b0lQaENhQmR3aHc3dz09','100','90','Active'),(17,'குடும்ப ஓய்வூதியம் (கட்டுமானம் மட்டும்)','1',NULL,1,'2','https://nalavariyam.com/apps/assets/upload/fromimg/fom_27144817301122',NULL,'1.Dowload The Application Form</br>\r\n2.Fill The Application form correctly (Use only blue ink)</br>\r\n3.Payment.','1.Upload the filled application form</br>\r\n2.Click \"SUBMIT\"</br>\r\n3.Dowload the \"EMPLOYMENT CERTIFICATE\" from our UNION</br>\r\n4.Click the link to apply Monthly  Family Pension  Welfare Benifits.','https://tnuwwb.tn.gov.in/claims/claimlogin/RGxaUzJFYWdKSUtsTWk3VGI3ZEJWdz09','90','100','Inactive');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-12 13:06:37
