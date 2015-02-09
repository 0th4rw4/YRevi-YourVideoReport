<?php
/*
# See AUTHORS for a list of contributors
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation; either version 3 of the
# License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
# General Public License for more details.
#
# You should have received a copy of the GNU Affero General
# Public License along with this program.  If not, see
# <http://www.gnu.org/licenses/>.
*/
include('conexion.php');

/*
USE YRevi;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '-03:00';
*/
$create = "CREATE TABLE IF NOT EXISTS `contacto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) DEFAULT NULL,
  `id_usuario` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `entradas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `comentario` text,
  `fecha` datetime DEFAULT NULL,
  `id_cliente` int(10) unsigned NOT NULL,
  `file_type` varchar(60) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comentario` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_comentario` datetime DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `id_entrada` int(10) unsigned DEFAULT NULL,
  `id_cliente` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_entrada` (`id_entrada`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `modulos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mime_type` varchar(20) DEFAULT NULL,
  `modulo` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `modulos` (`id`, `mime_type`, `modulo`) VALUES
(1, 'image/jpeg', 'image_jpeg.php'),
(2, 'video/youtube', 'video_youtube.php');

CREATE TABLE IF NOT EXISTS `niveles` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `nivel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nivel` (`nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

INSERT INTO `niveles` (`id`, `nivel`) VALUES
(1, 'administrador'),
(2, 'cliente'),
(0, 'superUsuario');

CREATE TABLE IF NOT EXISTS `sugerencias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` char(255) DEFAULT NULL,
  `sugerencia` text,
  `cliente` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(200) NOT NULL,
  `contrasenia` char(32) NOT NULL,
  `id_nivel` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `nombre` varchar(2000) DEFAULT NULL,
  `logo` varchar(2000) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `id_nivel` (`id_nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `usuarios` (`id`, `usuario`, `contrasenia`, `id_nivel`, `nombre`, `logo`, `state`) VALUES
(1, 'patoruzu', 'patoruzu', 1, NULL, NULL, 0),
(2, 'dominio.com', '123456789', 1, NULL, NULL, 1),
(4, 'cliente.com.ar', '123456789', 2, 'Cliente', 'logo.png', 3),

ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`id_entrada`) REFERENCES `entradas` (`id`) ON UPDATE CASCADE;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id`) ON UPDATE CASCADE; ";

$query = mysqli_query($cnx, $create);
var_dump($query);

?>

