-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 06 2021 г., 13:35
-- Версия сервера: 10.4.19-MariaDB
-- Версия PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `anecdote`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `dislikes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`post_id`, `user_id`) VALUES
(2, 1),
(3, 1),
(4, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `author_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `content`, `author_name`, `likes`, `author_id`) VALUES
(1, 'Три вещи никогда не возвращаются обратно — время, слово и накопительная часть пенсии.\r\nКонфуций.', 'leo', 2, 1),
(2, 'Парадокс: сначала ты долго и упорно ищешь работу, а потом не хочешь на неё ходить.', 'leo', 1, 1),
(3, 'Сегодня я заработал свои первые деньги как программист.\r\nЯ продал свой ноут.', 'leo', 1, 1),
(4, 'Негра, укравшего банкомат, не пустили с ним в автобус.\r\nКакие ещё нужны доказательства расизма в Америке?', 'leo', 1, 1),
(5, 'Ну, что вы докопались к министру строительства? Вы его дачу видели? А дом? Нормально он умеет строить!', 'leo', 0, 1),
(6, 'Психоаналитик:\r\n- Вы знаете, коллега, моя знакомая боится темноты. Пытался её убедить,\r\nчто ничего страшного там нет. Но она привела свои доводы, и теперь я\r\nтоже боюсь темноты...\r\n', 'leo', 1, 1),
(7, 'Шеф фирмы ругает своего подчиненного за допущенную грубую ошибку. Желая\r\nбыть тактичным, он спрашивает его:\r\n- Мне кажется, один из нас - придурок. Как вы думаете, кто?\r\n- Но, шеф, руководитель с вашим опытом вряд ли примет на работу придурка!', 'leo', 1, 1),
(8, 'Встречаются две подруги. Одна другой жалуется:\r\n- Мой муж так часто разговаривает во сне, что просто жуть! А\r\nтвой разговаривает?\r\n- Нет, только улыбается ... сволочь!', 'leo', 1, 1),
(9, 'Эйнштейна пригласили читать лекцию в один из университетов.\r\nПо пути туда водитель говорит Эйнштейну, что он так часто\r\nслушал его лекции, что выучил их наизусть и может без труда\r\nпрочитать сам. Эйнштейн на это ему предлагает поменяться ролями\r\n(тогда телевидения не было и в лицо знаменитостей знали не\r\nвсегда). Приехав в университет, водитель с успехом прочитал\r\nлекцию, после которой ему был задан вопрос. Водитель\r\nне растерялся и сказал:\r\n- Это настолько простой вопрос, что на него без труда ответит\r\nмой водитель!', 'leo', 1, 1),
(18, '- Василий Иваныч, белые с тылу зашли!\r\n- Вперед, Чапаев никогда не отступает.\r\n', 'leo', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'USER'),
(2, 'ADMIN');

-- --------------------------------------------------------

--
-- Структура таблицы `suggested_anecdotes`
--

CREATE TABLE `suggested_anecdotes` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `author_name` varchar(255) NOT NULL DEFAULT 'Гость',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `suggested_anecdotes`
--

INSERT INTO `suggested_anecdotes` (`id`, `content`, `author_name`, `user_id`) VALUES
(8, 'фффффф', 'leo', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `created_at`) VALUES
(1, 'leo', '$2y$10$haARQPSe9tOFG2/k9WHVWeFjMk3xsmHWL/g.BC.vDBhDVAqeufI2q', 2, '2021-06-04 13:57:57'),
(2, 'user', '$2y$10$aQhJGhLBry8vpMFLM3z9weiP4wziy4OjMA8eTsmS1mo/IohFg5coa', 1, '2021-06-05 23:49:34'),
(3, 'admin', '$2y$10$FD1BETwN9F1AbFxcLJrleO5eVxJL4q4Gh.JLtyVFI1fWPJQmPXPwe', 2, '2021-06-06 14:32:46');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_posts` (`post_id`),
  ADD KEY `comments_users` (`user_id`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD UNIQUE KEY `user_id` (`post_id`,`user_id`),
  ADD KEY `likes_users` (`user_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_users` (`author_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `suggested_anecdotes`
--
ALTER TABLE `suggested_anecdotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `suggested_anecdotes`
--
ALTER TABLE `suggested_anecdotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `suggested_anecdotes`
--
ALTER TABLE `suggested_anecdotes`
  ADD CONSTRAINT `suggested_anecdotes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
