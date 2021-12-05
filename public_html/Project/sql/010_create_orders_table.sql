CREATE TABLE IF NOT EXISTS Orders(
  id int AUTO_INCREMENT not null,
  user_id int NOT NULL,
  total_price int NOT NULL,
  address TEXT NOT NULL,
  payment_method TEXT NOT NULL,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`user_id`) REFERENCES Users(`id`)
)