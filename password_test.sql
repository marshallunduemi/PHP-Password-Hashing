CREATE TABLE `password_test` (
    `pass_id` INT(11) NOT NULL AUTO_INCREMENT,
    `hash_password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`pass_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
