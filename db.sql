-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table networking.live_stat
CREATE TABLE IF NOT EXISTS `live_stat` (
  `datetime` datetime NOT NULL,
  `rx` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `tx` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `interface` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table networking.live_stat: ~187 rows (approximately)
REPLACE INTO `live_stat` (`datetime`, `rx`, `tx`, `interface`) VALUES
	('2023-03-24 04:15:43', '1959176', '105824', 'INTERNET'),
	('2023-03-24 04:16:01', '14113256', '529704', 'INTERNET'),
	('2023-03-24 04:17:00', '3660992', '219736', 'INTERNET'),
	('2023-03-24 04:18:01', '1777440', '69360', 'INTERNET'),
	('2023-03-24 04:19:00', '1168624', '45880', 'INTERNET'),
	('2023-03-24 04:20:01', '1818784', '54712', 'INTERNET'),
	('2023-03-24 04:21:00', '1417664', '70192', 'INTERNET'),
	('2023-03-24 04:21:40', '1231952', '71856', 'INTERNET'),
	('2023-03-24 04:21:45', '4193152', '172584', 'INTERNET'),
	('2023-03-24 04:21:51', '4762048', '201112', 'INTERNET'),
	('2023-03-24 04:21:56', '1439232', '55976', 'INTERNET'),
	('2023-03-24 04:22:01', '1854904', '98408', 'INTERNET'),
	('2023-03-24 04:22:02', '1803160', '115968', 'INTERNET'),
	('2023-03-24 04:22:07', '3569600', '172712', 'INTERNET'),
	('2023-03-24 04:22:12', '2235104', '113208', 'INTERNET'),
	('2023-03-24 04:22:18', '6386504', '353520', 'INTERNET'),
	('2023-03-24 04:22:23', '3215600', '133520', 'INTERNET'),
	('2023-03-24 04:22:28', '1881472', '100416', 'INTERNET'),
	('2023-03-24 04:22:33', '4045760', '173224', 'INTERNET'),
	('2023-03-24 04:22:39', '4420048', '234360', 'INTERNET'),
	('2023-03-24 04:22:44', '1549272', '78848', 'INTERNET'),
	('2023-03-24 04:22:49', '1949728', '104072', 'INTERNET'),
	('2023-03-24 04:22:54', '2165488', '162024', 'INTERNET'),
	('2023-03-24 04:23:00', '11049976', '393624', 'INTERNET'),
	('2023-03-24 04:23:05', '2607976', '121240', 'INTERNET'),
	('2023-03-24 04:23:10', '2819488', '168176', 'INTERNET'),
	('2023-03-24 04:23:15', '2143944', '87280', 'INTERNET'),
	('2023-03-24 04:23:21', '2183008', '97272', 'INTERNET'),
	('2023-03-24 04:23:26', '2684488', '171608', 'INTERNET'),
	('2023-03-24 04:23:31', '3438208', '182368', 'INTERNET'),
	('2023-03-24 04:23:36', '1623320', '78856', 'INTERNET'),
	('2023-03-24 04:23:41', '5201928', '255264', 'INTERNET'),
	('2023-03-24 04:23:47', '1664256', '105168', 'INTERNET'),
	('2023-03-24 04:23:52', '3457424', '234224', 'INTERNET'),
	('2023-03-24 04:23:57', '1660696', '187208', 'INTERNET'),
	('2023-03-24 04:24:03', '3265688', '166232', 'INTERNET'),
	('2023-03-24 04:24:08', '6382688', '189672', 'INTERNET'),
	('2023-03-24 04:24:13', '3558560', '200616', 'INTERNET'),
	('2023-03-24 04:24:18', '4611800', '267456', 'INTERNET'),
	('2023-03-24 04:24:24', '5902584', '285528', 'INTERNET'),
	('2023-03-24 04:24:29', '8524544', '339896', 'INTERNET'),
	('2023-03-24 04:24:34', '12655928', '362704', 'INTERNET'),
	('2023-03-24 04:24:39', '3539904', '121424', 'INTERNET'),
	('2023-03-24 04:24:44', '3636776', '115088', 'INTERNET'),
	('2023-03-24 04:24:50', '11473400', '444456', 'INTERNET'),
	('2023-03-24 04:24:55', '2054856', '110672', 'INTERNET'),
	('2023-03-24 04:25:00', '539960', '33400', 'INTERNET'),
	('2023-03-24 04:25:05', '3922520', '265512', 'INTERNET'),
	('2023-03-24 04:25:11', '1951320', '59784', 'INTERNET'),
	('2023-03-24 04:25:16', '5981016', '209072', 'INTERNET'),
	('2023-03-24 04:25:21', '4344984', '211304', 'INTERNET'),
	('2023-03-24 04:25:26', '1325624', '133112', 'INTERNET'),
	('2023-03-24 04:25:31', '725976', '93232', 'INTERNET'),
	('2023-03-24 04:25:37', '2926232', '327872', 'INTERNET'),
	('2023-03-24 04:25:42', '5600032', '329656', 'INTERNET'),
	('2023-03-24 04:25:47', '2176136', '299104', 'INTERNET'),
	('2023-03-24 04:25:53', '6764856', '480008', 'INTERNET'),
	('2023-03-24 04:25:58', '4913408', '384968', 'INTERNET'),
	('2023-03-24 04:26:03', '1840640', '151368', 'INTERNET'),
	('2023-03-24 04:26:08', '2281432', '260608', 'INTERNET'),
	('2023-03-24 04:26:14', '8216528', '424848', 'INTERNET'),
	('2023-03-24 04:26:19', '9914952', '463936', 'INTERNET'),
	('2023-03-24 04:26:24', '13582416', '240616', 'INTERNET'),
	('2023-03-24 04:26:29', '10865584', '298576', 'INTERNET'),
	('2023-03-24 04:26:34', '2982400', '169360', 'INTERNET'),
	('2023-03-24 04:26:40', '1843312', '82920', 'INTERNET'),
	('2023-03-24 04:26:45', '3263608', '160040', 'INTERNET'),
	('2023-03-24 04:26:50', '2780944', '133416', 'INTERNET'),
	('2023-03-24 04:26:55', '4956104', '325496', 'INTERNET'),
	('2023-03-24 04:27:01', '4559744', '210424', 'INTERNET'),
	('2023-03-24 04:27:06', '3414216', '399216', 'INTERNET'),
	('2023-03-24 04:27:11', '2614320', '378152', 'INTERNET'),
	('2023-03-24 04:27:17', '9250672', '430128', 'INTERNET'),
	('2023-03-24 04:27:22', '15054600', '494928', 'INTERNET'),
	('2023-03-24 04:27:27', '3390096', '225192', 'INTERNET'),
	('2023-03-24 04:27:33', '2134656', '120024', 'INTERNET'),
	('2023-03-24 04:27:38', '2261960', '145416', 'INTERNET'),
	('2023-03-24 04:27:43', '16084720', '462504', 'INTERNET'),
	('2023-03-24 04:27:48', '2580728', '250048', 'INTERNET'),
	('2023-03-24 04:27:54', '2963384', '133216', 'INTERNET'),
	('2023-03-24 04:27:59', '4574192', '745952', 'INTERNET'),
	('2023-03-24 04:28:04', '2555424', '135672', 'INTERNET'),
	('2023-03-24 04:28:09', '6077168', '361272', 'INTERNET'),
	('2023-03-24 04:28:15', '5480088', '272696', 'INTERNET'),
	('2023-03-24 04:28:20', '13835656', '638880', 'INTERNET'),
	('2023-03-24 04:28:25', '7727432', '343704', 'INTERNET'),
	('2023-03-24 04:28:30', '2917064', '228104', 'INTERNET'),
	('2023-03-24 04:28:36', '3808144', '185640', 'INTERNET'),
	('2023-03-24 04:28:41', '4475808', '190832', 'INTERNET'),
	('2023-03-24 04:28:46', '2456112', '149392', 'INTERNET'),
	('2023-03-24 04:28:51', '3702192', '168584', 'INTERNET'),
	('2023-03-24 04:28:57', '6457000', '337512', 'INTERNET'),
	('2023-03-24 04:29:02', '3885120', '179544', 'INTERNET'),
	('2023-03-24 04:29:07', '6813752', '664896', 'INTERNET'),
	('2023-03-24 04:29:13', '3654632', '222800', 'INTERNET'),
	('2023-03-24 04:29:18', '4396400', '247096', 'INTERNET'),
	('2023-03-24 04:29:23', '3756800', '195816', 'INTERNET'),
	('2023-03-24 04:29:28', '3613480', '178144', 'INTERNET'),
	('2023-03-24 04:29:34', '2061168', '213176', 'INTERNET'),
	('2023-03-24 04:29:39', '5749688', '337168', 'INTERNET'),
	('2023-03-24 04:29:44', '2902504', '166952', 'INTERNET'),
	('2023-03-24 04:29:49', '3594768', '244008', 'INTERNET'),
	('2023-03-24 04:29:55', '2028128', '192144', 'INTERNET'),
	('2023-03-24 04:30:00', '3290816', '164480', 'INTERNET'),
	('2023-03-24 04:30:05', '3045296', '301616', 'INTERNET'),
	('2023-03-24 04:30:10', '2739408', '147576', 'INTERNET'),
	('2023-03-24 04:30:15', '1329680', '53960', 'INTERNET'),
	('2023-03-24 04:30:21', '2255184', '140344', 'INTERNET'),
	('2023-03-24 04:30:26', '5630368', '187888', 'INTERNET'),
	('2023-03-24 04:30:31', '3068016', '245832', 'INTERNET'),
	('2023-03-24 04:30:36', '1936096', '95064', 'INTERNET'),
	('2023-03-24 04:30:42', '1219384', '117704', 'INTERNET'),
	('2023-03-24 04:30:47', '4470152', '196648', 'INTERNET'),
	('2023-03-24 04:30:52', '1582584', '95584', 'INTERNET'),
	('2023-03-24 04:30:57', '3563968', '265168', 'INTERNET'),
	('2023-03-24 04:31:03', '2471280', '159224', 'INTERNET'),
	('2023-03-24 04:31:08', '5795840', '259048', 'INTERNET'),
	('2023-03-24 04:31:13', '4421800', '250560', 'INTERNET'),
	('2023-03-24 04:31:18', '4047632', '213744', 'INTERNET'),
	('2023-03-24 04:31:23', '4610272', '200368', 'INTERNET'),
	('2023-03-24 04:31:29', '5730080', '276728', 'INTERNET'),
	('2023-03-24 04:31:34', '14934008', '432392', 'INTERNET'),
	('2023-03-24 04:31:39', '1751424', '205376', 'INTERNET'),
	('2023-03-24 04:31:44', '1924312', '79512', 'INTERNET'),
	('2023-03-24 04:31:50', '4433592', '394024', 'INTERNET'),
	('2023-03-24 04:31:55', '4979184', '349416', 'INTERNET'),
	('2023-03-24 04:32:00', '4281384', '217552', 'INTERNET'),
	('2023-03-24 04:32:05', '5063792', '246008', 'INTERNET'),
	('2023-03-24 04:32:10', '1438760', '46256', 'INTERNET'),
	('2023-03-24 04:32:16', '2321792', '89448', 'INTERNET'),
	('2023-03-24 04:32:21', '6019424', '313656', 'INTERNET'),
	('2023-03-24 04:32:26', '3432432', '142312', 'INTERNET'),
	('2023-03-24 04:32:31', '4941424', '273120', 'INTERNET'),
	('2023-03-24 04:32:37', '2865888', '150112', 'INTERNET'),
	('2023-03-24 04:32:42', '1669208', '130560', 'INTERNET'),
	('2023-03-24 04:32:47', '3477160', '173136', 'INTERNET'),
	('2023-03-24 04:32:52', '3291176', '305048', 'INTERNET'),
	('2023-03-24 04:32:58', '1316040', '38128', 'INTERNET'),
	('2023-03-24 04:33:03', '8849792', '453984', 'INTERNET'),
	('2023-03-24 04:33:08', '16223624', '495840', 'INTERNET'),
	('2023-03-24 04:33:13', '1996096', '102000', 'INTERNET'),
	('2023-03-24 04:33:18', '2081992', '82816', 'INTERNET'),
	('2023-03-24 04:33:24', '2942608', '115272', 'INTERNET'),
	('2023-03-24 04:33:29', '1785088', '68104', 'INTERNET'),
	('2023-03-24 04:33:34', '3756520', '310824', 'INTERNET'),
	('2023-03-24 04:33:39', '6707960', '277704', 'INTERNET'),
	('2023-03-24 04:33:45', '1932760', '62752', 'INTERNET'),
	('2023-03-24 04:33:50', '1127752', '264760', 'INTERNET'),
	('2023-03-24 04:33:55', '4627344', '267320', 'INTERNET'),
	('2023-03-24 04:34:00', '6279864', '158392', 'INTERNET'),
	('2023-03-24 04:34:06', '1189016', '128864', 'INTERNET'),
	('2023-03-24 04:34:11', '2632960', '339344', 'INTERNET'),
	('2023-03-24 04:34:16', '1754952', '291904', 'INTERNET'),
	('2023-03-24 04:34:21', '1986464', '75168', 'INTERNET'),
	('2023-03-24 04:34:27', '1344064', '55992', 'INTERNET'),
	('2023-03-24 04:34:32', '2952280', '252336', 'INTERNET'),
	('2023-03-24 04:34:37', '1993360', '94928', 'INTERNET'),
	('2023-03-24 04:34:42', '4009720', '143144', 'INTERNET'),
	('2023-03-24 04:34:47', '2404936', '94824', 'INTERNET'),
	('2023-03-24 04:34:53', '2383528', '109200', 'INTERNET'),
	('2023-03-24 04:34:58', '1599088', '113928', 'INTERNET'),
	('2023-03-24 04:35:03', '2120880', '144336', 'INTERNET'),
	('2023-03-24 04:35:09', '2795848', '189968', 'INTERNET'),
	('2023-03-24 04:35:14', '3435184', '251472', 'INTERNET'),
	('2023-03-24 04:35:19', '4205968', '208384', 'INTERNET'),
	('2023-03-24 04:35:24', '3985888', '1969368', 'INTERNET'),
	('2023-03-24 04:35:29', '3973024', '659568', 'INTERNET'),
	('2023-03-24 04:35:35', '15916192', '408800', 'INTERNET'),
	('2023-03-24 04:35:40', '11370200', '470400', 'INTERNET'),
	('2023-03-24 04:35:45', '10694040', '441528', 'INTERNET'),
	('2023-03-24 04:35:50', '11057936', '396120', 'INTERNET'),
	('2023-03-24 04:35:56', '13631864', '413320', 'INTERNET'),
	('2023-03-24 04:36:01', '15482880', '300328', 'INTERNET'),
	('2023-03-24 04:36:06', '18261032', '454352', 'INTERNET'),
	('2023-03-24 04:36:11', '9753520', '321560', 'INTERNET'),
	('2023-03-24 04:36:17', '12402424', '463320', 'INTERNET'),
	('2023-03-24 04:36:22', '12996584', '335896', 'INTERNET'),
	('2023-03-24 04:36:27', '9309264', '344048', 'INTERNET'),
	('2023-03-24 04:36:32', '4199392', '156872', 'INTERNET'),
	('2023-03-24 04:36:37', '7080576', '180344', 'INTERNET'),
	('2023-03-24 04:36:43', '8319736', '205128', 'INTERNET'),
	('2023-03-24 04:36:48', '13191208', '337440', 'INTERNET'),
	('2023-03-24 04:36:53', '9007344', '160976', 'INTERNET'),
	('2023-03-24 04:36:58', '6251472', '242640', 'INTERNET'),
	('2023-03-24 04:37:03', '8966824', '381112', 'INTERNET'),
	('2023-03-24 04:37:09', '6012088', '138248', 'INTERNET'),
	('2023-03-24 04:37:14', '8174008', '240896', 'INTERNET'),
	('2023-03-24 04:37:19', '7490280', '312480', 'INTERNET'),
	('2023-03-24 04:37:25', '5378472', '257168', 'INTERNET'),
	('2023-03-24 04:37:30', '5017752', '140080', 'INTERNET'),
	('2023-03-24 04:37:35', '8632800', '233536', 'INTERNET'),
	('2023-03-24 04:37:40', '8383848', '168896', 'INTERNET'),
	('2023-03-24 04:37:45', '2141152', '269432', 'INTERNET'),
	('2023-03-24 04:37:51', '6353128', '549968', 'INTERNET'),
	('2023-03-24 04:37:56', '4626688', '260624', 'INTERNET'),
	('2023-03-24 04:38:01', '5076256', '515592', 'INTERNET'),
	('2023-03-24 04:38:06', '15854464', '468936', 'INTERNET'),
	('2023-03-24 04:38:12', '14675568', '392128', 'INTERNET'),
	('2023-03-24 04:38:17', '3550480', '133696', 'INTERNET'),
	('2023-03-24 04:38:22', '12833520', '346784', 'INTERNET'),
	('2023-03-24 04:38:28', '13626256', '372320', 'INTERNET'),
	('2023-03-24 04:38:33', '3507344', '113952', 'INTERNET'),
	('2023-03-24 04:38:38', '7674944', '389680', 'INTERNET'),
	('2023-03-24 04:38:43', '6880832', '289568', 'INTERNET'),
	('2023-03-24 04:38:49', '4228848', '177376', 'INTERNET'),
	('2023-03-24 04:38:54', '9439520', '308992', 'INTERNET');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
