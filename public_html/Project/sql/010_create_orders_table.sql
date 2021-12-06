CREATE TABLE IF NOT EXISTS Orders(
  id int AUTO_INCREMENT not null,
  user_id int NOT NULL,
  fName text NOT NULL,
  lName text NOT NULL,
  total_price int NOT NULL,
  address TEXT NOT NULL,
  payment_method TEXT NOT NULL,
  state text NOT NULL,
  zip int NOT NULL,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`user_id`) REFERENCES Users(`id`)
)