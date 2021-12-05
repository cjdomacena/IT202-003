CREATE TABLE IF NOT EXISTS OrderItems(
	id int AUTO_INCREMENT NOT NULL,
	order_id int not NULL UNIQUE,
	product_id int not NULL,
	quantity int DEFAULT 1,
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`order_id`) REFERENCES Orders(`id`),
	FOREIGN KEY(`product_id`) REFERENCES Products(`id`)
)