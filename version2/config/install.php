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

$create = "
USE puntoRojo;

CREATE TABLE niveles (
	id TINYINT(1)UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nivel VARCHAR(15) UNIQUE
);
CREATE TABLE sugerencias(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nombre CHAR(255),
	email CHAR(255),
	cargo CHAR(255),
	sugerencia TEXT,
	cliente VARCHAR(255) NOT NULL,
	fecha DATETIME
	);
CREATE TABLE usuarios (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	usuario VARCHAR(200) UNIQUE NOT NULL ,
	contrasenia CHAR(32) NOT NULL,
	id_nivel TINYINT(1) UNSIGNED DEFAULT 2 NOT NULL,
	nombre VARCHAR(2000),
	logo VARCHAR(2000),
	state TINYINT( 1 ) NOT NULL DEFAULT '1',
		
	FOREIGN KEY (id_nivel) REFERENCES niveles (id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
);
CREATE TABLE contacto(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(200) UNIQUE,
	id_usuario INT UNSIGNED,
	
	FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
	);
CREATE TABLE entradas (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	titulo VARCHAR(200),
	url VARCHAR(200),
	comentario TEXT,
	fecha DATETIME,
	id_cliente INT UNSIGNED NOT NULL,
	file_type VARCHAR(60),
	
	FOREIGN KEY (id_cliente) REFERENCES usuarios (id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
);
CREATE TABLE feedback(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	comentario TEXT,
	status TINYINT( 1 ) NOT NULL DEFAULT '1',
	fecha_comentario DATETIME,
	nombre VARCHAR(200),
	id_entrada INT UNSIGNED,
	id_cliente INT UNSIGNED,

	FOREIGN KEY (id_cliente) REFERENCES usuarios (id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT,

	FOREIGN KEY (id_entrada) REFERENCES entradas (id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
	);
CREATE TABLE modulos (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	mime_type VARCHAR(20),
	modulo VARCHAR(40)
);

INSERT INTO modulos(mime_type, modulo) VALUES 
('image/jpeg','image_jpeg.php'),
('video/youtube','video_youtube.php');

INSERT INTO niveles(id, nivel) VALUES 
(3, 'superUsuario'),
(1, 'administrador'),
(2, 'cliente');

INSERT INTO usuarios(usuario, contrasenia, id_nivel, state) VALUES 
('sebastianarca@gmail.com',MD5('PuntoRojo1970'),1,1),
('puntorojomarketing.com',MD5('PuntoRojo1970'),1,1);

";

$query=mysqli_query($cnx, $create);
var_dump($query);

?>

