-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2023 a las 03:38:16
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_administrativo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `ID_Auditoria` int(11) NOT NULL,
  `Fecha_Accion` date NOT NULL,
  `Hora_Accion` time NOT NULL,
  `Usuario` varchar(45) NOT NULL,
  `Descripcion_Accion` text NOT NULL,
  `Detalles_Adicionales` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `auditoria`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Auditoria` AFTER DELETE ON `auditoria` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" Información de Seguimiento';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Auditoria');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Auditoria` AFTER UPDATE ON `auditoria` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" Información de Seguimiento';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Auditoria');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `ID_Categoria` int(11) NOT NULL,
  `Nombre_Categoria` varchar(45) NOT NULL,
  `Detalle_Categoria` varchar(45) NOT NULL,
  `Productos_ID_Producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `categorias`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_Categorias` AFTER INSERT ON `categorias` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" una Categoria';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Categorias');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Categorias` AFTER DELETE ON `categorias` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" una Categoria';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Categorias');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Categorias` AFTER UPDATE ON `categorias` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" una Categoria';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Categorias');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierrecaja`
--

CREATE TABLE `cierrecaja` (
  `ID_CierreCaja` int(11) NOT NULL,
  `Num_Cajero` varchar(45) NOT NULL,
  `Fecha_Cierre` date NOT NULL,
  `Hora_Cierre` time NOT NULL,
  `Efectivo` decimal(10,2) DEFAULT NULL,
  `Tarjeta_Credito` decimal(10,2) DEFAULT NULL,
  `Transferencia_Bancaria` decimal(10,2) DEFAULT NULL,
  `Monto_Total` decimal(10,2) NOT NULL,
  `Detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `cierrecaja`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_CierreCaja` AFTER INSERT ON `cierrecaja` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" Información De Cierre de Caja';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cierre de Caja');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_CierreCaja` AFTER DELETE ON `cierrecaja` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" Información De Cierre de Caja';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cierre de Caja');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_CierreCaja` AFTER UPDATE ON `cierrecaja` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" Información De Cierre de Caja';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cierre de Caja');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` int(11) NOT NULL,
  `Cedula_Cliente` int(11) NOT NULL,
  `Nombre_Cliente` varchar(45) NOT NULL,
  `Apellido_Cliente` varchar(45) NOT NULL,
  `Telefono_Cliente` varchar(11) NOT NULL,
  `Correo_Cliente` varchar(45) DEFAULT NULL,
  `Direccion_Cliente` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `cliente`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Agregar_Cliente` AFTER INSERT ON `cliente` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" un Clienter';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cliente');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Cliente` AFTER DELETE ON `cliente` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" un Cliente';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cliente');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Cliente` AFTER UPDATE ON `cliente` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" un Cliente';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Cliente');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

CREATE TABLE `devoluciones` (
  `ID_Devolucion` int(11) NOT NULL,
  `Fecha_Devolucion` date NOT NULL,
  `Hora_Devolucion` time NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Motivo_Devolucion` text NOT NULL,
  `Detalles_Adicionales` text DEFAULT NULL,
  `Cliente_ID_Cliente` int(11) NOT NULL,
  `Recibos_ID_Recibo` int(11) NOT NULL,
  `Recibos_Cliente_ID_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `devoluciones`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_Devoluciones` AFTER INSERT ON `devoluciones` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" una Devolución';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Devoluciones');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Devoluciones` AFTER DELETE ON `devoluciones` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" una Devolución';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Devoluciones');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Devoluciones` AFTER UPDATE ON `devoluciones` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" una Devolución';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Devoluciones');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_de_pago`
--

CREATE TABLE `forma_de_pago` (
  `ID_FormaPago` int(11) NOT NULL,
  `Nombre_FormaPago` varchar(45) NOT NULL,
  `Descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `forma_de_pago`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_ForPag` AFTER INSERT ON `forma_de_pago` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" Información de Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Forma de Pago');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_ForPag` AFTER DELETE ON `forma_de_pago` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" Información de Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Forma de Pago');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_ForPag` AFTER UPDATE ON `forma_de_pago` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" Información de Forma de Pago';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Forma de Pago');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE `impuestos` (
  `ID_Impuestos` int(11) NOT NULL,
  `Nombre_Impuesto` varchar(45) NOT NULL,
  `Tasa_Impuesto` decimal(10,2) NOT NULL,
  `Descripcion_Impuesto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `impuestos`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_Impuestos` AFTER INSERT ON `impuestos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" un Impuesto';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Impuestos');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Impuestos` AFTER DELETE ON `impuestos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" un Impuesto';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Impuestos');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Impuestos` AFTER UPDATE ON `impuestos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" un Impuesto';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Impuestos');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_negocio`
--

CREATE TABLE `informacion_negocio` (
  `ID_InformacionNegocio` int(11) NOT NULL,
  `Nombre_Comercial_Negocio` varchar(45) NOT NULL,
  `Tipo_Documento` varchar(45) NOT NULL,
  `Numero_Documento` varchar(45) NOT NULL,
  `Telefono_Negocio` varchar(11) NOT NULL,
  `Correo_Negocio` varchar(45) NOT NULL,
  `Direccion_Negocio` text NOT NULL,
  `Fecha_Registro` date NOT NULL,
  `Hora_Registro` time NOT NULL,
  `Actividad_Comercial` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `informacion_negocio`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_InfoNeg` AFTER INSERT ON `informacion_negocio` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" información del Negocio';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Información de Negocio');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_InfoNeg` AFTER DELETE ON `informacion_negocio` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" información del Negocio';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Información de Negocio');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_InfoNeg` AFTER UPDATE ON `informacion_negocio` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" información del Negocio';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Información de Negocio');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manual`
--

CREATE TABLE `manual` (
  `ID_Manual` int(11) NOT NULL,
  `Titulo_Manual` varchar(45) NOT NULL,
  `Contenido_Manual` longtext NOT NULL,
  `Palabras_Clave` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Producto` int(11) NOT NULL,
  `Nombre_Producto` varchar(45) NOT NULL,
  `Codigo_Producto` varchar(45) NOT NULL,
  `Detalle_Producto` text DEFAULT NULL,
  `Cantidad_Producto` int(11) NOT NULL,
  `Precio_Venta` decimal(10,2) NOT NULL,
  `Precio_Costo` decimal(10,2) NOT NULL,
  `Fecha_Ingreso` date NOT NULL,
  `Descuento` decimal(10,2) DEFAULT NULL,
  `Promocion` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_Producto` AFTER INSERT ON `productos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" un Producto';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Producto` AFTER DELETE ON `productos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" un Producto';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Producto` AFTER UPDATE ON `productos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" un Producto';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Productos');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_Proveedor` int(11) NOT NULL,
  `Nombre_Comercial_Proveedor` varchar(45) NOT NULL,
  `Nombre_Proveedor` varchar(45) NOT NULL,
  `Apellido_Proveedor` varchar(45) NOT NULL,
  `Tipo_Documento` varchar(45) NOT NULL,
  `Numero_Documento` varchar(45) NOT NULL,
  `Telefono_Proveedor` varchar(11) NOT NULL,
  `Correo_Proveedor` varchar(45) NOT NULL,
  `Direccion_Proveedor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `proveedor`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Agregar_Proveedor` AFTER INSERT ON `proveedor` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" un Proveedor';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Proveedores');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Proveedor` AFTER DELETE ON `proveedor` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" un Proveedor';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Proveedores');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Proveedor` AFTER UPDATE ON `proveedor` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" un Proveedor';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Proveedores');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `ID_Recibo` int(11) NOT NULL,
  `Fecha_Recibo` date NOT NULL,
  `Hora_Recibo` time NOT NULL,
  `Cliente_ID_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `recibos`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_Recibos` AFTER INSERT ON `recibos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" un Recibo';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Recibos');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reembolsos`
--

CREATE TABLE `reembolsos` (
  `ID_Reembolsos` int(11) NOT NULL,
  `Fecha_Reembolso` date NOT NULL,
  `Hora_Reembolso` time NOT NULL,
  `Monto_Reembolso` decimal(10,2) NOT NULL,
  `Motivo_Reembolso` text NOT NULL,
  `Detalles_Adicionales` text DEFAULT NULL,
  `Cliente_ID_Cliente` int(11) NOT NULL,
  `Recibos_ID_Recibo` int(11) NOT NULL,
  `Recibos_Cliente_ID_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `reembolsos`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_Reembolsos` AFTER INSERT ON `reembolsos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" un Reembolso';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Reembolsos');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Reembolsos` AFTER DELETE ON `reembolsos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" un Reembolso';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Reembolsos');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Reembolsos` AFTER UPDATE ON `reembolsos` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" un Reembolso';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Reembolsos');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL,
  `Nombre_Personal` varchar(45) NOT NULL,
  `Apellido_Personal` varchar(45) NOT NULL,
  `Nombre_Usuario` varchar(45) NOT NULL,
  `Contraseña` varbinary(32) NOT NULL,
  `Salt` varbinary(32) NOT NULL,
  `Correo_Usuario` varchar(45) NOT NULL,
  `Fecha_Registro` date NOT NULL,
  `Hora_Registro` time NOT NULL,
  `Pregunta1` varchar(255) DEFAULT NULL,
  `Respuesta1` varbinary(32) DEFAULT NULL,
  `Salt2` varbinary(32) DEFAULT NULL,
  `Pregunta2` varchar(255) DEFAULT NULL,
  `Salt3` varbinary(32) DEFAULT NULL,
  `Respuesta2` varbinary(32) DEFAULT NULL,
  `Pregunta3` varchar(255) DEFAULT NULL,
  `Salt4` varbinary(32) DEFAULT NULL,
  `Respuesta3` varbinary(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Añadir_Usuario` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Añadido" Un usuario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Eliminar_Usuario` AFTER DELETE ON `usuarios` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Eliminado" un Usuario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Trigger_Auditoria_Modificar_Usuario` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
  DECLARE accion VARCHAR(45);
  SET accion = 'Ha "Modificado" un Usuario';

  INSERT INTO Auditoria (Fecha_Accion, Hora_Accion, Usuario, Descripcion_Accion, Detalles_Adicionales)
  VALUES (CURDATE(), CURTIME(), USER(), accion, 'Operación en Usuarios');
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`ID_Auditoria`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID_Categoria`,`Productos_ID_Producto`),
  ADD UNIQUE KEY `Nombre_Categoria_UNIQUE` (`Nombre_Categoria`),
  ADD KEY `fk_Categorias_Productos1_idx` (`Productos_ID_Producto`);

--
-- Indices de la tabla `cierrecaja`
--
ALTER TABLE `cierrecaja`
  ADD PRIMARY KEY (`ID_CierreCaja`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`),
  ADD UNIQUE KEY `Cedula_Cliente_UNIQUE` (`Cedula_Cliente`);

--
-- Indices de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`ID_Devolucion`,`Cliente_ID_Cliente`,`Recibos_ID_Recibo`,`Recibos_Cliente_ID_Cliente`),
  ADD KEY `fk_Devoluciones_Cliente1_idx` (`Cliente_ID_Cliente`),
  ADD KEY `fk_Devoluciones_Recibos1_idx` (`Recibos_ID_Recibo`,`Recibos_Cliente_ID_Cliente`);

--
-- Indices de la tabla `forma_de_pago`
--
ALTER TABLE `forma_de_pago`
  ADD PRIMARY KEY (`ID_FormaPago`),
  ADD UNIQUE KEY `Nombre_FormaPago_UNIQUE` (`Nombre_FormaPago`);

--
-- Indices de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`ID_Impuestos`),
  ADD UNIQUE KEY `Nombre_Impuesto_UNIQUE` (`Nombre_Impuesto`);

--
-- Indices de la tabla `informacion_negocio`
--
ALTER TABLE `informacion_negocio`
  ADD PRIMARY KEY (`ID_InformacionNegocio`),
  ADD UNIQUE KEY `Nombre_Comercial_Negocio_UNIQUE` (`Nombre_Comercial_Negocio`),
  ADD UNIQUE KEY `Numero_Documento_UNIQUE` (`Numero_Documento`);

--
-- Indices de la tabla `manual`
--
ALTER TABLE `manual`
  ADD PRIMARY KEY (`ID_Manual`),
  ADD UNIQUE KEY `Titulo_Manual_UNIQUE` (`Titulo_Manual`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD UNIQUE KEY `Codigo_Producto_UNIQUE` (`Codigo_Producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_Proveedor`),
  ADD UNIQUE KEY `Nombre_Comercial_Proveedor_UNIQUE` (`Nombre_Comercial_Proveedor`),
  ADD UNIQUE KEY `Numero_Documento_UNIQUE` (`Numero_Documento`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`ID_Recibo`,`Cliente_ID_Cliente`),
  ADD KEY `fk_Factura_Cliente1_idx` (`Cliente_ID_Cliente`);

--
-- Indices de la tabla `reembolsos`
--
ALTER TABLE `reembolsos`
  ADD PRIMARY KEY (`ID_Reembolsos`,`Cliente_ID_Cliente`,`Recibos_ID_Recibo`,`Recibos_Cliente_ID_Cliente`),
  ADD KEY `fk_Reembolsos_Cliente1_idx` (`Cliente_ID_Cliente`),
  ADD KEY `fk_Reembolsos_Recibos1_idx` (`Recibos_ID_Recibo`,`Recibos_Cliente_ID_Cliente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `Nombre_Usuario_UNIQUE` (`Nombre_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `ID_Auditoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cierrecaja`
--
ALTER TABLE `cierrecaja`
  MODIFY `ID_CierreCaja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  MODIFY `ID_Devolucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forma_de_pago`
--
ALTER TABLE `forma_de_pago`
  MODIFY `ID_FormaPago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  MODIFY `ID_Impuestos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informacion_negocio`
--
ALTER TABLE `informacion_negocio`
  MODIFY `ID_InformacionNegocio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `manual`
--
ALTER TABLE `manual`
  MODIFY `ID_Manual` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `ID_Recibo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reembolsos`
--
ALTER TABLE `reembolsos`
  MODIFY `ID_Reembolsos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `fk_Categorias_Productos1` FOREIGN KEY (`Productos_ID_Producto`) REFERENCES `productos` (`ID_Producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD CONSTRAINT `fk_Devoluciones_Cliente1` FOREIGN KEY (`Cliente_ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Devoluciones_Recibos1` FOREIGN KEY (`Recibos_ID_Recibo`,`Recibos_Cliente_ID_Cliente`) REFERENCES `recibos` (`ID_Recibo`, `Cliente_ID_Cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD CONSTRAINT `fk_Factura_Cliente1` FOREIGN KEY (`Cliente_ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reembolsos`
--
ALTER TABLE `reembolsos`
  ADD CONSTRAINT `fk_Reembolsos_Cliente1` FOREIGN KEY (`Cliente_ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Reembolsos_Recibos1` FOREIGN KEY (`Recibos_ID_Recibo`,`Recibos_Cliente_ID_Cliente`) REFERENCES `recibos` (`ID_Recibo`, `Cliente_ID_Cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
