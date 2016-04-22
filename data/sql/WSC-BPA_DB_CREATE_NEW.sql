/************************************************************************************************
 *Williams Specialty Company - Business Process Automation                                      *
 *MySQL - Create Database                                                                       *
 ************************************************************************************************
 **********************************************UPDATES*******************************************
 *March 28th, 2016 - Justin Byrne Created                                                       *
 *March 29th, 2016 - Joe Gibson - Update customer Table added column ActiveIND                  *
 *March 30th, 2016 - John Boley - Fixed the DateTime fields on two tables.                      *
 *March 30th, 2016 - Joe Gibson - Added Columns in Orders Table, Cleaned up typID columns       *
 *April 5th,  2016 - Joe Gibson - Combined all small scripts into one.                          *
 *April 7th,  2016 - Joe Gibson - Added Stockroom Clerk Types, Employees, and Credentials       *
 *April 14th, 2016 - Joe Gibson - Added two columns to Credentials Table for Login Security     *
 *April 15th, 2016 - Joe Gibson - Removed duplicate Type Row. Updated Inserts to Reflect Change *
 *April 17th, 2016 - Joe Gibson - Added Columns in payments for billing information             *
 *April 20th, 2016 - Joe Gibson - Massive changes to structure, inserts, and views              *
 *April 21st, 2016 - Joe Gibson - Added payID to payments and customer table to tie billing info*
 ***********************************************************************************************/

CREATE SCHEMA `williams` CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON `williams`.* TO `wscAdmin`@localhost IDENTIFIED BY 'password01';

-- Create Table - credentials

CREATE TABLE `williams`.`credentials` (
    `empID`             INT(2)          NOT NULL,
    `Password`          VARCHAR(25)     NOT NULL Comment 'Must contain combination of upper case, lower case, and numbers',
    `Time`				VARCHAR(30)     NOT NULL,
    `LoginAttempts`		INT(1)          NOT NULL,
    `ActiveIND`			BIT 			NOT NULL Comment '1= Active, 0=Inactive; Inactivated after 5 unsuccessful attempts',
    PRIMARY KEY (`empID`)
) ENGINE=INNODB;

-- Create Table - employee

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

-- Create Table - customer

CREATE TABLE `williams`.`customer` (
    `cusID`             INT(2)          NOT NULL AUTO_INCREMENT,
	`payID`             INT(2)          NOT NULL,
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

-- Create Table - inventory

CREATE TABLE `williams`.`inventory` (
    `invID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `typID`             INT(2)          NOT NULL,
    `Manufacturer`      VARCHAR(100)    NOT NULL,
    `Available`         BIT             NOT NULL,
    PRIMARY KEY (`invID`)
) ENGINE=INNODB;

-- Create Table - type

CREATE TABLE `williams`.`type` (
    `typID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `Description`       VARCHAR(100)    NOT NULL,
    `Meaning`           VARCHAR(250)    NOT NULL,
    PRIMARY KEY (`typID`)
) ENGINE=INNODB;

-- Create Table - orders

CREATE TABLE `williams`.`orders` (
    `ordID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `cusID`             INT(2)          NOT NULL,
    `invID`             INT(2)          NOT NULL,
    `empID`             INT(2)          NOT NULL,
    `typID`             INT(2)          NOT NULL,
    `Details`			VARCHAR(500)	NOT NULL,
    `Complete`          BIT             NOT NULL COMMENT 'Order Open or Closed (1 = Open 0 = Closed)',
    PRIMARY KEY (`ordID`)
) ENGINE=INNODB;

-- Create Table - payments

CREATE TABLE `williams`.`payments` (
    `payID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `ordID`             INT(2)          NOT NULL,
    `empID`             INT(2)          NOT NULL,
    `typID`             INT(2)			NOT NULL,
    `Address`           VARCHAR(100)    NOT NULL,
    `City`              VARCHAR(25)     NOT NULL,
    `State`             CHAR(2)         NOT NULL,
    `Zip`               VARCHAR(10)     NOT NULL,
    `Date`              DATETIME        NOT NULL DEFAULT NOW(),
    PRIMARY KEY (`payID`)
) ENGINE=INNODB;

-- Create Table - notification

CREATE TABLE `williams`.`notification` (
    `ntfID`             INT(2)          NOT NULL AUTO_INCREMENT,
    `ordID`             INT(2)          NOT NULL,
    `typID`             INT(2)			NOT NULL,
    `Memo`              VARCHAR(500)    NOT NULL,
    `Opened`            BIT             NOT NULL COMMENT 'Message Read (1 = Yes, 0 = No)',
    PRIMARY KEY (`ntfID`)
) ENGINE=INNODB;

-- Create Table - qa

CREATE TABLE `williams`.`qa` (
    `qaID`             INT(3)          NOT NULL AUTO_INCREMENT,
    `ordID`            INT(3)          NOT NULL,
    `Scratch`          BIT             NOT NULL COMMENT '1 = YES, 0 = NO',
    `Dent`             BIT             NOT NULL COMMENT '1 = YES, 0 = NO',
    `Break`            BIT             NOT NULL COMMENT '1 = YES, 0 = NO',
    `Misspelling`      BIT             NOT NULL COMMENT '1 = YES, 0 = NO',
    `Smudge`           BIT             NOT NULL COMMENT '1 = YES, 0 = NO',
    `Tear`             BIT             NOT NULL COMMENT '1 = YES, 0 = NO',
    `Discoloration`    BIT             NOT NULL COMMENT '1 = YES, 0 = NO',
    PRIMARY KEY (`qaID`)
) ENGINE=INNODB;



-- INSERT into TYPE

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Permissions for Sales Clerk', 'SALES_CLERK_PERMISSION');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Permissions for Specialist', 'SPECIALIST_PERMISSION');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Permissions for Operations Manager', 'OPERATIONS_MANAGER_PERMISSION');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Payment Not Received', 'PAYMENT_NONE');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Partial Payment Received', 'PAYMENT_PARTIAL');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Payment Received in Full', 'PAID_IN_FULL');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Sales Clerk', 'TYPE_SALES_CLERK');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Specialist', 'TYPE_SPECIALIST');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Operations Manager', 'TYPE_OPERATIONS_MANAGER');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Print Job', 'TYPE_JOB_PRINT');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Engrave Job', 'TYPE_ENGRAVE_JOB');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Clothing', 'TYPE_MEDIA_CLOTHING');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Trophy', 'TYPE_MEDIA_TROPHY');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Plaque', 'TYPE_MEDIA_PLAQUE');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Order Validated', 'TYPE_ORDER_VALID');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Order Not Validated', 'TYPE_ORDER_NOT_VALID');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Order Pass QA', 'TYPE_QA_PASS');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Order Fail QA', 'TYPE_QA_FAIL');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Work Complete', 'TYPE_WORK_COMPLETE');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Order Ready for Delivery', 'TYPE_ORDER_READY_DELIVER');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Permissions for Stockroom Clerk', 'STOCKROOM_CLERK_PERMISSION');

INSERT INTO `williams`.`type` (Description, Meaning)
VALUES ('Stockroom Clerk', 'TYPE_STOCKROOM_CLERK');

-- INSERT into EMPLOYEE

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('7', 'Sales Clerk', 'Jon', 'Holt', '5458 Riverside Dr.', 'San Francisco', 'CA', '94101', '(415) 555-5124', 'jholt@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Specialist', 'Barry', 'Collins', '12178 Paloma Ave.', 'San Francisco', 'CA', '94110', '(628) 555-1367', 'bcollins@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('9', 'Operations Manager', 'Phillip', 'Panzer', '1826 Avendale Dr.', 'San Francisco', 'CA', '94101', '(415) 555-0245', 'ppanzer@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Specialist', 'Eugene', 'Williams', '1669 Vista View Circle.', 'San Francisco', 'CA', '94110', '(628) 555-6748', 'ewilliams@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Specialist', 'Bradley', 'Jordan', '125 Pennington Way, Apt. B', 'Oakland', 'CA', '94601', '(510) 844-9072', 'bjordan@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('7', 'Sales Clerk', 'Lora', 'Bailey', '4418 Ballentine Ave.', 'San Mateo', 'CA', '94403', '(650) 694-0098', 'lbailey@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('9', 'Operations Manager', 'Rich', 'Canter', '1111 Shasta Dr.', 'San Francisco', 'CA', '94101', '(415) 555-1021', 'rcanter@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Specialist', 'Terry', 'Jefferies', '1808 Desert Brush Dr.', 'San Francisco', 'CA', '94110', '(628) 555-1998', 'tjefferies@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('7', 'Sales Clerk', 'Tracy', 'Maddison', '2248 Sagebrush Ave.', 'San Francisco', 'CA', '94101', '(415) 555-8877', 'tmaddison@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('7', 'Sales Clerk', 'Brittany', 'Ballinger', '14668 Airview Dr.', 'San Mateo', 'CA', '94401', '(650) 694-7872', 'bballinger@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('8', 'Specialist', 'Earl', 'Helm', '11121 E. Cactus Rd.', 'Oakland', 'CA', '94601', '(510) 844-3197', 'ehelm@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('7', 'Sales Clerk', 'Paul', 'Troby', '1741 Carlsbad Way', 'San Mateo', 'CA', '94403', '(650) 694-1554', 'ptroby@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('22', 'Stockroom Clerk', 'Daniel', 'Medlen', '8412 Flatbush Ave.', 'San Mateo', 'CA', '94403', '(650) 424-1977', 'dmedlen@wsc.com');

INSERT INTO `williams`.`employee` (typID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email)
VALUES ('22', 'Stockroom Clerk', 'Joanna', 'James', '1994 Piedmont St.', 'San Francisco', 'CA', '94101', '(628) 801-3214', 'jjames@wsc.com');



-- INSERT into CREDENTIALS

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('1', 'Provo12', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('2', 'Marvel02','', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('3', 'NoisyLotus1', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('4', 'Typical11', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('5', 'pAradise77', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('6', 'taranTula1965', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('7', 'mo22erellaM3lt', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('8', '3ggPlants', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('9', 'Charg3rsRul3', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('10', 'Silv3rAndBlack', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('11', 'pretzy1', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('12', 'Gh0st1y', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('13', 'Symb014pi', '', '0', '1');

INSERT INTO `williams`.`credentials` (empID, Password, Time, LoginAttempts, ActiveIND)
VALUES ('14', 'lAwNM0wer121', '', '0', '1');

-- INSERT into CUSTOMER

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('1', 'Mary', 'Castiglia', '1335 Buxton St.', 'Boston', 'MA', '02141', '(221) 848-8945', 'mcasts@gmail.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('2', 'Roland', 'Smith', '2212 Elm St.', 'Raleigh', 'NC', '04187', '(713) 422-5874', 'roland.smith@gmail.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('3', 'Robert', 'Withrow', '1974 Alta Vista Ln.', 'Miami', 'FL', '84015', '(218) 547-9684', 'bob.withrow@outlook.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('4', 'Carey', 'Stegner', '1993 Cottonwood Dr.', 'Alexandria', 'VA', '02141', '(713) 995-2219', 'carey_stegs@comcast.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('5', 'Laura', 'Johnson', '713 Pawnee Ln.', 'Belton', 'MO', '64012', '(816) 804-1235', 'ljohnson@kc.rr.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('6', 'Joshua', 'Pernell', '16001 Valentine Ave.', 'Charleston', 'SC', '02148', '(918) 506-7591', 'josh_pernell@hotmail.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('7', 'Paula', 'Pinnix', '14894 Pinehurst Rd.', 'Bixby', 'OK', '74012', '(916) 881-9258', 'p.pinnix@cox.net', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('8', 'Ryan', 'Caldwell', '19981 Tolliver St.', 'Augusta', 'ME', '03901', '(207) 848-8945', 'mcasts@gmail.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('9','Travis', 'Deal', '604 Quayle Rd.', 'Dallas', 'TX', '41895', '(415) 882-7469', 'tdeal@gmail.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('10', 'Roberto', 'Alvarez', '1854 Palm Terrace', 'Houston', 'TX', '41998', '(209) 664-8954', 'alvarez_r@outlook.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('11', 'Blaine', 'Brooks', '11881 Blacktree Pl.', 'Louisville', 'KY', '02149', '(715) 887-8721', 'double_b@hotmail.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('12', 'Joe', 'Bronson', '917 S. Westover Rd.', 'Lenexa', 'KS', '66023', '(913) 419-7732', 'joe.bron@kc.rr.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('13', 'Ruby', 'Lee', '2580 Vicie Ave.', 'Los Angeles', 'CA', '02148', '(812) 323-4543', 'rubylee@msn.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('14', 'Isaac', 'Sorrens', '323 Oakridge Blvd.', 'Orlando', 'FL', '54261', '(706) 408-2237', 'isaacs@comcast.com', 1);

INSERT INTO `williams`.`customer` (payID, FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND)
VALUES ('15', 'Darion', 'Bradley', '12114 Sunnybrook Rd.', 'Surprise', 'AZ', '99412', '(978) 877-4568', 'dbrads@kc.rr.com', 1);

-- INSERT into INVENTORY

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('12', 'Wilson Apparel', 1);

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('12', 'Under Armour', 1);

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('12', 'Russel Athletics', 1);

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('13', 'JDS Industries, Inc.', 1);

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('13', 'Trophy Wholesale Supplier, Inc.', 1);

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('13', 'Monumental Trophy, Inc.', 1);

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('14', 'Plaques are Us', 1);

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('14', 'Jon-Ko Wholesale', 1);

INSERT INTO `williams`.`inventory` (typID, Manufacturer, Available)
VALUES ('14', 'Statement Plaque Supply', 1);

-- INSERT into ORDERS

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('1', '4', '6', '11', 'Rogers Intramural Champions 2016', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('2', '1', '9', '10', 'Stencil Logo Flaming Basketball Through Hoop. Phrase "En Fuego" below logo.', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('3', '8', '1', '11', 'Top Plate: Congratulations; Font: Castellar; Bottom Plate: Top Sales Q4, 2015; Font: Castellar; Picture: Framed Dollar Bill.', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('4', '9', '10', '11', '2015 Annual Sales Leader', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('5', '5', '12', '11', 'District Co-Leader Golf', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('6', '3', '9', '10', 'Chevrolet Bowtie: Front; Phrase: Nothin Runs Like A Chevy: Below.', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('7', '2', '6', '10', 'STAFF on back', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('8', '1', '1', '10', 'VOLUNTEER on back.', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('9', '7', '12', '11', 'John Smith: Employee of the Month: September', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('10', '8', '1', '11', '5 Year Anniversary.', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('11', '2', '6', '10', 'Custom Team Logo: Dragon', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('12', '7', '10', '11', '$100k Total Annual Sales 2015', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('13', '2', '1', '10', 'Team Jersey with numbers 1-15: Back', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('14', '6', '6', '11', 'Bristol Intramural League MVP 2016', 1);

INSERT INTO `williams`.`orders` (cusID, invID, empID, typID, Details, Complete)
VALUES ('15', '4', '12', '11', 'Sand Trap Volleyball League MVP 2016', 1);

-- INSERT into NOTIFICATION

INSERT INTO `williams`.`notification` (ordID, typID, Memo, Opened)
VALUES (1, 15, 'Validated', 1);

INSERT INTO `williams`.`notification` (ordID, typID, Memo, Opened)
VALUES (2, 16, 'NOT Validated.', 1);

INSERT INTO `williams`.`notification` (ordID, typID, Memo, Opened)
VALUES (3, 17, 'Pass QA', 1);

INSERT INTO `williams`.`notification` (ordID, typID, Memo, Opened)
VALUES (4, 18, 'FAIL QA.', 0);

INSERT INTO `williams`.`notification` (ordID, typID, Memo, Opened)
VALUES (6, 19, 'Work Complete.', 0);

INSERT INTO `williams`.`notification` (ordID, typID, Memo, Opened)
VALUES (10, 20, 'Ready for Delivery.', 0);

-- INSERT into PAYMENTS

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('1', '1', '4', '1335 Buxton St.', 'Boston', 'MA', '02141');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('2', '6', '5', '2212 Elm St.', 'Raleigh', 'NC', '04187');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('3', '9', '6','1974 Alta Vista Ln.', 'Miami', 'FL', '84015');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('4', '10', '5','1993 Cottonwood Dr.', 'Alexandria', 'VA', '02141');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('5', '10', '4','713 Pawnee Ln.', 'Belton', 'MO', '64012');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('6', '10', '6','16001 Valentine Ave.', 'Charleston', 'SC', '02148');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('7', '10', '5','14894 Pinehurst Rd.', 'Bixby', 'OK', '74012');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('8', '10', '4','19981 Tolliver St.', 'Augusta', 'ME', '03901');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('9', '10', '6','604 Quayle Rd.', 'Dallas', 'TX', '41895');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('10', '10', '4','1854 Palm Terrace', 'Houston', 'TX', '41998');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('11', '10', '5','11881 Blacktree Pl.', 'Louisville', 'KY', '02149');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('12', '11', '5','917 S. Westover Rd.', 'Lenexa', 'KS', '66023');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('13', '12', '6','2580 Vicie Ave.', 'Los Angeles', 'CA', '02148');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('14', '13', '6','323 Oakridge Blvd.', 'Orlando', 'FL', '54261');

INSERT INTO `williams`.`payments` (ordID, empID, typID, Address, City, State, Zip)
VALUES ('15', '14', '4','12114 Sunnybrook Rd.', 'Surprise', 'AZ', '99412');

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
WHERE `typID` = 11;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`printJobs` AS
SELECT * FROM `williams`.`orders`
WHERE `typID` = 10;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`salesClerks` AS
SELECT * FROM `williams`.`employee`
WHERE `typID` = 7;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`specialists` AS
SELECT * FROM `williams`.`employee`
WHERE `typID` = 8;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`operationsManagers` AS
SELECT * FROM `williams`.`employee`
WHERE `typID` = 9;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusPassValidation` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 15;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusFailValidation` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 16;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusPassQA` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 17;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusFailQA` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 18;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusWorkComplete` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 19;
/*--------------------------------------------------------------------------------*/

CREATE VIEW `williams`.`orderStatusReadForDelivery` AS
SELECT * FROM `williams`.`notification`
WHERE `typID` = 20;
/*--------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------*/

-- Create Functions

DELIMITER $$
CREATE
    FUNCTION `williams`.`viewCustomer`()
    RETURNS VARCHAR(50)
    BEGIN
    RETURN @cust;
    END$$
DELIMITER ;

CREATE
    VIEW `williams`.`customerView`
    AS
    SELECT * FROM `williams`.`customer`
    WHERE `LastName` = `williams`.`viewCustomer`();

DELIMITER $$
CREATE
    FUNCTION `williams`.`viewEmployee`()
    RETURNS VARCHAR(50)
    BEGIN
    RETURN @emp;
    END$$
DELIMITER ;

CREATE
    VIEW `williams`.`employeeView` AS
    SELECT * FROM `williams`.`employee`
    WHERE `LastName` = `williams`.`viewEmployee`();

-- Alter Statements

ALTER TABLE `williams`.`employee` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`customer` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`inventory` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`employee` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`notification` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`orders` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`payments` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`type` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`qa` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`payments` AUTO_INCREMENT=1;

ALTER TABLE `williams`.`payments`
ADD CONSTRAINT `payments_fk0` FOREIGN KEY (`ordID`) REFERENCES `williams`.`orders`(`ordID`);

ALTER TABLE `williams`.`payments`
ADD CONSTRAINT `payments_fk1` FOREIGN KEY (`empID`) REFERENCES `williams`.`employee`(`empID`);

ALTER TABLE `williams`.`customer`
ADD CONSTRAINT `customer_fk0` FOREIGN KEY (`payID`) REFERENCES `williams`.`payments` (`payID`);

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

ALTER TABLE `williams`.`qa`
ADD CONSTRAINT `qa_fk0` FOREIGN KEY (`ordID`) REFERENCES `williams`.`orders` (`ordID`);