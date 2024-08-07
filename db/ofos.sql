-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 04:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ofos`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` varchar(255) NOT NULL,
  `products` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `fulfilled` varchar(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_id`, `products`, `total_price`, `fulfilled`) VALUES
(1, 1, 'ORD_66b1f54c25636', '1,2,2,1,3,1', 886.00, '1'),
(2, 1, 'ORD_66b1f96c696ee', '1,3,2,1,3,2', 1274.00, '1'),
(3, 1, 'ORD_66b1fbebc2c70', '1,10', 2990.00, '1'),
(4, 1, 'ORD_66b20eacd94af', '1,1,2,1,3,1,4,1,5,1,6,1,7,1,8,1,9,1,11,1,12,2,13,1,14,1,15,1,10,1', 3094.00, '1'),
(5, 1, 'ORD_66b218d65371f', '5,1', 159.00, '1'),
(6, 1, 'ORD_66b2f78d7bc57', '1,1', 299.00, '1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `picture_url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `name`, `description`, `category`, `price`, `picture_url`, `status`) VALUES
(1, '58359be0a592', 'Pizza', 'Margherita: Classic delight with fresh tomatoes, mozzarella, and basil, topped with a drizzle of olive oil and a sprinkle of sea salt.\r\n\r\n', 'Pizza', 299.00, 'https://www.southernliving.com/thmb/3x3cJaiOvQ8-3YxtMQX0vvh1hQw=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/2652401_QFSSL_SupremePizza_00072-d910a935ba7d448e8c7545a963ed7101.jpg', 1),
(2, 'b1486df65d93', 'Pasta', 'Classic Spaghetti Bolognese: Rich, savory ground beef and tomato sauce simmered with onions, garlic, and herbs, served over al dente spaghetti.\r\n\r\n', 'Pasta', 199.00, 'https://www.allrecipes.com/thmb/QiGptPjQB5mqSXGVxE4sLPMJs_4=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/AR-269500-creamy-garlic-pasta-Beauties-2x1-bcd9cb83138849e4b17104a1cd51d063.jpg', 1),
(3, '9277e47661e8', 'Maggi', 'Classic Maggi: Timeless and comforting, with a rich and savory seasoning blend and perfectly cooked noodles.\r\n\r\n', 'Pasta', 89.00, 'https://www.nestleprofessional.in/sites/default/files/2022-08/MAGGI-Noodles-Chakna-756x471.jpg', 1),
(4, '6bc3afa2a7fd', 'Tomato Soup', 'Classic Tomato Soup: A rich and velvety tomato soup made with ripe tomatoes, onions, and garlic, finished with a touch of cream.\r\n\r\n', 'Soup', 129.00, 'https://www.indianhealthyrecipes.com/wp-content/uploads/2022/11/tomato-soup-recipe-500x375.jpg', 1),
(5, '9eda480d1b6d', 'Manchow', 'Classic Manchow Soup: A savory blend of vegetables and crispy noodles in a spicy, tangy broth, garnished with fresh cilantro and spring onions.\r\n\r\n', 'Soup', 159.00, 'https://myfoodstory.com/wp-content/uploads/2016/07/Chicken-Manchow-Soup-2.jpg', 1),
(6, 'eb346ce673d0', 'Manchurian Soup', 'A savory, aromatic soup featuring crispy vegetable Manchurian balls simmered in a rich, slightly tangy broth with a perfect blend of soy sauce, garlic, and ginger, garnished with fresh spring onions and cilantro.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'Soup', 169.00, 'https://www.vegrecipesofindia.com/wp-content/uploads/2018/12/manchow-soup-recipe-1a.jpg', 1),
(7, '138ba7390a26', 'Spaghetti', 'A hearty Italian classic with a rich, savory meat sauce simmered with tomatoes, onions, and herbs.', 'Pasta', 229.00, 'https://www.archanaskitchen.com/images/archanaskitchen/10-Brands/DelMonte-KidsRecipes/Spaghetti_Pasta_Recipe_In_Creamy_Tomato_Sauce_-_Kids_Recipes_Made_With_Del_Monte-3.jpg', 1),
(8, 'd4d0f93e2bfe', 'Seven Cheese Pizza', 'A decadent and indulgent pizza featuring a blend of seven rich cheeses—mozzarella, cheddar, provolone, gouda, fontina, parmesan, and ricotta—melted to perfection over a crispy crust, with a touch of fresh basil and a drizzle of olive oil for a truly cheesy experience.', 'Pizza', 659.00, 'https://tabahifoodpanda.com/wp-content/uploads/2019/01/tnpa8979.jpg?w=1028&h=768&crop=1', 1),
(9, '314ed1e0c259', 'French Fries', 'Crispy, golden-brown fries made from freshly cut potatoes, lightly seasoned with salt and served hot for a perfect balance of crunch and tenderness.', 'Fries', 79.00, 'https://www.recipetineats.com/tachyon/2022/09/Fries-with-rosemary-salt_1.jpg', 1),
(10, '24e235efb1aa', 'Cheesy Fries', 'Crispy, golden-brown French fries smothered in a gooey blend of melted cheddar and mozzarella cheeses, topped with a sprinkle of chopped green onions and a drizzle of creamy cheese sauce for an irresistible, indulgent treat.', 'Fries', 129.00, 'https://www.dinneratthezoo.com/wp-content/uploads/2019/12/cheese-fries-5.jpg', 1),
(11, '76214490652e', 'Peri Peri Fries', 'Crispy, golden-brown fries coated in a zesty peri peri seasoning blend, offering a spicy kick and a burst of flavor with every bite. Garnished with a sprinkle of fresh cilantro and served with a side of cooling dipping sauce for a perfectly balanced, fiery treat.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'Fries', 119.00, 'https://i.pinimg.com/736x/4c/53/a4/4c53a4d4dbf64073fff9ad56701d849d.jpg', 1),
(12, '3298b72d50f3', 'Coca Cola', 'A classic, refreshing carbonated beverage with a bold, slightly sweet flavor and a hint of vanilla and caramel. Served chilled for a crisp and invigorating drink experience.', 'Drink', 89.00, 'https://image.cnbcfm.com/api/v1/image/107299260-1694535118258-gettyimages-1247877300-PIG71227JPG.jpeg?v=1694541175&w=1920&h=1080', 1),
(13, '9037dbb9d149', 'Thumbs UP', 'Thumbs Up: A bold and refreshing cola with a distinctive, slightly spicy flavor profile and a deep, rich caramel taste. Served ice-cold for a crisp, satisfying drink that\'s perfect for any occasion.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'Drink', 89.00, 'https://m.media-amazon.com/images/I/71G2SXt2hrL.jpg', 1),
(14, 'badde635c4f7', 'Sprite', 'Sprite: A crisp, refreshing lemon-lime soda with a clean, effervescent taste and a hint of sweetness. Served ice-cold for a revitalizing and thirst-quenching experience.\r\n\r\n\r\n', 'Drink', 89.00, 'https://miro.medium.com/v2/resize:fit:1400/1*NHdFxj1u-xQ_gAGk1Aw7mA.jpeg', 1),
(15, 'c8e007918f68', 'Panir Masala Pizza', 'Paneer Masala Pizza: A flavorful pizza topped with spiced paneer cubes, sautéed bell peppers, and onions, layered over a rich tomato sauce and mozzarella cheese. Garnished with fresh cilantro and a sprinkle of Indian spices for a delicious fusion of traditional Indian flavors and classic pizza.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'Pizza', 479.00, 'https://www.cookingcarnival.com/wp-content/uploads/2019/11/Paneer-Pizza-7.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mobile`, `password`, `is_admin`) VALUES
(1, '1111111111', '$2y$10$atiHiDWc.HnOETaZBCAKQ.F8BhKtrkiJHZzfb9i74rS2BEZRrUUBm', 0),
(2, '1234567890', '$2y$10$J7D4lMss.8S26hv/SDy6ge83VPmuUo5iyH10k8zClaeKKdAO3KxcS', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
