-- Run this SQL query via phpMyAdmin on the production database before testing the new API

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ip_address` VARCHAR(45) NOT NULL,
  `attempt_time` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_ip` (`ip_address`),
  INDEX `idx_time` (`attempt_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
