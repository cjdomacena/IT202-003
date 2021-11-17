CREATE TABLE IF NOT EXISTS Products(
  id int AUTO_INCREMENT not NULL,
  name VARCHAR(30) UNIQUE,
  description text,
  stock int DEFAULT 0,
  cost int DEFAULT 99999,
  image text,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (`user_id`) REFERENCES Users(`id`),
  FOREIGN KEY (`product_id`) REFERENCES Roles(`id`),
  UNIQUE KEY (`user_id`, `product_id`)
)