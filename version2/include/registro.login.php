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
$user=isset($_POST['email']) ? mysqli_real_escape_string($cnx, $_POST['email']) : false;
$pass=isset($_POST['password']) ? $_POST['password'] : false;

$_SESSION['error.log']='No esta registrado';

if( /*!isset($_SESSION['login'])&& */ $user!=false && $pass!=false){
	//$pass=md5($pass);
	$q = "SELECT usuario, contrasenia, id_nivel, state 
		FROM usuarios WHERE usuario = '$user' AND ( contrasenia = MD5('$pass') OR contrasenia = '$pass' );";	
	$filas=mysqli_query($cnx,$q);
	$qRta = mysqli_fetch_assoc($filas);
	if($qRta!=false && $qRta['state'] == '1'){
			$_SESSION['login']=$qRta['usuario'];
			$_SESSION['nivel']=$qRta['id_nivel'];
			$_SESSION['error.log']=true;
	}
	elseif( $qRta['state'] != '1' ){ $_SESSION['error.log']='Usuario invalido'; }
	else{$_SESSION['error.log']='Datos Invalidos';}
}elseif(isset($_SESSION['login'])){
	$_SESSION['error.log']=true;
}

if(isset($_GET['kill']))session_destroy();
if(isset($_GET['new']))$_SESSION['new']=true;
if(isset($_GET['close']))$_SESSION['new']=false;

header("Location: $_SERVER[HTTP_REFERER]");	

?>