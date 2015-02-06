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
include_once('../config/conexion.php');
$select = "SELECT nombre, logo, usuario FROM usuarios WHERE usuario = '$_SESSION[login]'; ";

$select = mysqli_query($cnx, $select);
while($selectRTA = mysqli_fetch_assoc($select) ){
  $imagenUsuario = '../upload/logos/'.$selectRTA['logo'];
  $nombreUsuario = $selectRTA['nombre'];
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Campañas PuntoRojo</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script type="text/javascript" src="../js/jquery-2.1.0.min.js"></script>
  </head>

  <body>

<header class="conteiner">
<div class="col-sm-12">
	<p class="col-sm-3">
    <img src="<?php echo '../'.$dirImgs.'/posicionamiento-web-2.png'; ?>" alt="Punto Rojo" />
  </p>
  
   <p class="col-sm-3">
    <img src="<?php echo $imagenUsuario ;?>" alt="<?php echo $nombreUsuario; ?>">
  </p>
  <h2 class="col-sm-3"><?php echo $nombreUsuario; ?> </h2>
  <p class="col-sm-2">
    <a href="<?php echo $url; ?>include/registro.login.php?kill" class="text-align">Cerrar Sesion</a>
  </p>
</div>
</header>