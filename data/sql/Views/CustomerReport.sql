SELECT orders.ordID AS "Order Number", type.description AS "Order Type", CONCAT(customer.Firstname,' ',customer.LastName) AS "Customer Name",
	   orders.date AS "Order Date", orders.Quantity AS "Quantity Ordered", inventory.Description AS "Items Ordered", orders.Details AS "Order Details", CONCAT(employee.FirstName,' ',employee.LastName) AS "Sales Associate",
	   payments.Paid AS "Total Paid", payments.Due AS "Total Due"
FROM orders
INNER JOIN customer
ON orders.cusID=customer.cusID
INNER JOIN employee
ON orders.empID=employee.empID
INNER JOIN type
ON orders.typID=type.typID
INNER JOIN payments
ON orders.ordID=payments.ordID
INNER JOIN inventory
ON orders.invID=inventory.invID
WHERE Complete=1