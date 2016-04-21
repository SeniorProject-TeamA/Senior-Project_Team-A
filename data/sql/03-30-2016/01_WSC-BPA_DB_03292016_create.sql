/*********************************************************************************************
 *Williams Specialty Company - Business Process Automation                                   *
 *MySQL - Create Database                                                                    *
 *********************************************************************************************
 **********************************************UPDATES****************************************
 *March 28th, 2016 - Justin Byrne Created                                                    *
 *March 29th, 2016 - Joe Gibson - Update customer Table added column ActiveIND               *
 *********************************************************************************************/

CREATE SCHEMA `williams` CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON `williams`.* TO `wscAdmin`@localhost IDENTIFIED BY 'password01';

CREATE TABLE `williams`.`credentials` (
    `empID`             INT(2)          NOT NULL,
    `Password`          VARCHAR(25)     NOT NULL Comment 'Must contain combination of upper case, lower case, and numbers',
    PRIMARY KEY (`empID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`employee` (
    `empID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `emptypID`          INT(2)          NOT NULL,
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
    `ActiveIND`         BIT             NOT NULL COMMENT 'Customer Still Still Active (1 = Active 0 = Inactive)',
    PRIMARY KEY (`cusID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`inventory` (
    `invID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `invtypID`          INT(2)          NOT NULL,
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

CREATE TABLE `williams`.`orders` (
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
    `typID`             INT(2)          NOT NULL,
    `Date`              DATETIME        NOT NULL,
    `Paid`              DECIMAL(6 , 2 ) NOT NULL,
    `Due`               DECIMAL(6 , 2 ) NOT NULL,
    PRIMARY KEY (`payID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`notification` (
    `ntfID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `ordID`             INT(2)          NOT NULL,
    `typeID`            INT(2)          NOT NULL,
    `Subject`           VARCHAR(50)     NOT NULL,
    `Notice`            VARCHAR(500)    NOT NULL,
    `Opened`            BIT             NOT NULL COMMENT 'Message Read (1 = Yes, 0 = No)',
    PRIMARY KEY (`ntfID`)
) ENGINE=INNODB;