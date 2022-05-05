-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: dbservice
-- Tiempo de generación: 22-04-2022 a las 20:00:59
-- Versión del servidor: 5.7.35
-- Versión de PHP: 7.4.20


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
  `rol_nombre` varchar(50) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ds_roles_usuario`
--

INSERT INTO `ds_roles_usuario` (`id`, `usuario_id`, `roles_id`) VALUES
(1, 1, 1),
(4, 2, 2);

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
  `password` varchar(256) NOT NULL,
  `id_institucion` int(11) DEFAULT NULL COMMENT 'Llave foranea de la institucion a la que pretenece el usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ds_usuario`
--

INSERT INTO `ds_usuario` (`id`, `usuario`, `hash`, `activo`, `nombre`, `codigo`, `created_at`, `updated_at`, `cambio`, `modulo`, `password`, `id_institucion`) VALUES
(1, 'test', 'test', 1, 'test', NULL, '2022-03-17 10:25:02', '2022-03-17 10:28:54', 0, 1, '$2y$10$0ESeVGjuIof8l1.9m35LYuBc.9JEdQP9rM5A779dgd0hyOkyFLvGC', 1),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'Administrador DGII', NULL, '2022-04-20 11:31:46', '2022-04-20 11:31:46', 0, 1, '$2y$10$zYXI61OYdJH4neikm3Dx7uebQSbn9qBHoSMn98dumGCofo.Xdlq3G', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituciones`
--

CREATE TABLE `instituciones` (
  `id` int(11) NOT NULL COMMENT 'id de la tabla instituciones',
  `nombre_institucion` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL COMMENT 'Nombre de la intitucion',
  `abrebiatura` varchar(100) DEFAULT NULL COMMENT 'abrebiatura del monbre de la institucion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tabla que almacena el listado de las instituciones';

--
-- Volcado de datos para la tabla `instituciones`
--

INSERT INTO `instituciones` (`id`, `nombre_institucion`, `abrebiatura`) VALUES
(1, 'Ministerio de Medio Ambiente y Recursos Naturales', 'MARN'),
(2, 'Dirección Nacional de Medicamentos', 'DNM'),
(3, 'Ministerio de Salud', 'MINSAL'),
(4, 'Ministerio de Economía', 'MINEC'),
(5, 'Ministerio de Gobernación y Desarrollo Territorial', 'MIGOB'),
(6, 'Dirección General de Aduanas', 'DGA'),
(7, 'Corporación Salvadoreña de Turismo', 'CORSATUR'),
(8, 'Ministerio de Turismo', 'MITUR'),
(9, 'Ministerio de Obras Públicas y de Transporte', 'MOPT'),
(10, 'Dirección de Hidrocarburos y Minas', 'DGHM'),
(11, 'Administración Nacional de Acueductos y Alcantarillados', 'ANDA'),
(12, 'Ministerio de Agricultura y Ganadería', 'MAG'),
(13, 'Centro Nacional de Registros', 'CNR');

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
  ADD KEY `ds_usuarios_modulo_index` (`modulo`),
  ADD KEY `ds_usuario_id_institucion_IDX` (`id_institucion`) USING BTREE;

--
-- Indices de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adt_log`
--
ALTER TABLE `adt_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `ds_roles`
--
ALTER TABLE `ds_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ds_roles_usuario`
--
ALTER TABLE `ds_roles_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ds_usuario`
--
ALTER TABLE `ds_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la tabla instituciones', AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ds_roles_usuario`
--
ALTER TABLE `ds_roles_usuario`
  ADD CONSTRAINT `FK_ds_roles_usuario_ds_roles` FOREIGN KEY (`roles_id`) REFERENCES `ds_roles` (`id`),
  ADD CONSTRAINT `FK_ds_roles_usuario_ds_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `ds_usuario` (`id`);

--
-- Filtros para la tabla `ds_usuario`
--
ALTER TABLE `ds_usuario`
  ADD CONSTRAINT `ds_usuario_FK` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id`);