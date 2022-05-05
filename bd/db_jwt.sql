-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: dbservice
-- Tiempo de generación: 21-03-2022 a las 20:35:02
-- Versión del servidor: 5.7.35
-- Versión de PHP: 7.4.20


--
-- Base de datos: `bd_jwt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adt_log`
--

CREATE TABLE `adt_log` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `nivel_nombre` varchar(50) DEFAULT NULL,
  `nivel` int(11) NOT NULL,
  `mensaje` text,
  `referencia` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `remote_ip` char(15) NOT NULL,
  `datos` text NOT NULL,
  `agente` varchar(255) DEFAULT NULL,
  `contexto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `huella` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ds_roles`
--

CREATE TABLE `ds_roles` (
  `id` int(11) NOT NULL,
  `rol_nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ds_roles`
--

INSERT INTO `ds_roles` (`id`, `rol_nombre`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_USER'),
(3, 'ROLE_SUPERVISOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ds_roles_usuario`
--

CREATE TABLE `ds_roles_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ds_roles_usuario`
--

INSERT INTO `ds_roles_usuario` (`id`, `usuario_id`, `roles_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ds_usuario`
--

CREATE TABLE `ds_usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `hash` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET latin1 DEFAULT '100',
  `codigo` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `cambio` tinyint(1) DEFAULT '0',
  `modulo` int(11) NOT NULL DEFAULT '1',
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ds_usuario`
--

INSERT INTO `ds_usuario` (`id`, `usuario`, `hash`, `activo`, `nombre`, `codigo`, `created_at`, `updated_at`, `cambio`, `modulo`, `password`) VALUES
(1, 'test', 'test', 1, 'test', NULL, '2022-03-17 10:25:02', '2022-03-17 10:28:54', 0, 1, '$2y$10$0ESeVGjuIof8l1.9m35LYuBc.9JEdQP9rM5A779dgd0hyOkyFLvGC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adt_log`
--
ALTER TABLE `adt_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `nivel` (`nivel`),
  ADD KEY `nivel_nombre` (`nivel_nombre`),
  ADD KEY `huella` (`huella`),
  ADD KEY `remote_ip` (`remote_ip`);

--
-- Indices de la tabla `ds_roles`
--
ALTER TABLE `ds_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ds_roles_usuario`
--
ALTER TABLE `ds_roles_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario` (`usuario_id`),
  ADD KEY `idx_rol` (`roles_id`);

--
-- Indices de la tabla `ds_usuario`
--
ALTER TABLE `ds_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_UN` (`usuario`),
  ADD KEY `activo` (`activo`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `updated_at` (`updated_at`),
  ADD KEY `cambio` (`cambio`),
  ADD KEY `hash` (`hash`),
  ADD KEY `ds_usuarios_modulo_index` (`modulo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adt_log`
--
ALTER TABLE `adt_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ds_roles`
--
ALTER TABLE `ds_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ds_roles_usuario`
--
ALTER TABLE `ds_roles_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ds_usuario`
--
ALTER TABLE `ds_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ds_roles_usuario`
--
ALTER TABLE `ds_roles_usuario`
  ADD CONSTRAINT `FK_ds_roles_usuario_ds_roles` FOREIGN KEY (`roles_id`) REFERENCES `ds_roles` (`id`),
  ADD CONSTRAINT `FK_ds_roles_usuario_ds_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `ds_usuario` (`id`);

