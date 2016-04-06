/*********************************************************************************************
 *Williams Specialty Company - Business Process Automation                                   *
 *MySQL Insert Values into table notification                                                *
 *********************************************************************************************
 **********************************************UPDATES****************************************
 *March 30th, 2016 - Joe Gibson - Created                                                    *
 *********************************************************************************************/

INSERT INTO notification (ordID, ntftypID, Subject, Notice, Opened)
VALUES ('1', '17', 'Order# 1 Validated.', 'Customer information validated. Ready for processing.', '1');

INSERT INTO notification (ordID, ntftypID, Subject, Notice, Opened)
VALUES ('2', '18', 'Order# 1 NOT Validated.', 'Customer information failed validation. Make Corrections.', '1');

INSERT INTO notification (ordID, ntftypID, Subject, Notice, Opened)
VALUES ('3', '19', 'Order# 1 PASS QA.', 'Order passed QA. Ready For Delivery to Sales Person.', '1');

INSERT INTO notification (ordID, ntftypID, Subject, Notice, Opened)
VALUES ('4', '20', 'Order# 1 FAIL QA.', 'Order failed QA. Scratch on Plate 1 Lower Left Corner. Rework or reprocess.', '0');

INSERT INTO notification (ordID, ntftypID, Subject, Notice, Opened)
VALUES ('5', '21', 'Work Complete. Ready to Process', '0');

INSERT INTO notification (ordID, ntftypID, Subject, Notice, Opened)
VALUES ('3', '22', 'Order Complete. Call Customer to arrange delivery.', '0');