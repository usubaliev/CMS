-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2020 at 02:25 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Bootstrap'),
(2, 'Javascript'),
(3, 'PHP'),
(33, 'OOP');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(106, 115, 'EdwinDiaz', 'example@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.', 'approved', '2020-08-16');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` varchar(255) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`) VALUES
(115, 2, 'Javascript Rico 1', '', 'rico', '2020-08-17', 'image2.jpg', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque sit amet justo non neque efficitur rhoncus dictum ac tortor. Nullam mattis viverra orci, et fermentum orci congue convallis. Etiam interdum dui vitae lacus aliquam, et ornare metus sodales. Praesent varius eget odio sed vehicula. Nullam ullamcorper mi in nisi lacinia, tincidunt sollicitudin tellus lobortis. Sed eget augue diam. Aenean consequat lectus a ligula cursus varius. Ut cursus vehicula mi, in finibus nunc commodo quis.</p>', 'js, tupolev, kyrghyzstan, course, plane', '', 'published', 74),
(119, 2, 'Javascript Sandra 2', '', 'sandra', '2020-08-17', 'image-tempp.jpg', '<p>Suspendisse scelerisque dui eget libero feugiat ultricies. Mauris a accumsan tellus. Donec venenatis posuere cursus. Nullam efficitur venenatis eros, eu egestas dolor cursus facilisis. Suspendisse potenti. Morbi et tempus lacus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pellentesque magna leo, in pharetra lorem mollis sed. Quisque tempor justo nisl, in vehicula felis suscipit in.</p>', 'js, tupolev, kyrghyzstan, course, plane', '', 'published', 7),
(124, 1, 'Bootstrap Rico 2', '', 'rico', '2020-08-17', 'image-tempp.jpg', '<p>Suspendisse scelerisque dui eget libero feugiat ultricies. Mauris a accumsan tellus. Donec venenatis posuere cursus. Nullam efficitur venenatis eros, eu egestas dolor cursus facilisis. Suspendisse potenti. Morbi et tempus lacus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pellentesque magna leo, in pharetra lorem mollis sed. Quisque tempor justo nisl, in vehicula felis suscipit in.</p>', 'js, tupolev, kyrghyzstan, course, plane', '', 'published', 19),
(125, 1, 'Bootstrap Rico 1', '', 'rico', '2020-08-17', 'image2.jpg', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque sit amet justo non neque efficitur rhoncus dictum ac tortor. Nullam mattis viverra orci, et fermentum orci congue convallis. Etiam interdum dui vitae lacus aliquam, et ornare metus sodales. Praesent varius eget odio sed vehicula. Nullam ullamcorper mi in nisi lacinia, tincidunt sollicitudin tellus lobortis. Sed eget augue diam. Aenean consequat lectus a ligula cursus varius. Ut cursus vehicula mi, in finibus nunc commodo quis.</p>', 'js, tupolev, kyrghyzstan, course, plane', '', 'published', 1),
(126, 2, 'Javascript Sandra 1', '', 'sandra', '2020-08-17', 'image1.jpg', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>', 'Bootstrap, course, udemy', '', 'published', 1),
(127, 3, 'Phasellus at malesuada nulla', '', 'rico', '2020-08-29', 'image0.jpg', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p><p>Phasellus at malesuada nulla, non malesuada erat. Vivamus interdum pretium pretium. Nam blandit quam non malesuada vehicula.</p><p>Curabitur ut orci nisl. Sed gravida pulvinar odio, nec rhoncus felis gravida a. Nam ac magna eros. Fusce id aliquam lacus. Pellentesque pellentesque ex enim, ac ultricies felis egestas nec. Sed quis velit suscipit, iaculis dolor quis, tristique augue.</p>', 'php, cms, udemy, course, online', '', 'published', 6),
(128, 33, 'Curabitur ut orci nisl', '', 'sara', '2020-08-29', 'image0.jpg', '<p>Curabitur ut orci nisl. Sed gravida pulvinar odio, nec rhoncus felis gravida a. Nam ac magna eros. Fusce id aliquam lacus. Pellentesque pellentesque ex enim, ac ultricies felis egestas nec. Sed quis velit suscipit, iaculis dolor quis, tristique augue.</p>', 'php, cms, udemy, course, online', '', 'published', 3),
(129, 1, 'Curabitur ut orci nisl', '', 'sandra', '2020-08-29', 'image0.jpg', '<p>asdfasdf</p>', 'php, cms, udemy, course, online', '', 'published', 3),
(130, 1, 'Curabitur', '', 'sandra', '2020-08-29', '', '<p>Curabitur ut orci nisl.</p>', 'php, cms, udemy, course, online', '', 'published', 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(20) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `randSalt` varchar(255) NOT NULL DEFAULT '$2y$10$iusesomecrazystrings22',
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `randSalt`, `token`) VALUES
(47, 'link', '$2y$12$eGrsQ6z9i00vbAmzCUIRJeY2Gy5D6luP/aCbRI5NC9Pa2kKwnB8zW', '', '', 'link@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id_` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id_`, `session`, `time`) VALUES
(8, 'urfh1r484eq92u03hae00n5rb3', 1596931464),
(9, 'nbdb5rg8p5rpnph0jg21ob73cp', 1597001371),
(10, 'bja5l0r2vhgj7ts4vbnob06uiv', 1597095308),
(11, 'flse2mrdd0cc6rk67kng0nk6r2', 1597272448),
(12, 'i49jt5acr2pqo2qv8k0octtl1p', 1597444436),
(13, '9teifd3rm6trah54cjefabhdc8', 1597536815),
(14, 'a440vdmok4npp6pjhmtosjr6hd', 1597615913),
(15, 'd4dg11v4qkufcceskgj4fnn238', 1597785693),
(16, 'poni1eumv6i3a1up2eaekqhbf4', 1597793255),
(17, 'pa8ghcv51mst6fk0q8rp14bl75', 1597926973),
(18, '12n7fr1n27c87e0f64sms5ktjh', 1598291056),
(19, '1bt58a4gerqldvlsa4t7i0nd05', 1598384930),
(20, 'kop3u9ivq3i1bnfn591j5d9j0q', 1598569766),
(21, 'pa85bcljf8u796j79atac5l4gr', 1598659048),
(22, 'rtshsf1b17huslcfdon2dpk3ba', 1598747074);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id_`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
