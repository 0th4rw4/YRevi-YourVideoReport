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

//Ingreso de clientes

$addClientes = isset($_POST['addClientes'])?$_POST['addClientes']:false;

$nombreClienteNuevo = isset($_POST['nombreClienteNuevo']) ? $_POST['nombreClienteNuevo']:false;
$emailClienteNuevo = isset($_POST['emailClienteNuevo'])? $_POST['emailClienteNuevo']:false;
$contraseniaNuevo = isset($_POST['contraseniaNuevo']) ? $_POST['contraseniaNuevo']:false;

if($addClientes):

foreach($emailClienteNuevo as $clave => $valor) :

  $emailClienteNuevo = isset($emailClienteNuevo[$clave])?mysqli_real_escape_string($cnx, $emailClienteNuevo[$clave]):false;
  $contraseniaNuevo = isset($contraseniaNuevo[$clave])?mysqli_real_escape_string($cnx, $contraseniaNuevo[$clave]):false;



if($addClientes == "true" && $emailClienteNuevo && $contraseniaNuevo){

  $insert = "INSERT INTO usuarios (usuario, contrasenia, nombre, id_nivel";

  $insert .= ")VALUES('$emailClienteNuevo', md5('$contraseniaNuevo'), NULL, 1";

  $insert .= " );";
  $query = mysqli_query($cnx, $insert);

  if($query) $_SESSION['error.addAdmin'] = 'Alta de Administrador Exitosa';
  else $_SESSION['error.addAdmin'] = 'Error al ingresar administrador';
}
elseif($addClientes == "true") $_SESSION['error.addAdmin'] = 'Faltan Datos';
else $_SESSION['error.addAdmin'] = false;
endforeach;
endif;
?>

<div class="container admin">
	<h2>Agregar Administradores</h2>
  <?php 
    if($_SESSION['error.addAdmin']) {
    echo '<div class="text-warning"><p class="bg-warning text-center">'.$_SESSION['error.addAdmin'].'</p></div>'; 
    $_SESSION['error.addAdmin'] = false ;
    } 
  ?>
    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="admin.addAdmin.php">
    	<input type="hidden" name="addClientes" value="true" />

<?php

$limit= 1;
for($i=0; $i<$limit; $i++) : 
?>

 <div class="form-group col-sm-12">
    <label for="emailClienteNuevo" class="col-sm-2 control-label">Nombre Usuario</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="emailClienteNuevo" placeholder="Usuario para Login" name="emailClienteNuevo[]" >
    </div>
    <label for="contraseniaNuevo" class="col-sm-2 control-label">Contrasenia Admin</label>
    <div class="col-sm-4">
       <input type="text" class="form-control" id="contraseniaNuevo" name="contraseniaNuevo[]" >
    </div>
  </div>
<?php endfor; ?>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Cargar Datos</button>
    </div>
  </div>
  </form>
</div> 
<?php include('../include/footer.php'); ?>