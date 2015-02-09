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
$pass=isset($_POST['password']) ? mysqli_real_escape_string($cnx, $_POST['password']) : false;

$_SESSION['error.log']='No esta registrado';

if( !isset($_SESSION['login']) &&  $user!=false && $pass!=false){

	$q = "SELECT usuario, contrasenia, id_nivel, state 
		FROM usuarios WHERE usuario = '$user' AND (state = 1 OR state = 0) AND ( contrasenia = MD5('$pass') OR contrasenia = '$pass' );";	
	$filas=mysqli_query($cnx,$q);
	$qRta = mysqli_fetch_assoc($filas);

	// Check if user exist, and is active
	// Check values for Default Admin User
	if( ( $qRta!=false && $qRta['state'] == '1' ) || ( isset($default_user) === true && ( $default_user === true && $user == 'patoruzu' && $pass == 'patoruzu' ) ) ){
			$_SESSION['login']=$qRta['usuario'];

			if( ( $qRta['id_nivel'] == '1' || $qRta['id_nivel'] == '0' ) || $default_user === true )
				$_SESSION['nivel'] = '4DM1N';
			if($qRta['id_nivel'] == '2')
				$_SESSION['nivel'] = 'U53R';

			$_SESSION['error.log']=true;
	}
	elseif( $qRta['state'] != '1' ){ 
		$_SESSION['error.log']='Usuario invalido'; }
	else{
		$_SESSION['error.log']='Datos Invalidos';}
}elseif(isset($_SESSION['login'])){
	$_SESSION['error.log']=true;
}

if(isset($_GET['kill'])) session_destroy();
if(isset($_GET['new'])) $_SESSION['new']=true;
if(isset($_GET['close'])) $_SESSION['new']=false;

header("Location: $_SERVER[HTTP_REFERER]");	

?>