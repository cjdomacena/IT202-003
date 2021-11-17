CREATE TABLE IF NOT EXISTS UserProducts (
  id int AUTO_INCREMENT not NULL FOREIGN KEY(user_id) REFERENCES Users(id) FOREIGN KEY (product_id) REFERENCES Products(id)
)