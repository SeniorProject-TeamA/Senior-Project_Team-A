/*********************************************************************************************
 *Williams Specialty Company - Business Process Automation                                   *
 *MySQL - Create Database                                                                    *
 *********************************************************************************************
 **********************************************UPDATES****************************************
 *March 28th, 2016 - Justin Byrne Created                                                    *
 *March 29th, 2016 - Joe Gibson - Update customer Table added column ActiveIND               *
 *March 30th, 2016 - John Boley - Fixed the DateTime fields on two tables.                   *
 *March 30th, 2016 - Joe Gibson - Added Columns in Orders Table, Cleaned up typID columns    *
 *April 5th, 2016  - Joe Gibson - Combined all small scripts into one.                       *
 *April 7th, 2016  - Joe Gibson - Added Stockroom Clerk Types, Employees, and Credentials    *
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
    `ActiveIND`         BIT             NOT NULL COMMENT 'Customer Still Still Active (1 = Active 0 = Inactive)',
    PRIMARY KEY (`cusID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`inventory` (
    `invID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `typID`             INT(2)          NOT NULL,
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
    `Price`             DECIMAL(6 , 2),
    PRIMARY KEY (`typID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`orders` (
    `ordID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `cusID`             INT(2)          NOT NULL,
    `invID`             INT(2)          NOT NULL,
    `empID`             INT(2)          NOT NULL,
    `typID`             INT(2)          NOT NULL,
    `Details`			VARCHAR(500)	NOT NULL,
    `Date`              DATETIME        NOT NULL DEFAULT NOW(),
    `Quantity`			INT(3)      	NOT NULL,
    `Complete`          BIT             NOT NULL COMMENT 'Order Open or Closed (1 = Open 0 = Closed)',
    PRIMARY KEY (`ordID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`payments` (
    `payID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `ordID`             INT(2)          NOT NULL,
    `empID`             INT(2)          NOT NULL,
    `typID`             INT(2)			NOT NULL,
    `Date`              DATETIME        NOT NULL DEFAULT NOW(),
    `Paid`              DECIMAL(6 , 2 ) NOT NULL,
    `Due`               DECIMAL(6 , 2 ) NOT NULL,
    PRIMARY KEY (`payID`)
) ENGINE=INNODB;

CREATE TABLE `williams`.`notification` (
    `ntfID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `ordID`             INT(2)          NOT NULL,
    `typID`             INT(2)			NOT NULL,
    `Subject`           VARCHAR(50)     NOT NULL,
    `Notice`            VARCHAR(500)    NOT NULL,
    `Opened`            BIT             NOT NULL COMMENT 'Message Read (1 = Yes, 0 = No)',
    PRIMARY KEY (`ntfID`)
) ENGINE=INNODB;

-- Alter Statements

ALTER TABLE `williams`.`employee` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`customer` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`inventory` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`employee` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`notification` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`orders` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`payments` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`type` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`payments`
ADD CONSTRAINT `payments_fk0` FOREIGN KEY (`ordID`) REFERENCES `williams`.`orders`(`ordID`);

ALTER TABLE `williams`.`payments`
ADD CONSTRAINT `payments_fk1` FOREIGN KEY (`empID`) REFERENCES `williams`.`employee`(`empID`);

ALTER TABLE `williams`.`orders`
ADD CONSTRAINT `orders_fk0` FOREIGN KEY (`cusID`) REFERENCES `williams`.`customer`(`cusID`);

ALTER TABLE `williams`.`orders`
ADD CONSTRAINT `orders_fk1` FOREIGN KEY (`invID`) REFERENCES `williams`.`inventory`(`invID`);

ALTER TABLE `williams`.`orders`
ADD CONSTRAINT `orders_fk2` FOREIGN KEY (`empID`) REFERENCES `williams`.`employee`(`empID`);

ALTER TABLE `williams`.`orders`
ADD CONSTRAINT `orders_fk3` FOREIGN KEY (`typID`) REFERENCES `williams`.`type`(`typID`);

ALTER TABLE `williams`.`notification`
ADD CONSTRAINT `notification_fk0` FOREIGN KEY (`ordID`) REFERENCES `williams`.`orders`(`ordID`);

ALTER TABLE `williams`.`credentials`
ADD CONSTRAINT `credentials_fk0` FOREIGN KEY (`empID`) REFERENCES `williams`.`employee`(`empID`);

ALTER TABLE `williams`.`employee`
ADD CONSTRAINT `employee_fk0` FOREIGN KEY (`typID`) REFERENCES `williams`.`type`(`typID`);

ALTER TABLE `williams`.`notification`
ADD CONSTRAINT `notification_fk1` FOREIGN KEY (`typID`) REFERENCES `williams`.`type`(`typID`);

ALTER TABLE `williams`.`payments`
ADD CONSTRAINT `payments_fk2` FOREIGN KEY (`typID`) REFERENCES `williams`.`type`(`typID`);

ALTER TABLE `williams`.`inventory`
ADD CONSTRAINT `inventory_fk0` FOREIGN KEY (`typID`) REFERENCES `williams`.`type` (`typID`);

-- INSERT into TYPE

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Permissions for Sales Clerk', 'SALES_CLERK_PERMISSION', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Permissions for Specialist', 'SPECIALIST_PERMISSION', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Permissions for Operations Manager', 'OPERATIONS_MANAGER_PERMISSION', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Permissions for Sales Clerk', 'SALES_CLERK_PERMISSION', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Payment Not Received', 'PAYMENT_NONE', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Partial Payment Received', 'PAYMENT_PARTIAL', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Payment Received in Full', 'PAYMENT_FULL', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Sales Clerk', 'TYPE_SALES_CLERK', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Specialist', 'TYPE_SPECIALIST', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Operations Manager', 'TYPE_OPERATIONS_MANAGER', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Print Job', 'TYPE_JOB_PRINT', '39.99');

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Engrave Job', 'TYPE_ENGRAVE_JOB', '69.99');

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('T-Shirt', 'TYPE_MEDIA_TSHIRT', '12.99 ');

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Paper', 'TYPE_MEDIA_PAPER', '0.10 ');

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Trophy', 'TYPE_MEDIA_TROPHY', '45.99');

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Plaque', 'TYPE_MEDIA_PLAQUE', '85.99 ');

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Order Validated', 'TYPE_ORDER_VALID', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Order Not Validated', 'TYPE_ORDER_NOT_VALID', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Order Pass QA', 'TYPE_QA_PASS', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Order Fail QA', 'TYPE_QA_FAIL', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Work Complete', 'TYPE_WORK_COMPLETE', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Order Ready for Delivery', 'TYPE_ORDER_READY_DELIVER', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Permissions for Stockroom Clerk', 'STOCKROOM_CLERK_PERMISSION', 0);

INSERT INTO `williams`.`type` (Description, Meaning, Price)
VALUES ('Stockroom Clerk', 'TYPE_STOCKROOM_CLERK', 0);

-- INSERT into EMPLOYEE

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Sales Clerk', 'Jon', 'Holt', '5458 Riverside Dr.', 'San Francisco', 'CA', '94101', '(415) 555-5124', 'jholt@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('9', 'Specialist', 'Barry', 'Collins', '12178 Paloma Ave.', 'San Francisco', 'CA', '94110', '(628) 555-1367', 'bcollins@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('10', 'Operations Manager', 'Phillip', 'Panzer', '1826 Avendale Dr.', 'San Francisco', 'CA', '94101', '(415) 555-0245', 'ppanzer@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('9', 'Specialist', 'Eugene', 'Williams', '1669 Vista View Circle.', 'San Francisco', 'CA', '94110', '(628) 555-6748', 'ewilliams@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('9', 'Specialist', 'Bradley', 'Jordan', '125 Pennington Way, Apt. B', 'Oakland', 'CA', '94601', '(510) 844-9072', 'bjordan@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Sales Clerk', 'Lora', 'Bailey', '4418 Ballentine Ave.', 'San Mateo', 'CA', '94403', '(650) 694-0098', 'lbailey@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('10', 'Operations Manager', 'Rich', 'Canter', '1111 Shasta Dr.', 'San Francisco', 'CA', '94101', '(415) 555-1021', 'rcanter@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('9', 'Specialist', 'Terry', 'Jefferies', '1808 Desert Brush Dr.', 'San Francisco', 'CA', '94110', '(628) 555-1998', 'tjefferies@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Sales Clerk', 'Tracy', 'Maddison', '2248 Sagebrush Ave.', 'San Francisco', 'CA', '94101', '(415) 555-8877', 'tmaddison@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Sales Clerk', 'Brittany', 'Ballinger', '14668 Airview Dr.', 'San Mateo', 'CA', '94401', '(650) 694-7872', 'bballinger@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('9', 'Specialist', 'Earl', 'Helm', '11121 E. Cactus Rd.', 'Oakland', 'CA', '94601', '(510) 844-3197', 'ehelm@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Sales Clerk', 'Paul', 'Troby', '1741 Carlsbad Way', 'San Mateo', 'CA', '94403', '(650) 694-1554', 'ptroby@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('24', 'Stockroom Clerk', 'Daniel', 'Medlen', '8412 Flatbush Ave.', 'San Mateo', 'CA', '94403', '(650) 424-1977', 'dmedlen@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('24', 'Stockroom Clerk', 'Joanna', 'James', '1994 Piedmont St.', 'San Francisco', 'CA', '94101', '(628) 801-3214', 'jjames@wsc.com');

-- INSERT into CREDENTIALS

INSERT INTO `williams`.`credentials`
VALUES ('1', 'Provo12');

INSERT INTO `williams`.`credentials` 
VALUES ('2', 'Marvel02');

INSERT INTO `williams`.`credentials` 
VALUES ('3', 'NoisyLotus1');

INSERT INTO `williams`.`credentials`
VALUES ('4', 'Typical11');

INSERT INTO `williams`.`credentials` 
VALUES ('5', 'pAradise77');

INSERT INTO `williams`.`credentials` 
VALUES ('6', 'taranTula1965');

INSERT INTO `williams`.`credentials` 
VALUES ('7', 'mo22erellaM3lt');

INSERT INTO `williams`.`credentials` 
VALUES ('8', '3ggPlants');

INSERT INTO `williams`.`credentials` 
VALUES ('9', 'Charg3rsRul3');

INSERT INTO `williams`.`credentials` 
VALUES ('10', 'Silv3rAndBlack');

INSERT INTO `williams`.`credentials` 
VALUES ('11', 'pretzy1');

INSERT INTO `williams`.`credentials` 
VALUES ('12', 'Gh0st1y');

INSERT INTO `williams`.`credentials`
VALUES ('13', 'Symb014pi');

INSERT INTO `williams`.`credentials`
VALUES ('14', 'lAwNM0wer121');

-- INSERT into CUSTOMER

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Mary', 'Castiglia', '1335 Buxton St.', 'Boston', 'MA', '02141', '(221) 848-8945', 'mcasts@gmail.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Roland', 'Smith', '2212 Elm St.', 'Raleigh', 'NC', '04187', '(713) 422-5874', 'roland.smith@gmail.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Robert', 'Withrow', '1974 Alta Vista Ln.', 'Miami', 'FL', '84015', '(218) 547-9684', 'bob.withrow@outlook.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Carey', 'Stegner', '1993 Cottonwood Dr.', 'Alexandria', 'VA', '02141', '(713) 995-2219', 'carey_stegs@comcast.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Laura', 'Johnson', '713 Pawnee Ln.', 'Belton', 'MO', '64012', '(816) 804-1235', 'ljohnson@kc.rr.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Joshua', 'Pernell', '16001 Valentine Ave.', 'Charleston', 'SC', '02148', '(918) 506-7591', 'josh_pernell@hotmail.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Paula', 'Pinnix', '14894 Pinehurst Rd.', 'Bixby', 'OK', '74012', '(916) 881-9258', 'p.pinnix@cox.net', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Ryan', 'Caldwell', '19981 Tolliver St.', 'Augusta', 'ME', '03901', '(207) 848-8945', 'mcasts@gmail.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Travis', 'Deal', '604 Quayle Rd.', 'Dallas', 'TX', '41895', '(415) 882-7469', 'tdeal@gmail.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Roberto', 'Alvarez', '1854 Palm Terrace', 'Houston', 'TX', '41998', '(209) 664-8954', 'alvarez_r@outlook.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Blaine', 'Brooks', '11881 Blacktree Pl.', 'Louisville', 'KY', '02149', '(715) 887-8721', 'double_b@hotmail.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Joe', 'Bronson', '917 S. Westover Rd.', 'Lenexa', 'KS', '66023', '(913) 419-7732', 'joe.bron@kc.rr.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Ruby', 'Lee', '2580 Vicie Ave.', 'Los Angeles', 'CA', '02148', '(812) 323-4543', 'rubylee@msn.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Isaac', 'Sorrens', '323 Oakridge Blvd.', 'Orlando', 'FL', '54261', '(706) 408-2237', 'isaacs@comcast.com', 1);

INSERT INTO `williams`.`customer` (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('Darion', 'Bradley', '12114 Sunnybrook Rd.', 'Surprise', 'AZ', '99412', '(978) 877-4568', 'dbrads@kc.rr.com', 1);

-- INSERT into INVENTORY

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('13', 'T-Shirt, Short Sleeve, White', '7.99', '60', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('13', 'T-Shirt, Short Sleeve, Red', '7.99', '75', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('13', 'T-Shirt, Short Sleeve, Blue', '7.99', '50', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('13', 'T-Shirt, Long Sleeve, White', '12.99', '20', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('14', 'Pamphlet, Photo Generic', '0.25', '500', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('14', 'Cardstock, white', '0.49', '500', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('14', 'Plain, White', '0.08', '800', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('14', 'Special Order, Generic', '1.99', '0', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('15', 'Baseball, Generic, Hitter', '21.99', '30', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('15', 'Baseball, In-Motion, Pitcher', '28.99', '25', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('15', 'Basketball, In-Motion, Shooter', '29.99', '50', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('15', 'Basketball, Generic, Shooter', '26.99', '40', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('16', 'Two-plate, Generic, Crest Shaped', '39.99', '25', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('16', 'One-plate, Generic, Square', '37.99', '25', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('13', 'One-plate, Picture, Oval', '45.99', '30', 1);

INSERT INTO `williams`.`inventory` (typID, Description, Cost, Quantity, Available)
VALUES ('13', 'Two-plate, Picture, Square', '47.99', '60', 1);

-- INSERT into ORDERS

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Quantity, Complete)
VALUES ('7', '12', '6', '12', 'Rogers Intramural Champions 2016', '12', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Quantity, Complete)
VALUES ('10', '4', '10', '11', 'Stencil Logo Flaming Basketball Through Hoop. Phrase "En Fuego" below logo.', '1', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Quantity, Complete)
VALUES ('2', '16', 1, '12', 'Top Plate: Congratulations; Font: Castellar; Bottom Plate: Top Sales Q4, 2015; Font: Castellar; Picture: Framed Dollar Bill.', '1', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Quantity, Complete)
VALUES ('1', '2', '9', '11', 'Chevrolet Bowtie: Front; Phrase: Nothin Runs Like A Chevy: Below.', '1', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Quantity, Complete)
VALUES ('14', '7', '12', '11', 'Flier: Custom Format Provided by Customer: See attached', '100', 1);

-- INSERT into NOTIFICATION

INSERT INTO `williams`.`notification` (ordID, typID, Subject, Notice, Opened)
VALUES (1, 17, 'Order# 1 Validated.', 'Customer information validated. Ready for processing.', 1);

INSERT INTO `williams`.`notification` (ordID, typID, Subject, Notice, Opened)
VALUES (2, 18, 'Order# 2 NOT Validated.', 'Customer information failed validation. Make Corrections.', 1);

INSERT INTO `williams`.`notification` (ordID, typID, Subject, Notice, Opened)
VALUES (3, 19, 'Order# 3 PASS QA.', 'Order passed QA. Ready For Delivery to Sales Person.', 1);

INSERT INTO `williams`.`notification` (ordID, typID, Subject, Notice, Opened)
VALUES (4, 20, 'Order# 4 FAIL QA.', 'Order failed QA. Scratch on Plate 1 Lower Left Corner. Rework or reprocess.', 0);

INSERT INTO `williams`.`notification` (ordID, typID, Subject, Notice, Opened)
VALUES (5, 21, 'Order# 5 Work Complete.', 'Ready to Process', 0);

INSERT INTO `williams`.`notification` (ordID, typID, Subject, Notice, Opened)
VALUES (3, 22, 'Order# 3 Complete.', 'Call Customer to arrange delivery.', 0);

-- INSERT into PAYMENTS

INSERT INTO `williams`.`payments` (ordID, empID, typID, Paid, Due)
VALUES ('1', '1', '5', '0.00', '540.97');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Paid, Due)
VALUES ('2', '6', '6.', '22.50', '202.50');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Paid, Due)
VALUES ('3', '9', '7', '133.50', '0.00');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Paid, Due)
VALUES ('4', '10', '6.', '18.50', '166.50');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Paid, Due)
VALUES ('5', '12', '5', '0.00', '200.98');

-- CREATE VIEWS

/* Select Statement ---------------------------------------------------------*/

CREATE VIEW `williams`.`activeCustomer` AS
SELECT * FROM `williams`.`customer`
WHERE `ActiveIND` = 1;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`inactiveCustomer` AS
SELECT * FROM `williams`.`customer`
WHERE `ActiveIND` = 0;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderClosed` AS
SELECT * FROM `williams`.`orders`
WHERE `Complete` = 0;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`productAvailable` AS
SELECT * FROM `williams`.`inventory`
WHERE `Available` = 1;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`noticationUnread` AS
SELECT * FROM `williams`.`notification`
WHERE `Opened` = 0;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`notificationRead` AS
SELECT * FROM `williams`.`notification`
WHERE `Opened` = 1;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`ordersOpen` AS
SELECT * FROM `williams`.`orders`
WHERE `Complete` = 1;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`engraveJobs` AS
SELECT * FROM `williams`.`orders`
WHERE `typID` = 12;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`printJobs` AS
SELECT * FROM `williams`.`orders`
WHERE `typID` = 11;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`salesClerks` AS
SELECT * FROM `williams`.`employee`
WHERE `typID` = 8;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`specialists` AS
SELECT * FROM `williams`.`employee`
WHERE `typID` = 9;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`operationsManagers` AS
SELECT * FROM `williams`.`employee`
WHERE `typID` = 10;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusPassValidation` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 17;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusFailValidation` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 18;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusPassQA` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 19;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusFailQA` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 20;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusWorkComplete` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 21;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusReadForDelivery` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 22;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`extensiveOrderReport` AS
SELECT orders.ordID AS "Order Number", type.description AS "Order Type", CONCAT(customer.Firstname,' ',customer.LastName) AS "Customer Name", 
	   orders.date AS "Order Date", orders.Quantity AS "Quantity Ordered", inventory.Description AS "Items Ordered", orders.Details AS "Order Details", CONCAT(employee.FirstName,' ',employee.LastName) AS "Sales Associate", 
	   payments.Paid AS "Total Paid", payments.Due AS "Total Due"
FROM `williams`. `orders`
INNER JOIN `williams`.`customer`
ON orders.cusID=customer.cusID
INNER JOIN `williams`.`employee`
ON orders.empID=employee.empID
INNER JOIN `williams`.`type`
ON orders.typID=type.typID
INNER JOIN `williams`.`payments`
ON orders.ordID=payments.ordID
INNER JOIN `williams`.`inventory`
ON orders.invID=inventory.invID
WHERE Complete=1

--Create Procedures

/*-------------------------------------------------------------------------------------------------------------------------------------------------*/

DELIMITER $$
CREATE
    PROCEDURE `williams`.`customerInsert`(IN `FirstName` VARCHAR(50), IN `LastName` VARCHAR(50), IN `Address`VARCHAR(100),IN `City`VARCHAR(25),
    IN `State`CHAR(2), IN `Zip`VARCHAR(10),IN `Phone`VARCHAR(15), IN `Email`VARCHAR(50),`ActiveIND` BIT(1))
    BEGIN
	INSERT INTO `customer`(`FirstName`,`LastName`,`Address`,`City`,`State`,`Zip`,`Phone`,`Email`,`ActiveIND`)
	VALUES(`FirstName`,`LastName`,`Address`,`City`,`State`,`Zip`,`Phone`,`Email`,`ActiveIND`); 
    END$$
DELIMITER ;
/*-------------------------------------------------------------------------------------------------------------------------------------------------*/

DELIMITER $$
CREATE   
    PROCEDURE `williams`.`orderInsert`(IN `cusID` INT(2),IN `invID` INT(2),IN `empID` INT(2),IN `typID` INT(6),
    IN `Details` VARCHAR(500),IN `Quantity` INT(3),IN `Complete` BIT(1))
    BEGIN
	INSERT INTO `order`(`cusID`,`invID`,`empID`,`typID`,`Details`,`Quantity`,`Complete`)
	VALUES (`cusID`,`invID`,`empID`,`typID`,`Details`,`Quantity`,`Complete`);
    END$$
DELIMITER ;
/*--------------------------------------------------------------------------------------------------------------------------------------------------*/

DELIMITER $$
CREATE    
    PROCEDURE `williams`.`employeeInsert`(IN `typID` INT(2),IN `Title` VARCHAR(25),IN `FirstName`VARCHAR(50),
    IN `LastName`VARCHAR(50),IN `Address`VARCHAR(100),IN `City`VARCHAR(25),IN `State`CHAR(2),IN `Zip`VARCHAR(10),
    IN `Phone`VARCHAR(15),IN `Email`VARCHAR(50))
    BEGIN
	INSERT INTO `employee`(`typID`,`Title`,`FirstName`,`LastName`,`Address`,`City`,`State`,`Zip`,`Phone`,`Email`)
	VALUES (`typID`,`Title`,`FirstName`,`LastName`,`Address`,`City`,`State`,`Zip`,`Phone`,`Email`);
    END$$
DELIMITER ;
/*---------------------------------------------------------------------------------------------------------------------------------------------------*/

DELIMITER $$
CREATE   
    PROCEDURE `williams`.`inventoryInsert`(IN `typID` INT(2),IN `Description`VARCHAR(200),IN `Cost` DECIMAL(6,2),IN `Quantity` INT(3),
    IN `Available` BIT(1))
    BEGIN
	INSERT INTO `inventory`(`typID`,`Description`,`Cost`,`Quantity`,`Available`)
	VALUES (`typID`,`Description`,`Cost`,`Quantity`,`Available`);
    END$$
DELIMITER ;
/*---------------------------------------------------------------------------------------------------------------------------------------------------*/

DELIMITER $$
CREATE
    PROCEDURE `williams`.`credentialsInsert`(IN `Password`VARCHAR(25))
    BEGIN
	INSERT INTO `credentials`(`Password`)
	VALUES(`Password`);
    END$$
DELIMITER ;
/*----------------------------------------------------------------------------------------------------------------------------------------------------*/

DELIMITER $$
CREATE
    PROCEDURE `williams`.`paymentInsert`(IN `ordID` INT(2),IN `empID` INT(2),IN `typID` INT(2),IN `Paid` DECIMAL(6,2),
    IN `Due` DECIMAL(6,2))
    BEGIN
	INSERT INTO `payments`(`ordID`,`empID`,`typID`,`Paid`,`Due`)
	VALUES (`ordID`,`empID`,`typID`,`Paid`,`Due`);
    END$$
DELIMITER ;
/*-----------------------------------------------------------------------------------------------------------------------------------------------------*/

DELIMITER $$
CREATE
    PROCEDURE `williams`.`notificationInsert`(IN `ordID` INT(2),IN `typID` INT(2),IN `Subject` VARCHAR(50),IN `Notice`VARCHAR(500),
    IN `Opened`BIT(1))
    BEGIN
	INSERT INTO `notification`(`ordID`,`typID`,`Subject`,`Notice`,`Opened`)
	VALUES (`ordID`,`typID`,`Subject`,`Notice`,`Opened`);
    END$$
DELIMITER ;

/*--------------------------------------------------------------------------------------------------------------------------------------------------END*/

