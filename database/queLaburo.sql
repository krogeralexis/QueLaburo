-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 20, 2025 at 12:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `queLaburo`
--

-- --------------------------------------------------------

--
-- Table structure for table `Administrador`
--

CREATE TABLE `Administrador` (
  `id_administrador` int(11) NOT NULL,
  `cantrep_resuelto` int(11) DEFAULT 0,
  `estado` varchar(50) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Cliente`
--

CREATE TABLE `Cliente` (
  `id_cliente` int(11) NOT NULL,
  `calificaciones` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Gestiona`
--

CREATE TABLE `Gestiona` (
  `id_usuario` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `fecha_gestion` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Mensaje`
--

CREATE TABLE `Mensaje` (
  `id_mensaje` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_emisor` int(11) DEFAULT NULL,
  `id_receptor` int(11) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Proveedor`
--

CREATE TABLE `Proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `referencias` text DEFAULT NULL,
  `cantidad_ventas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Reserva`
--

CREATE TABLE `Reserva` (
  `id_reserva` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `recordatorio` tinyint(1) DEFAULT 0,
  `reseña` text DEFAULT NULL,
  `fecha_reserva` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Servicio`
--

CREATE TABLE `Servicio` (
  `id_servicio` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `disponibilidad` tinyint(1) DEFAULT 1,
  `categoria` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Usuario`
--

CREATE TABLE `Usuario` (
  `id` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Usuario`
--

INSERT INTO `Usuario` (`id`, `fecha_creacion`, `nombre`, `correo`, `telefono`, `password`) VALUES
(1, '2025-09-14', 'aleli aleli', 'aleli@aleli.com', '1234', '$2y$10$Jfqh3Tm8/9pBKvuWNoKyOOTPI9kR.ClFfwmqmr8oKR0FMPT90btQO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Administrador`
--
ALTER TABLE `Administrador`
  ADD PRIMARY KEY (`id_administrador`);

--
-- Indexes for table `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `Gestiona`
--
ALTER TABLE `Gestiona`
  ADD PRIMARY KEY (`id_usuario`,`id_administrador`),
  ADD KEY `fk_gestiona_admin` (`id_administrador`);

--
-- Indexes for table `Mensaje`
--
ALTER TABLE `Mensaje`
  ADD PRIMARY KEY (`id_usuario`,`id_mensaje`);

--
-- Indexes for table `Proveedor`
--
ALTER TABLE `Proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indexes for table `Reserva`
--
ALTER TABLE `Reserva`
  ADD PRIMARY KEY (`id_reserva`,`id_cliente`,`id_proveedor`,`id_servicio`),
  ADD KEY `fk_reserva_cliente` (`id_cliente`),
  ADD KEY `fk_reserva_proveedor` (`id_proveedor`),
  ADD KEY `fk_reserva_servicio` (`id_servicio`);

--
-- Indexes for table `Servicio`
--
ALTER TABLE `Servicio`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `fk_servicio_proveedor` (`id_proveedor`);

--
-- Indexes for table `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `telefono` (`telefono`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Administrador`
--
ALTER TABLE `Administrador`
  ADD CONSTRAINT `fk_admin_usuario` FOREIGN KEY (`id_administrador`) REFERENCES `Usuario` (`id`);

--
-- Constraints for table `Cliente`
--
ALTER TABLE `Cliente`
  ADD CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`id_cliente`) REFERENCES `Usuario` (`id`);

--
-- Constraints for table `Gestiona`
--
ALTER TABLE `Gestiona`
  ADD CONSTRAINT `fk_gestiona_admin` FOREIGN KEY (`id_administrador`) REFERENCES `Administrador` (`id_administrador`),
  ADD CONSTRAINT `fk_gestiona_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id`);

--
-- Constraints for table `Mensaje`
--
ALTER TABLE `Mensaje`
  ADD CONSTRAINT `fk_mensaje_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id`);

--
-- Constraints for table `Proveedor`
--
ALTER TABLE `Proveedor`
  ADD CONSTRAINT `fk_proveedor_usuario` FOREIGN KEY (`id_proveedor`) REFERENCES `Usuario` (`id`);

--
-- Constraints for table `Reserva`
--
ALTER TABLE `Reserva`
  ADD CONSTRAINT `fk_reserva_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `Cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_reserva_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `Proveedor` (`id_proveedor`),
  ADD CONSTRAINT `fk_reserva_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `Servicio` (`id_servicio`);

--
-- Constraints for table `Servicio`
--
ALTER TABLE `Servicio`
  ADD CONSTRAINT `fk_servicio_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `Proveedor` (`id_proveedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
