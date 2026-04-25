-- phpMyAdmin SQL Dump
-- منصة أمان للرعاية الصحية المنزلية
-- Aman Platform - Home Healthcare System
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2026

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+03:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aman`
--
CREATE DATABASE IF NOT EXISTS `aman` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `aman`;

-- --------------------------------------------------------

--
-- جدول المدير - Table structure for table `admin`
--
DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL,
  `aname` varchar(255) DEFAULT 'مدير النظام',
  PRIMARY KEY (`aemail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin` (`aemail`, `apassword`, `aname`) VALUES
('admin@aman.com', '123', 'مدير النظام');

-- --------------------------------------------------------

--
-- جدول مزودي الخدمات (الأطباء/الممرضين/الأخصائيين)
-- Table structure for table `doctor`
--
DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `docid` int(11) NOT NULL AUTO_INCREMENT,
  `docemail` varchar(255) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  `docpassword` varchar(255) DEFAULT NULL,
  `docnic` varchar(15) DEFAULT NULL,
  `doctel` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `experience_years` int(3) DEFAULT 0,
  `rating` decimal(3,2) DEFAULT 0.00,
  `location` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `status` enum('نشط','غير نشط','معلق') DEFAULT 'نشط',
  PRIMARY KEY (`docid`),
  KEY `specialties` (`specialties`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `doctor` (`docid`, `docemail`, `docname`, `docpassword`, `docnic`, `doctel`, `specialties`, `license_number`, `experience_years`, `rating`, `location`, `bio`, `status`) VALUES
(1, 'nurse@aman.com', 'سارة أحمد', '123', '000000000', '0771234567', 1, 'LIC-001', 5, 4.80, 'صنعاء - حدة', 'ممرضة متخصصة في الرعاية المنزلية مع خبرة 5 سنوات', 'نشط'),
(2, 'therapist@aman.com', 'محمد علي', '123', '111111111', '0772345678', 2, 'LIC-002', 8, 4.50, 'صنعاء - الزبيري', 'أخصائي علاج طبيعي معتمد', 'نشط'),
(3, 'doctor@aman.com', 'د. خالد حسن', '123', '222222222', '0773456789', 5, 'LIC-003', 12, 4.90, 'صنعاء - التحرير', 'طبيب استشاري في الرعاية المنزلية', 'نشط');

-- --------------------------------------------------------

--
-- جدول المرضى/المستفيدين
-- Table structure for table `patient`
--
DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pnic` varchar(15) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `ptel` varchar(15) DEFAULT NULL,
  `plocation` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `emergency_phone` varchar(15) DEFAULT NULL,
  `health_condition` text DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `patient` (`pid`, `pemail`, `pname`, `ppassword`, `paddress`, `pnic`, `pdob`, `ptel`, `plocation`, `emergency_contact`, `emergency_phone`, `health_condition`) VALUES
(1, 'patient@aman.com', 'أحمد محمد', '123', 'صنعاء - شارع الزبيري', '0000000000', '1985-03-15', '0779876543', 'صنعاء', 'علي محمد', '0771111111', 'مريض سكري - يحتاج متابعة دورية'),
(2, 'fatima@aman.com', 'فاطمة عبدالله', '123', 'صنعاء - حدة', '1111111111', '1990-07-22', '0778765432', 'صنعاء', 'سعيد عبدالله', '0772222222', 'نفاس - تحتاج رعاية منزلية');

-- --------------------------------------------------------

--
-- جدول الخدمات (بدلاً من التخصصات)
-- Table structure for table `specialties`
--
DROP TABLE IF EXISTS `specialties`;
CREATE TABLE IF NOT EXISTS `specialties` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `sname` varchar(100) DEFAULT NULL,
  `sdescription` text DEFAULT NULL,
  `sprice_range` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `specialties` (`id`, `sname`, `sdescription`, `sprice_range`) VALUES
(1, 'تمريض منزلي', 'خدمات التمريض العامة في المنزل: حقن، تضميد، قياس ضغط وسكر', '5000 - 15000 ر.ي'),
(2, 'علاج طبيعي', 'جلسات علاج طبيعي وتأهيل في المنزل', '8000 - 20000 ر.ي'),
(3, 'رعاية كبار السن', 'رعاية شاملة لكبار السن: مراقبة صحية، مساعدة يومية', '10000 - 25000 ر.ي'),
(4, 'رعاية ما بعد العمليات', 'متابعة ورعاية المرضى بعد العمليات الجراحية', '12000 - 30000 ر.ي'),
(5, 'استشارات طبية منزلية', 'زيارة طبيب استشاري للمنزل', '15000 - 35000 ر.ي'),
(6, 'رعاية الأمومة والنفاس', 'رعاية الأمهات في فترة النفاس والمواليد الجدد', '8000 - 20000 ر.ي'),
(7, 'تحاليل وفحوصات منزلية', 'سحب عينات وإجراء فحوصات في المنزل', '3000 - 10000 ر.ي'),
(8, 'رعاية الأمراض المزمنة', 'متابعة مرضى السكري والضغط والقلب', '7000 - 18000 ر.ي');

-- --------------------------------------------------------

--
-- جدول الجدول الزمني / الجلسات
-- Table structure for table `schedule`
--
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `scheduleid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `service_type` int(2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `schedule_status` enum('متاح','محجوز','مكتمل','ملغي') DEFAULT 'متاح',
  PRIMARY KEY (`scheduleid`),
  KEY `docid` (`docid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `schedule` (`scheduleid`, `docid`, `title`, `scheduledate`, `scheduletime`, `nop`, `location`, `service_type`, `price`, `schedule_status`) VALUES
(1, '1', 'جلسة تمريض منزلي', '2026-05-01', '09:00:00', 5, 'صنعاء - حدة', 1, 10000.00, 'متاح'),
(2, '2', 'جلسة علاج طبيعي', '2026-05-01', '14:00:00', 3, 'صنعاء - الزبيري', 2, 15000.00, 'متاح'),
(3, '3', 'استشارة طبية منزلية', '2026-05-02', '10:00:00', 4, 'صنعاء - التحرير', 5, 20000.00, 'متاح');

-- --------------------------------------------------------

--
-- جدول الحجوزات (المواعيد)
-- Table structure for table `appointment`
--
DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `appoid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  `app_status` enum('معلق','مؤكد','مكتمل','ملغي') DEFAULT 'معلق',
  `notes` text DEFAULT NULL,
  `patient_location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`appoid`),
  KEY `pid` (`pid`),
  KEY `scheduleid` (`scheduleid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `appointment` (`appoid`, `pid`, `apponum`, `scheduleid`, `appodate`, `app_status`, `notes`, `patient_location`) VALUES
(1, 1, 1, 1, '2026-05-01', 'مؤكد', 'مريض سكري يحتاج فحص دوري', 'صنعاء - شارع الزبيري');

-- --------------------------------------------------------

--
-- جدول التقييمات والمراجعات - NEW
-- Table structure for table `reviews`
--
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `docid` int(10) DEFAULT NULL,
  `appoid` int(10) DEFAULT NULL,
  `rating` int(1) DEFAULT 5,
  `comment` text DEFAULT NULL,
  `review_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `pid` (`pid`),
  KEY `docid` (`docid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reviews` (`review_id`, `pid`, `docid`, `appoid`, `rating`, `comment`, `review_date`) VALUES
(1, 1, 1, 1, 5, 'خدمة ممتازة ومهنية عالية. شكراً لمنصة أمان', '2026-04-15 10:30:00');

-- --------------------------------------------------------

--
-- جدول المدفوعات - NEW
-- Table structure for table `payments`
--
DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `appoid` int(10) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `payment_method` enum('نقدي','إلكتروني','تحويل بنكي') DEFAULT 'نقدي',
  `payment_status` enum('معلق','مكتمل','مرفوض','مسترد') DEFAULT 'معلق',
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `transaction_ref` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `appoid` (`appoid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `payments` (`payment_id`, `appoid`, `amount`, `payment_method`, `payment_status`, `payment_date`) VALUES
(1, 1, 10000.00, 'نقدي', 'مكتمل', '2026-04-15 11:00:00');

-- --------------------------------------------------------

--
-- جدول السجلات الطبية - NEW
-- Table structure for table `medical_records`
--
DROP TABLE IF EXISTS `medical_records`;
CREATE TABLE IF NOT EXISTS `medical_records` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `docid` int(10) DEFAULT NULL,
  `appoid` int(10) DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `record_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`record_id`),
  KEY `pid` (`pid`),
  KEY `docid` (`docid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `medical_records` (`record_id`, `pid`, `docid`, `appoid`, `diagnosis`, `prescription`, `notes`, `record_date`) VALUES
(1, 1, 1, 1, 'مستوى السكر 180 - يحتاج متابعة', 'جلوكوفاج 500 مرتين يومياً', 'ينصح بفحص دوري كل أسبوعين', '2026-04-15 10:00:00');

-- --------------------------------------------------------

--
-- جدول الإشعارات - NEW
-- Table structure for table `notifications`
--
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notif_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `notif_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `notif_type` enum('حجز','تذكير','تقييم','نظام') DEFAULT 'نظام',
  PRIMARY KEY (`notif_id`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notifications` (`notif_id`, `user_email`, `title`, `message`, `is_read`, `notif_date`, `notif_type`) VALUES
(1, 'patient@aman.com', 'تم تأكيد حجزك', 'تم تأكيد حجز جلسة التمريض المنزلي بتاريخ 2026-05-01', 0, '2026-04-15 10:30:00', 'حجز');

-- --------------------------------------------------------

--
-- جدول المستخدمين
-- Table structure for table `webuser`
--
DROP TABLE IF EXISTS `webuser`;
CREATE TABLE IF NOT EXISTS `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@aman.com', 'a'),
('nurse@aman.com', 'd'),
('therapist@aman.com', 'd'),
('doctor@aman.com', 'd'),
('patient@aman.com', 'p'),
('fatima@aman.com', 'p');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
