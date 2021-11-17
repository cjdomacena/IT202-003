CREATE TABLE IF NOT EXISTS UserProducts (
  id int AUTO_INCREMENT not NULL,
  user_id int,
  product_id int,
  `created` timestamp default current_timestamp,
  `modified` timestamp default current_timestamp on update current_timestamp,
  FOREIGN KEY (`user_id`) REFERENCES Users(`id`),
  FOREIGN KEY(`product_id`) REFERENCES Products(`id`),
  PRIMARY KEY(`id`)
)