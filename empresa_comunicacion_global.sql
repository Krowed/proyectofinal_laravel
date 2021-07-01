-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2021 a las 17:25:09
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `empresa_comunicacion_global`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `Precio_Unitario` decimal(12,2) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Total` decimal(12,2) NOT NULL,
  `ID_Ordc` int(11) NOT NULL,
  `ID_Prod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`Precio_Unitario`, `Cantidad`, `Total`, `ID_Ordc`, `ID_Prod`) VALUES
('11.00', 5, '55.00', 1, 4),
('16.00', 4, '54.00', 3, 1),
('35.00', 2, '70.00', 3, 3),
('10.00', 2, '20.00', 5, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `ID_Prod` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Total` decimal(12,2) NOT NULL,
  `ID_Ingres` int(11) NOT NULL,
  `ID_Ordc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`ID_Prod`, `Cantidad`, `Total`, `ID_Ingres`, `ID_Ordc`) VALUES
(1, 13, '5000.00', 1, 3),
(2, 10, '50.00', 2, 4),
(3, 1, '10.00', 5, 6),
(4, 100, '680.00', 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_salida`
--

CREATE TABLE `detalle_salida` (
  `ID_Prod` int(11) NOT NULL,
  `ID_Salid` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_salida`
--

INSERT INTO `detalle_salida` (`ID_Prod`, `ID_Salid`, `Cantidad`) VALUES
(1, 1, 13),
(4, 6, 10),
(2, 3, 18),
(3, 4, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE `distrito` (
  `ID_Distrito` int(11) NOT NULL,
  `Nombre_Distrito` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`ID_Distrito`, `Nombre_Distrito`) VALUES
(1, 'Santa Anita'),
(2, 'Lurigancho'),
(3, 'Ate Vitarte'),
(4, 'San Borja'),
(5, 'San Isidro'),
(6, 'Breña');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `ID_Empl` int(11) NOT NULL,
  `Nombre_Empl` varchar(20) NOT NULL,
  `ApellidoPat_Empl` varchar(20) NOT NULL,
  `ApellidoMat_Empl` varchar(20) NOT NULL,
  `Direccion_Empl` varchar(50) DEFAULT NULL,
  `NumeroDoc_Empl` varchar(20) NOT NULL,
  `Telefono_Empl` varchar(20) NOT NULL,
  `FechaNacimiento_Emp` date NOT NULL,
  `ID_TEmpl` int(11) NOT NULL,
  `ID_Sucur` int(11) NOT NULL,
  `ID_TDoc` int(11) NOT NULL,
  `ID_Distrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`ID_Empl`, `Nombre_Empl`, `ApellidoPat_Empl`, `ApellidoMat_Empl`, `Direccion_Empl`, `NumeroDoc_Empl`, `Telefono_Empl`, `FechaNacimiento_Emp`, `ID_TEmpl`, `ID_Sucur`, `ID_TDoc`, `ID_Distrito`) VALUES
(1, 'Gary', 'Carlos', 'Vasquez', 'Av.Cajamarquill', '78912371', '9657435238', '1996-09-10', 2, 2, 2, 4),
(2, 'Leslie', 'Pizarro', 'Estrada', 'Av. Fortaleza', '79400904', '975452213', '2000-12-02', 2, 2, 1, 1),
(3, 'Carlos', 'Hernandez', 'Ruiz', 'Av. Los Ficus', '78657888', '963443241', '1992-09-12', 2, 1, 2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_de_remision`
--

CREATE TABLE `guia_de_remision` (
  `ID_GRemi` int(11) NOT NULL,
  `NumeroDoc_GRemi` varchar(20) NOT NULL,
  `RUC_GRemi` varchar(20) NOT NULL,
  `ID_Salid` int(11) NOT NULL,
  `ID_Sucur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `ID_Ingres` int(11) NOT NULL,
  `Serie` varchar(20) NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`ID_Ingres`, `Serie`, `Fecha`) VALUES
(1, '001001910', '2021-09-22'),
(2, '001001911', '2021-12-24'),
(3, '001001912', '2021-12-07'),
(4, '4234231912', '2021-11-17'),
(5, '846534563', '2021-10-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE `orden_compra` (
  `ID_Ordc` int(11) NOT NULL,
  `FechaOrden_Ordc` date NOT NULL,
  `FechaEntrega_Ordc` date NOT NULL,
  `ID_Prov` int(11) NOT NULL,
  `ID_Empl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `orden_compra`
--

INSERT INTO `orden_compra` (`ID_Ordc`, `FechaOrden_Ordc`, `FechaEntrega_Ordc`, `ID_Prov`, `ID_Empl`) VALUES
(1, '2021-06-15', '2021-06-24', 5, 1),
(3, '2021-02-17', '2021-06-19', 1, 3),
(4, '2021-07-23', '2021-07-24', 3, 1),
(5, '2021-12-16', '2021-12-24', 1, 3),
(6, '2021-10-21', '2021-10-29', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_Prod` int(11) NOT NULL,
  `Nombre_Prod` varchar(40) NOT NULL,
  `PrecioVent_Prod` decimal(12,2) NOT NULL,
  `PrecioComp_Prod` decimal(12,2) NOT NULL,
  `StockActual_Prod` int(11) NOT NULL,
  `StockInicial_Prod` int(11) NOT NULL,
  `ID_Prov` int(11) NOT NULL,
  `ID_TProd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_Prod`, `Nombre_Prod`, `PrecioVent_Prod`, `PrecioComp_Prod`, `StockActual_Prod`, `StockInicial_Prod`, `ID_Prov`, `ID_TProd`) VALUES
(1, 'V8 OTROS', '5.00', '5.00', 77, 155, 1, 22),
(2, 'LYG/MOVISCON', '3.00', '4.00', 59, 104, 3, 2),
(3, 'IPHONE GENERICO', '400.00', '200.00', -2, 1, 2, 3),
(4, 'TABLET', '70.00', '60.00', 15, 8, 3, 10),
(5, 'CELULAR', '980.00', '900.00', 123, 234, 1, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_Prov` int(11) NOT NULL,
  `Direccion_Prov` varchar(50) NOT NULL,
  `Telefono_Prov` varchar(20) DEFAULT NULL,
  `RazonSocial_Prov` varchar(50) NOT NULL,
  `Email_Prov` varchar(50) DEFAULT NULL,
  `Nombre_Prov` varchar(50) DEFAULT NULL,
  `ID_TProv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_Prov`, `Direccion_Prov`, `Telefono_Prov`, `RazonSocial_Prov`, `Email_Prov`, `Nombre_Prov`, `ID_TProv`) VALUES
(1, 'Cercado de Lima ', '(01)3886906', 'Oscaona Ruiz', 'oscaonaruiz@gmail.com', 'Brigida Amador', 1),
(2, 'Santiago de Surco', '948326040', 'Smartphones Peru SAC ', 'smarthperu@gmail.com', 'Carlos Enrique Cabrera', 2),
(3, 'Av.La Molina', '981599076', 'Celulares Peru', 'celuperuoficial@gmail.com', 'Equipos para oficina y escolar', 3),
(4, 'Lince ', '989796177', 'Venta Celular Jhonny', 'jhonnycelulares@gmail.com', 'Maria Milagros Pina', 4),
(5, 'Santa Anita', '997927404', 'Peru Importa', 'peruimporta@gmail.com', 'Percy Gonzalo Cabrera', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE `salida` (
  `ID_Salid` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Serie` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `salida`
--

INSERT INTO `salida` (`ID_Salid`, `Fecha`, `Serie`) VALUES
(1, '2019-09-28', '001'),
(2, '2019-10-05', '002'),
(3, '2021-10-11', '003'),
(4, '2021-06-24', '004'),
(5, '2021-09-29', '005'),
(6, '2021-10-22', '006'),
(7, '2021-11-17', '007'),
(8, '2021-12-14', '008'),
(9, '2021-12-10', '009'),
(10, '2021-12-21', '0010');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `ID_Sucur` int(11) NOT NULL,
  `Telefono_Sucur` varchar(20) NOT NULL,
  `ID_TSucur` int(11) NOT NULL,
  `Direccion_Sucur` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`ID_Sucur`, `Telefono_Sucur`, `ID_TSucur`, `Direccion_Sucur`) VALUES
(1, '(01)2891797', 1, '54291 Austen Via Suite 399 - Louisville/Jefferson '),
(2, '(01)2891781', 2, '678 Isabel Cliffs Suite 181 - Kent, DE / 63785'),
(3, '(01)2890191', 2, '3356 Raynor Drive Apt. 056 - Scranton, MI / 28467'),
(4, '(01)2831038', 2, '5467 Jace Dam Apt. 574 - Anchorage, MS / 25770'),
(5, '(01)2812839', 2, '49408 Citlalli Highway Apt. 833 - Clifton, OR / 68'),
(6, '(01)2812839', 2, '743 Thad Shores Suite 359 - Honolulu, NE / 64272');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_documento`
--

CREATE TABLE `tipo_de_documento` (
  `ID_TDoc` int(11) NOT NULL,
  `TipoDocumento_TDoc` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_de_documento`
--

INSERT INTO `tipo_de_documento` (`ID_TDoc`, `TipoDocumento_TDoc`) VALUES
(1, 'DNI'),
(2, 'CE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_empleado`
--

CREATE TABLE `tipo_de_empleado` (
  `ID_TEmpl` int(11) NOT NULL,
  `Nombre_TEmpl` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_de_empleado`
--

INSERT INTO `tipo_de_empleado` (`ID_TEmpl`, `Nombre_TEmpl`) VALUES
(1, 'Administrador'),
(2, 'Encargado_Almacen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_proveedor`
--

CREATE TABLE `tipo_de_proveedor` (
  `ID_TProv` int(11) NOT NULL,
  `NombreComp_TProv` varchar(50) NOT NULL,
  `Descripcion_TProv` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_de_proveedor`
--

INSERT INTO `tipo_de_proveedor` (`ID_TProv`, `NombreComp_TProv`, `Descripcion_TProv`) VALUES
(1, 'Borer Emmerich', 'Accesorios para los equipos y celulares'),
(2, 'Hills LLC', 'Repuestos de las PCs'),
(3, 'Tremblay Yundt', 'Equipos para oficina y escolar'),
(4, 'Friesen Parisian', 'Celulares y Tablets');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_sucursal`
--

CREATE TABLE `tipo_de_sucursal` (
  `ID_TSucur` int(11) NOT NULL,
  `Nombre_TSucur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_de_sucursal`
--

INSERT INTO `tipo_de_sucursal` (`ID_TSucur`, `Nombre_TSucur`) VALUES
(1, 'Almacen'),
(2, 'Tienda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `ID_TProd` int(11) NOT NULL,
  `Nombre_TProd` varchar(40) NOT NULL,
  `Descripcion_TProd` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`ID_TProd`, `Nombre_TProd`, `Descripcion_TProd`) VALUES
(1, 'Cable USB', 'V8-TIPOC/V3/HDMI/IPHONE/OTG'),
(2, 'Mouse', 'Genericos Orginal'),
(3, 'Teclados/ Pad Mouse', 'Accesorios para computadoras'),
(4, 'Rack/ Soporte auto', 'Racks'),
(5, 'Mini PC HTPC Intel Core i7', 'Windows 10 Pro, Enfriador de ordenador, oficina, escritorio, minipc, WIFI, Gráficos HD'),
(6, 'Alfombrilla de ratón RGB MSI LED XXL', 'Antideslizante, de goma, para juegos, luz LED, para teclado, portátil, ordenador y PC'),
(7, 'Alfombrilla de oficina anime', 'Para ordenador portátil, ratones Mousepad Muismat gran Borde de bloqueo'),
(8, 'Teclado LED', 'Retroiluminado con LED para juegos, ratón ajustable, ordenador'),
(9, 'Auriculares de alta calidad', 'Para videojuegos, música, negocios, PC/ordenador portátil/teléfono, oficina'),
(10, 'Bluetooth para PC TV adaptador inalámbri', 'Inalámbrica Bluetooth V4.1 + receptor EDR de Audio adaptador AUX estéreo'),
(11, 'Auriculares inalámbricos IPX6 ', 'Impermeables para hombre joven, cascos deportivos inteligentes con Bluetooth 2000, TWS, 5,0 mAh, alta fidelidad, música, Control de botones'),
(12, 'Auricular inalámbrico con Bluetooth 5,1 ', 'Dispositivo de audio para teléfono inteligente, poco retraso, para videojuegos, música, HD, micrófono, manos libres, Control de botón, nueva actualización'),
(13, 'ASUS ROM 5 Gaming Phone', 'ROG 5 5G 6,78 \"Snapdragon 888 Android11 6000mAh cargador rápida 65W ROG 5 Teléfono de juegos'),
(14, 'ASUS ROM Phone 3', '12 GB de RAM 128/256/512 GB ROM OTA actualización Snapdragon865Plus 6000mAh Smartphone'),
(15, 'ASUS Zenfone 5 ZE620KL', '4GB RAM 64GB ROM teléfono móvil de 6,2 pulgadas 19:9 FHD + Android 8,0 12MP + 8MP NFC 3300mAh'),
(16, 'Lenovo YOGA - ordenador portátil ', '14 pulgadas, notebook con intel i5-1135G7/i5-11300H, 16 GB RAM, 2021 GB SSD, Pantalla táctil IPS, ultradelgado, 14s, novedad de 512'),
(17, 'LLANO-Soporte de escritorio para ordenad', 'Base giratoria de 360 grados, altura ajustable para MacBook Air Pro, almohadilla de enfriamiento, soporte para ordenador portátil'),
(18, 'Soporte de escritorio Vertical de alumin', 'Ahorra espacio para MacBook Air/Pro 16 13 15, iPad Pro 12,9, Chromebook y portátil de 11 a 17 pulgadas'),
(19, 'Cargador múltiple LENTION', 'Lention USB HUB de USB 3,0 HDMI adaptador Dock para 2020-2016 MacBook Pro 13,3 USB-C tipo C 3,1 divisor 11 Puerto USB'),
(20, 'DROBO', 'Creader-herramienta de diagnóstico Creader profesional CRP123 Creader VII, 100% Original, para lanzar el lector de código, Software, actualización en varios idiomas'),
(21, 'Monitor portátil para PC', 'Para PC, móvil y Gaming con batería de 13,3 mAh, HDMI para Switch, PC, teléfonos Huawei, 10800'),
(22, 'Xiaomi Redmi Note 10 ', 'Pro 6GB RAM 64GB / 128GB ROM teléfono móvil 108MP Cámara Snapdragon 732G 120Hz Pantalla AMOLED'),
(23, 'Huawei Mate 20X5G', 'EVR-N29 Android Teléfono Kirin 980 40.0MP NFC IP53 7,2 pulgadas 2244X1080 8GB RAM 256GB ROM'),
(24, 'Xiaomi-Smartphone Redmi K40 5G', '12GB y 256GB, Snapdragon 870, gran batería de 4520mAh, 48MP, 8MP, 5MP, Triple cámara trasera'),
(25, 'Xiaomi Redmi Note 9', '3GB 64GB / 4GB 128GB MTK Helio G85 48MP Quad 5020mAh Cámara 6,53 \"DotDisplay teléfono móvil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Usuario` varchar(50) NOT NULL,
  `Contraseña` varchar(50) NOT NULL,
  `ID_TEmpl` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Usuario`, `Contraseña`, `ID_TEmpl`, `ID_Usuario`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1),
('almacen', '4e210009a1cfbf891ee1a8f75f441e2f', 2, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD KEY `ID_Ordc` (`ID_Ordc`,`ID_Prod`);

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD KEY `ID_Prod` (`ID_Prod`),
  ADD KEY `ID_Ingres` (`ID_Ingres`),
  ADD KEY `ID_Ordc` (`ID_Ordc`);

--
-- Indices de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  ADD KEY `ID_Prod` (`ID_Prod`,`ID_Salid`);

--
-- Indices de la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`ID_Distrito`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`ID_Empl`),
  ADD KEY `ID_TEmpl` (`ID_TEmpl`,`ID_Sucur`,`ID_TDoc`,`ID_Distrito`);

--
-- Indices de la tabla `guia_de_remision`
--
ALTER TABLE `guia_de_remision`
  ADD PRIMARY KEY (`ID_GRemi`),
  ADD KEY `ID_Salid` (`ID_Salid`,`ID_Sucur`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`ID_Ingres`);

--
-- Indices de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`ID_Ordc`),
  ADD KEY `ID_Prov` (`ID_Prov`,`ID_Empl`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_Prod`),
  ADD KEY `ID_Prov` (`ID_Prov`,`ID_TProd`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_Prov`),
  ADD KEY `ID_TProv` (`ID_TProv`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`ID_Salid`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`ID_Sucur`),
  ADD KEY `ID_TSucur` (`ID_TSucur`);

--
-- Indices de la tabla `tipo_de_documento`
--
ALTER TABLE `tipo_de_documento`
  ADD PRIMARY KEY (`ID_TDoc`);

--
-- Indices de la tabla `tipo_de_empleado`
--
ALTER TABLE `tipo_de_empleado`
  ADD PRIMARY KEY (`ID_TEmpl`);

--
-- Indices de la tabla `tipo_de_proveedor`
--
ALTER TABLE `tipo_de_proveedor`
  ADD PRIMARY KEY (`ID_TProv`);

--
-- Indices de la tabla `tipo_de_sucursal`
--
ALTER TABLE `tipo_de_sucursal`
  ADD PRIMARY KEY (`ID_TSucur`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`ID_TProd`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD KEY `ID_TEmpl` (`ID_TEmpl`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipo_de_empleado`
--
ALTER TABLE `tipo_de_empleado`
  MODIFY `ID_TEmpl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
