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
include_once('admin.header.php');
if(! ( $_SESSION['nivel']=='4DM1N' )  )
  header("Location: index.php");

$qClientes = "SELECT 
	usuario, 
	id_nivel, 
	nombre
FROM usuarios WHERE id_nivel = 2 AND state = 1 ORDER BY id;";
$queryClientes = mysqli_query($cnx, $qClientes);

$usuarioCliente = isset($_POST['usuarioCliente']) ? mysqli_real_escape_string($cnx,$_POST['usuarioCliente']) : false;

$qEntradas = "SELECT 
	nombre,
	email,
	cargo,
	sugerencia,
	cliente,
	DATE_FORMAT(fecha,'%d-%m-%Y') as fecha
 FROM sugerencias ";
 if($usuarioCliente)
	$qEntradas .= "WHERE cliente = '$usuarioCliente' ";
 if($fecha)
 	$qEntradas .= "AND fecha = '$fecha' ";

$qEntradas .= " ;";
$queryEntradas = mysqli_query($cnx, $qEntradas);

?>
<div class="conteiner admin">
	<form class="form-horizontal" role="form" name="datosDelCliente" id="datosDelCliente" method="post" action="admin.sugerenciasMostrar.php">
		<div class="form-group col-sm-12">
			 <div class="col-sm-4 col-sm-offset-4">
			 	 <label for="usuarioCliente" class="control-label col-sm-offset-4">Nombre Cliente</label>
				 <select class="form-control" name="usuarioCliente" id="usuarioCliente">
				 <?php
				 	while($clienteRTA=mysqli_fetch_assoc($queryClientes)){
				 		$anioNow = $clienteRTA['anioNow'];
				 		$mesNow = $clienteRTA['mesNow'];
				 		$diaNow = $clienteRTA['diaNow'];
				 		echo '<option value="'.$clienteRTA['usuario'].'">'.$clienteRTA['nombre'].' - '.$clienteRTA['usuario'].'</option>';
				 	}
				 ?>
				 </select>
			 </div>
			 <div class="col-sm-2">
			 	 <button type="submit" class="btn btn-info">Consultar</button>
			 </div>
		</div>
		<div class="col-sm-12 text-center">
			<p>Pag: </p>
			<p> <a href="admin.sugerenciasMostrar.php?pag=mas" >Anterior</a> <strong>1</strong> <a href="admin.sugerenciasMostrar.php?pag=menos" >Siguiente</a> </p>
		</div>
	</form>
	<div class="col-sm-10 col-sm-offset-1" id="mostrarDatos">
		<ul class="list-unstyled col-sm-8 col-sm-push-2 adminSugerencias">
		<?php
			while ($entradasRTA=mysqli_fetch_assoc($queryEntradas)){
				echo '<li class="col-sm-12">';
				echo '<p class="col-sm-6"><strong>Cliente:</strong> '.$entradasRTA['cliente'].' </p>';
				echo '<p class="col-sm-6"><strong>Fecha:</strong> '.$entradasRTA['fecha'].'</p>';
				echo '<p class="col-sm-6"><strong>Nombre: </strong>'.$entradasRTA['nombre'].'</p>';
				//echo '<p class="col-sm-6"><strong>Cargo: </strong>'.$entradasRTA['cargo'].'</p>';
				//echo '<p class="col-sm-12 text-center"><strong>Email: </strong>'.$entradasRTA['email'].'</p>';
				echo '<p class="col-sm-12 text-center"><strong>Sugerencia:  </strong></p>';
				echo '<p class="col-sm-9">'.$entradasRTA['sugerencia'].'</p>';
				echo '<hr />';
				echo '</li>';
			}
		
		?>
		</ul>
	</div>
</div>

<?php
include_once('../include/footer.php');
?>