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
include_once('config/conexion.php');

/*toDOs
--- agregar capa de JSON

//si es otharwa cargar addAdmin.php
//si es administrador cargar administradore.php
//si es usuario cargar usuarios.php

//en este archivo se genera toda la interfaz
//se recive un json, y se cargan los js segun corresponda
*/
if(isset($_SESSION['nivel'])){
switch( $_SESSION['nivel']){
  case '4DM1N': header("Location: admin/index.php");break;
  case 'U53R': header("Location: cliente/index.php");break;
}}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />

    <title><?php echo $title_default; ?></title>

    <link href="<?php global $url; echo $url; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php global $url; echo $url; ?>css/style.css" rel="stylesheet">
  </head>

  <body>
    <div class="container index">
      <form class="form-signin " role="form" method="post" action="include/registro.login.php">
        <h2 class="form-signin-heading text-center">Bienvenido al sistema de reportes de <img src="<?php echo $logo_empresa2; ?>" alt="<?php echo $own_name; ?>" /></h2>
        <input type="text" class="form-control" placeholder="Usuario" required autofocus name="email" id="email" />
        <input type="password" class="form-control" placeholder="Password" required id="password" name="password" />
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
        <?php if($_SESSION['error.log']) echo '<div class="text-warning"><p class="bg-warning text-center">'.$_SESSION['error.log'].'</p></div>'; ?>
      </form>
    </div> 
  </body>
</html>