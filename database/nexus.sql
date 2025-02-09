DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` text COLLATE utf8mb4_general_ci,
  `text` text COLLATE utf8mb4_general_ci NOT NULL,
  `images` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `likes` int NOT NULL,
  `dislikes` int NOT NULL,
  `comments` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `images_1` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `images_2` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `images` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `news_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `family` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `age` date NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `profilePic` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

