CREATE TABLE IF NOT EXISTS Ratings(
  id int AUTO_INCREMENT NOT NULL,
  product_id int not NULL,
  user_id int not NULL,
  rating int DEFAULT 0,
  comment text,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`product_id`) REFERENCES Products(`id`),
  FOREIGN KEY(`user_id`) REFERENCES Users(`id`)
)