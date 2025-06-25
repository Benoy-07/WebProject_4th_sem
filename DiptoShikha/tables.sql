-- Create `users` table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  profile_pic VARCHAR(255) DEFAULT '/DiptoShikha/assets/img/default-avatar.png',
  role ENUM('admin', 'customer') DEFAULT 'customer',
  is_verified BOOLEAN DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- admin_secrets--
CREATE TABLE admin_secrets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  secret_code VARCHAR(255) NOT NULL
);

INSERT INTO admin_secrets (secret_code) VALUES ('###123');


-- Create `books` table
CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NUSELECT * FROM `books` WHERE 1LL,
  writer_id INT,
  publisher_id INT,
  category_id INT,
  description TEXT,
  cover_image VARCHAR(255),
  price DECIMAL(10,2),
  old_price DECIMAL(10,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (writer_id) REFERENCES writers(id),
  FOREIGN KEY (publisher_id) REFERENCES publishers(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
);
alter table books ADD Old_book_price DECIMAL(10,2);
ALTER TABLE books CHANGE Old_book_price old_book_price DECIMAL(10,2);


-- Create `categories` table
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name) VALUES
('Academic'),
('Literature'),
('Islamic Books'),
('Science Fiction'),
('Engineering'),
('Medical'),
('Novels'),
('Story Books');


-- Create `writers` table
CREATE TABLE writers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  photo VARCHAR(255) DEFAULT NULL, -- Future: if you want to store image path
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Create `publishers` table
CREATE TABLE publishers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  logo VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create `favourites` table
CREATE TABLE favourites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  book_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (book_id) REFERENCES books(id)
);


-- Create `cart` table
CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  book_id INT,
  quantity INT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (book_id) REFERENCES books(id)
);



CREATE TABLE exchange_requests (
    exchange_id INT PRIMARY KEY,
    user_id INT,
    book_name VARCHAR(255),
    writer_name VARCHAR(255),
    buy_price DECIMAL(10, 2),
    phone VARCHAR(20),
    status VARCHAR(50),
    created_at DATETIME,
    publisher_name VARCHAR(255)
OREIGN KEY (user_id) REFERENCES users(id)
);




CREATE TABLE orders (  
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  book_id INT,
  total_amount DECIMAL(10,2),
  status VARCHAR(50) DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE order_items (
  order_id INT,
  book_id INT,
  quantity INT DEFAULT 1,
  price DECIMAL(10,2),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (book_id) REFERENCES books(id)
);


-- CREATE TABLE payments (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     order_id INT,
--     method ENUM('Card', 'Cash on Delivery', 'bKash', 'Nagad') NOT NULL,
--     status ENUM('Pending', 'Paid', 'Failed') DEFAULT 'Pending',
--     transaction_id VARCHAR(100) DEFAULT NULL,
--     paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
-- );

-- CREATE TABLE payments (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   order_id INT,
--   payment_method VARCHAR(50),
--   payment_status VARCHAR(50) DEFAULT 'unpaid',
--   paid_at TIMESTAMP NULL,
--   FOREIGN KEY (order_id) REFERENCES orders(id)
-- );
CREATE TABLE payments (
  user_id INT,
  order_id INT,
  method VARCHAR(50),
  transaction_id VARCHAR(100),
  amount DECIMAL(10, 2),
  status VARCHAR(20) DEFAULT 'Pending',
  payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (order_id) REFERENCES orders(id)
);


