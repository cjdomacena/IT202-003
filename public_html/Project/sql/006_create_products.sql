CREATE TABLE IF NOT EXISTS Products(
  id int AUTO_INCREMENT not NULL,
  user_id int not NULL,
  name VARCHAR(30) UNIQUE,
  description text,
  stock int DEFAULT 0,
  cost int DEFAULT 99999,
  image text,
  category text NULL,
  visibility TINYINT(1) DEFAULT 0,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY(user_id) REFERENCES Users(id)
)