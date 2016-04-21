/*********************************************************************************************
 *Williams Specialty Company - Business Process Automation                                   *
 *MySQL Insert Values into table payments                                                    *
 *********************************************************************************************
 **********************************************UPDATES****************************************
 *March 30th, 2016 - Joe Gibson - Created                                                    *
 *********************************************************************************************/

INSERT INTO payments (ordID, empID, paytypID, Date, Paid, Due)
VALUES ('1', '1', '5', 'CURDATE()', '0.00', '540.97');

INSERT INTO payments (ordID, empID, paytypID, Date, Paid, Due)
VALUES ('2', '6', '6.', 'CURDATE()', '22.50', '202.50');

INSERT INTO payments (ordID, empID, paytypID, Date, Paid, Due)
VALUES ('3', '9', '7', 'CURDATE()', '133.50', '0.00');

INSERT INTO payments (ordID, empID, paytypID, Date, Paid, Due)
VALUES ('4', '10', '6.', 'CURDATE()', '18.50', '166.50');

INSERT INTO payments (ordID, empID, paytypID, Date, Paid, Due)
VALUES ('5', '12', '5', 'CURDATE()', '0.00', '200.98');

INSERT INTO payments (ordID, empID, paytypID, Date, Paid, Due)
VALUES ('6', '6', '7', 'CURDATE()', '1561.00', '0.00');