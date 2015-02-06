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


$_SESSION['error.addComentario'] = false;

$comentario = isset($_POST['comentario']) ? mysqli_real_escape_string($cnx,$_POST['comentario']) : false;
$nombreFulano = isset($_POST['comentarioNombre']) ? mysqli_real_escape_string($cnx,$_POST['comentarioNombre']) : false;
$idUsuario = isset($_POST['idUsuario']) ? mysqli_real_escape_string($cnx,$_POST['idUsuario']) : false;
$idEntrada = isset($_POST['idEntrada']) ? mysqli_real_escape_string($cnx,$_POST['idEntrada']) : false;

if($comentario && $nombreFulano && $idUsuario && $idEntrada){
	$insert = "INSERT INTO feedback(comentario, nombre, id_cliente, id_entrada, fecha_comentario) VALUES ";
	$insert .= "( '$comentario', '$nombreFulano', '$idUsuario', '$idEntrada', NOW() );";

	$query = mysqli_query($cnx, $insert);
	if(! $query) $_SESSION['error.addComentario'] = 'Error al insertar comentario';
	//var_dump($query);
}
else $_SESSION['error.addComentario'] = 'faltan datos';

//var_dump($_SESSION['error.addComentario']);
//$url = "http://localhost/proyectos/puntoRojo/administracionPuntoRojo/version2/admin/admin.mostrarDatosCliente.php";
//var_dump($url);
$data =  array("test"=>"hola") ;

header("Location: $_SERVER[HTTP_REFERER]?test=hola");	
?>