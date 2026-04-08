USE onlineStore;

SELECT products.name AS `Product Name`, SUM(orders.quantity) AS `Total Ordered`
FROM products
INNER JOIN orders ON products.product_id = orders.product_id
GROUP BY products.product_id
ORDER BY SUM( orders.quantity ) DESC
LIMIT 5;

SELECT products.name AS `Product Name`, products.quantity AS `Stock`
FROM products
WHERE products.quantity < 5
ORDER BY products.quantity;

SELECT CONCAT( customers.first_name, ' ', customers.last_name ) AS `Customer Name`, COUNT(orders.quantity) AS `Orders`
FROM customers
INNER JOIN orders ON customers.customer_id = orders.customer_id
GROUP BY customers.customer_id
ORDER BY COUNT(orders.quantity) DESC;

SELECT products.name AS `Product Name`, orders.order_date AS `Date Ordered`
FROM orders 
INNER JOIN products ON products.product_id = orders.product_id
WHERE orders.order_date BETWEEN '1993-11-1' AND '1993-12-1';