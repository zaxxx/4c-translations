-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `abbreviation` (`abbreviation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `product_text_type`;
CREATE TABLE `product_text_type` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `product_translation`;
CREATE TABLE `product_translation` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(2) unsigned NOT NULL,
  `product_id` int(9) unsigned NOT NULL,
  `product_text_type_id` int(3) unsigned NOT NULL,
  `current_revision_id` int(9) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`),
  KEY `product_text_type_id` (`product_text_type_id`),
  KEY `current_revision_id` (`current_revision_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_translation_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  CONSTRAINT `product_translation_ibfk_2` FOREIGN KEY (`product_text_type_id`) REFERENCES `product_text_type` (`id`),
  CONSTRAINT `product_translation_ibfk_3` FOREIGN KEY (`current_revision_id`) REFERENCES `product_translation_revision` (`id`),
  CONSTRAINT `product_translation_ibfk_4` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `product_translation_revision`;
CREATE TABLE `product_translation_revision` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `product_translation_id` int(9) unsigned NOT NULL,
  `revision` int(9) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `translation` text COLLATE utf8_unicode_ci NOT NULL,
  `translation_source_id` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_translation_id` (`product_translation_id`),
  KEY `translation_source_id` (`translation_source_id`),
  CONSTRAINT `product_translation_revision_ibfk_1` FOREIGN KEY (`product_translation_id`) REFERENCES `product_translation` (`id`),
  CONSTRAINT `product_translation_revision_ibfk_2` FOREIGN KEY (`translation_source_id`) REFERENCES `product_translation_source` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `product_translation_source`;
CREATE TABLE `product_translation_source` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source` (`source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `product_translation`
ADD `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

ALTER TABLE `product_translation_revision`
CHANGE `updated_at` `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;


-- 2019-11-11 13:21:05
