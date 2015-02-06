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
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $nombreUsuario; ?> | <?php echo $title_default; ?></title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19324891-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

    </head>
  <body>

<header class="container clearfix cliente">
	
  <p class="col-sm-6 text-left logo">
  	<img src="<?php echo $imagenUsuario ;?>" alt="<?php echo $nombreUsuario; ?>">
  </p>
  

<div class="col-sm-5">
	  <h2 class="col-sm-12 text-right font-semibold"><?php /* echo $nombreUsuario; */ echo 'Punto Rojo!'?></h2>

  	<nav class="clearfix col-sm-12 text-right">
	   	<ul class="list-inline" id="navegacion">
			   <li><a href="index.php">Ver Reportes</a></li>
			   <li><a class="font-bold" href="cliente.libroSugerencias.php">Sugerencias</a></li>
			   <!--<li><a href="cliente.actualizar.php">Modificar Datos</a></li>-->
			   <li class="cerrar"><a href="../include/registro.login.php?kill">Salir</a></li>
		</ul>
	</nav>
</div>
<p class="col-sm-1 text-left">
    <img src="<?php echo '../'.$dirImgs.'/logoPuntoRojo.png'; ?>" alt="Punto Rojo" />
</p>
</header>
