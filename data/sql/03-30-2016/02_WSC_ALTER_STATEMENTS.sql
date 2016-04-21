/*********************************************************************************************
 *Williams Specialty Company - Business Process Automation                                   *
 *MySQL Create Constraints                                                                   *
 *********************************************************************************************
 **********************************************UPDATES****************************************
 *March 28th, 2016 - Justin Byrne Created                                                    *
 *March 29th, 2016 - Joe Gibson - Added ALTER TABLE `XXXXXXXXXXXXXXXXXXXXX` AUTO_INCREMENT=1;*
 *********************************************************************************************/

ALTER TABLE `employee` AUTO_INCREMENT=1;

ALTER TABLE `customer` AUTO_INCREMENT=1;

ALTER TABLE `inventory` AUTO_INCREMENT=1;

ALTER TABLE `employee` AUTO_INCREMENT=1;

ALTER TABLE `notification` AUTO_INCREMENT=1;

ALTER TABLE `orders` AUTO_INCREMENT=1;

ALTER TABLE `payments` AUTO_INCREMENT=1;

ALTER TABLE `type` AUTO_INCREMENT=1;

ALTER TABLE `payments`
ADD CONSTRAINT `payments_fk0` FOREIGN KEY (`ordID`) REFERENCES `orders`(`ordID`);

ALTER TABLE `payments`
ADD CONSTRAINT `payments_fk1` FOREIGN KEY (`empID`) REFERENCES `employee`(`empID`);

ALTER TABLE `orders`
ADD CONSTRAINT `orders_fk0` FOREIGN KEY (`cusID`) REFERENCES `customer`(`cusID`);

ALTER TABLE `orders`
ADD CONSTRAINT `orders_fk1` FOREIGN KEY (`invID`) REFERENCES `inventory`(`invID`);

ALTER TABLE `orders`
ADD CONSTRAINT `orders_fk2` FOREIGN KEY (`empID`) REFERENCES `employee`(`empID`);

ALTER TABLE `orders`
ADD CONSTRAINT `orders_fk3` FOREIGN KEY (`typID`) REFERENCES `type`(`typID`);

ALTER TABLE `notification`
ADD CONSTRAINT `notification_fk0` FOREIGN KEY (`ordID`) REFERENCES `orders`(`ordID`);

ALTER TABLE `credentials`
ADD CONSTRAINT `credentials_fk0` FOREIGN KEY (`empID`) REFERENCES `employee`(`empID`);

ALTER TABLE `employee`
ADD CONSTRAINT `employee_fk0` FOREIGN KEY (`emptypID`) REFERENCES `type`(`typID`);

ALTER TABLE `notification`
ADD CONSTRAINT `notification_fk1` FOREIGN KEY (`ntftypID`) REFERENCES `type`(`typID`);

ALTER TABLE `payments`
ADD CONSTRAINT `payments_fk2` FOREIGN KEY (`paytypID`) REFERENCES `type`(`typID`);

ALTER TABLE `inventory`
ADD CONSTRAINT `inventory_fk0` FOREIGN KEY (`invtypID`) REFERENCES `type` (`typID`);