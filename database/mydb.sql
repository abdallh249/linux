

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE `dictionary` (
  `definition` varchar(255) DEFAULT NULL,
  `word` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `dictionary` (`definition`, `word`) VALUES
('fruits', 'apple'),
('car', 'bmw'),
('phone', 'iphone'),
('sun', 'star');
COMMIT;

