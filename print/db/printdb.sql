-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 22 2018 г., 17:29
-- Версия сервера: 5.6.31
-- Версия PHP: 7.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `printdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `duedates`
--

CREATE TABLE `duedates` (
  `title` varchar(32) NOT NULL,
  `duedate` varchar(32) NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `duedates`
--

INSERT INTO `duedates` (`title`, `duedate`, `rate`) VALUES
('Обычный заказ (до 6 дней)', 'fivedays', 1),
('Срочный заказ (2 дня)', 'oneday', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `material` varchar(20) NOT NULL,
  `size` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `deadline` date NOT NULL,
  `url` varchar(250) CHARACTER SET cp1251 NOT NULL,
  `cost` int(11) NOT NULL,
  `typo_id` bigint(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'В обработке'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `papers`
--

CREATE TABLE `papers` (
  `title` varchar(32) NOT NULL,
  `paper` varchar(32) NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `papers`
--

INSERT INTO `papers` (`title`, `paper`, `rate`) VALUES
('Глянцевая', 'glossy', 1),
('Матовая', 'matt', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `prodtypes`
--

CREATE TABLE `prodtypes` (
  `title` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `prodtypes`
--

INSERT INTO `prodtypes` (`title`, `type`, `rate`) VALUES
('Баннер', 'banner', 15),
('Визитка', 'vizit', 3),
('Фото', 'foto', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `sizes`
--

CREATE TABLE `sizes` (
  `title` varchar(32) NOT NULL,
  `size` varchar(32) NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sizes`
--

INSERT INTO `sizes` (`title`, `size`, `rate`) VALUES
('10x15', '10x15', 1),
('20x30', '20x30', 2),
('A3', 'A3', 4),
('A4', 'A4', 3),
('A5', 'A5', 2.5);

-- --------------------------------------------------------

--
-- Структура таблицы `typographers`
--

CREATE TABLE `typographers` (
  `typo_id` bigint(20) NOT NULL,
  `fullname` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `typographers`
--

INSERT INTO `typographers` (`typo_id`, `fullname`) VALUES
(1, 'Смешнов Петр Андреевич'),
(2, 'Быстрова Алина Константиновна'),
(6, 'Марков Алексей Сергеевич');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(32) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `fullname` varchar(32) NOT NULL,
  `tag` varchar(10) NOT NULL DEFAULT 'c',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone`, `fullname`, `tag`, `date`) VALUES
(1, 'admin', '$2y$10$3QXdIt7mBdPgaqYvVO4oSOkBDRgSdY/GwMQj3KrQbUpYmYDv0dfzm', 'example@mail.ru', NULL, 'Admin', 'a', '2018-04-11 19:57:08');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `duedates`
--
ALTER TABLE `duedates`
  ADD PRIMARY KEY (`title`),
  ADD UNIQUE KEY `duedate` (`duedate`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `typo_id` (`order_id`),
  ADD KEY `orders_ibfk_2` (`typo_id`),
  ADD KEY `orders_ibfk_3` (`material`),
  ADD KEY `orders_ibfk_4` (`size`),
  ADD KEY `orders_ibfk_5` (`type`);

--
-- Индексы таблицы `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`title`),
  ADD UNIQUE KEY `paper` (`paper`);

--
-- Индексы таблицы `prodtypes`
--
ALTER TABLE `prodtypes`
  ADD PRIMARY KEY (`title`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Индексы таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`title`),
  ADD UNIQUE KEY `size` (`size`);

--
-- Индексы таблицы `typographers`
--
ALTER TABLE `typographers`
  ADD PRIMARY KEY (`typo_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT для таблицы `typographers`
--
ALTER TABLE `typographers`
  MODIFY `typo_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`typo_id`) REFERENCES `typographers` (`typo_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`material`) REFERENCES `papers` (`title`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`size`) REFERENCES `sizes` (`title`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`type`) REFERENCES `prodtypes` (`title`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
