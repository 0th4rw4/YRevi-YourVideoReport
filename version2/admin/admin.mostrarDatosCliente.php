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

//Obtener listado de clientes
$qClientes = "SELECT 
	usuario, 
	id_nivel, 
	nombre, 
	DATE_FORMAT(NOW(), '%Y') as anioNow,
	DATE_FORMAT(NOW(), '%c') as mesNow,
	DATE_FORMAT(NOW(), '%d') as diaNow
FROM usuarios WHERE id_nivel = 2 AND state = 1 ORDER BY id DESC;";
$queryClientes = mysqli_query($cnx, $qClientes);


//Obtener datos de un usuario/cliente puntual
$usuarioCliente = isset($_POST['usuarioCliente']) ? mysqli_real_escape_string($cnx,$_POST['usuarioCliente']) : false;
$mesDia = isset($_POST['mesDia']) ? mysqli_real_escape_string($cnx,$_POST['mesDia']) : false;
$anio_ = isset($_POST['anio']) ? mysqli_real_escape_string($cnx,$_POST['anio']) : false;
if( $mesDia && $mesDia == "todos" )
	$fecha = "todos"; 
else if( $mesDia && $anio_ )
	$fecha = $anio_.'-'.$mesDia;
else
	$fecha = false;


$_SESSION['log.mailUsuario'] = $usuarioCliente ? $usuarioCliente : false ;

$qEntradas = "SELECT 
	entradas.id,
	entradas.titulo,
	entradas.url,
	entradas.comentario,
	DATE_FORMAT(entradas.fecha,'%Y-%c-%d') as fecha,
	DATE_FORMAT(entradas.fecha,'%d-%m-%Y') as fechaMostrar,
	entradas.id_cliente,
	entradas.file_type,
	entradas.status AS status,
	usuarios.id as idCliente,
	usuarios.usuario,
	now() as actual
 FROM entradas 
 	JOIN usuarios ON entradas.id_cliente = usuarios.id
 WHERE status = '1' ";

if($usuarioCliente) $qEntradas .= "AND usuarios.usuario = '$usuarioCliente' ";
if($fecha) $qEntradas .= "AND fecha = '$fecha' ";

$qEntradas .= " ORDER BY entradas.fecha DESC;";
$queryEntradas = mysqli_query($cnx, $qEntradas);

?>
<div class="container admin">
	<form class="form-horizontal" role="form" name="datosDelCliente" id="datosDelCliente" method="post" action="admin.mostrarDatosCliente.php">
		<div class="form-group col-md-12">
			 <div class="col-md-4 col-md-offset-1">
			 	 <label for="usuarioCliente" class="text-center">Nombre Cliente
					 <select class="form-control" name="usuarioCliente" id="usuarioCliente">
					 <?php
					 	while($clienteRTA=mysqli_fetch_assoc($queryClientes)){
					 		if( $_SESSION['log.mailUsuario'] == $clienteRTA['usuario'] )
					 			echo '<option selected="selected" value="'.$clienteRTA['usuario'].'">'.$clienteRTA['nombre'].' - '.$clienteRTA['usuario'].'</option>';
					 		else
					 			echo '<option value="'.$clienteRTA['usuario'].'">'.$clienteRTA['nombre'].' - '.$clienteRTA['usuario'].'</option>';
					 	}
					 ?>
					 </select>
				  </label>
			 </div>

			 <div class="col-md-3">
			 	 <label for="fecha" class="text-center">Mes
					 <select class="form-control" name="mesDia" id="fecha" >
					 	<option value="">Mostrar Todos</option>
					 	<?php 
				          foreach($calendario as $numMes => $mes){
				          		if ($numMes == $now['month'])
				          			echo '<option selected="selected" value="'.$numMes.'-01">'.$mes.'</option>';
				          		else
	            					echo '<option value="'.$numMes.'-01">'.$mes.'</option>';
	          				}
	        			?>
					 </select>
				 </label>

			 	 <label for="fecha" class="text-center">Año
					 <select class="form-control" name="anio" id="fecha" >
					 	<?php 
				          foreach($anio as $numero ){
				          		if ($numero == $now['year'])
				          			echo '<option selected="selected" value="'.$numero.'">'.$numero.'</option>';
				          		else
	            					echo '<option value="'.$numero.'">'.$numero.'</option>';
	          				}
	        			?>
					 </select>
				 </label>
			 </div>

			 <div class="col-md-1">
			 	 <button type="submit" class="btn btn-info" style="margin-top: 1em; ">Ver</button>
			 </div>
			 <div class="col-md-1">
			 	 <a href="/admin/admin.dataEntry.php" class="btn btn-warning" style="margin-top: 1em; color: #333333;" >Nuevo Reporte</a>
			 </div>
		</div>
	</form>
	<div class="col-sm-10 col-sm-offset-1" id="mostrarDatos">
		<ul class="list-unstyled">
		<?php
		//if($usuarioCliente){
			while ($entradasRTA=mysqli_fetch_assoc($queryEntradas)){
				$tipo = $entradasRTA['file_type'];
				$src = $entradasRTA['url'];
				$urlArchivos = $url.$directorioReportes.'/'.$entradasRTA['usuario'].'/'.$entradasRTA['fecha'].'/';

				echo '<li class="clearfix" id="'.$entradasRTA['id'].'">';
				?>
				<div class="modal-dialog">
					<div class="modal-content">
						<p> ¿Desea eliminar este reporte? <a href="">Si</a> <a href="">No</a></p>
					</div>
				</div>
				<?php
				echo '<div class="clearfix">';
				echo '<h2 class="col-sm-10">';
				echo '<a class="close" href="#" data-role="'.$entradasRTA['id'].'">&times;</a>';
				echo $entradasRTA['titulo'].'</h2>';
				echo '<p class="col-sm-2 text-right fecha">'.$entradasRTA['fechaMostrar'].'</p>';
				echo '</div><hr />';
				$modulo[$tipo]->mostrar($src);
				echo '<p class="col-sm-10 col-sm-offset-1">'.$entradasRTA['comentario'].'</p>';
				echo '</li>';
			}
		//}
		?>
		</ul>
	</div>
</div>

<?php
include_once('../include/footer.php');
?>