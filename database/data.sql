-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `language` (`id`, `abbreviation`) VALUES
(1,	'cz'),
(2,	'sk'),
(3,	'ro'),
(4,	'hu');

INSERT INTO `product` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(45),
(46),
(47),
(48),
(49),
(50);

INSERT INTO `product_text_type` (`id`, `type`, `description`) VALUES
(1,	'title',	'Nadpis'),
(2,	'perex',	'Perex'),
(3,	'description',	'Dlouhý popis');

INSERT INTO `product_translation_source` (`id`, `source`, `description`) VALUES
(1,	'manual',	'Přeloženo ručně'),
(2,	'automatic',	'Přeloženo automatickým překladačem');

-- 2019-11-11 13:17:49
