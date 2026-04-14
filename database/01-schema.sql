CREATE TABLE IF NOT EXISTS `user` (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `movement` (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `personal_record` (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` int UNSIGNED NOT NULL,
    `movement_id` int UNSIGNED NOT NULL,
    `value` FLOAT NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `personal_record` 
ADD CONSTRAINT `personal_record_fk0` 
FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `personal_record` 
ADD CONSTRAINT `personal_record_fk1` 
FOREIGN KEY (`movement_id`) REFERENCES `movement`(`id`);