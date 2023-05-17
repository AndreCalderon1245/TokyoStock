-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 16-05-2023 a las 10:40:09
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tokyostock`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_activity_log`
--

CREATE TABLE `tbl_activity_log` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `event` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_inventory_log`
--

CREATE TABLE `tbl_inventory_log` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `event` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_inventory_log`
--

INSERT INTO `tbl_inventory_log` (`id`, `id_user`, `datetime`, `event`, `description`, `status`) VALUES
(27, 1, '2023-05-15 22:25:46', 'Eliminación', 'Se ha removido el registro del producto con el código de producto A-AGD-807', 'Autorizado'),
(28, 1, '2023-05-15 22:29:13', 'Insertado', 'Se ha creado el registro para el producto ・ Ce-AGD-656・ Camiseta estampadas ・ Azul ・ Grande ・ Dama ・ Mariconera para ocasiones ・ 100.00', 'Autorizado'),
(29, 1, '2023-05-15 22:31:43', 'Reducción', 'Se redujo el stock del producto con el código de producto Ce-AGD-656', 'Autorizado'),
(30, 1, '2023-05-15 23:06:42', 'Aumento', 'Se aumento el stock del producto con el código de producto Ce-AGD-656', 'Autorizado'),
(31, 1, '2023-05-15 23:06:46', 'Disminución', 'Se disminuyo el stock del producto con el código de producto Ce-AGD-656', 'Autorizado'),
(32, 1, '2023-05-15 23:27:32', 'Modificación', 'Se ha modificado el registro para el producto con el código de producto ・ Ce-AGD-656・ Grande -> Chico ', 'Autorizado'),
(33, 1, '2023-05-15 23:27:39', 'Modificación', 'Se ha modificado el registro para el producto con el código de producto ・ Ce-AGD-656・ Chico -> Grande ', 'Autorizado'),
(34, 1, '2023-05-16 00:22:40', 'Aumento', 'Se aumento el stock del producto con el código de producto M-RGD-743', 'Autorizado'),
(35, 1, '2023-05-16 00:26:02', 'Aumento', 'Se aumento el stock del producto con el código de producto Ce-AGD-656 de 11 -> 2', 'Autorizado'),
(36, 1, '2023-05-16 00:29:09', 'Aumento', 'Se aumento el stock del producto con el código de producto Ce-AGD-656 de 13 -> 14', 'Autorizado'),
(37, 1, '2023-05-16 00:48:34', 'Disminución', 'Se disminuyo el stock del producto con el código de producto Ce-AGD-656 de 14 -> 11', 'Autorizado'),
(38, 1, '2023-05-16 02:06:56', 'Insertado', 'Se ha creado el registro para el producto ・ 123・ Rojo ・ 100.00', 'Autorizado'),
(39, 1, '2023-05-16 02:08:56', 'Modificación', 'Se ha modificado el registro para el producto con el código de vinil ・ 123', 'Autorizado'),
(40, 1, '2023-05-16 02:29:30', 'Aumento', 'Se aumento el stock del producto con el código de producto 1234 de 12.00 -> 20', 'Autorizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_product`
--

INSERT INTO `tbl_product` (`product_code`, `name`, `color`, `size`, `gender`, `stock`, `description`, `unit_price`) VALUES
('Ce-AGD-656', 'Camiseta estampadas', 'Azul', 'Grande', 'Dama', 11, 'Mariconera para ocasiones', '100.00'),
('M-ACC-913', 'Mariconera', 'Rojo', 'Grande', 'Dama', 17, 'Mariconera para ocasiones', '120.00'),
('M-RGD-743', 'Mochila', 'Roja', 'Grande', 'Caballero', 20, 'Test', '22.40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_vinyl`
--

CREATE TABLE `tbl_vinyl` (
  `vinyl_code` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `stock` decimal(11,2) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_vinyl`
--

INSERT INTO `tbl_vinyl` (`vinyl_code`, `color`, `type`, `stock`, `unit_price`) VALUES
('123', 'Rojo', '1233', '123.00', '100.00'),
('1234', 'Rojo', 'Textil', '20.00', '12.00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_activity_log`
--
ALTER TABLE `tbl_activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_inventory_log`
--
ALTER TABLE `tbl_inventory_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_code`);

--
-- Indices de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_vinyl`
--
ALTER TABLE `tbl_vinyl`
  ADD PRIMARY KEY (`vinyl_code`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_activity_log`
--
ALTER TABLE `tbl_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_inventory_log`
--
ALTER TABLE `tbl_inventory_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
