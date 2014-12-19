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

if(isset($_GET['activar']) || isset($_GET['inactivar'])){
	$idCliente = isset( $_GET['activar'] ) ? mysqli_real_escape_string($cnx,$_GET['activar']) : mysqli_real_escape_string($cnx,$_GET['inactivar']);
	$estado = isset( $_GET['activar'] ) ? 1 : 0 ;
	$qUpdate = "UPDATE usuarios SET state = '$estado' WHERE id = '$idCliente' ;";

	$queryUpdate = mysqli_query($cnx, $qUpdate);
	//if($queryUpdate) header("Location: $_SERVER[HTTP_HOST]/$_SERVER[SCRIPT_NAME]");
}

$qClientes = "SELECT id, usuario, nombre, logo, state, id_nivel
FROM usuarios WHERE id_nivel = '2' ORDER BY id;";
$queryClientes = mysqli_query($cnx, $qClientes);

?>
<div class="container admin">
<div class="text-center col-sm-12">
	<ul class="list-inline" id="nav">
		<li><a href="#" >Activos</a></li>
		<li><a href="#" >Suspendidos</a></li>
		<li><a href="#" >Todos</a></li>
	</ul>
	<table class="table actualizar show" id="activos">
		<thead>
			<tr>
				<th>Id</th>
				<th>Logo</th>
				<th>Nombre</th>
				<th>Usuario</th>
				<th>Estado</th>
				<th>Editar</th>
				
			</tr>
		</thead>
		<tbody>
		<?php 
		while($rtaClientes=mysqli_fetch_assoc($queryClientes)): 
			if( $rtaClientes['state'] == '1' ):
				echo "
			<tr id=\"$rtaClientes[id]\">
					<td> $rtaClientes[id]</td>
					<td><img src=\"../upload/logos/$rtaClientes[logo]\" alt=\"$rtaClientes[nombre]\"</td>
					<td> $rtaClientes[nombre]</td>
					<td> $rtaClientes[usuario]</td>";
			if($rtaClientes['state'] == '1')
		  		echo "<td><p class=\"bg-warning status\">Activo</p></td>";
			else 
		  		echo "<td><p class=\"bg-success status\">Inactivo</p></td>";
			?>
					<td><a class="glyphicon glyphicon-cog">.</a></td>
			</tr>
			<tr id="form" class="hidden">
			<form action="#" method="post">
				<td></td>
				<td><input type="text" name="logo" value=""/></td>
				<td><input type="text" name="nombre" value=""/></td>
				<td><input type="text" name="Usuario" value=""/></td>
			<?php 
			if($rtaClientes['state'] == '1')
				echo "<td><a href=\"$_SERVER[SCRIPT_NAME]?inactivar=$rtaClientes[id]\" class=\"btn btn-info\" >Suspender</a></td>";
			else 
				echo "<td><a href=\"$_SERVER[SCRIPT_NAME]?activar=$rtaClientes[id]\" class=\"btn btn-info\">Activar</a></td>";
			?>
			</form>
			</tr>
			<?php endif; ?>
		<?php endwhile; ?>
		</tbody>
	</table>



	<table class="table actualizar show" id="suspendidos">
		<thead>
			<tr>
				<th>Id</th>
				<th>Logo</th>
				<th>Nombre</th>
				<th>Usuario</th>
				<th>Estado</th>
				<th>Editar</th>
			</tr>
		</thead>
		<tbody>
		<?php
		mysqli_data_seek($queryClientes,0);
		while($rtaClientes=mysqli_fetch_assoc($queryClientes)): 
			if( $rtaClientes['state'] == '0'):
			echo "
			<tr id=\"$rtaClientes[id]\">
					<td> $rtaClientes[id]</td>
					<td><img src=\"../upload/logos/$rtaClientes[logo]\" alt=\"$rtaClientes[nombre]\"</td>
					<td> $rtaClientes[nombre]</td>
					<td> $rtaClientes[usuario]</td>";
			if($rtaClientes['state'] == '1')
		  		echo "<td><p class=\"bg-warning status\">Activo</p></td>";
			else 
		  		echo "<td><p class=\"bg-success status\">Inactivo</p></td>";
			?>
					<td><a class="glyphicon glyphicon-cog">.</a></td>
			</tr>
			<tr id="form" class="show">
			<form action="#" method="post">
				<td></td>
				<td><input type="text" name="logo" value=""/></td>
				<td><input type="text" name="nombre" value=""/></td>
				<td><input type="text" name="Usuario" value=""/></td>
			<?php 
			if($rtaClientes['state'] == '1')
				echo "<td><a href=\"$_SERVER[SCRIPT_NAME]?inactivar=$rtaClientes[id]\" class=\"btn btn-info\" >Suspender</a></td>";
			else 
				echo "<td><a href=\"$_SERVER[SCRIPT_NAME]?activar=$rtaClientes[id]\" class=\"btn btn-info\">Activar</a></td>";
			?>
			</form>
			</tr>
			<?php endif; ?>
		<?php endwhile; ?>
		</tbody>
	</table>

</div>
</div>
<?php
include_once('../include/footer.php');
?>

<script type="text/javascript">
	

	/*
	Para Ajax recivir realizar la accion y responder (idCliente:2, logo: false, nombre: false, usuario: false, estado: suspendido);
	y cambiar los datos en funcion de los esos datos recividos

	$("table tr#".idCliente);
	*/
	var filas = $("table tbody tr");
	for(i=0 ; i< filas.length; i++){
		fila = filas[i];

		idCliente = fila.getAttribute("id");
		if( !(idCliente == "form") ){
			var btnEditar = fila.children[5].childNodes[0];
			btnEditar.innerHTML = "";
			clickFuncion = function(){
					form = this.parentNode.parentNode;
					alert(form);
					form.setAttribute("class","show");
				}
			btnEditar.onclick = clickFuncion;
		}
	}

	var contenedor = $("div.admin > div");
	var activos = $("#activos");
	var suspendidos = $("#suspendidos");
	suspendidos.remove();
	
	var nav = $("#nav > li");
	a0 = nav[0].children[0];
	a0.onclick = function(){
		suspendidos.remove();
		activos.remove();
		contenedor.append(activos);
	};
	a1 = nav[1].children[0];
	a1.onclick = function(){
		suspendidos.remove();
		activos.remove();
		contenedor.append(suspendidos);
	};
	a2 = nav[2].children[0];
	a2.onclick = function(){
		suspendidos.remove();
		activos.remove();
		contenedor.append(activos);
		contenedor.append(suspendidos);
	};
</script>