-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 01, 2025 at 09:28 PM
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
  `especialidad` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Cliente`
--

CREATE TABLE `Cliente` (
  `id_cliente` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `calificaciones` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Gestiona`
--

CREATE TABLE `Gestiona` (
  `id_usuario` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `fecha_gestion` datetime DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Mensaje`
--

CREATE TABLE `Mensaje` (
  `id_usuario` int(11) NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `id_mensaje` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `notificacion` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Ofrece`
--

CREATE TABLE `Ofrece` (
  `id_proveedor` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Proveedor`
--

CREATE TABLE `Proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `referencias` text DEFAULT NULL,
  `calificacion` int(11) DEFAULT 0,
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
  `recordatorio` varchar(255) DEFAULT NULL,
  `reseña` text DEFAULT NULL,
  `fecha_reserva` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Servicio`
--

CREATE TABLE `Servicio` (
  `id_servicio` int(11) NOT NULL,
  `disponibilidad` varchar(50) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Usuario`
--

CREATE TABLE `Usuario` (
  `id_usuario` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Usuario`
--

INSERT INTO `Usuario` (`id_usuario`, `fecha_creacion`, `nombre`, `correo`, `telefono`, `password`) VALUES
(2, '2025-07-23 02:11:58', 'admin', 'admin@admin.com', '999', '$2y$10$D19jKGb8vtOwxKqy3ySNfON6USMgeAK56uOdPQn3XbTKgtf4/jZaa'),
(3, '2025-07-23 02:12:35', 'admin2', 'admin2@admin.com', '1234', '$2y$10$IM8GlDakS90NYrFr2CO64OgRJs0TLCZdLCGlFdr28oJfStQ732CuO'),
(4, '2025-07-23 02:13:01', 'juansito', 'jjuansito@gmail.com', '8872493', '$2y$10$REVC4w0W4CLqSH/js2vEj.DOOFVulms1YaTXxRaKfTa2KiqtbMXru');

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
  ADD KEY `fk_gestiona_administrador` (`id_administrador`);

--
-- Indexes for table `Mensaje`
--
ALTER TABLE `Mensaje`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `fk_mensaje_usuario` (`id_usuario`);

--
-- Indexes for table `Ofrece`
--
ALTER TABLE `Ofrece`
  ADD PRIMARY KEY (`id_proveedor`,`id_servicio`),
  ADD KEY `fk_ofrece_servicio` (`id_servicio`);

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
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indexes for table `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Mensaje`
--
ALTER TABLE `Mensaje`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Reserva`
--
ALTER TABLE `Reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Servicio`
--
ALTER TABLE `Servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Administrador`
--
ALTER TABLE `Administrador`
  ADD CONSTRAINT `fk_administrador_usuario` FOREIGN KEY (`id_administrador`) REFERENCES `Usuario` (`id_usuario`);

--
-- Constraints for table `Cliente`
--
ALTER TABLE `Cliente`
  ADD CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`id_cliente`) REFERENCES `Usuario` (`id_usuario`);

--
-- Constraints for table `Gestiona`
--
ALTER TABLE `Gestiona`
  ADD CONSTRAINT `fk_gestiona_administrador` FOREIGN KEY (`id_administrador`) REFERENCES `Administrador` (`id_administrador`),
  ADD CONSTRAINT `fk_gestiona_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

--
-- Constraints for table `Mensaje`
--
ALTER TABLE `Mensaje`
  ADD CONSTRAINT `fk_mensaje_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

--
-- Constraints for table `Ofrece`
--
ALTER TABLE `Ofrece`
  ADD CONSTRAINT `fk_ofrece_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `Proveedor` (`id_proveedor`),
  ADD CONSTRAINT `fk_ofrece_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `Servicio` (`id_servicio`);

--
-- Constraints for table `Proveedor`
--
ALTER TABLE `Proveedor`
  ADD CONSTRAINT `fk_proveedor_usuario` FOREIGN KEY (`id_proveedor`) REFERENCES `Usuario` (`id_usuario`);

--
-- Constraints for table `Reserva`
--
ALTER TABLE `Reserva`
  ADD CONSTRAINT `fk_reserva_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `Cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_reserva_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `Proveedor` (`id_proveedor`),
  ADD CONSTRAINT `fk_reserva_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `Servicio` (`id_servicio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
