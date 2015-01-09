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
if(! ( $_SESSION['nivel']=='1' || $_SESSION['nivel']=='0' )  )
  header("Location: index.php");

//Obtener listado de clientes
$qClientes = "SELECT 
	usuario, 
	id_nivel, 
	nombre, 
	DATE_FORMAT(NOW(), '%Y') as anioNow,
	DATE_FORMAT(NOW(), '%c') as mesNow,
	DATE_FORMAT(NOW(), '%d') as diaNow
FROM usuarios WHERE id_nivel = 2 AND state = 1 ORDER BY id;";
$queryClientes = mysqli_query($cnx, $qClientes);


//Obtener datos de un usuario/cliente puntual
$usuarioCliente = isset($_POST['usuarioCliente']) ? mysqli_real_escape_string($cnx,$_POST['usuarioCliente']) : false;
$mesDia = isset($_POST['mesDia']) ? mysqli_real_escape_string($cnx,$_POST['mesDia']) : false;
$anio_ = isset($_POST['anio']) ? mysqli_real_escape_string($cnx,$_POST['anio']) : false;
$fecha = $anio_.'-'.$mesDia;

if($usuarioCliente){
$qEntradas = "
SELECT 
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
 WHERE usuarios.usuario = '$usuarioCliente' AND status = '1' ";

if($fecha) $qEntradas .= "AND fecha = '$fecha' ";

$qEntradas .= " ORDER BY entradas.fecha ASC;";
$queryEntradas = mysqli_query($cnx, $qEntradas);
}
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

			 <div class="col-md-2">
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
			 </div>

			  <div class="col-md-2">
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
			 	 <button type="submit" class="btn btn-info">Ver</button>
			 </div>
		</div>
	</form>
	<div class="col-sm-10 col-sm-offset-1" id="mostrarDatos">
		<ul class="list-unstyled">
		<?php
		if($usuarioCliente){
			while ($entradasRTA=mysqli_fetch_assoc($queryEntradas)){
				$tipo = $entradasRTA['file_type'];
				$src = $entradasRTA['url'];
				$urlArchivos = $url.$directorioReportes.'/'.$entradasRTA['usuario'].'/'.$entradasRTA['fecha'].'/';

				/*
				$selectComent = "SELECT 
				id, comentario, status, fecha_comentario, nombre, id_entrada, id_cliente
				 FROM feedback WHERE id_entrada = '$entradasRTA[id]' AND status = 1 ORDER BY fecha_comentario;";
				$comentQuery = mysqli_query($cnx, $selectComent);
				*/

				echo '<li class="clearfix" id="'.$entradasRTA['id'].'">';
				?>
				<div class="modal-dialog">
					<div class="modal-content">
						<p> ¿Desea enviar este reporte a la papelera? <a href="">Si</a> <a href="">No</a></p>
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
				/* SISTEMA COMENTARIO
				echo '<ul class="comentarios col-sm-10 col-sm-offset-2 list-unstyled">';
				while($comentRTA = mysqli_fetch_assoc($comentQuery)){
				echo '<li class="clearfix">';
				echo '<p class="col-sm-6 text-right" >'.$comentRTA['nombre'].'</p>';
				echo '<p class="col-sm-6 text-right">'.$comentRTA['fecha_comentario'].'</p>';
				echo '<p class="col-sm-12">'.$comentRTA['comentario'].'</p></li>';
			}
				echo '<li>';
			?>

			<form class="form-horizontal clearfix" role="form" name="formComentarios" method="post" action="../include/addComentarios.php">
			<input type="hidden" name="idUsuario" value="<?php echo $entradasRTA['idCliente']; ?>" />
			<input type="hidden" name="idEntrada" value="<?php echo $entradasRTA['id']; ?>" />
				<div class="col-sm-3 text-center">
					<label for="comentarioNombre">Su Nombre</label>
					<input type="text" name="comentarioNombre" id="comentarioNombre" value="" placeholder="Ingrese su nombre" />
			 	 	<button type="submit" class="btn btn-info">Enviar</button>
			 	</div>
				<div class="form-group col-sm-9">
				 	<label for="comentario" class="control-label col-sm-7">Deje un Comentario sobre el reporte</label>
				 	<textarea class="form-control col-sm-12" name="comentario" id="comentario"></textarea>
				</div>
			</form>

			 <?php
				echo'</li>';

				echo'</ul>';
				*/
				echo '</li>';
			}
		}
		?>
		</ul>
	</div>
</div>

<?php
include_once('../include/footer.php');
?>