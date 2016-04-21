CREATE USER 'wsc_user'@'localhost' IDENTIFIED BY 'whvhYQ4SuQJVuHtLKPSaK3gY';
GRANT SELECT, INSERT, UPDATE ON `williams`.* TO 'wsc_user'@'localhost';

CREATE TABLE `williams`.`login_attempts` (
    `id` INT(2) NOT NULL,
    `time` VARCHAR(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;