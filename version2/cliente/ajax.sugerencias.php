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
$loop=true;
include_once('../config/conexion.php');

$error = array();

$nombre = !isset($_POST['nombre']) && $_POST['nombre'] != "undefined" ? mysqli_real_escape_string($cnx,$_POST['nombre']) : $error['nombre'] = false;
//$email = !isset($_POST['email']) && $_POST['email'] != "undefined" ? mysqli_real_escape_string($cnx,$_POST['email']) : $error['email'] = false;
//$cargo = !isset($_POST['cargo']) && $_POST['cargo'] != "undefined" ? mysqli_real_escape_string($cnx,$_POST['cargo']) : $error['cargo'] = false;
$sugerencia = !isset($_POST['sugerencia']) && $_POST['sugerencia'] != "undefined" ? mysqli_real_escape_string($cnx,$_POST['sugerencia']) : $error['sugerencia'] = false;
$usuarioCliente = !isset($_POST['usuarioCliente']) && $_POST['usuarioCliente'] != "undefined" ? mysqli_real_escape_string($cnx,$_POST['usuarioCliente']) : $error['usuarioCliente'] = false;

if( count($error) <= 0 ){
	$sugerenciaInsert = "INSERT INTO sugerencias
	(nombre, email, cargo, sugerencia, cliente) VALUES
	('$nombre', NULL, NULL, '$sugerencia', '$usuarioCliente'); ";

	$sugerenciaQuery = mysqli_query($cnx, $sugerenciaInsert);
	if(!$sugerenciaQuery) $error['mysql'] = false;
	else $error['exito'] = true;

	echo json_encode($error);
}
 echo json_encode($error);

$_SESSION['error.sugerencias'] = $error;

?>