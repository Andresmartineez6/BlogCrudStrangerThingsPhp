-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2025 a las 08:02:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `stranger_things_blog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Stranger Things', 'Noticias, teorías y curiosidades sobre la serie Stranger Things'),
(2, 'Temporadas', 'Análisis, resúmenes y curiosidades por temporada'),
(3, 'Personajes', 'Biografías, evolución y momentos clave de cada personaje'),
(4, 'Merchandising', 'Ropa, figuras y productos oficiales'),
(5, 'Tráilers y Avances', 'Portadas, teorías y análisis de tráilers'),
(6, 'Diseño y Logotipos', 'Elementos visuales de la serie');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `autor` varchar(100) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `creado_en` datetime DEFAULT current_timestamp(),
  `actualizado_en` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id`, `titulo`, `contenido`, `imagen`, `autor`, `categoria_id`, `creado_en`, `actualizado_en`) VALUES
(22, 'Todos los personajes clave de Stranger Things', 'Analizamos la evolución de los personajes principales desde la primera temporada hasta hoy. ¿Quién cambió más? ¿Quién sigue siendo el alma del grupo? Este recorrido por los protagonistas —Eleven, Mike, Dustin, Lucas, Will, Max y Hopper— revela los giros de cada uno y cómo el trauma, el amor y la amistad los han definido.', 'imagen_personajes.jpg', 'Nancy la Reportera', 3, '2025-06-05 07:03:38', '2025-06-05 07:03:38'),
(23, 'Logo original de Stranger Things: un ícono de los 80 reinventado', 'El logo de Stranger Things no es solo una tipografía bonita. Está inspirado en los libros de Stephen King y el diseño retro de películas como \"The Thing\". En este artículo exploramos cómo fue creado, su evolución y por qué sigue siendo uno de los logos más reconocibles de la televisión actual.', 'logo.png', 'Steve el Editor', 6, '2025-06-05 07:03:38', '2025-06-05 07:03:38'),
(24, 'Figuras, camisetas y más: lo mejor del merchandising oficial', 'Stranger Things ha generado una línea brutal de merchandising que incluye desde camisetas retro hasta figuras Funko Pop, pasando por patinetes, sudaderas y ediciones especiales de videojuegos. Aquí te mostramos los más vendidos, ediciones limitadas y dónde comprarlos online.', 'merchandising.jpeg', 'MerchaLover', 4, '2025-06-05 07:03:38', '2025-06-05 07:03:38'),
(25, 'Análisis del tráiler final de la temporada 5', 'El tráiler de la temporada 5 es simplemente brutal: un ambiente más oscuro, el regreso de viejos personajes y pistas clave que podrían cambiarlo todo. Exploramos escena por escena y teorizamos sobre la posible muerte de un personaje importante y el cierre del portal.', 'portada_trailer_stranger_things.jpg', 'Dustin Teórico', 5, '2025-06-05 07:03:38', '2025-06-05 07:03:38'),
(26, 'Stranger Things: el fenómeno cultural', 'No es solo una serie: Stranger Things cambió la televisión. Hablamos de su impacto en redes, en la moda, en la música (¡hola, Kate Bush!) y en toda una generación de jóvenes que crecieron viendo cómo la nostalgia de los 80 se mezclaba con monstruos, amistad y ciencia ficción.', 'stranger_things.jpg', 'Eleven Admin', 1, '2025-06-05 07:03:38', '2025-06-05 07:03:38'),
(27, 'El poder del logo: diseño y cultura pop', '¿Por qué todos reconocen el logo de Stranger Things? Su tipografía, su simetría y su carga visual nos remiten al terror clásico con un giro moderno. Este análisis visual revela cómo un simple diseño puede convertirse en símbolo de una era.', 'Stranger_Things_Logo_UBX.jpg', 'Will el Cronista', 6, '2025-06-05 07:03:38', '2025-06-05 07:03:38'),
(28, 'Stranger Things en 4K: ¿vale la pena verlo así?', 'La experiencia de ver Stranger Things en 4K es completamente diferente: los efectos visuales, las luces del Mundo del Revés, la textura de los escenarios cobran vida como nunca. Te contamos por qué deberías hacer el rewatch en la mejor calidad posible.', 'stranger-things-4k-d22h0coz6j6ph0e7.jpg', 'Lucas el Estratega', 1, '2025-06-05 07:03:38', '2025-06-05 07:29:35'),
(29, 'Resumen completo de la temporada 2', 'La temporada 2 expandió el universo de Hawkins con nuevos personajes, amenazas del Mundo del Revés y una evolución clave en el grupo original. Repasamos todos los episodios, analizamos a Kali y el nuevo monstruo que dio miedo de verdad: el Azotamentes.', 'temporada_2_stranger_things.jpg', 'Max la Skater', 2, '2025-06-05 07:03:38', '2025-06-05 07:03:38'),
(30, 'Qué sabemos hasta ahora de la temporada 5', 'El final está cerca. La temporada 5 promete cerrar la historia de una forma épica. Eleven ha recuperado parte de sus poderes, Will siente que algo va mal, y Vecna sigue vivo. Recogemos teorías, rumores y confirmaciones oficiales.', 'temporada_5_stranger_things.jpg', 'Hopper Jefe', 2, '2025-06-05 07:03:38', '2025-06-05 07:03:38'),
(31, 'Tienda oficial Stranger Things: qué comprar y qué evitar', 'Desde mochilas con luces LED hasta libros de la historia secreta de Hawkins, el catálogo oficial está lleno de cosas útiles y muchas... no tanto. Aquí va una guía completa con recomendaciones, precios y rarezas.', 'tienda_stranger_things.jpg', 'MerchaLover', 4, '2025-06-05 07:03:38', '2025-06-05 07:03:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','editor') DEFAULT 'admin',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `creado_en`) VALUES
(10, 'Administrador', 'admin@blog.com', '1234', 'admin', '2025-06-05 05:03:44'),
(11, 'Eleven Admin', 'eleven@hawkinsblog.com', '1234', 'admin', '2025-06-05 05:03:44'),
(12, 'Hopper Jefe', 'hopper@hawkinspd.com', '1234', 'admin', '2025-06-05 05:03:44'),
(13, 'Nancy la Reportera', 'nancy@hawkinspost.com', '1234', 'editor', '2025-06-05 05:03:44'),
(14, 'Steve el Editor', 'steve@scoopsahoy.com', '1234', 'editor', '2025-06-05 05:03:44'),
(15, 'Dustin Teórico', 'dustin@curiosidades.com', '1234', 'editor', '2025-06-05 05:03:44'),
(16, 'Lucas el Estratega', 'lucas@arcadeclan.com', '1234', 'editor', '2025-06-05 05:03:44'),
(17, 'Will el Cronista', 'will@shadowrealm.org', '1234', 'editor', '2025-06-05 05:03:44'),
(18, 'Max la Skater', 'max@rollergirls.net', '1234', 'editor', '2025-06-05 05:03:44'),
(19, 'MerchaLover', 'merch@hawkinsfans.com', '1234', 'editor', '2025-06-05 05:03:44'),
(20, 'fran morales', 'franmorales@eag.com', '$2y$10$Xt.Q4Xqhik6iTy/gTkN/KObHS3MrQHyfCtMm6V7z9cUdThXwA4bwC', 'editor', '2025-06-05 05:58:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
