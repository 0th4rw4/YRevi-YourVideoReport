SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `entradas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tituloYoutube` varchar(100) DEFAULT NULL,
  `urlYoutube` varchar(200) DEFAULT NULL,
  `tituloArchivo` varchar(150) DEFAULT NULL,
  `nombreArchivo` varchar(200) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '1', 
  `id_cliente` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

CREATE TABLE IF NOT EXISTS `niveles` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `nivel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nivel` (`nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

INSERT INTO `niveles` (`id`, `nivel`) VALUES
(0, 'superUsuario'),
(1, 'Administrador'),
(2, 'Cliente');

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` char(100) NOT NULL,
  `contrasenia` char(32) NOT NULL,
  `id_nivel` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `nombre` varchar(20) DEFAULT NULL,
  `logo` varchar(20) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `id_nivel` (`id_nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `usuarios` (`id`, `usuario`, `contrasenia`, `id_nivel`, `nombre`, `logo`) VALUES
(1, 'sebastianarca@gmail.', '6c6586e6cd71fd64f94218d3142ce87b', 0, NULL, NULL);

ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id`) ON UPDATE CASCADE;

