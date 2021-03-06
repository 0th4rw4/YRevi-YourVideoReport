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
if(! isset( $_SESSION['nivel'] ))
  header("Location: index.php");

$usuarioCliente = isset($_SESSION['login']) ? mysqli_real_escape_string($cnx,$_SESSION['login']) : false;
$mesDia = isset($_POST['mesDia']) ? mysqli_real_escape_string($cnx,$_POST['mesDia']) : false;
$anio_ = isset($_POST['anio']) ? mysqli_real_escape_string($cnx,$_POST['anio']) : false;

if( $mesDia && $mesDia == "todos" )
	$fecha = "todos"; 
else if( $mesDia && $anio_ )
	$fecha = $anio_.'-'.$mesDia;
else
	$fecha = false;

if($usuarioCliente){
$qEntradas = "
SELECT 
	entradas.id as id,
	entradas.titulo as titulo,
	entradas.url as url,
	entradas.comentario as comentario,
	DATE_FORMAT(entradas.fecha,'%Y-%c-%d') as fecha,
	DATE_FORMAT(entradas.fecha,'%d-%m-%Y') as fechaMostrar,
	entradas.id_cliente as id_cliente,
	entradas.file_type as file_type,
	usuarios.id as idCliente,
	usuarios.usuario as usuario
 FROM entradas 
 	JOIN usuarios ON entradas.id_cliente = usuarios.id
 WHERE usuarios.usuario = '$usuarioCliente' AND status = '1' ";

if($fecha && $fecha != "todos") $qEntradas .= "AND fecha = '$fecha' ";
elseif ($fecha && $fecha == "todos") $qEntradas .= " ORDER by fecha ASC ";
else $qEntradas .= " ORDER by fecha ASC LIMIT 1"; //mostrar la ultima entrada LIMIT 1


$qEntradas .= " ;";
$queryEntradas = mysqli_query($cnx, $qEntradas);

}
?>
<div class="container">
	<form class="form-horizontal clearfix" role="form" name="datosDelCliente" id="datosDelCliente" method="post" action="index.php">
		<div class="form-group row">
			 <div class="col-md-2 col-md-offset-4">
			 	 <label for="fecha" class="text-center">Elija el reporte del mes
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
			 	 <label for="fecha" class="text-center">Elija un año
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
	<div class="col-sm-12" id="mostrarDatos">
		<ul class="list-unstyled">
		<?php
		if($usuarioCliente){
			while ($entradasRTA=mysqli_fetch_assoc($queryEntradas)){
				$tipo = $entradasRTA['file_type'];
				$src = $entradasRTA['url'];
				$urlArchivos = $url.$directorioReportes.'/'.$entradasRTA['usuario'].'/'.$entradasRTA['fecha'].'/';

				$selectComent = "SELECT 
				id, comentario, status, fecha_comentario, nombre, id_entrada, id_cliente
				 FROM feedback WHERE id_entrada = '$entradasRTA[id]' AND status = 1 ORDER BY fecha_comentario;";
				$comentQuery = mysqli_query($cnx, $selectComent);

				echo '<li class="clearfix">';
				echo '<div class="clearfix">';
				echo '<h2 class="col-sm-10">'.$entradasRTA['titulo'].'</h2>';
				echo '<p class="col-sm-2 text-right fecha">'.$entradasRTA['fechaMostrar'].'</p>';
				echo '</div><hr />';
				$modulo[$tipo]->mostrar($src);
				echo '<p class="col-sm-10 col-sm-offset-1">'.$entradasRTA['comentario'].'</p>';
				/* SISTEMA COMENTARIOS
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

				echo'</ul>';*/
				echo '</li>';
			}
		}
		?>
		</ul>
	</div>
</div>
