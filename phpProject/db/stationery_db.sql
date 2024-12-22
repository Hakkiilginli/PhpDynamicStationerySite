-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 Ara 2024, 01:24:27
-- Sunucu sürümü: 5.7.17
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `stationery_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `quantity`) VALUES
(67544, 1, 16),
(67545, 5, 1),
(67546, 4, 1),
(67547, 3, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `contact_form`
--

INSERT INTO `contact_form` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'HakkÄ± ', 'hakkilginli59@gmail.com', 'Ã¼rÃ¼nler yetersiz\r\n', '2024-12-14 22:24:05'),
(2, 'emir', 'emir3@gmail.com', 'hepÄ±nÄ±zÄ±n emeÄŸine saÄŸlÄ±k', '2024-12-14 22:51:12'),
(3, 'taner', 'taner@gmail.com', 'Ã¼rÃ¼nler Ã§ok az geliÅŸmesi gerekiyor saygÄ±lar.', '2024-12-15 16:18:25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`) VALUES
(1, 8, '50.00', 'pending', '2024-12-14 21:38:27'),
(2, 1, '465.00', 'pending', '2024-12-14 22:35:59'),
(3, 1, '860.00', 'pending', '2024-12-15 16:03:35'),
(4, 1, '560.00', 'pending', '2024-12-15 16:17:20'),
(5, 1, '50.00', 'pending', '2024-12-15 17:07:06'),
(7, 2, '35.00', 'pending', '2024-12-17 11:14:05'),
(8, 2, '65.00', 'pending', '2024-12-17 11:16:15'),
(9, 2, '65.00', 'pending', '2024-12-17 12:25:20');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 30, 1, '50.00'),
(2, 2, 29, 1, '65.00'),
(3, 2, 30, 8, '50.00'),
(4, 3, 30, 7, '50.00'),
(5, 3, 29, 4, '65.00'),
(6, 3, 28, 5, '50.00'),
(7, 4, 30, 6, '50.00'),
(8, 4, 29, 4, '65.00'),
(9, 5, 30, 1, '50.00'),
(10, 6, 6, 4, '50.00'),
(11, 7, 32, 1, '35.00'),
(12, 8, 29, 1, '65.00'),
(13, 9, 29, 1, '65.00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stock` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`, `stock`) VALUES
(30, 'UÃ§lu Kalem', '0.7 Fabel Castel UÃ§lu Kalem', '49.99', '../images/fabeluclutek.jpg', '2024-12-14 19:42:06', 27),
(6, 'Fosforlu Kalem', '5 adet fosforlu kaliteli kalemler', '49.99', 'fosfoslukalem.jpeg', '2024-12-07 18:32:24', 46),
(28, 'Mum Boya', 'Carioca mum boyalarÄ±', '49.99', '../images/caricoamum.jpg', '2024-12-14 19:40:26', 1),
(29, 'TÃ¼kenmez Kalemler', 'Fabel Castel tÃ¼kenmez kalem', '64.99', '../images/fabeltukenmez.jpg', '2024-12-14 19:41:26', 4),
(31, 'Sepet Kalemlik', 'Metal sepet kalemlik ', '79.99', '../images/sepetkalemlik.jpg', '2024-12-14 19:43:10', 15),
(32, 'Pembe Makas', 'Pembe Makas', '34.99', '../images/makas.jpg', '2024-12-14 19:43:29', 24),
(34, 'Postit', 'Not almak iÃ§in kullanÄ±ÅŸlÄ± postitler', '49.99', '../images/postitler.jpg', '2024-12-14 19:45:23', 30),
(37, 'SarÄ± Kalemkutu', 'SarÄ± Kalemkutu kumaÅŸ kalemkutu', '54.99', '../images/kalemlik.jpg', '2024-12-17 14:13:51', 65),
(38, 'YapÄ±ÅŸtÄ±rÄ±cÄ± Pritt', 'YapÄ±ÅŸtÄ±rÄ±cÄ± Pritt KaÄŸÄ±t,KumaÅŸ yapÄ±ÅŸtÄ±rÄ±lmaya uygun', '24.99', '../images/prit.jpeg', '2024-12-17 14:14:56', 100),
(39, 'SÄ±rt Ã‡antasÄ± (Siyah)', 'Siyah su geÃ§irmez sÄ±rt Ã§antasÄ± kumaÅŸ', '249.99', '../images/canta.jpg', '2024-12-17 14:15:55', 50),
(40, 'A4 KaÄŸÄ±t', '500lÃ¼ Paket A4 ', '124.99', '../images/a4kagit.jpg', '2024-12-17 14:18:45', 50),
(41, 'Oyun Hamuru', '6 renk oyun hamuru kÄ±rmÄ±zÄ±,beyaz,sarÄ±,mavi,yeÅŸil,mor', '219.99', '../images/oyunhamuru.jpg', '2024-12-17 14:21:35', 50);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin123', 'admin', '2024-12-05 22:26:47'),
(2, 'hako', 'klas59', 'user', '2024-12-05 23:12:08'),
(9, 'HakkÄ±Bey', 'klas59', 'user', '2024-12-15 21:28:01'),
(4, 'rambo', 'klas59', 'user', '2024-12-07 17:49:59'),
(5, 'hako59', 'klas5959', 'user', '2024-12-07 17:55:00'),
(6, 'sh6622', 'klas59', 'user', '2024-12-07 18:13:12'),
(8, 'tanerguve', 'taner59', 'user', '2024-12-14 21:31:14');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Tablo için indeksler `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67548;
--
-- Tablo için AUTO_INCREMENT değeri `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Tablo için AUTO_INCREMENT değeri `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
