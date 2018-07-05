CREATE TABLE IF NOT EXISTS `cot_seosubdom` (
	`seos_id` INT(11) NOT NULL AUTO_INCREMENT,
	`seos_domain` VARCHAR(128) NOT NULL,
	`seos_address_index` INT(6) NOT NULL default '0',
	`seos_address_region` VARCHAR(128) NOT NULL default '',
	`seos_address_city` VARCHAR(128) NOT NULL default '',
	`seos_address_street` VARCHAR(128) NOT NULL default '',
	`seos_address_house` VARCHAR(12) NOT NULL default '',
	`seos_address_office` VARCHAR(12) NOT NULL default '',
	`seos_address_working_days` VARCHAR(128) NOT NULL default '',
	`seos_address_working_hours` VARCHAR(128) NOT NULL default '',
	`seos_phone` VARCHAR(128) NOT NULL default '',
	`seos_mail` VARCHAR(128) NOT NULL default '',
	`seos_description` TEXT NOT NULL default '',
	`seos_video` VARCHAR(255) NOT NULL default '',
	`seos_image` VARCHAR(255) NOT NULL default '',
	`seos_map_coordinate` VARCHAR(64) NOT NULL default '',
	PRIMARY KEY (`seos_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;