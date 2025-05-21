-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2025 a las 05:48:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `user_exam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioex`
--

CREATE TABLE `usuarioex` (
  `id` int(10) UNSIGNED NOT NULL,
  `correo` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `nombre` tinytext NOT NULL,
  `avatar` tinyint(3) UNSIGNED NOT NULL,
  `link` tinytext NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `nota1` float NOT NULL DEFAULT -1,
  `nota2` float NOT NULL DEFAULT -1,
  `nota3` float NOT NULL DEFAULT -1,
  `nota4` float NOT NULL DEFAULT -1,
  `nota5` float NOT NULL DEFAULT -1,
  `nota6` float NOT NULL DEFAULT -1,
  `genero` tinyint(3) UNSIGNED NOT NULL,
  `activo` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `time_recupera` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarioex`
--
ALTER TABLE `usuarioex`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarioex`
--
ALTER TABLE `usuarioex`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
