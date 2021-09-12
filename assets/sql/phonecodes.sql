-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 13, 2021 at 07:55 AM
-- Server version: 10.3.22-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adb`
--

-- --------------------------------------------------------

--
-- Table structure for table `phonecodes`
--

CREATE TABLE `phonecodes` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `main_name` varchar(80) NOT NULL,
  `country_name` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  `image` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phonecodes`
--

INSERT INTO `phonecodes` (`id`, `iso`, `main_name`, `country_name`, `iso3`, `numcode`, `phonecode`, `image`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93, 'af.png'),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355, 'al.png'),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213, 'dz.png'),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684, 'as.png'),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376, 'ad.png'),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244, 'ao.png'),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264, 'ai.png'),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0, 'aq.png'),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268, 'ag.png'),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54, 'ar.png'),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374, 'am.png'),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297, 'aw.png'),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61, 'au.png'),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43, 'at.png'),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994, 'az.png'),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242, 'bs.png'),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973, 'bh.png'),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880, 'bd.png'),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246, 'bb.png'),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375, 'by.png'),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32, 'be.png'),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501, 'bz.png'),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229, 'bj.png'),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441, 'bm.png'),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975, 'bt.png'),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591, 'bo.png'),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387, 'ba.png'),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267, 'bw.png'),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0, 'bv.png'),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55, 'br.png'),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246, 'io.png'),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673, 'bn.png'),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359, 'bg.png'),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226, 'bf.png'),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257, 'bi.png'),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855, 'kh.png'),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237, 'cm.png'),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1, 'ca.png'),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238, 'cv.png'),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345, 'ky.png'),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236, 'cf.png'),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235, 'td.png'),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56, 'cl.png'),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86, 'cn.png'),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61, 'cx.png'),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672, 'cc.png'),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57, 'co.png'),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269, 'km.png'),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242, 'cg.png'),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242, 'cd.png'),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682, 'ck.png'),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506, 'cr.png'),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225, 'ci.png'),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385, 'hr.png'),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53, 'cu.png'),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357, 'cy.png'),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420, 'cz.png'),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45, 'dk.png'),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253, 'dj.png'),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767, 'dm.png'),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809, 'do.png'),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593, 'ec.png'),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20, 'eg.png'),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503, 'sv.png'),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240, 'gq.png'),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291, 'er.png'),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372, 'ee.png'),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251, 'et.png'),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500, 'fk.png'),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298, 'fo.png'),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679, 'fj.png'),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358, 'fi.png'),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33, 'fr.png'),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594, 'gf.png'),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689, 'pf.png'),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0, 'tf.png'),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241, 'ga.png'),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220, 'gm.png'),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995, 'ge.png'),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49, 'de.png'),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233, 'gh.png'),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350, 'gi.png'),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30, 'gr.png'),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299, 'gl.png'),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473, 'gd.png'),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590, 'gp.png'),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671, 'gu.png'),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502, 'gt.png'),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224, 'gn.png'),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245, 'gw.png'),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592, 'gy.png'),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509, 'ht.png'),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0, 'hm.png'),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39, 'va.png'),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504, 'hn.png'),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852, 'hk.png'),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36, 'hu.png'),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354, 'is.png'),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91, 'in.png'),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62, 'id.png'),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98, 'ir.png'),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964, 'iq.png'),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353, 'ie.png'),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972, 'il.png'),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39, 'it.png'),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876, 'jm.png'),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81, 'jp.png'),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962, 'jo.png'),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7, 'kz.png'),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254, 'ke.png'),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686, 'ki.png'),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850, 'kp.png'),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, 'kr.png'),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, 'kw.png'),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, 'kg.png'),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856, 'la.png'),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371, 'lv.png'),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961, 'lb.png'),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266, 'ls.png'),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231, 'lr.png'),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218, 'ly.png'),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423, 'li.png'),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370, 'lt.png'),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352, 'lu.png'),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853, 'mo.png'),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389, 'mk.png'),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261, 'mg.png'),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265, 'mw.png'),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60, 'my.png'),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960, 'mv.png'),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223, 'ml.png'),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356, 'mt.png'),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692, 'mh.png'),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596, 'mq.png'),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222, 'mr.png'),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230, 'mu.png'),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269, 'yt.png'),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52, 'mx.png'),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691, 'fm.png'),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373, 'md.png'),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377, 'mc.png'),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976, 'mn.png'),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664, 'ms.png'),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212, 'ma.png'),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258, 'mz.png'),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95, 'mm.png'),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264, 'na.png'),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674, 'nr.png'),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977, 'np.png'),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31, 'nl.png'),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599, 'an.png'),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687, 'nc.png'),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64, 'nz.png'),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505, 'ni.png'),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227, 'ne.png'),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234, 'ng.png'),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683, 'nu.png'),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672, 'nf.png'),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670, 'mp.png'),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47, 'no.png'),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968, 'om.png'),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92, 'pk.png'),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680, 'pw.png'),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970, 'ps.png'),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507, 'pa.png'),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675, 'pg.png'),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595, 'py.png'),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51, 'pe.png'),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63, 'ph.png'),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0, 'pn.png'),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48, 'pl.png'),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351, 'pt.png'),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787, 'pr.png'),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974, 'qa.png'),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262, 're.png'),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40, 'ro.png'),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70, 'ru.png'),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250, 'rw.png'),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290, 'sh.png'),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869, 'kn.png'),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758, 'lc.png'),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508, 'pm.png'),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784, 'vc.png'),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684, 'ws.png'),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378, 'sm.png'),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239, 'st.png'),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966, 'sa.png'),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221, 'sn.png'),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381, 'cs.png'),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248, 'sc.png'),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232, 'sl.png'),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65, 'sg.png'),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421, 'sk.png'),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386, 'si.png'),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677, 'sb.png'),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252, 'so.png'),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27, 'za.png'),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0, 'gs.png'),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34, 'es.png'),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94, 'lk.png'),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249, 'sd.png'),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597, 'sr.png'),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47, 'sj.png'),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268, 'sz.png'),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46, 'se.png'),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41, 'ch.png'),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963, 'sy.png'),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886, 'tw.png'),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992, 'tj.png'),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255, 'tz.png'),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66, 'th.png'),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670, 'tl.png'),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228, 'tg.png'),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690, 'tk.png'),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676, 'to.png'),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868, 'tt.png'),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216, 'tn.png'),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90, 'tr.png'),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370, 'tm.png'),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649, 'tc.png'),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688, 'tv.png'),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256, 'ug.png'),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380, 'ua.png'),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971, 'ae.png'),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44, 'gb.png'),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1, 'us.png'),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1, 'um.png'),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598, 'uy.png'),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998, 'uz.png'),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678, 'vu.png'),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58, 've.png'),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84, 'vn.png'),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284, 'vg.png'),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340, 'vi.png'),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681, 'wf.png'),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212, 'eh.png'),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967, 'ye.png'),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260, 'zm.png'),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263, 'zw.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phonecodes`
--
ALTER TABLE `phonecodes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phonecodes`
--
ALTER TABLE `phonecodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
