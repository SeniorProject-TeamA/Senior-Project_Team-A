-- Williams Specialty Company - Business Process Automation
-- MySQL Data Schema

CREATE SCHEMA `williams` CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON `williams`.* TO `wscAdmin`@localhost IDENTIFIED BY 'password01';

CREATE TABLE `williams`.`credentials` (
    `empID`             INT(2)          NOT NULL,
    `Password`          VARCHAR(25)     NOT NULL,
    PRIMARY KEY (`empID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`employee` (
    `empID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `typID`             INT(2)          NOT NULL,
    `Title`             VARCHAR(25)     NOT NULL,
    `FirstName`         VARCHAR(50)     NOT NULL,
    `LastName`          VARCHAR(50)     NOT NULL,
    `Address`           VARCHAR(100)    NOT NULL,
    `City`              VARCHAR(25)     NOT NULL,
    `State`             CHAR(2)         NOT NULL,
    `Zip`               VARCHAR(10)     NOT NULL,
    `Phone`             VARCHAR(15)     NOT NULL,
    `Email`             VARCHAR(50)     NOT NULL,
    PRIMARY KEY (`empID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`customer` (
    `cusID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `FirstName`         VARCHAR(50)     NOT NULL,
    `LastName`          VARCHAR(50)     NOT NULL,
    `Address`           VARCHAR(100)    NOT NULL,
    `City`              VARCHAR(25)     NOT NULL,
    `State`             CHAR(2)         NOT NULL,
    `Zip`               VARCHAR(10)     NOT NULL,
    `Phone`             VARCHAR(15)     NOT NULL,
    `Email`             VARCHAR(50)     NOT NULL,
    PRIMARY KEY (`cusID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`inventory` (
    `invID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `Description`       VARCHAR(200)    NOT NULL,
    `Cost`              DECIMAL(6 , 2 ) NOT NULL,
    `Quantity`          INT(3)          NOT NULL,
    `Available`         BIT             NOT NULL,
    PRIMARY KEY (`invID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`type` (
    `typID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `Description`       VARCHAR(100)    NOT NULL,
    `Meaning`           VARCHAR(250)    NOT NULL,
    `Price`             DECIMAL(6 , 2)  NOT NULL,
    PRIMARY KEY (`typID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`order` (
    `ordID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `cusID`             INT(2)          NOT NULL,
    `invID`             INT(2)          NOT NULL,
    `empID`             INT(2)          NOT NULL,
    `typID`             INT(2)          NOT NULL,
    `Date`              DATETIME        NOT NULL,
    `Complete`          BIT             NOT NULL COMMENT 'Order Open or Closed (1 = Open 0 = Closed)',
    PRIMARY KEY (`ordID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`payments` (
    `payID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `ordID`             INT(2)          NOT NULL,
    `empID`             INT(2)          NOT NULL,
    `Date`              DATETIME        NOT NULL,
    `Paid`              DECIMAL(6 , 2 ) NOT NULL,
    `Due`               DECIMAL(6 , 2 ) NOT NULL,
    PRIMARY KEY (`payID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`notification` (
    `ntfID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `ordID`             INT(2)          NOT NULL,
    `Notice`            VARCHAR(500)    NOT NULL,
    `Read`              BIT             NULL COMMENT 'Message Read (1 = Yes, 0 = No)',
    PRIMARY KEY (`ntfID`)
) ENGINE=INNODB;

--------------------- [ Run After Above Script while in "williams" schema ] ------------------------

ALTER TABLE `payments`
ADD CONSTRAINT `payments_fk0` FOREIGN KEY (`ordID`) REFERENCES `order`(`ordID`);

ALTER TABLE `payments`
ADD CONSTRAINT `payments_fk1` FOREIGN KEY (`empID`) REFERENCES `employee`(`empID`);

ALTER TABLE `order`
ADD CONSTRAINT `order_fk0` FOREIGN KEY (`cusID`) REFERENCES `customer`(`cusID`);

ALTER TABLE `order`
ADD CONSTRAINT `order_fk1` FOREIGN KEY (`invID`) REFERENCES `inventory`(`invID`);

ALTER TABLE `order`
ADD CONSTRAINT `order_fk2` FOREIGN KEY (`empID`) REFERENCES `employee`(`empID`);

ALTER TABLE `order`
ADD CONSTRAINT `order_fk3` FOREIGN KEY (`typID`) REFERENCES `type`(`typID`);

ALTER TABLE `notification`
ADD CONSTRAINT `notification_fk0` FOREIGN KEY (`ordID`) REFERENCES `order`(`ordID`);

ALTER TABLE `credentials`
ADD CONSTRAINT `credentials_fk0` FOREIGN KEY (`empID`) REFERENCES `employee`(`empID`);

ALTER TABLE `employee`
ADD CONSTRAINT `employee_fk0` FOREIGN KEY (`typID`) REFERENCES `type`(`typID`);