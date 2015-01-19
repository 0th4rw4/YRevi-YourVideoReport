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
if($_SESSION['nivel']=='1'){ //Es administrador ?

$eliminar = isset( $_POST['delete'] ) ? mysqli_real_escape_string($cnx,$_POST['delete']) : false;
if($eliminar){
	$log = array();
	$log['id'] = $eliminar;

	$qUpdate = "UPDATE entradas SET status = '2' WHERE id='$eliminar' ;";
	$queryUpdate = mysqli_query($cnx, $qUpdate);

	if( $queryUpdate ){ 
		$log['mess'] = "El reporte se suspendio !!";
		echo json_encode($log);
	}else{
		$log['mess'] = "Error sql al procesar el reporte";
		echo json_encode($log);
	}
}
$userChange = isset( $_POST['userChange'] ) ? mysqli_real_escape_string($cnx,$_POST['userChange']) : false;
$changeName = isset( $_POST['changeName'] ) ? mysqli_real_escape_string($cnx,$_POST['changeName']) : false;
$changeUrl = isset( $_POST['changeUrl'] ) ? mysqli_real_escape_string($cnx,$_POST['changeUrl']) : false;
$changeStatus = isset( $_POST['changeStatus'] ) ? mysqli_real_escape_string($cnx,$_POST['changeStatus']) : false;
$changePassword = isset( $_POST['changePassword'] ) ? mysqli_real_escape_string($cnx,$_POST['changePassword']) : false;

if($userChange){
	$log = array();
	$log['id'] = $userChange;
	$log['valor'] = false;
	$changeStatus = intval($changeStatus);

	$qUpdate = "UPDATE usuarios SET ";
	if($changeName) { $qUpdate .= " nombre = '$changeName' "; $log['valor'] = $changeName; }
	if($changeUrl) { $qUpdate .= " usuario = '$changeUrl' "; $log['valor'] = $changeUrl; }
	if($changeStatus) { $qUpdate .= " state = $changeStatus "; $log['valor'] = $changeStatus;  }
	if($changePassword) { $qUpdate .= " contrasenia = '$changePassword' "; $log['valor'] = $changePassword; }
	$qUpdate .= " WHERE id='$userChange' ;"; 
	$queryUpdate = mysqli_query($cnx, $qUpdate);

	if( $queryUpdate ){ 
		$log['mess'] = "Actualizacion exitosa";
		echo json_encode($log);
	}else{
		$log['mess'] = "Error sql";
		echo json_encode($log);
	}
}


}
?>