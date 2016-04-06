-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2016 at 09:28 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `williams`
--

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `empID` int(2) NOT NULL,
  `Password` varchar(25) NOT NULL COMMENT 'Must contain combination of upper case, lower case, and numbers'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`empID`, `Password`) VALUES
(1, 'Provo12'),
(2, 'Marvel02'),
(3, 'NoisyLotus1'),
(4, 'Typical11'),
(5, 'pAradise77'),
(6, 'taranTula1965'),
(7, 'mo22erellaM3lt'),
(8, '3ggPlants'),
(9, 'Charg3rsRul3'),
(10, 'Silv3rAndBlack'),
(11, 'pretzy1'),
(12, 'Gh0st1y');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cusID` int(2) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` char(2) NOT NULL,
  `Zip` varchar(10) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `ActiveIND` bit(1) NOT NULL COMMENT 'Customer Still Still Active (1 = Active 0 = Inactive)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cusID`, `FirstName`, `LastName`, `Address`, `City`, `State`, `Zip`, `Phone`, `Email`, `ActiveIND`) VALUES
(1, 'Mary', 'Castiglia', '1335 Buxton St.', 'Boston', 'MA', '02141', '(221) 848-8945', 'mcasts@gmail.com', b'1'),
(2, 'Roland', 'Smith', '2212 Elm St.', 'Raleigh', 'NC', '04187', '(713) 422-5874', 'roland.smith@gmail.com', b'1'),
(3, 'Robert', 'Withrow', '1974 Alta Vista Ln.', 'Miami', 'FL', '84015', '(218) 547-9684', 'bob.withrow@outlook.com', b'1'),
(4, 'Carey', 'Stegner', '1993 Cottonwood Dr.', 'Alexandria', 'VA', '02141', '(713) 995-2219', 'carey_stegs@comcast.com', b'1'),
(5, 'Laura', 'Johnson', '713 Pawnee Ln.', 'Belton', 'MO', '64012', '(816) 804-1235', 'ljohnson@kc.rr.com', b'1'),
(6, 'Joshua', 'Pernell', '16001 Valentine Ave.', 'Charleston', 'SC', '02148', '(918) 506-7591', 'josh_pernell@hotmail.com', b'1'),
(7, 'Paula', 'Pinnix', '14894 Pinehurst Rd.', 'Bixby', 'OK', '74012', '(916) 881-9258', 'p.pinnix@cox.net', b'1'),
(8, 'Ryan', 'Caldwell', '19981 Tolliver St.', 'Augusta', 'ME', '03901', '(207) 848-8945', 'mcasts@gmail.com', b'1'),
(9, 'Travis', 'Deal', '604 Quayle Rd.', 'Dallas', 'TX', '41895', '(415) 882-7469', 'tdeal@gmail.com', b'1'),
(10, 'Roberto', 'Alvarez', '1854 Palm Terrace', 'Houston', 'TX', '41998', '(209) 664-8954', 'alvarez_r@outlook.com', b'1'),
(11, 'Blaine', 'Brooks', '11881 Blacktree Pl.', 'Louisville', 'KY', '02149', '(715) 887-8721', 'double_b@hotmail.com', b'1'),
(12, 'Joe', 'Bronson', '917 S. Westover Rd.', 'Lenexa', 'KS', '66023', '(913) 419-7732', 'joe.bron@kc.rr.com', b'1'),
(13, 'Ruby', 'Lee', '2580 Vicie Ave.', 'Los Angeles', 'CA', '02148', '(812) 323-4543', 'rubylee@msn.com', b'1'),
(14, 'Isaac', 'Sorrens', '323 Oakridge Blvd.', 'Orlando', 'FL', '54261', '(706) 408-2237', 'isaacs@comcast.com', b'1'),
(15, 'Darion', 'Bradley', '12114 Sunnybrook Rd.', 'Surprise', 'AZ', '99412', '(978) 877-4568', 'dbrads@kc.rr.com', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `empID` int(2) NOT NULL,
  `typID` int(2) NOT NULL,
  `Title` varchar(25) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` char(2) NOT NULL,
  `Zip` varchar(10) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`empID`, `typID`, `Title`, `FirstName`, `LastName`, `Address`, `City`, `State`, `Zip`, `Phone`, `Email`) VALUES
(1, 8, 'Sales Clerk', 'Jon', 'Holt', '5458 Riverside Dr.', 'San Francisco', 'CA', '94101', '(415) 555-5124', 'jholt@wsc.com'),
(2, 9, 'Specialist', 'Barry', 'Collins', '12178 Paloma Ave.', 'San Francisco', 'CA', '94110', '(628) 555-1367', 'bcollins@wsc.com'),
(3, 10, 'Operations Manager', 'Phillip', 'Panzer', '1826 Avendale Dr.', 'San Francisco', 'CA', '94101', '(415) 555-0245', 'ppanzer@wsc.com'),
(4, 9, 'Specialist', 'Eugene', 'Williams', '1669 Vista View Circle.', 'San Francisco', 'CA', '94110', '(628) 555-6748', 'ewilliams@wsc.com'),
(5, 9, 'Specialist', 'Bradley', 'Jordan', '125 Pennington Way, Apt. B', 'Oakland', 'CA', '94601', '(510) 844-9072', 'bjordan@wsc.com'),
(6, 8, 'Sales Clerk', 'Lora', 'Bailey', '4418 Ballentine Ave.', 'San Mateo', 'CA', '94403', '(650) 694-0098', 'lbailey@wsc.com'),
(7, 10, 'Operations Manager', 'Rich', 'Canter', '1111 Shasta Dr.', 'San Francisco', 'CA', '94101', '(415) 555-1021', 'rcanter@wsc.com'),
(8, 9, 'Specialist', 'Terry', 'Jefferies', '1808 Desert Brush Dr.', 'San Francisco', 'CA', '94110', '(628) 555-1998', 'tjefferies@wsc.com'),
(9, 8, 'Sales Clerk', 'Tracy', 'Maddison', '2248 Sagebrush Ave.', 'San Francisco', 'CA', '94101', '(415) 555-8877', 'tmaddison@wsc.com'),
(10, 8, 'Sales Clerk', 'Brittany', 'Ballinger', '14668 Airview Dr.', 'San Mateo', 'CA', '94401', '(650) 694-7872', 'bballinger@wsc.com'),
(11, 9, 'Specialist', 'Earl', 'Helm', '11121 E. Cactus Rd.', 'Oakland', 'CA', '94601', '(510) 844-3197', 'ehelm@wsc.com'),
(12, 8, 'Sales Clerk', 'Paul', 'Troby', '1741 Carlsbad Way', 'San Mateo', 'CA', '94403', '(650) 694-1554', 'ptroby@wsc.com');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invID` int(2) NOT NULL,
  `typID` int(2) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Cost` decimal(6,2) NOT NULL,
  `Quantity` int(3) NOT NULL,
  `Available` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invID`, `typID`, `Description`, `Cost`, `Quantity`, `Available`) VALUES
(1, 13, 'T-Shirt, Short Sleeve, White', '7.99', 60, b'1'),
(2, 13, 'T-Shirt, Short Sleeve, Red', '7.99', 75, b'1'),
(3, 13, 'T-Shirt, Short Sleeve, Blue', '7.99', 50, b'1'),
(4, 13, 'T-Shirt, Long Sleeve, White', '12.99', 20, b'1'),
(5, 14, 'Pamphlet, Photo Generic', '0.25', 500, b'1'),
(6, 14, 'Cardstock, white', '0.49', 500, b'1'),
(7, 14, 'Plain, White', '0.08', 800, b'1'),
(8, 14, 'Special Order, Generic', '1.99', 0, b'1'),
(9, 15, 'Baseball, Generic, Hitter', '21.99', 30, b'1'),
(10, 15, 'Baseball, In-Motion, Pitcher', '28.99', 25, b'1'),
(11, 15, 'Basketball, In-Motion, Shooter', '29.99', 50, b'1'),
(12, 15, 'Basketball, Generic, Shooter', '26.99', 40, b'1'),
(13, 16, 'Two-plate, Generic, Crest Shaped', '39.99', 25, b'1'),
(14, 16, 'One-plate, Generic, Square', '37.99', 25, b'1'),
(15, 13, 'One-plate, Picture, Oval', '45.99', 30, b'1'),
(16, 13, 'Two-plate, Picture, Square', '47.99', 60, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `ntfID` int(2) NOT NULL,
  `ordID` int(2) NOT NULL,
  `typID` int(2) NOT NULL,
  `Subject` varchar(50) NOT NULL,
  `Notice` varchar(500) NOT NULL,
  `Opened` bit(1) NOT NULL COMMENT 'Message Read (1 = Yes, 0 = No)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`ntfID`, `ordID`, `typID`, `Subject`, `Notice`, `Opened`) VALUES
(1, 1, 17, 'Order# 1 Validated.', 'Customer information validated. Ready for processing.', b'1'),
(2, 2, 18, 'Order# 2 NOT Validated.', 'Customer information failed validation. Make Corrections.', b'1'),
(3, 3, 19, 'Order# 3 PASS QA.', 'Order passed QA. Ready For Delivery to Sales Person.', b'1'),
(4, 4, 20, 'Order# 4 FAIL QA.', 'Order failed QA. Scratch on Plate 1 Lower Left Corner. Rework or reprocess.', b'0'),
(5, 5, 21, 'Order# 5 Work Complete.', 'Ready to Process', b'0'),
(6, 3, 22, 'Order# 3 Complete.', 'Call Customer to arrange delivery.', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ordID` int(2) NOT NULL,
  `cusID` int(2) NOT NULL,
  `invID` int(2) NOT NULL,
  `empID` int(2) NOT NULL,
  `typID` int(2) NOT NULL,
  `Details` varchar(500) NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Quantity` int(3) NOT NULL,
  `Complete` bit(1) NOT NULL COMMENT 'Order Open or Closed (1 = Open 0 = Closed)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ordID`, `cusID`, `invID`, `empID`, `typID`, `Details`, `Date`, `Quantity`, `Complete`) VALUES
(1, 7, 12, 6, 12, 'Rogers Intramural Champions 2016', '2016-03-31 18:56:14', 12, b'1'),
(2, 10, 4, 10, 11, 'Stencil Logo Flaming Basketball Through Hoop. Phrase "En Fuego" below logo.', '2016-03-31 18:56:14', 1, b'1'),
(3, 2, 16, 1, 12, 'Top Plate: Congratulations; Font: Castellar; Bottom Plate: Top Sales Q4, 2015; Font: Castellar; Picture: Framed Dollar Bill.', '2016-03-31 18:56:14', 1, b'1'),
(4, 1, 2, 9, 11, 'Chevrolet Bowtie: Front; Phrase: Nothin Runs Like A Chevy: Below.', '2016-03-31 18:56:14', 1, b'1'),
(5, 14, 7, 12, 11, 'Flier: Custom Format Provided by Customer: See attached', '2016-03-31 18:56:14', 100, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payID` int(2) NOT NULL,
  `ordID` int(2) NOT NULL,
  `empID` int(2) NOT NULL,
  `typID` int(2) NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Paid` decimal(6,2) NOT NULL,
  `Due` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payID`, `ordID`, `empID`, `typID`, `Date`, `Paid`, `Due`) VALUES
(1, 1, 1, 5, '2016-03-31 18:56:32', '0.00', '540.97'),
(2, 2, 6, 6, '2016-03-31 18:56:32', '22.50', '202.50'),
(3, 3, 9, 7, '2016-03-31 18:56:32', '133.50', '0.00'),
(4, 4, 10, 6, '2016-03-31 18:56:32', '18.50', '166.50'),
(5, 5, 12, 5, '2016-03-31 18:56:32', '0.00', '200.98');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `typID` int(2) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Meaning` varchar(250) NOT NULL,
  `Price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`typID`, `Description`, `Meaning`, `Price`) VALUES
(1, 'Permissions for Sales Clerk', 'SALES_CLERK_PERMISSION', '0.00'),
(2, 'Permissions for Specialist', 'SPECIALIST_PERMISSION', '0.00'),
(3, 'Permissions for Operations Manager', 'OPERATIONS_MANAGER_PERMISSION', '0.00'),
(4, 'Permissions for Sales Clerk', 'SALES_CLERK_PERMISSION', '0.00'),
(5, 'Payment Not Received', 'PAYMENT_NONE', '0.00'),
(6, 'Partial Payment Received', 'PAYMENT_PARTIAL', '0.00'),
(7, 'Payment Received in Full', 'PAYMENT_FULL', '0.00'),
(8, 'Sales Clerk', 'TYPE_SALES_CLERK', '0.00'),
(9, 'Specialist', 'TYPE_SPECIALIST', '0.00'),
(10, 'Operations Manager', 'TYPE_OPERATIONS_MANAGER', '0.00'),
(11, 'Print Job', 'TYPE_JOB_PRINT', '39.99'),
(12, 'Engrave Job', 'TYPE_ENGRAVE_JOB', '69.99'),
(13, 'T-Shirt', 'TYPE_MEDIA_TSHIRT', '12.99'),
(14, 'Paper', 'TYPE_MEDIA_PAPER', '0.10'),
(15, 'Trophy', 'TYPE_MEDIA_TROPHY', '45.99'),
(16, 'Plaque', 'TYPE_MEDIA_PLAQUE', '85.99'),
(17, 'Order Validated', 'TYPE_ORDER_VALID', '0.00'),
(18, 'Order Not Validated', 'TYPE_ORDER_NOT_VALID', '0.00'),
(19, 'Order Pass QA', 'TYPE_QA_PASS', '0.00'),
(20, 'Order Fail QA', 'TYPE_QA_FAIL', '0.00'),
(21, 'Work Complete', 'TYPE_WORK_COMPLETE', '0.00'),
(22, 'Order Ready for Delivery', 'TYPE_ORDER_READY_DELIVER', '0.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`empID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cusID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`empID`),
  ADD KEY `employee_fk0` (`typID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invID`),
  ADD KEY `inventory_fk0` (`typID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ntfID`),
  ADD KEY `notification_fk0` (`ordID`),
  ADD KEY `notification_fk1` (`typID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ordID`),
  ADD KEY `orders_fk0` (`cusID`),
  ADD KEY `orders_fk1` (`invID`),
  ADD KEY `orders_fk2` (`empID`),
  ADD KEY `orders_fk3` (`typID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payID`),
  ADD KEY `payments_fk0` (`ordID`),
  ADD KEY `payments_fk1` (`empID`),
  ADD KEY `payments_fk2` (`typID`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`typID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cusID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `empID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `ntfID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ordID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `typID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `credentials`
--
ALTER TABLE `credentials`
  ADD CONSTRAINT `credentials_fk0` FOREIGN KEY (`empID`) REFERENCES `employee` (`empID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_fk0` FOREIGN KEY (`typID`) REFERENCES `type` (`typID`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_fk0` FOREIGN KEY (`typID`) REFERENCES `type` (`typID`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_fk0` FOREIGN KEY (`ordID`) REFERENCES `orders` (`ordID`),
  ADD CONSTRAINT `notification_fk1` FOREIGN KEY (`typID`) REFERENCES `type` (`typID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_fk0` FOREIGN KEY (`cusID`) REFERENCES `customer` (`cusID`),
  ADD CONSTRAINT `orders_fk1` FOREIGN KEY (`invID`) REFERENCES `inventory` (`invID`),
  ADD CONSTRAINT `orders_fk2` FOREIGN KEY (`empID`) REFERENCES `employee` (`empID`),
  ADD CONSTRAINT `orders_fk3` FOREIGN KEY (`typID`) REFERENCES `type` (`typID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_fk0` FOREIGN KEY (`ordID`) REFERENCES `orders` (`ordID`),
  ADD CONSTRAINT `payments_fk1` FOREIGN KEY (`empID`) REFERENCES `employee` (`empID`),
  ADD CONSTRAINT `payments_fk2` FOREIGN KEY (`typID`) REFERENCES `type` (`typID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
