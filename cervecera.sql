-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-02-2025 a las 20:50:25
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cervecera`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `denominacion` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `formato` varchar(100) NOT NULL,
  `cantidad` varchar(100) NOT NULL,
  `alergenos` varchar(100) NOT NULL,
  `fecha_consumo` varchar(100) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `precio` float NOT NULL,
  `observaciones` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `denominacion`, `marca`, `tipo`, `formato`, `cantidad`, `alergenos`, `fecha_consumo`, `imagen`, `precio`, `observaciones`) VALUES
(24, 'Cruzcampo', 'Cruzcampo', 'lager', 'botella', 'botellin', 'Gluten,Huevo,Cacahuete', '2025-02-20', '../img/uploads/cruzcampo.jpeg', 1.2, 'Fria no está mal'),
(25, 'Heineken', 'Heineken', 'pale', 'pack', 'litro', 'Gluten,Huevo,Cacahuete', '2025-02-27', '../img/uploads/heineken.jpeg', 2.3, 'Suave'),
(26, 'Alhambra', 'Alhambra', 'lager', 'botella', 'tercio', 'Gluten,Huevo', '2025-02-19', '../img/uploads/Alhambra.jpeg', 1.4, 'La favorita del mejor profesor ;) ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `perfil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `correo`, `nombre`, `password`, `perfil`) VALUES
(1, 'admin@admin.com', 'Antonio', '827ccb0eea8a706c4c34a16891f84e7b', 'admin'),
(2, 'user@user.com', 'Antonio', '827ccb0eea8a706c4c34a16891f84e7b', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
