-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2019 a las 17:30:06
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `horario`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaHorarioCurso` (`_dia` INT, `_hora` INT)  BEGIN
	SELECT 
		h.idhorariocurso,
		c.nombre
	FROM horario_curso AS h
	INNER JOIN curso AS c ON h.idcurso=c.idcurso
	WHERE h.idhora = _hora AND h.dia = _dia;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mantenimientoHorario` (`_flag` INT, `_idhorario` INT, `_idhora` INT, `_idcurso` INT, `_dia` INT)  BEGIN
	if _flag = 1 then
		INSERT INTO horario_curso (
			idhora,
			idcurso,
			dia
		)VALUES(
			_idhora,
			_idcurso,
			_dia
		) ;
		
		SET @idregistro  = LAST_INSERT_ID();
		
		select 'se guardo correctamente' as msj, 'info' as icon,@idregistro  as horario; 
	end if;
	if _flag = 2 then
		delete from horario_curso where idhorariocurso = _idhorario;
		
		select 'se elimino correctamente' as msj, 'info' as icon; 
	end if;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `idcurso` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`idcurso`, `nombre`) VALUES
(1, 'Matematica'),
(2, 'Fisica'),
(3, 'Comunicacion'),
(4, 'Arte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hora`
--

CREATE TABLE `hora` (
  `idhora` int(11) NOT NULL,
  `inicio` time NOT NULL,
  `fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `hora`
--

INSERT INTO `hora` (`idhora`, `inicio`, `fin`) VALUES
(1, '07:00:00', '08:00:00'),
(2, '08:00:00', '09:00:00'),
(3, '09:00:00', '10:00:00'),
(4, '10:00:00', '11:00:00'),
(5, '11:00:00', '12:00:00'),
(6, '12:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_curso`
--

CREATE TABLE `horario_curso` (
  `idhorariocurso` int(11) NOT NULL,
  `idhora` int(11) NOT NULL,
  `idcurso` int(11) NOT NULL,
  `dia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `horario_curso`
--

INSERT INTO `horario_curso` (`idhorariocurso`, `idhora`, `idcurso`, `dia`) VALUES
(13, 3, 2, 2),
(22, 4, 4, 3),
(23, 5, 2, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`idcurso`);

--
-- Indices de la tabla `hora`
--
ALTER TABLE `hora`
  ADD PRIMARY KEY (`idhora`);

--
-- Indices de la tabla `horario_curso`
--
ALTER TABLE `horario_curso`
  ADD PRIMARY KEY (`idhorariocurso`),
  ADD KEY `dia` (`dia`),
  ADD KEY `idhora` (`idhora`),
  ADD KEY `idcurso` (`idcurso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `idcurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `hora`
--
ALTER TABLE `hora`
  MODIFY `idhora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `horario_curso`
--
ALTER TABLE `horario_curso`
  MODIFY `idhorariocurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `horario_curso`
--
ALTER TABLE `horario_curso`
  ADD CONSTRAINT `horario_curso_ibfk_1` FOREIGN KEY (`idhora`) REFERENCES `hora` (`idhora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `horario_curso_ibfk_2` FOREIGN KEY (`idcurso`) REFERENCES `curso` (`idcurso`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
