-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 31 2019 г., 12:09
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `medico`
--
CREATE DATABASE IF NOT EXISTS `medico` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `medico`;

-- --------------------------------------------------------

--
-- Структура таблицы `accesses`
--

CREATE TABLE `accesses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `access` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `accesses`
--

INSERT INTO `accesses` (`id`, `user_id`, `access`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `names`
--

CREATE TABLE `names` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `names`
--

INSERT INTO `names` (`id`, `user_id`, `name`) VALUES
(1, 3, 'Sergey');

-- --------------------------------------------------------

--
-- Структура таблицы `phones`
--

CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `phones`
--

INSERT INTO `phones` (`id`, `user_id`, `phone`) VALUES
(1, 3, '066665757');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_name` varchar(20) NOT NULL,
  `task` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `task_name`, `task`) VALUES
(2, 1, 'fibonacci', '[10,20]'),
(3, 1, 'fibonacci', '[10,20]'),
(4, 1, 'fibonacci', '[10,20]'),
(5, 1, 'fibonacci', '[10,20]'),
(6, 1, 'fibonacci', '[10,20]'),
(7, 1, 'fibonacci', '[10,20]'),
(8, 1, 'fibonacci', '[10,20]'),
(9, 1, 'fibonacci', '[10,20]'),
(10, 1, 'fibonacci', '[10,20]'),
(11, 1, 'fibonacci', '[10,20]'),
(12, 1, 'fibonacci', '[10,20]'),
(13, 1, 'fibonacci', '[10,20]'),
(14, 1, 'fibonacci', '[10,20]'),
(15, 1, 'fibonacci', '[10,20]'),
(16, 1, 'fibonacci', '[10,20]'),
(17, 1, 'fibonacci', '[10,20]'),
(18, 1, 'fibonacci', '[10,20]'),
(19, 1, 'fibonacci', '[10,20]'),
(20, 1, 'fibonacci', '[10,20]'),
(21, 1, 'fibonacci', '[10,20]'),
(22, 1, 'fibonacci', '[10,20]'),
(23, 1, 'fibonacci', '[10,20]'),
(24, 1, 'fibonacci', '[10,20]'),
(25, 1, 'fibonacci', '[10,20]'),
(26, 1, 'fibonacci', '[10,20]'),
(27, 1, 'fibonacci', '[10,20]'),
(28, 1, 'fibonacci', '[10,20]'),
(29, 1, 'fibonacci', '[10,20]'),
(30, 1, 'fibonacci', '[10,20]'),
(31, 1, 'fibonacci', '[10,20]'),
(32, 1, 'fibonacci', '[10,20]'),
(33, 1, 'fibonacci', '[10,20]'),
(34, 1, 'fibonacci', '[10,20]'),
(35, 1, 'fibonacci', '[10,20]'),
(36, 1, 'fibonacci', '[10,20]'),
(37, 1, 'fibonacci', '[10,20]'),
(38, 1, 'fibonacci', '[10,20]'),
(39, 1, 'fibonacci', '[10,20]'),
(40, 1, 'fibonacci', '[10,20]'),
(41, 1, 'fibonacci', '[10,20]'),
(43, 1, 'sleep', '[10]'),
(42, 1, 'sleep', '[25]');

-- --------------------------------------------------------

--
-- Структура таблицы `task_results`
--

CREATE TABLE `task_results` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `result` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `task_results`
--

INSERT INTO `task_results` (`id`, `task_id`, `result`) VALUES
(1, 25, '[55,6765]'),
(2, 26, '[55,6765]'),
(3, 27, '[55,6765]'),
(4, 28, '[55,6765]'),
(5, 29, '[55,6765]'),
(6, 30, '[55,6765]'),
(7, 31, '[55,6765]'),
(8, 32, '[55,6765]'),
(9, 33, '[55,6765]'),
(10, 35, '[55,6765]'),
(11, 38, '[55,6765]'),
(12, 39, '[55,6765]'),
(13, 40, '[55,6765]'),
(14, 41, '[55,6765]'),
(15, 43, '[\"finished\"]');

-- --------------------------------------------------------

--
-- Структура таблицы `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(36) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`) VALUES
(1, 1, '48530017-15b3-406f-8fd4-f64788b4c56e');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `update_at`, `updated_at`) VALUES
(1, 'test1@gmail.com', '$2y$10$GyMD2b3PlRY76mn.cdPVsOfGfDWpDk1uaLYycmWxcPF41J9bZO4he', NULL, '2019-03-28 07:16:17'),
(2, 'test2@gmail.com', '$2y$10$gMzT3SxUnh3IR7IZwIhRluyoeIeDi/6qVWzj0Fa9zKQKzYFcFf7LS', NULL, NULL),
(3, 'test3@gmail.com', '$2y$10$yCFXJYAl5QFOstCo6fGqqOgfwBFSv8wgtbtLitkvZiKb6BPcuvwJa', '2019-03-28 20:31:29', '2019-03-29 08:04:38');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accesses`
--
ALTER TABLE `accesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `accesses_access` (`access`);

--
-- Индексы таблицы `names`
--
ALTER TABLE `names`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Индексы таблицы `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_user_id_phone` (`user_id`,`phone`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_task_name_task` (`user_id`,`task_name`,`task`);

--
-- Индексы таблицы `task_results`
--
ALTER TABLE `task_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_results_task_id_task_name_task` (`task_id`,`result`);

--
-- Индексы таблицы `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `users_email_pass` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accesses`
--
ALTER TABLE `accesses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `names`
--
ALTER TABLE `names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `task_results`
--
ALTER TABLE `task_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `accesses`
--
ALTER TABLE `accesses`
  ADD CONSTRAINT `accesses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `names`
--
ALTER TABLE `names`
  ADD CONSTRAINT `names_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `task_results`
--
ALTER TABLE `task_results`
  ADD CONSTRAINT `task_results_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- База данных: `parser`
--
CREATE DATABASE IF NOT EXISTS `parser` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `parser`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
