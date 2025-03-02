-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2025 a las 21:16:24
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
-- Base de datos: `tiendasara`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Tecnología'),
(2, 'Hogar'),
(3, 'Jardinería'),
(4, 'Ropa y Accesorios'),
(5, 'Belleza y Cuidado Personal'),
(7, 'Juguetes y Juegos'),
(8, 'Electrodomésticos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--

CREATE TABLE `lineas_pedidos` (
  `id` int(255) NOT NULL,
  `pedido_id` int(255) NOT NULL,
  `producto_id` int(255) NOT NULL,
  `unidades` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) NOT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `coste` float(200,2) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(255) NOT NULL,
  `categoria_id` int(255) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` float(100,2) NOT NULL,
  `stock` int(255) NOT NULL,
  `oferta` varchar(2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(4, 1, 'Iphone 16 Pro', 'Diseño de aluminioParte delantera con Ceramic Shield de última generaciónParte trasera de vidrio tintado en masa', 959.00, 3, NULL, NULL, '1740936811_61Ml-IP+73L._AC_UF1000,1000_QL80_.jpg'),
(6, 1, 'Airpods Max', 'Los AirPods Max son alta fidelidad en estado puro, con una variedad de matices que te llevará al nirvana. Cada componente de su transductor a medida contribuye a crear un oasis de claridad y distorsión ultrabaja. Así no da ninguna pereza volver a escuchar esos grandes temazos.', 579.00, 2, NULL, NULL, '1740936983_apple_airpods_max_silver_front.png'),
(7, 1, 'IPad Pro', 'En su diseño fino y ligero al límite, el nuevo iPad Pro encierra una potencia descomunal. Ahora desafía la lógica con un modelo de 11 pulgadas superportátil y otro de 13 pulgadas, que no solo tiene una pantalla de mayor tamaño, sino que además es el producto más fino que ha creado Apple.', 1199.00, 5, NULL, NULL, '1740940535_81rxOSprYqL.jpg'),
(8, 2, 'Sofá 3 plazas', 'Este sofá 3 plazas de 210 cm te va a encantar. Su diseño moderno y elegante, y su comodidad, te darán grandes momentos de los que disfrutar. ', 919.20, 10, NULL, NULL, '1740940693_sofa-3-plazas-de-210-cm.jpg'),
(9, 2, 'Alfombra', 'Alfombra muy bonita', 20.45, 1, NULL, NULL, '1740940756_81+-Kfzi8gL.jpg'),
(10, 3, 'Jardinera', 'Jardineras 2 unidades acero corten plateado 32x30x29 cm Adecuado para jardines, terrazas y patios, duradero y decorativo, perfecto para tu espacio exterior.', 40.43, 6, NULL, NULL, '1740940925_a46431b5-1f34-4538-9111-cc76365bbb8a.webp'),
(11, 4, 'Gorra Nike', 'Combinado con tecnología absorbente de sudor para mantenerte fresco y seco, estás listo para hacer que el día funcione para ti.', 27.99, 12, NULL, NULL, '1740941097_00125258145405____2__1200x1200.avif'),
(12, 4, 'Chándal Adidas', 'Algunas prendas nunca pasan de moda. Este chándal adidas para peques con estilo reinventa una prenda icónica para una nueva generación.', 50.00, 2, NULL, NULL, '1740941267_Chandal_SST_Adicolor_Bebe_Azul_IY4026_01_laydown.avif'),
(13, 5, 'Colorete Rare Beauty', 'Un colorete líquido con una fórmula ligera y, duradera que se extiende y se fija perfectamente consiguiendo un rubor, sutil y saludable.', 27.99, 10, NULL, NULL, '1740941401_P10017094_principal.avif'),
(14, 5, 'Crema Solar Byoma', 'Protege tu piel de los dañinos rayos UV con la Crema Facial BYOMA SPF 30. Esta crema facial sin fragancia ofrece protección solar broad spectrum con un factor de protección solar (SPF) de 30.', 44.99, 23, NULL, NULL, '1740941507_31TzqXYoe1L.jpg'),
(15, 5, 'Corrector YSL', 'All Hours Precise Angles Concealer de Yves Saint Laurent es un corrector de cobertura modulable y acabado mate luminoso con un revolucionario aplicador multifunción para corregir, esculpir y resaltar tu rostro.', 31.50, 2, NULL, NULL, '1740941629_00113516721456____6__516x640.jpg'),
(16, 7, 'Uno', 'Juego del Uno', 15.00, 3, NULL, NULL, '1740941754_46516.18.jpg'),
(17, 8, 'Microondas Samsung', 'Interior cerámico de fácil limpieza\r\nGasto energético reducido con el modo ECO\r\nPotencia: 800W\r\nPantalla incorporada, Reloj integrado', 153.48, 44, NULL, NULL, '1740942022_81mP4fmvvLL._AC_SX679_.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`) VALUES
(1, 'Sara', 'Garzón', 'sara@garzon.com', '$2y$10$NWsQFe7AAYOCn6de3DjpeO3Y7FkBxcIqLUWAQHjvsnim9DEFKJyEW', 'user'),
(5, 'admin', 'admin', 'admin@admin.com', '$2y$10$8mHqtLwXgQ9kA3ziUF4uouY9QLwINFkA9kvcJqLYZPhTFSNxl4Lz.', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `lineas_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lineas_pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
