-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-12-2012 a las 11:15:01
-- Versión del servidor: 5.1.66
-- Versión de PHP: 5.3.20

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ch_manager_member`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `iso` char(2) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `printable_name` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `iso3` char(3) COLLATE latin1_spanish_ci DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`iso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`iso`, `name`, `printable_name`, `iso3`, `numcode`) VALUES
('AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4),
('AL', 'ALBANIA', 'Albania', 'ALB', 8),
('DZ', 'ALGERIA', 'Algeria', 'DZA', 12),
('AS', 'AMERICAN SAMOA', 'American \r\nSamoa', 'ASM', 16),
('AD', 'ANDORRA', 'Andorra', 'AND', 20),
('AO', 'ANGOLA', 'Angola', 'AGO', 24),
('AI', 'ANGUILLA', 'Anguilla', 'AIA', 660),
('AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL),
('AG', 'ANTIGUA AND BARBUDA', 'Antigua and \r\nBarbuda', 'ATG', 28),
('AR', 'ARGENTINA', 'Argentina', 'ARG', 32),
('AM', 'ARMENIA', 'Armenia', 'ARM', 51),
('AW', 'ARUBA', 'Aruba', 'ABW', 533),
('AU', 'AUSTRALIA', 'Australia', 'AUS', 36),
('AT', 'AUSTRIA', 'Austria', 'AUT', 40),
('AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31),
('BS', 'BAHAMAS', 'Bahamas', 'BHS', 44),
('BH', 'BAHRAIN', 'Bahrain', 'BHR', 48),
('BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50),
('BB', 'BARBADOS', 'Barbados', 'BRB', 52),
('BY', 'BELARUS', 'Belarus', 'BLR', 112),
('BE', 'BELGIUM', 'Belgium', 'BEL', 56),
('BZ', 'BELIZE', 'Belize', 'BLZ', 84),
('BJ', 'BENIN', 'Benin', 'BEN', 204),
('BM', 'BERMUDA', 'Bermuda', 'BMU', 60),
('BT', 'BHUTAN', 'Bhutan', 'BTN', 64),
('BO', 'BOLIVIA', 'Bolivia', 'BOL', 68),
('BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and \r\nHerzegovina', 'BIH', 70),
('BW', 'BOTSWANA', 'Botswana', 'BWA', 72),
('BV', 'BOUVET ISLAND', 'Bouvet \r\nIsland', NULL, NULL),
('BR', 'BRAZIL', 'Brazil', 'BRA', 76),
('IO', 'BRITISH INDIAN OCEAN \r\nTERRITORY', 'British Indian Ocean Territory', NULL, NULL),
('BN', 'BRUNEI DARUSSALAM', 'Brunei \r\nDarussalam', 'BRN', 96),
('BG', 'BULGARIA', 'Bulgaria', 'BGR', 100),
('BF', 'BURKINA FASO', 'Burkina \r\nFaso', 'BFA', 854),
('BI', 'BURUNDI', 'Burundi', 'BDI', 108),
('KH', 'CAMBODIA', 'Cambodia', 'KHM', 116),
('CM', 'CAMEROON', 'Cameroon', 'CMR', 120),
('CA', 'CANADA', 'Canada', 'CAN', 124),
('CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132),
('KY', 'CAYMAN ISLANDS', 'Cayman \r\nIslands', 'CYM', 136),
('CF', 'CENTRAL AFRICAN REPUBLIC', 'Central \r\nAfrican Republic', 'CAF', 140),
('TD', 'CHAD', 'Chad', 'TCD', 148),
('CL', 'CHILE', 'Chile', 'CHL', 152),
('CN', 'CHINA', 'China', 'CHN', 156),
('CX', 'CHRISTMAS ISLAND', 'Christmas \r\nIsland', NULL, NULL),
('CC', 'COCOS (KEELING) ISLANDS', 'Cocos \r\n(Keeling) Islands', NULL, NULL),
('CO', 'COLOMBIA', 'Colombia', 'COL', 170),
('KM', 'COMOROS', 'Comoros', 'COM', 174),
('CG', 'CONGO', 'Congo', 'COG', 178),
('CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF \r\nTHE', 'Congo, the Democratic Republic of the', 'COD', 180),
('CK', 'COOK ISLANDS', 'Cook \r\nIslands', 'COK', 184),
('CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188),
('CI', 'COTE D''IVOIRE', 'Cote \r\nD''Ivoire', 'CIV', 384),
('HR', 'CROATIA', 'Croatia', 'HRV', 191),
('CU', 'CUBA', 'Cuba', 'CUB', 192),
('CY', 'CYPRUS', 'Cyprus', 'CYP', 196),
('CZ', 'CZECH REPUBLIC', 'Czech \r\nRepublic', 'CZE', 203),
('DK', 'DENMARK', 'Denmark', 'DNK', 208),
('DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262),
('DM', 'DOMINICA', 'Dominica', 'DMA', 212),
('DO', 'DOMINICAN REPUBLIC', 'Dominican \r\nRepublic', 'DOM', 214),
('EC', 'ECUADOR', 'Ecuador', 'ECU', 218),
('EG', 'EGYPT', 'Egypt', 'EGY', 818),
('SV', 'EL SALVADOR', 'El \r\nSalvador', 'SLV', 222),
('GQ', 'EQUATORIAL GUINEA', 'Equatorial \r\nGuinea', 'GNQ', 226),
('ER', 'ERITREA', 'Eritrea', 'ERI', 232),
('EE', 'ESTONIA', 'Estonia', 'EST', 233),
('ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231),
('FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland\r\n Islands (Malvinas)', 'FLK', 238),
('FO', 'FAROE ISLANDS', 'Faroe \r\nIslands', 'FRO', 234),
('FJ', 'FIJI', 'Fiji', 'FJI', 242),
('FI', 'FINLAND', 'Finland', 'FIN', 246),
('FR', 'FRANCE', 'France', 'FRA', 250),
('GF', 'FRENCH GUIANA', 'French \r\nGuiana', 'GUF', 254),
('PF', 'FRENCH POLYNESIA', 'French \r\nPolynesia', 'PYF', 258),
('TF', 'FRENCH SOUTHERN TERRITORIES', 'French \r\nSouthern Territories', NULL, NULL),
('GA', 'GABON', 'Gabon', 'GAB', 266),
('GM', 'GAMBIA', 'Gambia', 'GMB', 270),
('GE', 'GEORGIA', 'Georgia', 'GEO', 268),
('DE', 'GERMANY', 'Germany', 'DEU', 276),
('GH', 'GHANA', 'Ghana', 'GHA', 288),
('GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292),
('GR', 'GREECE', 'Greece', 'GRC', 300),
('GL', 'GREENLAND', 'Greenland', 'GRL', 304),
('GD', 'GRENADA', 'Grenada', 'GRD', 308),
('GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312),
('GU', 'GUAM', 'Guam', 'GUM', 316),
('GT', 'GUATEMALA', 'Guatemala', 'GTM', 320),
('GN', 'GUINEA', 'Guinea', 'GIN', 324),
('GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624),
('GY', 'GUYANA', 'Guyana', 'GUY', 328),
('HT', 'HAITI', 'Haiti', 'HTI', 332),
('HM', 'HEARD ISLAND AND MCDONALD \r\nISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL),
('VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy \r\nSee (Vatican City State)', 'VAT', 336),
('HN', 'HONDURAS', 'Honduras', 'HND', 340),
('HK', 'HONG KONG', 'Hong Kong', 'HKG', 344),
('HU', 'HUNGARY', 'Hungary', 'HUN', 348),
('IS', 'ICELAND', 'Iceland', 'ISL', 352),
('IN', 'INDIA', 'India', 'IND', 356),
('ID', 'INDONESIA', 'Indonesia', 'IDN', 360),
('IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, \r\nIslamic Republic of', 'IRN', 364),
('IQ', 'IRAQ', 'Iraq', 'IRQ', 368),
('IE', 'IRELAND', 'Ireland', 'IRL', 372),
('IL', 'ISRAEL', 'Israel', 'ISR', 376),
('IT', 'ITALY', 'Italy', 'ITA', 380),
('JM', 'JAMAICA', 'Jamaica', 'JAM', 388),
('JP', 'JAPAN', 'Japan', 'JPN', 392),
('JO', 'JORDAN', 'Jordan', 'JOR', 400),
('KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398),
('KE', 'KENYA', 'Kenya', 'KEN', 404),
('KI', 'KIRIBATI', 'Kiribati', 'KIR', 296),
('KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC \r\nOF', 'Korea, Democratic People''s Republic of', 'PRK', 408),
('KR', 'KOREA, REPUBLIC OF', 'Korea, Republic \r\nof', 'KOR', 410),
('KW', 'KUWAIT', 'Kuwait', 'KWT', 414),
('KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417),
('LA', 'LAO PEOPLE''S DEMOCRATIC \r\nREPUBLIC', 'Lao People''s Democratic Republic', 'LAO', 418),
('LV', 'LATVIA', 'Latvia', 'LVA', 428),
('LB', 'LEBANON', 'Lebanon', 'LBN', 422),
('LS', 'LESOTHO', 'Lesotho', 'LSO', 426),
('LR', 'LIBERIA', 'Liberia', 'LBR', 430),
('LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab \r\nJamahiriya', 'LBY', 434),
('LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438),
('LT', 'LITHUANIA', 'Lithuania', 'LTU', 440),
('LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442),
('MO', 'MACAO', 'Macao', 'MAC', 446),
('MK', 'MACEDONIA, THE FORMER YUGOSLAV \r\nREPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807),
('MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450),
('MW', 'MALAWI', 'Malawi', 'MWI', 454),
('MY', 'MALAYSIA', 'Malaysia', 'MYS', 458),
('MV', 'MALDIVES', 'Maldives', 'MDV', 462),
('ML', 'MALI', 'Mali', 'MLI', 466),
('MT', 'MALTA', 'Malta', 'MLT', 470),
('MH', 'MARSHALL ISLANDS', 'Marshall \r\nIslands', 'MHL', 584),
('MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474),
('MR', 'MAURITANIA', 'Mauritania', 'MRT', 478),
('MU', 'MAURITIUS', 'Mauritius', 'MUS', 480),
('YT', 'MAYOTTE', 'Mayotte', NULL, NULL),
('MX', 'MEXICO', 'Mexico', 'MEX', 484),
('FM', 'MICRONESIA, FEDERATED STATES \r\nOF', 'Micronesia, Federated States of', 'FSM', 583),
('MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, \r\nRepublic of', 'MDA', 498),
('MC', 'MONACO', 'Monaco', 'MCO', 492),
('MN', 'MONGOLIA', 'Mongolia', 'MNG', 496),
('MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500),
('MA', 'MOROCCO', 'Morocco', 'MAR', 504),
('MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508),
('MM', 'MYANMAR', 'Myanmar', 'MMR', 104),
('NA', 'NAMIBIA', 'Namibia', 'NAM', 516),
('NR', 'NAURU', 'Nauru', 'NRU', 520),
('NP', 'NEPAL', 'Nepal', 'NPL', 524),
('NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528),
('AN', 'NETHERLANDS ANTILLES', 'Netherlands \r\nAntilles', 'ANT', 530),
('NC', 'NEW CALEDONIA', 'New \r\nCaledonia', 'NCL', 540),
('NZ', 'NEW ZEALAND', 'New \r\nZealand', 'NZL', 554),
('NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558),
('NE', 'NIGER', 'Niger', 'NER', 562),
('NG', 'NIGERIA', 'Nigeria', 'NGA', 566),
('NU', 'NIUE', 'Niue', 'NIU', 570),
('NF', 'NORFOLK ISLAND', 'Norfolk \r\nIsland', 'NFK', 574),
('MP', 'NORTHERN MARIANA ISLANDS', 'Northern \r\nMariana Islands', 'MNP', 580),
('NO', 'NORWAY', 'Norway', 'NOR', 578),
('OM', 'OMAN', 'Oman', 'OMN', 512),
('PK', 'PAKISTAN', 'Pakistan', 'PAK', 586),
('PW', 'PALAU', 'Palau', 'PLW', 585),
('PS', 'PALESTINIAN TERRITORY, \r\nOCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL),
('PA', 'PANAMA', 'Panama', 'PAN', 591),
('PG', 'PAPUA NEW GUINEA', 'Papua New \r\nGuinea', 'PNG', 598),
('PY', 'PARAGUAY', 'Paraguay', 'PRY', 600),
('PE', 'PERU', 'Peru', 'PER', 604),
('PH', 'PHILIPPINES', 'Philippines', 'PHL', 608),
('PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612),
('PL', 'POLAND', 'Poland', 'POL', 616),
('PT', 'PORTUGAL', 'Portugal', 'PRT', 620),
('PR', 'PUERTO RICO', 'Puerto \r\nRico', 'PRI', 630),
('QA', 'QATAR', 'Qatar', 'QAT', 634),
('RE', 'REUNION', 'Reunion', 'REU', 638),
('RO', 'ROMANIA', 'Romania', 'ROM', 642),
('RU', 'RUSSIAN FEDERATION', 'Russian \r\nFederation', 'RUS', 643),
('RW', 'RWANDA', 'Rwanda', 'RWA', 646),
('SH', 'SAINT HELENA', 'Saint \r\nHelena', 'SHN', 654),
('KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts \r\nand Nevis', 'KNA', 659),
('LC', 'SAINT LUCIA', 'Saint \r\nLucia', 'LCA', 662),
('PM', 'SAINT PIERRE AND MIQUELON', 'Saint \r\nPierre and Miquelon', 'SPM', 666),
('VC', 'SAINT VINCENT AND THE \r\nGRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670),
('WS', 'SAMOA', 'Samoa', 'WSM', 882),
('SM', 'SAN MARINO', 'San Marino', 'SMR', 674),
('ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and \r\nPrincipe', 'STP', 678),
('SA', 'SAUDI ARABIA', 'Saudi \r\nArabia', 'SAU', 682),
('SN', 'SENEGAL', 'Senegal', 'SEN', 686),
('CS', 'SERBIA AND MONTENEGRO', 'Serbia and \r\nMontenegro', NULL, NULL),
('SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690),
('SL', 'SIERRA LEONE', 'Sierra \r\nLeone', 'SLE', 694),
('SG', 'SINGAPORE', 'Singapore', 'SGP', 702),
('SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703),
('SI', 'SLOVENIA', 'Slovenia', 'SVN', 705),
('SB', 'SOLOMON ISLANDS', 'Solomon \r\nIslands', 'SLB', 90),
('SO', 'SOMALIA', 'Somalia', 'SOM', 706),
('ZA', 'SOUTH AFRICA', 'South \r\nAfrica', 'ZAF', 710),
('GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH \r\nISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL),
('ES', 'SPAIN', 'Spain', 'ESP', 724),
('LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144),
('SD', 'SUDAN', 'Sudan', 'SDN', 736),
('SR', 'SURINAME', 'Suriname', 'SUR', 740),
('SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and \r\nJan Mayen', 'SJM', 744),
('SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748),
('SE', 'SWEDEN', 'Sweden', 'SWE', 752),
('CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756),
('SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab \r\nRepublic', 'SYR', 760),
('TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, \r\nProvince of China', 'TWN', 158),
('TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762),
('TZ', 'TANZANIA, UNITED REPUBLIC \r\nOF', 'Tanzania, United Republic of', 'TZA', 834),
('TH', 'THAILAND', 'Thailand', 'THA', 764),
('TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL),
('TG', 'TOGO', 'Togo', 'TGO', 768),
('TK', 'TOKELAU', 'Tokelau', 'TKL', 772),
('TO', 'TONGA', 'Tonga', 'TON', 776),
('TT', 'TRINIDAD AND TOBAGO', 'Trinidad and \r\nTobago', 'TTO', 780),
('TN', 'TUNISIA', 'Tunisia', 'TUN', 788),
('TR', 'TURKEY', 'Turkey', 'TUR', 792),
('TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795),
('TC', 'TURKS AND CAICOS ISLANDS', 'Turks and \r\nCaicos Islands', 'TCA', 796),
('TV', 'TUVALU', 'Tuvalu', 'TUV', 798),
('UG', 'UGANDA', 'Uganda', 'UGA', 800),
('UA', 'UKRAINE', 'Ukraine', 'UKR', 804),
('AE', 'UNITED ARAB EMIRATES', 'United Arab \r\nEmirates', 'ARE', 784),
('GB', 'UNITED KINGDOM', 'United \r\nKingdom', 'GBR', 826),
('US', 'UNITED STATES', 'United \r\nStates', 'USA', 840),
('UM', 'UNITED STATES MINOR OUTLYING \r\nISLANDS', 'United States Minor Outlying Islands', NULL, NULL),
('UY', 'URUGUAY', 'Uruguay', 'URY', 858),
('UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860),
('VU', 'VANUATU', 'Vanuatu', 'VUT', 548),
('VE', 'VENEZUELA', 'Venezuela', 'VEN', 862),
('VN', 'VIET NAM', 'Viet Nam', 'VNM', 704),
('VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin \r\nIslands, British', 'VGB', 92),
('VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands,\r\n U.s.', 'VIR', 850),
('WF', 'WALLIS AND FUTUNA', 'Wallis and \r\nFutuna', 'WLF', 876),
('EH', 'WESTERN SAHARA', 'Western \r\nSahara', 'ESH', 732),
('YE', 'YEMEN', 'Yemen', 'YEM', 887),
('ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894),
('ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE latin1_spanish_ci NOT NULL,
  `footer` longtext COLLATE latin1_spanish_ci NOT NULL,
  `show_signature` varchar(3) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `invoice`
--

INSERT INTO `invoice` (`cod`, `body`, `footer`, `show_signature`) VALUES
(1, '<p>Dear,</p>\r\n<p>We hereby acknowledge receipt of you membership payment:</p>\r\n<p>Company/Organisation name: {{name}} {{surname}}</p>\r\n<p>E-mail: {{email}}</p>\r\n<p>Telephone: {{phone}}</p>\r\n<p>Annual fee: {{quota}}</p>\r\n<p>&nbsp;</p>\r\n<p>Your official membership starts on the {{renewal}}. It will expire in one year from now. We will remind you in the time (by e-mail) that your payment is due for renewal, and will apply the corresponding reductions depending on your contributions to Chamilo.</p>\r\n<p>&nbsp;</p>\r\n<p>If you have specific questions, don''t hesitate to contact the board of directors at <a href="mailto:board@chamilo.org">board@chamilo.org</a></p>\r\n<p>Welcome to the Chamilo Association!</p>\r\n<p>&nbsp;</p>', '<p>Frans Kamp - Treasurer</p>\r\n<p>&nbsp;</p>\r\n<p>Chamilo Association<br />Av. de la Verrerie, 136 - 1190 Forest - Belgium<br />BE 43 9794 3491 8501 | BIC ARSPBE22</p>\r\n<p>&nbsp;</p>\r\n<p><a href="http://www.chamilo.org">www.chamilo.org</a> | info@chamilo.org</p>', 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `num_invoice` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `cod_member` int(11) NOT NULL,
  `message` longtext COLLATE latin1_spanish_ci NOT NULL,
  `quota` float NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=65 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `short` mediumtext COLLATE latin1_spanish_ci NOT NULL,
  `active` int(1) NOT NULL,
  `vdefault` int(1) NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=108 ;

--
-- Volcado de datos para la tabla `language`
--

INSERT INTO `language` (`cod`, `language`, `short`, `active`, `vdefault`) VALUES
(1, 'English', 'en', 1, 1),
(2, 'German', 'de', 0, 0),
(3, 'French', 'fr', 1, 0),
(4, 'Dutch', 'nl', 0, 0),
(5, 'Italian', 'it', 0, 0),
(6, 'Spanish', 'es', 1, 0),
(7, 'Polish', 'pl', 0, 0),
(8, 'Russian', 'ru', 0, 0),
(9, 'Japanese', 'ja', 0, 0),
(10, 'Portuguese', 'pt', 0, 0),
(11, 'Swedish', 'sv', 0, 0),
(12, 'Chinese', 'zh', 0, 0),
(13, 'Catalan', 'ca', 0, 0),
(14, 'Ukrainian', 'uk', 0, 0),
(15, 'Norwegian (Bokmål)', 'no', 0, 0),
(16, 'Finnish', 'fi', 0, 0),
(17, 'Vietnamese', 'vi', 0, 0),
(18, 'Czech', 'cs', 0, 0),
(19, 'Hungarian', 'hu', 0, 0),
(20, 'Korean', 'ko', 0, 0),
(21, 'Indonesian', 'id', 0, 0),
(22, 'Turkish', 'tr', 0, 0),
(23, 'Romanian', 'ro', 0, 0),
(24, 'Persian', 'fa', 0, 0),
(25, 'Arabic', 'ar', 0, 0),
(26, 'Danish', 'da', 0, 0),
(27, 'Esperanto', 'eo', 0, 0),
(28, 'Serbian', 'sr', 0, 0),
(29, 'Lithuanian', 'lt', 0, 0),
(30, 'Slovak', 'sk', 0, 0),
(31, 'Malay', 'ms', 0, 0),
(32, 'Hebrew', 'he', 0, 0),
(33, 'Bulgarian', 'bg', 0, 0),
(34, 'Slovenian', 'sl', 0, 0),
(35, 'Volapük', 'vo', 0, 0),
(36, 'Kazakh', 'kk', 0, 0),
(37, 'Waray-Waray', 'war', 0, 0),
(38, 'Basque', 'eu', 0, 0),
(39, 'Croatian', 'hr', 0, 0),
(40, 'Hindi', 'hi', 0, 0),
(41, 'Estonian', 'et', 0, 0),
(42, 'Azerbaijani', 'az', 0, 0),
(43, 'Galician', 'gl', 0, 0),
(44, 'Simple English', 'simple', 0, 0),
(45, 'Norwegian (Nynorsk)', 'nn', 0, 0),
(46, 'Thai', 'th', 0, 0),
(47, 'Newar / Nepal Bhasa', 'new', 0, 0),
(48, 'Greek', 'el', 0, 0),
(49, 'Aromanian', 'roa-rup', 0, 0),
(50, 'Latin', 'la', 0, 0),
(51, 'Occitan', 'oc', 0, 0),
(52, 'Tagalog', 'tl', 0, 0),
(53, 'Haitian', 'ht', 0, 0),
(54, 'Macedonian', 'mk', 0, 0),
(55, 'Georgian', 'ka', 0, 0),
(56, 'Serbo-Croatian', 'sh', 0, 0),
(57, 'Telugu', 'te', 0, 0),
(58, 'Piedmontese', 'pms', 0, 0),
(59, 'Cebuano', 'ceb', 0, 0),
(60, 'Tamil', 'ta', 0, 0),
(61, 'Belarusian (Taraškievica)', 'be-x-old', 0, 0),
(62, 'Breton', 'br', 0, 0),
(63, 'Latvian', 'lv', 0, 0),
(64, 'Javanese', 'jv', 0, 0),
(65, 'Albanian', 'sq', 0, 0),
(66, 'Belarusian', 'be', 0, 0),
(67, 'Marathi', 'mr', 0, 0),
(68, 'Welsh', 'cy', 0, 0),
(69, 'Luxembourgish', 'lb', 0, 0),
(70, 'Icelandic', 'is', 0, 0),
(71, 'Bosnian', 'bs', 0, 0),
(72, 'Yoruba', 'yo', 0, 0),
(73, 'Malagasy', 'mg', 0, 0),
(74, 'Aragonese', 'an', 0, 0),
(75, 'Bishnupriya Manipuri', 'bpy', 0, 0),
(76, 'Lombard', 'lmo', 0, 0),
(77, 'West Frisian', 'fy', 0, 0),
(78, 'Bengali', 'bn', 0, 0),
(79, 'Ido', 'io', 0, 0),
(80, 'Swahili', 'sw', 0, 0),
(81, 'Gujarati', 'gu', 0, 0),
(82, 'Malayalam', 'ml', 0, 0),
(83, 'Western Panjabi', 'pnb', 0, 0),
(84, 'Afrikaans', 'af', 0, 0),
(85, 'Low Saxon', 'nds', 0, 0),
(86, 'Sicilian', 'scn', 0, 0),
(87, 'Urdu', 'ur', 0, 0),
(88, 'Kurdish', 'ku', 0, 0),
(89, 'Cantonese', 'zh-yue', 0, 0),
(90, 'Armenian', 'hy', 0, 0),
(91, 'Quechua', 'qu', 0, 0),
(92, 'Sundanese', 'su', 0, 0),
(93, 'Nepali', 'ne', 0, 0),
(94, 'Zazaki', 'diq', 0, 0),
(95, 'Asturian', 'ast', 0, 0),
(96, 'Tatar', 'tt', 0, 0),
(97, 'Neapolitan', 'nap', 0, 0),
(98, 'Irish', 'ga', 0, 0),
(99, 'Chuvash', 'cv', 0, 0),
(100, 'Samogitian', 'bat-smg', 0, 0),
(101, 'Walloon', 'wa', 0, 0),
(102, 'Amharic', 'am', 0, 0),
(103, 'Kannada', 'kn', 0, 0),
(104, 'Alemannic', 'als', 0, 0),
(105, 'Buginese', 'bug', 0, 0),
(106, 'Burmese', 'my', 0, 0),
(107, 'Interlingua', 'ia', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `title` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `enlace` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `links`
--

INSERT INTO `links` (`cod`, `description`, `title`, `enlace`) VALUES
(1, 'Forum Chamilo', 'Interaction with users Chamilo', 'http://www.chamilo.org/en/forum'),
(3, 'Track Chamilo', 'Chamilo Tracking System', 'http://support.chamilo.org/'),
(4, 'Translate Chamilo', 'CT - Chamilo', 'http://translate.chamilo.org/'),
(6, 'Twitter', 'Twitter - Chamilo', 'https://twitter.com/chamilo_news'),
(8, 'Facebook', 'Official Facebook page', 'https://es-es.facebook.com/chamilolms');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `fecha` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `hora` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `url` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `ip` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Guarda el registro de personas' AUTO_INCREMENT=1938 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `surname` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `country` char(2) COLLATE latin1_spanish_ci NOT NULL,
  `language` int(3) NOT NULL,
  `phone` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `renewal` date NOT NULL,
  `mark_renewal` date NOT NULL,
  `quota` float NOT NULL,
  `type` int(2) NOT NULL,
  `comment` longtext COLLATE latin1_spanish_ci NOT NULL,
  `status` int(2) NOT NULL,
  `date_arrival` date NOT NULL,
  `email_renewal` int(1) NOT NULL,
  `email_expired` int(1) NOT NULL,
  `institution` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `address` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `postal_code` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `vat` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `language` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `message` longtext COLLATE latin1_spanish_ci NOT NULL,
  `default` varchar(1) COLLATE latin1_spanish_ci NOT NULL,
  `subject` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Template for automatic message for users' AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`cod`, `type`, `language`, `message`, `default`, `subject`) VALUES
(2, 'welcome', 'Spanish', '<p>Bienvenid@ {{name}} {{surname}} al grupo de miembros de Chamilo.</p>\n<p>Le indicamos los datos de su ficha para que nos comunique si hay alg&uacute;n error:</p>\n<p>Nombre: {{name}}</p>\n<p>Apellidos: {{surname}}</p>\n<p>Pa&iacute;s: {{country}}</p>\n<p>Idioma: {{language}}</p>\n<p>Tel&eacute;fono: {{phone}}</p>\n<p>E-mail: {{email}}</p>\n<p>Fecha de renovaci&oacute;n: {{renewal}}</p>\n<p>Cuota de pago: {{quota}}</p>\n<p>Tipo de miembro: {{type}}</p>\n<p>Comentarios que nos ha adjuntado en el formulario:</p>\n<p>{{comment}}</p>\n<p>Estado actual de su cuenta: {{status}}</p>\n<p>Fecha de alta en el sistema:{{date_arrival}}</p>\n<p>&nbsp;</p>\n<p>Reciba un coordial saludo.</p>', '', '[Chamilo] - Le damos la bienvenida'),
(3, 'renewal', 'Spanish', '<p>Estimad@ {{name}} {{surname}}</p>\n<p>Este mensaje es un aviso de renovaci&oacute;n pues su fecha de renovaci&oacute;n es: {{renewal}}</p>\n<p>La cuota de renovaci&oacute;n es {{quota}} &euro;.</p>\n<p>&nbsp;</p>\n<p>Saludos.</p>\n<p>&nbsp;</p>', '', '[Chamilo] - Su cuenta está próxima a su vencimiento'),
(4, 'expired', 'Spanish', '<p>Estimad@ {{name}} {{surname}}</p>\n<p>Ha vencido su fecha de renovaci&oacute;n: {{renewal}}</p>\n<p>Si est&aacute; interesado en renovar envienos un correo electr&oacute;nico indicando su deseo de volver a pertenecer al grupo de Chamilo</p>\n<p>&nbsp;</p>\n<p>Saludos.</p>\n<p>&nbsp;</p>', '', '[Chamilo] - Su cuenta ha expirado'),
(5, 'renewed', 'Spanish', '<p>Estimado {{name}} {{surname}}</p>\n<p>Se ha procedido a la renovaci&oacute;n de su cuenta.</p>\n<p>Su cuenta estar&aacute; activa hasta el {{renewal}}.</p>\n<p>Recibir&aacute; la factura como archivo adjunto de este correo.</p>\n<p>Atentamente.</p>', '', '[Chamilo] - Su cuenta ha sido renovada'),
(6, 'welcome', 'English', '<p>Dear {{name}}</p>\n<p>Welcome to the Chamilo Association!</p>\n<p>Just to inform you that the your membership application has been received.</p>\n<p>Thanks for joining the Chamilo Association</p>\n<p>&nbsp;</p>\n<p>Frans Kamp,</p>\n<p>Treasurer</p>\n<p>Chamilo Association</p>', '', 'Welcome to the Chamilo Association'),
(7, 'renewal', 'English', '<p>Dear {{name}}</p>\n<p>You have been a great supporter of the Chamilo Association during the last 11 months and we hope you have enjoyed it and benefited from our (and your) activities.</p>\n<p><br />Your current membership will expire on {{renewal}}</p>\n<p>We appreciate your contribution, and we would also appreciate your suggestions for the improvement of the actions of the Chamilo Association. This is a great opportunity for us to improve our processes in time for your next year of membership.</p>\n<p>To renew, please make your payment to <a href="mailto:paypal@chamilo.org">paypal@chamilo.org</a></p>\n<p>&nbsp;</p>\n<p>Your current fee: {{quota}}</p>\n<p>Best regards,</p>\n<p>Chamilo Association<br />Glasblazerijlaan 136 - 1190 Brussels - Belgium<br />BE 43 9794 3491 8501 | BIC ARSPBE22<br /><a class="external" href="http://www.chamilo.org">www.chamilo.org</a> | <a class="email" href="mailto:info@chamilo.org">info@chamilo.org</a></p>', '', 'Your membership will expire shortly.'),
(8, 'expired', 'English', '<p>Dear {{name}},</p>\n<p>&nbsp;</p>\n<p>Your Chamilo Association membership has expired on the {{renewal}}</p>\n<p>As you know our members are of great importance to the Chamilo Association. With your membership fee we are able to facilitate the activities of the Association and of various Chamilo user groups all over the world.</p>\n<p>Therefore we would kindly ask you to reconsider and renew your membership to the Chamilo Association today. To renew, please make your payment to <a>paypal@chamilo.org</a></p>\n<p>Your current fee: {{cuota}}</p>\n<p>In case you decide not to renew your Chamilo membership, please inform us by e-mail, <a href="mailto:info@chamilo.org">info@chamilo.org</a></p>\n<p>&nbsp;</p>\n<p>Best regards,</p>\n<p>Chamilo Association<br />Glasblazerijlaan 136 - 1190 Brussels - Belgium<br />BE 43 9794 3491 8501 | BIC ARSPBE22<br /><a class="external" href="http://www.chamilo.org">www.chamilo.org</a> | <a class="email" href="mailto:info@chamilo.org">info@chamilo.org</a></p>', '', 'Your membership has expired'),
(9, 'renewed', 'English', '<p>Dear {{name}},</p>\n<p>&nbsp;</p>\n<p>Thanks for renewal of your membership to the Chamilo Association. We really appreciate your support and&nbsp; contribution to the project.</p>\n<p>&nbsp;</p>\n<p>Your help enables us to facilitate the Chamilo Community and spread Chamilo all over the world.</p>\n<p>&nbsp;</p>\n<p>Thanks!</p>\n<p>Chamilo Association<br />Glasblazerijlaan 136 - 1190 Brussels - Belgium<br />BE 43 9794 3491 8501 | BIC ARSPBE22<br /><a class="external" href="http://www.chamilo.org">www.chamilo.org</a> | <a class="email" href="mailto:info@chamilo.org">info@chamilo.org</a></p>', '', 'Thanks for your support'),
(10, 'welcome', 'French', '<p>Dear {{name}}</p>\n<p>Welcome to the Chamilo Association!</p>\n<p>Just to inform you that the your membership application has been received.</p>\n<p>Thanks for joining the Chamilo Association</p>\n<p>&nbsp;</p>\n<p>Frans Kamp,</p>\n<p>Treasurer</p>\n<p>Chamilo Association</p>', '', 'Association Chamilo - Bienvenu(e)'),
(11, 'renewal', 'French', '', '', 'Association Chamilo - Votre souscription arrivera bientôt à expiration'),
(12, 'invoice_forward', 'Spanish', '<div class="moz-text-html" lang="x-unicode">\n<p>Estimado {{name}} {{surname}}</p>\n<p>Se ha procedido al reenvio de la factura.</p>\n<p>Recibir&aacute; la factura como archivo adjunto de este correo.</p>\n<p>Atentamente.</p>\n</div>', '', 'Reenvio de factura'),
(13, 'invoice_forward', 'English', '<p>Dear {{name}},</p>\n<p>&nbsp;</p>\n<p>We proceed to send an invoice as an attachment.</p>\n<p>&nbsp;</p>\n<p>Regards<br /><br /></p>\n<p>Chamilo Association<br />Glasblazerijlaan 136 - 1190 Brussels - Belgium<br />BE 43 9794 3491 8501 | BIC ARSPBE22<br /><a class="external" href="http://www.chamilo.org">www.chamilo.org</a> | <a class="email" href="mailto:info@chamilo.org">info@chamilo.org</a></p>', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE IF NOT EXISTS `parametros` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `notice_renewal` int(11) NOT NULL,
  `sender` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `num_invoice` int(11) NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`cod`, `notice_renewal`, `sender`, `num_invoice`) VALUES
(1, 30, 'communication@chamilo.org', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsible`
--

CREATE TABLE IF NOT EXISTS `responsible` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `responsible` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `area` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=25 ;

--
-- Volcado de datos para la tabla `responsible`
--

INSERT INTO `responsible` (`cod`, `responsible`, `area`) VALUES
(23, 'communication@chamilo.org', 'expired'),
(22, 'communication@chamilo.org', 'renewal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`cod`, `status`) VALUES
(1, 'Active'),
(2, 'Expired'),
(3, 'Pending');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_member`
--

CREATE TABLE IF NOT EXISTS `type_member` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `type_member`
--

INSERT INTO `type_member` (`cod`, `name`) VALUES
(1, 'Admitted - Non profit'),
(2, 'Admitted - Corporate'),
(3, 'Admitted - Individual'),
(4, 'Effective - Non profit'),
(5, 'Effective - Corporate'),
(6, 'Effective - Promoted from individual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `pass` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `actual_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `ip` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `cookie` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'valor de la cookie',
  `validez` datetime DEFAULT NULL COMMENT 'tiempo de la cookie',
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`cod`, `user`, `pass`, `email`, `name`, `last_login`, `actual_login`, `last_ip`, `ip`, `cookie`, `validez`) VALUES
(1, 'admin', 'ce78692e23367e7a9b92b804487ff71cd4fe9fc9', 'jaruiz@nosolored.com', 'Administrator', '2012-12-27 10:07:24', '2012-12-27 10:05:04', '79.157.15.242', '79.157.15.242', '3dc802d3326772d10c5143b2a72c90eca236e89a', '2012-12-27 16:55:14'),
(6, 'nsradmin', '432ad24894c99a2bbb8b58b0c2a9136a682b2780', 'nosolored@nosolored.com', 'nosolored - Administrator', '2012-12-11 11:03:08', '2012-12-11 11:42:27', '79.157.14.241', '79.157.14.241', NULL, NULL),
(10, 'admin1', 'a02ac394bf173efdbfb401399c31eb9d88249943', 'info@contidosdixitais.com', 'admin', '2012-12-19 16:11:05', '2012-12-20 20:47:07', '82.176.16.122', '82.176.16.122', NULL, NULL),
(4, 'noa', '09f3e9a504b20ca125d3f4d5a5b68ad92bd561a2', 'noa@contidosdixitais.com', 'Noa Orizales', '2012-12-21 18:48:26', '2012-12-26 18:30:57', '81.39.31.198', '81.39.31.198', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
