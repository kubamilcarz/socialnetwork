-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 07 Gru 2017, 21:47
-- Wersja serwera: 10.1.25-MariaDB
-- Wersja PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `facebook`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) UNSIGNED NOT NULL,
  `album_name` int(11) NOT NULL,
  `album_description` text COLLATE utf8mb4_polish_ci NOT NULL,
  `album_created_at` date NOT NULL,
  `album_userid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `comments_id` int(11) UNSIGNED NOT NULL,
  `comments_body` text COLLATE utf8mb4_polish_ci NOT NULL,
  `comments_likes` int(11) UNSIGNED NOT NULL,
  `comments_comments` int(11) UNSIGNED NOT NULL,
  `comments_date` date NOT NULL,
  `comments_userid` int(11) UNSIGNED NOT NULL,
  `comments_postid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comment_likes`
--

CREATE TABLE `comment_likes` (
  `comment_likes_id` int(11) UNSIGNED NOT NULL,
  `comment_likes_type` tinyint(4) NOT NULL,
  `comment_likes_userid` int(11) UNSIGNED NOT NULL,
  `comment_likes_commentid` int(11) UNSIGNED NOT NULL,
  `comment_likes_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events`
--

CREATE TABLE `events` (
  `events_event_id` int(11) UNSIGNED NOT NULL,
  `event_name` varchar(128) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `event_date` date NOT NULL,
  `event_status` tinyint(1) NOT NULL,
  `event_userid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `friends`
--

CREATE TABLE `friends` (
  `friends_id` int(11) UNSIGNED NOT NULL,
  `friends_userid` int(11) UNSIGNED NOT NULL,
  `friends_friendid` int(11) UNSIGNED NOT NULL,
  `friends_status` tinyint(1) NOT NULL,
  `friends_friends_from` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login_tokens`
--

CREATE TABLE `login_tokens` (
  `login_tokens_id` int(11) UNSIGNED NOT NULL,
  `login_token_token` varchar(64) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `login_token_userid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `messages_message_id` int(11) UNSIGNED NOT NULL,
  `messages_body` text COLLATE utf8mb4_polish_ci,
  `messages_senderid` int(11) NOT NULL,
  `messages_receiverid` int(11) NOT NULL,
  `messages_send_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notifications`
--

CREATE TABLE `notifications` (
  `notifications_notification_id` int(11) UNSIGNED NOT NULL,
  `notifications_type` int(11) UNSIGNED NOT NULL,
  `notifications_receiverid` int(11) UNSIGNED NOT NULL,
  `notifications_senderid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `photos`
--

CREATE TABLE `photos` (
  `photos_id` int(11) UNSIGNED NOT NULL,
  `photos_type` tinyint(1) NOT NULL,
  `photos_userid` int(11) UNSIGNED NOT NULL,
  `photos_source` varchar(128) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `photos_in_album`
--

CREATE TABLE `photos_in_album` (
  `photos_in_album_id` int(11) UNSIGNED NOT NULL,
  `photos_in_album_albumid` int(11) UNSIGNED NOT NULL,
  `photos_in_album_photoid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `posts_id` int(11) UNSIGNED NOT NULL,
  `posts_body` text COLLATE utf8mb4_polish_ci NOT NULL,
  `posts_likes` int(11) UNSIGNED NOT NULL,
  `posts_comments` int(11) UNSIGNED NOT NULL,
  `posts_date` date NOT NULL,
  `posts_privacy` tinyint(1) NOT NULL,
  `posts_userid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post_likes`
--

CREATE TABLE `post_likes` (
  `post_likes_id` int(11) UNSIGNED NOT NULL,
  `post_likes_type` tinyint(1) NOT NULL,
  `post_likes_userid` int(11) UNSIGNED NOT NULL,
  `post_likes_postid` int(11) UNSIGNED NOT NULL,
  `post_likes_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `roles_role_id` int(11) UNSIGNED NOT NULL,
  `roles_role` tinyint(1) NOT NULL,
  `roles_userid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_user_id` int(11) UNSIGNED NOT NULL,
  `user_full_name` varchar(64) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_firstname` varchar(32) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_lastname` varchar(32) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_email` varchar(128) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_password` varchar(64) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_phone` int(9) NOT NULL,
  `user_gender` varchar(2) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_dob` date NOT NULL,
  `user_bio` varchar(256) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_profile_picture` varchar(256) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_profile_background_picture` varchar(256) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '',
  `user_active` tinyint(1) NOT NULL,
  `user_points` int(11) NOT NULL,
  `user_friends` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_status`
--

CREATE TABLE `user_status` (
  `user_status_id` int(11) UNSIGNED NOT NULL,
  `user_status_type` tinyint(1) NOT NULL,
  `user_status_userid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `album_userid` (`album_userid`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comments_id`),
  ADD KEY `posts_userid` (`comments_userid`),
  ADD KEY `comments_postid` (`comments_postid`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`comment_likes_id`),
  ADD KEY `post_likes_userid` (`comment_likes_userid`),
  ADD KEY `comment_likes_comment_id` (`comment_likes_commentid`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`events_event_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friends_id`);

--
-- Indexes for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`login_tokens_id`),
  ADD KEY `login_token_userid` (`login_token_userid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messages_message_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notifications_notification_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photos_id`),
  ADD KEY `photos_userid` (`photos_userid`);

--
-- Indexes for table `photos_in_album`
--
ALTER TABLE `photos_in_album`
  ADD PRIMARY KEY (`photos_in_album_id`),
  ADD KEY `photos_in_album_albumid` (`photos_in_album_albumid`),
  ADD KEY `photos_in_album_photoid` (`photos_in_album_photoid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`posts_id`),
  ADD KEY `posts_userid` (`posts_userid`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`post_likes_id`),
  ADD KEY `post_likes_userid` (`post_likes_userid`),
  ADD KEY `post_likes_postid` (`post_likes_postid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roles_role_id`),
  ADD KEY `roles_userid` (`roles_userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_user_id`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`user_status_id`),
  ADD KEY `user_status_userid` (`user_status_userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `comments_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `comment_likes_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `events`
--
ALTER TABLE `events`
  MODIFY `events_event_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `friends`
--
ALTER TABLE `friends`
  MODIFY `friends_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `login_tokens_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `messages_message_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notifications_notification_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `photos`
--
ALTER TABLE `photos`
  MODIFY `photos_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `photos_in_album`
--
ALTER TABLE `photos_in_album`
  MODIFY `photos_in_album_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `posts`
--
ALTER TABLE `posts`
  MODIFY `posts_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `post_likes_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `roles`
--
ALTER TABLE `roles`
  MODIFY `roles_role_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT dla tabeli `user_status`
--
ALTER TABLE `user_status`
  MODIFY `user_status_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`album_userid`) REFERENCES `users` (`user_user_id`);

--
-- Ograniczenia dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comments_userid`) REFERENCES `users` (`user_user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`comments_postid`) REFERENCES `posts` (`posts_id`);

--
-- Ograniczenia dla tabeli `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `comment_likes_ibfk_1` FOREIGN KEY (`comment_likes_userid`) REFERENCES `users` (`user_user_id`),
  ADD CONSTRAINT `comment_likes_ibfk_2` FOREIGN KEY (`comment_likes_commentid`) REFERENCES `comments` (`comments_id`);

--
-- Ograniczenia dla tabeli `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`login_token_userid`) REFERENCES `users` (`user_user_id`);

--
-- Ograniczenia dla tabeli `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`photos_userid`) REFERENCES `users` (`user_user_id`);

--
-- Ograniczenia dla tabeli `photos_in_album`
--
ALTER TABLE `photos_in_album`
  ADD CONSTRAINT `photos_in_album_ibfk_1` FOREIGN KEY (`photos_in_album_albumid`) REFERENCES `albums` (`album_id`),
  ADD CONSTRAINT `photos_in_album_ibfk_2` FOREIGN KEY (`photos_in_album_photoid`) REFERENCES `photos` (`photos_id`);

--
-- Ograniczenia dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`posts_userid`) REFERENCES `users` (`user_user_id`);

--
-- Ograniczenia dla tabeli `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_likes_userid`) REFERENCES `users` (`user_user_id`),
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`post_likes_postid`) REFERENCES `posts` (`posts_id`);

--
-- Ograniczenia dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`roles_userid`) REFERENCES `users` (`user_user_id`);

--
-- Ograniczenia dla tabeli `user_status`
--
ALTER TABLE `user_status`
  ADD CONSTRAINT `user_status_ibfk_1` FOREIGN KEY (`user_status_userid`) REFERENCES `users` (`user_user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
