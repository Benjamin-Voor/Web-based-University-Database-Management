CREATE DATABASE IF NOT EXISTS onlineStore;

USE onlineStore;

DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS restock;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS suppliers;

create table customers
(
	customer_id	int,
	first_name	varchar( 35 ),
	last_name	varchar( 35 ),

	primary key 	( customer_id )
);

create table suppliers
(
	supplier_id	int,
	name		varchar( 35 ),
	address		varchar( 50 ),

	primary key	( supplier_id )
);

create table products
(
	product_id	int,
	name		varchar( 500 ),
	price 		double,
	quantity	int,
	supplier_id	int,
	category	varchar( 500 ),

	primary key	( product_id ),
	
	foreign key 	( supplier_id ) references suppliers ( supplier_id ) on delete cascade
);

create table orders
(
	order_id	int,
	product_id	int,
	quantity	int,
	customer_id	int,
	order_date	date,

	primary key	( order_id ),

	foreign key	( customer_id ) references customers ( customer_id ) on delete cascade,
	foreign key	( product_id ) references products ( product_id ) on delete cascade
);

create table restock
(
	restock_id	int,
	product_id	int,
	quantity	int,

	primary key	( restock_id ),
	
	foreign key	( product_id ) references products ( product_id ) on delete cascade
);