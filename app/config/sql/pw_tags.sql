
/**
 * Contains metadata about our passwords.
 * #define LOCK_PRIVY 1
 */
DROP TABLE IF EXISTS `pw_tags`;
CREATE TABLE IF NOT EXISTS `pw_tags` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `pw_id` INT UNSIGNED DEFAULT 0 NOT NULL,    -- Reference to pw_dictionary.id.
    `tag` VARCHAR(255) DEFAULT NULL,            -- Metadata/extra data about a password.
    `flags` INT(1) DEFAULT 0 NOT NULL,          -- Bitwise options/metadata about a password.
	PRIMARY KEY (`id`),
	KEY `idx` (`id`),
    CONSTRAINT `pw_tags_pw_id_fk` FOREIGN KEY (`id`) REFERENCES `pw_dictionary`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=0;

