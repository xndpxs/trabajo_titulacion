-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Dec 21, 2023 at 02:04 AM
-- Server version: 11.2.2-MariaDB-1:11.2.2+maria~ubu2204
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gymes`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrador`
--

CREATE TABLE `administrador` (
  `id_administrador` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrador`
--

INSERT INTO `administrador` (`id_administrador`, `id_persona`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `alimentacion`
--

CREATE TABLE `alimentacion` (
  `id_alimentacion` int(11) NOT NULL,
  `id_sesion` int(11) NOT NULL,
  `desayuno` varchar(250) DEFAULT NULL,
  `almuerzo` varchar(250) DEFAULT NULL,
  `merienda` varchar(250) DEFAULT NULL,
  `extra` varchar(250) DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `recomendada` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alimentacion`
--

INSERT INTO `alimentacion` (`id_alimentacion`, `id_sesion`, `desayuno`, `almuerzo`, `merienda`, `extra`, `observaciones`, `recomendada`) VALUES
(1, 1, 'Korn Flakes', 'Cuarto de Pollo', 'Pizza', '2 litros de agua', 'Esta muy flaco', NULL),
(2, 11, 'fruta', 'carbohidratos y prote[ina', 'fruta', 'fruta', 'controlar cantidades', 'sugherencia en pr[oixima cita'),
(3, 9, 'Leche', 'Pollo', 'Pescado', NULL, NULL, 'NO comer en exceso'),
(4, 20, 'Fruta', 'Sopa', 'Pan', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asignacion`
--

CREATE TABLE `asignacion` (
  `id_asignacion` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asignacion`
--

INSERT INTO `asignacion` (`id_asignacion`, `id_doctor`, `id_paciente`) VALUES
(1, 2, 2),
(3, 2, 47),
(4, 3, 9),
(5, 2, 29),
(6, 2, 32),
(7, 2, 47),
(8, 2, 9),
(9, 2, 9),
(10, 2, 9),
(11, 2, 9),
(12, 2, 47),
(13, 21, 2),
(14, 21, 2),
(15, 21, 40),
(16, 2, 2),
(17, 2, 2),
(18, 2, 2),
(19, 2, 2),
(20, 2, 2),
(21, 2, 46),
(22, 2, 46),
(23, 21, 46),
(24, 3, 46),
(25, 3, 2),
(26, 3, 49),
(27, 3, 49);

-- --------------------------------------------------------

--
-- Table structure for table `datos_medicos`
--

CREATE TABLE `datos_medicos` (
  `id_datos_medicos` int(11) NOT NULL,
  `id_sesion` int(11) NOT NULL,
  `talla` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `ta` float DEFAULT NULL,
  `pulso` float DEFAULT NULL,
  `fr` float DEFAULT NULL,
  `medicamentos` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `datos_medicos`
--

INSERT INTO `datos_medicos` (`id_datos_medicos`, `id_sesion`, `talla`, `peso`, `ta`, `pulso`, `fr`, `medicamentos`) VALUES
(1, 1, 0.65, 20, 100, 100, 30, 'Antiparasitario'),
(2, 2, 1.85, 82, 100, 80, 25, 'Ibuprofeno'),
(4, 3, 1.75, 9, 120, 100, 35, 'Levetiracetam'),
(6, 4, 1.9, 90, 120, 100, 30, 'Acetaminofen'),
(8, 11, 1.65, 54, 120, 90, 90, 'quepapina'),
(9, 10, NULL, 53, NULL, NULL, NULL, NULL),
(10, 9, 1.75, 70, 120, 80, 30, 'Ibuprofeno'),
(11, 18, NULL, 23, NULL, NULL, NULL, NULL),
(12, 23, 183, 80, 120, 30, 100, 'Enalapril'),
(13, 25, 185, 80, NULL, 200, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id_doctor` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id_doctor`, `id_persona`) VALUES
(1, 2),
(2, 15),
(3, 17),
(14, 30),
(16, 32),
(17, 33),
(18, 34),
(19, 35),
(20, 36),
(21, 37),
(22, 38),
(23, 39),
(27, 43),
(28, 44),
(29, 45),
(36, 69),
(38, 93);

-- --------------------------------------------------------

--
-- Table structure for table `enfermedad`
--

CREATE TABLE `enfermedad` (
  `id_enfermedad` int(11) NOT NULL,
  `id_sesion` int(11) NOT NULL,
  `tipo` varchar(250) DEFAULT NULL,
  `detalle` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enfermedad`
--

INSERT INTO `enfermedad` (`id_enfermedad`, `id_sesion`, `tipo`, `detalle`) VALUES
(1, 1, 'Pierna Fracturada', NULL),
(2, 11, 'luxacion', 'luxacion miembro inferior'),
(3, 9, 'Fractura de muñeca', NULL),
(4, 14, 'Fractura', 'Pierna'),
(5, 20, 'Fractura', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medidas`
--

CREATE TABLE `medidas` (
  `id_medidas` int(11) NOT NULL,
  `id_sesion` int(11) NOT NULL,
  `torax` float DEFAULT NULL,
  `axilas` float DEFAULT NULL,
  `busto` float DEFAULT NULL,
  `brazo_der` float DEFAULT NULL,
  `brazo_izq` float DEFAULT NULL,
  `abd_alto` float DEFAULT NULL,
  `abd_bajo` float DEFAULT NULL,
  `cintura` float DEFAULT NULL,
  `cadera` float DEFAULT NULL,
  `gluteos` float DEFAULT NULL,
  `muslo_der` float DEFAULT NULL,
  `muslo_izq` float DEFAULT NULL,
  `rodilla_der` float DEFAULT NULL,
  `rodilla_izq` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medidas`
--

INSERT INTO `medidas` (`id_medidas`, `id_sesion`, `torax`, `axilas`, `busto`, `brazo_der`, `brazo_izq`, `abd_alto`, `abd_bajo`, `cintura`, `cadera`, `gluteos`, `muslo_der`, `muslo_izq`, `rodilla_der`, `rodilla_izq`) VALUES
(1, 1, 40, 20, 50, 10, 10, 60, 70, 40, 60, 30, 24, 25, 10, 10),
(2, 9, 1, 0.2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 20, NULL, NULL, NULL, 10, NULL, NULL, NULL, 80, NULL, NULL, 30, NULL, NULL, NULL),
(4, 11, 50, 20, 40, 20, 21, 60, 80, 60, 70, 70, 40, 40, 20, 20),
(5, 23, NULL, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `ocupacion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `id_persona`, `fecha_nacimiento`, `ocupacion`) VALUES
(1, 3, '1991-11-11', 'Estudiante'),
(2, 7, '2021-12-12', 'Seguridad'),
(9, 14, NULL, NULL),
(10, 18, NULL, NULL),
(11, 21, '2001-11-04', 'Estudiante'),
(29, 70, '2001-12-11', 'Musico'),
(32, 73, '2001-12-12', 'FABRICANTE DE ARMAS'),
(40, 83, '2003-12-12', 'Beisbol'),
(46, 90, '1980-12-12', 'Estadista'),
(47, 91, '2001-12-12', 'Estudiante'),
(48, 92, '1999-12-11', 'Empleado publico'),
(49, 95, '2012-01-12', 'Estudiante');

-- --------------------------------------------------------

--
-- Table structure for table `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(250) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(200) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(200) NOT NULL,
  `rol` enum('paciente','administrador','doctor','') NOT NULL,
  `estado_login` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personas`
--

INSERT INTO `personas` (`id_persona`, `nombre`, `apellido`, `direccion`, `telefono`, `cedula`, `email`, `fecha_creacion`, `password`, `rol`, `estado_login`) VALUES
(1, 'Andres', 'Administrador', 'Versalles', '999999999', '123456789', 'admin@gymes.com', '2023-06-09 00:08:40', '$2y$10$T2XdZYme7JowKRY/EuVvl.kpTwlwPKZ651LC8qALBs0V19HQFrjdq', 'administrador', 1),
(2, 'Luis', 'Suarez', 'Uruguay', '2342342342', '8768674564', 'lucho@gymes.com', '2023-06-23 21:05:19', '$2y$10$VhyK7DauuXwqqt9zMMWIfuttkfCmSxj6d0ObMqEvq6sAhdFFq5oIW', 'doctor', 0),
(3, 'paciente', 'primero', 'UIO', '23492349239', '23942394329', 'paciente@gymes.com', '2023-06-23 21:17:51', '$2y$10$nzY5QuM32LCwoj7jYFp4V.fBAN0msBj1lJkbM8VP6UliXKpitGgau', 'paciente', 0),
(7, 'milo', 'pasquel', 'versalles y portoviejo', '12345', '1111', 'milo@gymes.com', '2023-06-30 22:08:06', '$2y$10$kNNvU0t2nPDYmEKDzrwpP.2ed96M/qzFXSXQHzpZ0JJdyiX5o39pu', 'paciente', 1),
(8, 'pedro', ' rosales', 'versalles', '123456', '1111112222', 'pedro@gymes.com', '2023-07-17 17:34:08', '$2y$10$ok5Ansc/K8dtT/VJAPQqLeFkOiXuURs6vgfm9o2Px3AxV.e5nHsKi', 'paciente', 0),
(14, 'luis', 'perez', 'versalles', '3453453453', '6789765456', 'luis@gymes.com', '2023-07-18 23:05:25', '$2y$10$YVsfVFUxPXJdezciFcacK.pKBB1ObZzR4CNz.59XUu.bxvc4M1D46', 'paciente', 0),
(15, 'Gregory', 'House', 'Century City', '23942394239', '23842384238', 'house@gymes.com', '2023-07-25 20:47:37', '$2y$10$FQZGIzHqM3GOHa2FggTiU.Kkptt5EEZr8112wjMQO83N06e9aLRsi', 'doctor', 1),
(17, 'Jessica', 'Pinata', 'versalles', '345345345', '9787897897', 'pina@gymes.com', '2023-07-26 01:41:47', '$2y$10$8OdyBMzPziu0Ls6yUKRYz.rw.N27yqEVCGKxHqg8IqEb0FJtj1xje', 'doctor', 0),
(18, 'Enrique', 'Alvarez', 'Portoviejo', '456456456', '3245456456', 'kike@gymes.com', '2023-07-27 20:14:56', '$2y$10$DQH/jtUmGvlpq4cjR6CnNeYFqdkDfEqcPfdGqlmQchXiUY1fv2LAS', 'paciente', 1),
(21, 'gabriel', 'fernandez', 'Real audiencia', '3424234', '4536456456', 'gabo@gymes.com', '2023-07-31 17:40:27', '$2y$10$Vccgzdz432Gm5gRQG7/2AeFg9du2FeT.34mHOhnguOpn8gspLkOEO', 'paciente', 1),
(30, 'Punzadas', 'De Magia', 'Real Audiencia', '3939394', '483838383', 'punzon@gymes.com', '2023-08-01 00:07:44', '2222', 'doctor', 0),
(32, 'Gonzalo', 'Plata', 'Qatar', '32423423432', '456456456', 'plata@gymes.com', '2023-08-02 04:54:40', '$2y$10$S5xTCALgIjFoma1uOUukdOEj1rehMnEaVqjz49brM/oHway.mXf5i', 'doctor', 0),
(33, 'Jeremy', 'Sarmiento', 'Inglaterra', '3423424', '789789789', 'jere@gymes.com', '2023-08-02 04:55:27', '$2y$10$xwQ0MQdBG5kzJ1FaMc9RCORc8V1r.x4ZHvIKOZjIb.lT1NLUs7TBS', 'doctor', 0),
(34, 'Dida', 'Dominguez', 'Quito', '023402402304', '9123912391', 'dida@gymes.com', '2023-08-02 04:56:03', '$2y$10$DIh69p6nneUQNH9O4hoP2et4l3YwZb7alCXvT9f5LP/r2Ac4dnxoe', 'doctor', 0),
(35, 'Patricio', 'Urrutia', 'Riobamba', '213423423423', '349349349493', 'pato@gymes.com', '2023-08-03 04:46:26', '$2y$10$O7ORvl9/LpgmtXkJqQ6jYuD/MIvj92K8snO5bspDzx0zBBU071g4K', 'doctor', 0),
(36, 'Lautaro', 'Martinez', 'Italia', '34234234', '5665756756567', 'toro@gymes.com', '2023-08-03 04:47:02', '$2y$10$lLpX8T0jt6u9LBm/19BjSOm4U/kumlVGkTEpSo0E5BY/1bqavNvF6', 'doctor', 0),
(37, 'Erling', 'Haaland', 'Inglaterra', '34534534534', '341231235345345', 'majinbu@gymes.com', '2023-08-03 04:47:39', '$2y$10$H0SY/lG7FITYzP4v8hmkceQYWVEMX3qzWQMF.IHaue.65Y90NMUGa', 'doctor', 0),
(38, 'antonio', 'valencia', 'GYE', '2398423984', '293482394', 'tony@gymes.com', '2023-08-11 17:15:59', '$2y$10$gj7Vn.HQDct23oDX//Zw..2ncb0Fo8YFEYRIv9rA/jn55OJk0KtDe', 'doctor', 0),
(39, 'luis', 'cardenas', 'quito', '23942394', '2392349', 'lucho@gymes.com', '2023-08-11 22:08:59', '$2y$10$PFiJL7.awaxOY6BlQnL8e./zY/rMOEX2xswJU6I6M0gIsc5qsvPbq', 'doctor', 0),
(43, 'paolo', 'guerrero', 'Quito', '2394239429', '12319239', 'paolo@gymes.com', '2023-08-12 00:12:19', '$2y$10$MyIjugaJRdPalGUjIs2hNO49svJCsndbqsmyJaSGCoo/pZu.xhOty', 'doctor', 0),
(44, 'Edison', 'Mendez', 'Quito', '234923490239', '23042304230', 'mendez@gymes.com', '2023-08-12 00:12:38', '$2y$10$hBratBYhnegRaCTCnJqs2.2vhwxLejCZ72mq3jB9e1YECsSsdNAs2', 'doctor', 0),
(45, 'Anderson', 'Julio', 'Quito', '43593459349', '765875675', 'ajulio@gymes.com', '2023-08-12 01:02:55', '$2y$10$WznlvXldV.sowL.jOXj92uHU30No94r6v6c8vADfV/IyJTSKd5x6O', 'doctor', 0),
(69, 'Alberto', 'Plaza', 'Arg', '213492349', '394239429', 'voyoyaf802@vikinoko.com', '2023-08-23 17:36:27', '$2y$10$lh/wSqZUz/ehidV2lWuDWejEqWD.i4Z3RP.NzFSOgrCUpfNVbW.pC', 'doctor', 0),
(70, 'juan', 'plaza', 'UIO', '239429349', '234923942', 'milmasadru@gufum.com', '2023-08-23 17:39:22', '$2y$10$h14ASlYpQ2XUB7bAFwVt8.ACoyjsjKAGyrdz7ORBqUppDFE6ipi7y', 'paciente', 0),
(73, 'Temla', 'Faydi', 'AFGHANISTAN', '23494395349', '234593495439', 'temlafaydi@gufum.com', '2023-08-23 23:04:57', '$2y$10$jAhfNyLdVQBer0BGHGS41eiKYL6XepP/X1d1Ub4pyOpr2Wo2BUHae', 'paciente', 1),
(83, 'Bep ', 'Statista', 'ARGENTINA', '012301230120', '0102301230120', 'bepsatista@gufum.com', '2023-08-25 03:04:50', '$2y$10$RWrtGMmx3NsXk0/byqhmsOdWd9lHzOz06lM/aBAFV/RWvcJDUoWZG', 'paciente', 1),
(90, 'lume', 'hoqe', 'POLAND', '01203120310', '012301203', 'lumehoqe@tutuapp.bid', '2023-08-25 03:54:26', '$2y$10$CbLOJo5H8I/xooNRxJErju5V8KBxdAu0e/pP8N6TRP1ByUEs0aMu6', 'paciente', 1),
(91, 'Pedro', 'Pereira', 'Quito', '0432402340', '923492394293', 'zikkihikka@gufum.com', '2023-08-28 17:47:45', '$2y$10$u.7dsprI7Mz72LQrXhsCre0ROEvrDUXQwsMrz5hfvm5YPXqMY6yIi', 'paciente', 1),
(92, 'xal', 'aba', 'Cuenca', '2340230230', '23942394239', 'xalaba2268@gearstag.com', '2023-12-07 05:45:05', '$2y$10$.mlsrigRdP7PQlPtORQHk.dHvSRVuImU8BEHzIpgCdUvwxIlrupz.', 'paciente', 1),
(93, 'Luis', 'Sanchez', 'Quito', '2304230423042', '34598349593459', 'lsan@gymes.com', '2023-12-11 15:22:27', '$2y$10$5IT.4uOfn2n4tPEXWTThNecjh83VhdI0YysI4NGxxx01nGyxBYQ1a', 'doctor', 0),
(95, 'Pedro', 'Castro', 'Quito', '2334023402', '1234567', 'dumlomegnu@gufum.com', '2023-12-20 16:59:30', '$2y$10$61NosXivXFhSiJ4NrtQVJ.x6v2hjckYIyAduQ6rhR6CgwNLHMdSzi', 'paciente', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sesion`
--

CREATE TABLE `sesion` (
  `id_sesion` int(11) NOT NULL,
  `id_asignacion` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tiempo` time NOT NULL,
  `lugar` varchar(250) NOT NULL DEFAULT 'Conocoto',
  `notas` varchar(255) DEFAULT NULL,
  `estado` enum('cancelado','pasado','activo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sesion`
--

INSERT INTO `sesion` (`id_sesion`, `id_asignacion`, `fecha`, `tiempo`, `lugar`, `notas`, `estado`) VALUES
(1, 1, '2023-12-29', '08:00:00', 'Conocoto', 'Un perro husky le mordio el ojo', 'cancelado'),
(2, 3, '2023-11-11', '11:00:00', 'Conocoto', 'Se fracturo el tobillo', 'pasado'),
(3, 4, '2023-10-30', '10:00:00', 'Conocoto', 'Desgarro muscular', 'pasado'),
(4, 5, '2023-12-12', '10:00:00', 'Conocoto', '', 'pasado'),
(9, 10, '2023-12-29', '09:00:00', 'Conocoto', '', 'activo'),
(10, 11, '2023-11-11', '13:00:00', 'Conocoto', '', 'pasado'),
(11, 12, '2024-05-17', '15:00:00', 'Conocoto', 'puntual', 'activo'),
(14, 15, '2023-12-29', '15:00:00', 'Conocoto', 'Fractura pierna', 'cancelado'),
(18, 19, '2024-01-10', '08:00:00', 'Conocoto', '', 'cancelado'),
(20, 21, '2024-01-24', '13:00:00', 'Conocoto', 'Puntual', 'activo'),
(21, 22, '2024-01-17', '13:00:00', 'Conocoto', '', 'activo'),
(22, 23, '2023-12-29', '08:00:00', 'Conocoto', 'Temporada 1', 'cancelado'),
(23, 24, '2024-02-14', '14:00:00', 'Conocoto', 'Lesion triceps', 'activo'),
(24, 25, '2023-12-29', '08:00:00', 'Conocoto', 'Cadera lesionada', 'activo'),
(25, 26, '2024-02-15', '08:00:00', 'Conocoto', 'Idem', 'cancelado'),
(26, 27, '2023-12-28', '08:00:00', 'Conocoto', '', 'activo');

-- --------------------------------------------------------

--
-- Table structure for table `tratamiento`
--

CREATE TABLE `tratamiento` (
  `id_tratamiento` int(11) NOT NULL,
  `id_sesion` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `area` varchar(250) DEFAULT NULL,
  `observacion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tratamiento`
--

INSERT INTO `tratamiento` (`id_tratamiento`, `id_sesion`, `nombre`, `area`, `observacion`) VALUES
(1, 1, 'Masaje', 'Gemelos', NULL),
(2, 11, 'luxacion', 'miembro inferior', NULL),
(3, 9, NULL, 'muñeca', NULL),
(4, 14, 'Masaje', 'Tobillo', NULL),
(5, 20, 'Pierna', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_administrador`),
  ADD KEY `fk_personas_id` (`id_persona`);

--
-- Indexes for table `alimentacion`
--
ALTER TABLE `alimentacion`
  ADD PRIMARY KEY (`id_alimentacion`),
  ADD UNIQUE KEY `id_sesion` (`id_sesion`),
  ADD KEY `fk_alimentacion_sesion` (`id_sesion`);

--
-- Indexes for table `asignacion`
--
ALTER TABLE `asignacion`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `fk_doctor_asignacion` (`id_doctor`),
  ADD KEY `fk_paciente_asignacion` (`id_paciente`);

--
-- Indexes for table `datos_medicos`
--
ALTER TABLE `datos_medicos`
  ADD PRIMARY KEY (`id_datos_medicos`),
  ADD UNIQUE KEY `id_sesion` (`id_sesion`),
  ADD KEY `fk_datos_sesion` (`id_sesion`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id_doctor`),
  ADD KEY `fk_doctor_personas` (`id_persona`);

--
-- Indexes for table `enfermedad`
--
ALTER TABLE `enfermedad`
  ADD PRIMARY KEY (`id_enfermedad`),
  ADD UNIQUE KEY `id_sesion` (`id_sesion`),
  ADD KEY `fk_enfermedad_sesion` (`id_sesion`);

--
-- Indexes for table `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`id_medidas`),
  ADD UNIQUE KEY `id_sesion` (`id_sesion`),
  ADD KEY `fk_medidas_sesion` (`id_sesion`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`),
  ADD KEY `fk_paciente_persona` (`id_persona`);

--
-- Indexes for table `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indexes for table `sesion`
--
ALTER TABLE `sesion`
  ADD PRIMARY KEY (`id_sesion`),
  ADD KEY `fk_sesion_asignacion` (`id_asignacion`);

--
-- Indexes for table `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD PRIMARY KEY (`id_tratamiento`),
  ADD UNIQUE KEY `id_sesion` (`id_sesion`),
  ADD KEY `fk_tratamiento_sesion` (`id_sesion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `alimentacion`
--
ALTER TABLE `alimentacion`
  MODIFY `id_alimentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `asignacion`
--
ALTER TABLE `asignacion`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `datos_medicos`
--
ALTER TABLE `datos_medicos`
  MODIFY `id_datos_medicos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id_doctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `enfermedad`
--
ALTER TABLE `enfermedad`
  MODIFY `id_enfermedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id_medidas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `sesion`
--
ALTER TABLE `sesion`
  MODIFY `id_sesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tratamiento`
--
ALTER TABLE `tratamiento`
  MODIFY `id_tratamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `fk_personas_id` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Constraints for table `alimentacion`
--
ALTER TABLE `alimentacion`
  ADD CONSTRAINT `fk_alimentacion_sesion` FOREIGN KEY (`id_sesion`) REFERENCES `sesion` (`id_sesion`) ON DELETE CASCADE;

--
-- Constraints for table `asignacion`
--
ALTER TABLE `asignacion`
  ADD CONSTRAINT `fk_doctor_asignacion` FOREIGN KEY (`id_doctor`) REFERENCES `doctor` (`id_doctor`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_paciente_asignacion` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE CASCADE;

--
-- Constraints for table `datos_medicos`
--
ALTER TABLE `datos_medicos`
  ADD CONSTRAINT `fk_datos_sesion` FOREIGN KEY (`id_sesion`) REFERENCES `sesion` (`id_sesion`) ON DELETE CASCADE;

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `fk_doctor_personas` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Constraints for table `enfermedad`
--
ALTER TABLE `enfermedad`
  ADD CONSTRAINT `fk_enfermedad_sesion` FOREIGN KEY (`id_sesion`) REFERENCES `sesion` (`id_sesion`) ON DELETE CASCADE;

--
-- Constraints for table `medidas`
--
ALTER TABLE `medidas`
  ADD CONSTRAINT `fk_medidas_sesion` FOREIGN KEY (`id_sesion`) REFERENCES `sesion` (`id_sesion`) ON DELETE CASCADE;

--
-- Constraints for table `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `fk_paciente_persona` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Constraints for table `sesion`
--
ALTER TABLE `sesion`
  ADD CONSTRAINT `fk_sesion_asignacion` FOREIGN KEY (`id_asignacion`) REFERENCES `asignacion` (`id_asignacion`) ON DELETE CASCADE;

--
-- Constraints for table `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD CONSTRAINT `fk_tratamiento_sesion` FOREIGN KEY (`id_sesion`) REFERENCES `sesion` (`id_sesion`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`%` EVENT `actualizar_estados_sesion` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-12-12 14:39:50' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Actualizar sesiones pasadas
    UPDATE sesion
    SET estado = 'pasado'
    WHERE (fecha < CURRENT_DATE() OR (fecha = CURRENT_DATE() AND tiempo < CURRENT_TIME()))
    AND estado != 'cancelado';

    -- Actualizar sesiones activas
    UPDATE sesion
    SET estado = 'activo'
    WHERE (fecha >= CURRENT_DATE() OR (fecha = CURRENT_DATE() AND tiempo >= CURRENT_TIME()))
    AND estado != 'cancelado';
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
