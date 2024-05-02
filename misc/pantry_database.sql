CREATE DATABASE IF NOT EXISTS agrarian_pantry;

USE agrarian_pantry;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20), 
    password VARCHAR(255) NOT NULL,
    type ENUM('Customer', 'Seller') NOT NULL,
    address VARCHAR(255)
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
    seller_id INT NOT NULL,
    product_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (seller_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE seller_order(
    id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    order_id INT NOT NULL,
    FOREIGN KEY (seller_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES orders(orders_id)
);

CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    order_id INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(orders_id)
);

CREATE TABLE order_history (
    order_history_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
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

--(DO NOT EXECUTE THE QUERIES BELOW. I REPEAT DO NOT WITHOUT CONSULTING)--

-- FIRST MAKE A CUSTOMER ACCOUNT USING THE WEBSITE, THEN MAKE FOUR SELLER ACCOUNTS USING THE WEBSITE, THEN EXECUTE THE QUERIES BELOW --

-- Inserting into baked table --
INSERT INTO products (product_type, seller_id, name, description, price, quantity, image_url)
VALUES
('baked', 2, 'Croissant', 'Buttery and flaky croissant, a classic pastry for breakfast or anytime.', 8.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2Fbakery%2Fcroissant%201.jpg?alt=media&token=0e7911e1-3dbb-4ccf-bdd7-db64d49a8a1b'),
('baked', 2, 'Sourdough Bread', 'Artisanal sourdough bread with a chewy crust and tangy flavor.', 25.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2Fbakery%2FSourdough%20Bread.jpg?alt=media&token=71aa00e3-5b1e-4de6-afba-55184ff8cd6f'),
('baked', 2, 'Rye Bread', 'Dense and hearty rye bread, great for sandwiches or toasting.', 30.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2Fbakery%2Frye%20bread.jpg?alt=media&token=982a5ef9-8767-45c2-865d-7bc46ef3b91b'),
('baked', 2, 'Donut', 'Sweet and indulgent donut, a delightful treat for dessert or breakfast.', 5.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2Fbakery%2FDonut.jpg?alt=media&token=61e66a4c-43d6-4c38-8b04-d982d231cae7'),
('baked', 2, 'Cookies', 'Delicious assorted cookies, perfect for satisfying your sweet cravings.', 15.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2Fbakery%2Fcookies.jpg?alt=media&token=903248e3-4a11-4547-aba3-48020af197b1'),
('baked', 2, 'Chocolate Cake', 'Rich and decadent chocolate cake, a perfect dessert for any occasion.', 40.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2Fbakery%2FChocolate%20Cake.jpg?alt=media&token=de3ae0cf-f502-42da-8b37-b93be9b1038e');

-- Inserting data into greens table --
INSERT INTO products (product_type, seller_id, name, description, price, quantity, image_url) VALUES
('greens', 3, 'Lettuce', 'Crisp and fresh lettuce, ideal for salads or as a sandwich filler.', 7.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FLettuce.png?alt=media&token=00116c9d-e623-406d-a361-0195d2821c2d'),
('greens', 3, 'Mint', 'Fresh mint, a flavorful herb that adds a vibrant touch to dishes.', 5.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FMint.jpg?alt=media&token=d7034236-a4ee-4ecc-b0bb-63bc87f6d778'),
('greens', 3, 'Cucumber', 'Crisp and refreshing cucumber, a great addition to salads or as a snack.', 6.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FCucumber.jpg?alt=media&token=d0480014-2257-4ad7-8f5d-5c7b87cf29da'),
('greens', 3, 'Kiwi', 'Vibrant and nutritious kiwi fruit, a flavorful addition to your diet.', 10.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fkiwi.jpg?alt=media&token=8c823cb4-0670-4226-8f37-9895970fe177'),
('greens', 3, 'Strawberry', 'Fresh and juicy strawberries, a delightful and healthy snack.', 15.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FStrawberries.jpg?alt=media&token=981121a9-f809-4942-b741-fd8fe1733e74'),
('greens', 3, 'Papaya', 'Ripe and tropical papaya, rich in vitamins and antioxidants.', 12.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fpapaya.jpg?alt=media&token=39bab6f1-eb15-4c38-a51e-dc730c816809'),
('greens', 3, 'Pomegranate', 'Sweet and tangy pomegranate, a nutritious and refreshing fruit.', 18.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fpomegranate.jpg?alt=media&token=fcc19958-cf04-409d-a226-366e29ec1df7'),
('greens', 3, 'Potato', 'Versatile potatoes, suitable for various culinary applications.', 10.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fpotato.jpg?alt=media&token=c3c10281-481b-4330-b2e8-702afad4915e'),
('greens', 3, 'Carrot', 'Sweet and crunchy carrots, great for snacking or cooking.', 6.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FCarrot.jpg?alt=media&token=5850696a-2ad4-4061-85d1-27a7ba96f1d0'),
('greens', 3, 'Corn', 'Fresh and sweet corn, ideal for boiling, grilling.', 3.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FCorn.jpg?alt=media&token=d0f77eb4-5ad5-479f-9890-3197787feb03'),
('greens', 3, 'Apples', 'Crisp and juicy apples, a classic and healthy snack.', 10.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2Fapples1.jpg?alt=media&token=a4824d4d-a644-492e-8d4c-fc195d7cae6b'),
('greens', 3, 'Mangoes', 'Sweet and tropical mangoes, a delicious and refreshing treat.', 15.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FGreens%2FMango%201.jpeg?alt=media&token=48add76a-fdbb-49ed-97b9-2c0ae260e663');

-- Inserting into meat table --
INSERT INTO products (product_type, seller_id, name, description, price, quantity, image_url)
VALUES
('meat', 4, 'Lamb', 'Tender and flavorful lamb, perfect for roasting or grilling.', 40.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FMeat%2Flamb.jpg?alt=media&token=64ba63d0-cb35-4509-94bf-70ffeb062bfa'),
('meat', 4, 'Beef', 'High-quality beef, perfect for roasts, steaks, or stews.', 50.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FMeat%2Fbeef.jpg?alt=media&token=8cc1592f-7d8e-4fc6-b72c-39be89abffe9'),
('meat', 4, 'Beef Mince', 'Finely ground beef mince, versatile for a variety of dishes.', 25.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FMeat%2Fbeef-mince.jpg?alt=media&token=251cf3c0-27a1-4bb2-96b9-6f70eb51d359'),
('meat', 4, 'Chicken', 'Fresh chicken, versatile for a wide range of delicious recipes.', 15.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FMeat%2Fchicken.jpg?alt=media&token=5f543ea3-92eb-4dca-9745-04e562f16b87'),
('meat', 4, 'Short Ribs', 'Tender and succulent short ribs, perfect for slow cooking or grilling.', 80.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FMeat%2Fshort%20ribs.jpg?alt=media&token=cbc1d15e-cf4c-4304-8cbb-a51b2ae5ce4e'),
('meat', 4, 'Tomahawk', 'A large, flavorful Tomahawk steak, ideal for grilling or roasting.', 120.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FMeat%2Ftomahawk.png?alt=media&token=f56fd14c-2792-4603-b1f6-a32f97d2c5cb');

--  inserting into dairy table --
INSERT INTO products (product_type, seller_id, name, description, price, quantity, image_url)
VALUES
('dairy', 5, 'Feta Cheese', 'Tangy and crumbly feta cheese, great for salads and Mediterranean dishes.', 25.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FDairy%2Ffeta%20cheese.jpg?alt=media&token=ddc64d28-bc4d-4cdc-b349-8f5f08625487'),
('dairy', 5, 'Yellow Cheese', 'Creamy and mild yellow cheese, perfect for sandwiches or snacks.', 20.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FDairy%2FYellow%20Cheese.png?alt=media&token=37990863-79a9-4a16-ae17-0d4942647dde'),
('dairy', 5, 'Butter', 'Creamy and rich butter, a staple for cooking and baking.', 15.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FDairy%2FButter.jpeg?alt=media&token=5d2636d7-d2a8-4b2e-b0ed-1f545b1f957d'),
('dairy', 5, 'Eggs', 'Farm-fresh eggs, a versatile and essential kitchen staple.', 10.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FDairy%2Feggs.jpg?alt=media&token=a8221d8e-aa95-437f-9054-840c90306f54'),
('dairy', 5, 'Milk', 'Fresh and creamy milk, straight from the farm to your table.', 8.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FDairy%2Fmilk.jpg?alt=media&token=b48b3b77-df71-47c9-be7b-ebc3e73f9e61'),
('dairy', 5, 'Yogurt', 'Smooth and tangy yogurt, a nutritious and delicious addition to your diet.', 12.00, 100, 'https://firebasestorage.googleapis.com/v0/b/agrarian-pantry.appspot.com/o/agrarian-images%2FDairy%2Fyoghurt.jpg?alt=media&token=b7397fc9-9d98-4c02-8ec4-d73f90868d08');