
/**
 * Setup a few items to ensure these pass in order.
 */
SET @@FOREIGN_KEY_CHECKS = 0;

/**
 * Password Dictionary. Contains the list of passwords we're maintaining in the database.
 */
DROP TABLE IF EXISTS `pw_dictionary`;
CREATE TABLE IF NOT EXISTS `pw_dictionary` (
	`id` INT UNSIGNED AUTO_INCREMENT,
	`password` VARCHAR(1024) DEFAULT '' NOT NULL,   -- The password to store. No need to encrypt these in any fashion, since it's open-source =P
	`popularity` INT(9) DEFAULT 0 NOT NULL,         -- How popular is this password? The higher the popularity, the more frequently we've encountered this password.
	`added` TIMESTAMP NOT NULL,                     -- When did we first see this password? Keep in mind, this is subjective to the start date of the project.
	PRIMARY KEY (`id`),
	KEY `popularityx` (`popularity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=0;

