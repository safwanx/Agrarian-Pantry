CREATE DATABASE IF NOT EXISTS agrarian_pantry;

USE agrarian_pantry;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20), 
    password VARCHAR(255) NOT NULL,
    type ENUM('Customer', 'Seller') NOT NULL
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_type ENUM('greens', 'meat', 'dairy', 'baked') NOT NULL,
    seller_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    image_url VARCHAR(255),
    FOREIGN KEY (seller_id) REFERENCES users(id)
);

CREATE TABLE orders (
    orders_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    ordered_product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(orders_id),
    FOREIGN KEY (ordered_product_id) REFERENCES products(product_id)
);

CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    order_id INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(orders_id)
);

CREATE TABLE order_history (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_history_id INT NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(orders_id)
);

CREATE TABLE contact_form (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message TEXT NOT NULL
);


--Use the above script to make the database in ur local machine. The below part is only when needed, contact before executing them--

--(DO NOT EXECUTE THE QUERIES BELOW. I REPEAT DO NOT WITHOUT CONSULT)--


-- Inserting data into the users table 
INSERT INTO products (product_type, seller_id, name, description, price, quantity, image_url) VALUES
('greens', 1001, 'Lettuce', 'Crisp and fresh lettuce, ideal for salads or as a sandwich filler.', 7.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FLettuce.png?alt=media&token=00116c9d-e623-406d-a361-0195d2821c2d'),
('greens', 1001, 'Mint', 'Fresh mint, a flavorful herb that adds a vibrant touch to dishes.', 5.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FMint.png?alt=media&token=d212f383-4715-4d5e-961f-2f4afa305fa7'),
('greens', 1001, 'Cucumber', 'Crisp and refreshing cucumber, a great addition to salads or as a snack.', 6.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FCucumber.jpg?alt=media&token=53439e26-f4f5-4879-beb3-f0b711bf0b69'),
('greens', 1001, 'Kiwi', 'Vibrant and nutritious kiwi fruit, a flavorful addition to your diet.', 10.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fkiwi.jpg?alt=media&token=8c823cb4-0670-4226-8f37-9895970fe177'),
('greens', 1001, 'Strawberry', 'Fresh and juicy strawberries, a delightful and healthy snack.', 15.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FStrawberries.jpg?alt=media&token=981121a9-f809-4942-b741-fd8fe1733e74'),
('greens', 1001, 'Papaya', 'Ripe and tropical papaya, rich in vitamins and antioxidants.', 12.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fpapaya.jpg?alt=media&token=39bab6f1-eb15-4c38-a51e-dc730c816809'),
('greens', 1001, 'Pomegranate', 'Sweet and tangy pomegranate, a nutritious and refreshing fruit.', 18.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fpomegranate.jpg?alt=media&token=fcc19958-cf04-409d-a226-366e29ec1df7'),
('greens', 1001, 'Potato', 'Versatile potatoes, suitable for various culinary applications.', 10.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fpotato.jpg?alt=media&token=c3c10281-481b-4330-b2e8-702afad4915e'),
('greens', 1001, 'Carrot', 'Sweet and crunchy carrots, great for snacking or cooking.', 6.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FCarrot.jpg?alt=media&token=5850696a-2ad4-4061-85d1-27a7ba96f1d0'),
('greens', 1001, 'Corn', 'Fresh and sweet corn, ideal for boiling, grilling.', 3.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FCorn.jpg?alt=media&token=d0f77eb4-5ad5-479f-9890-3197787feb03'),
('greens', 1001, 'Apples', 'Crisp and juicy apples, a classic and healthy snack.', 10.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fapples1.jpg?alt=media&token=a4824d4d-a644-492e-8d4c-fc195d7cae6b'),
('greens', 1001, 'Mangoes', 'Sweet and tropical mangoes, a delicious and refreshing treat.', 15.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fmangoes.jpg?alt=media&token=f1d731b6-a26c-4755-a520-a997e3759790');
