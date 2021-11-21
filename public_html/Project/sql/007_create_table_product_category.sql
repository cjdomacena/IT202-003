CREATE TABLE IF NOT EXISTS Product_Category(
	id int AUTO_INCREMENT NOT NULL,
	product_id int not NULL,
	category text NOT NULL,
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`product_id`) REFERENCES Products(`id`)
)