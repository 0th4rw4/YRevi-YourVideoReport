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


<style type="text/css">
    .panel{
      padding: 40px;
    }
    div.listUser {
      height: auto;
      min-height: 200px;
      overflow: none;
      margin-bottom: 40px;
    }
    div.listUser tbody tr td img {
      max-height: 60px;
    }

    div.listUser tbody tr td a.activo {  background-color: green; }
    div.listUser tbody tr td a.inactivo {  background-color: red; }
    div.admin span#refereshActivos {}

    .row.panel,
    .row.panel:before,
    .row.panel:after {
      position: relative;
      clear: both;
      content: "";
    }
    .panel h2 {
      display: inline-block;
      opacity: 0.6;
      color: #222222;
      font-size: 1.9em;
      border-bottom: 3px solid transparent;
      margin-right: 10px; 

      transition-delay: 0s;
      transition-duration: 0.2s;
      transition-property: all;
      transition-timing-function: ease;
    }
    .panel h2.active,
    .panel h2:hover {
      opacity: 1;
      color: #333333;
    }
    .panel h2.active {
      font-size: 2.3em;
    }
    .panel h2:hover {
      border-bottom: 3px solid red;
    }

    .panel div.listUser {
      display: none;
    }
    .panel div.active {
      display: block;
    }

  </style>
<?php
$qClientes = "SELECT * FROM usuarios WHERE id_nivel = 1 ORDER BY id ASC;";
$queryClientes = mysqli_query($cnx, $qClientes);
?>
  <div class="row panel" id="panel">

    <h2 class="active">Activos</h2>
    <h2>Inactivos</h2>
    <p class="help-block"> Clickear sobre el campo para cambiar</p>

    <div id="userActivos" class="listUser table-responsive active">
      <table class="table table-striped table-hover "> 
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Status</th>
          <th>Cambiar Clave</th>
        </tr>
      </thead>
        <tbody>
        <?php 
        while( $clientesRTA = mysqli_fetch_assoc($queryClientes) ){
          if($clientesRTA['state'] == 1):
            $state_ = 2;
            $imagenUsuario = '../upload/logos/'.$clientesRTA['logo'];
            echo "<tr data-role=\"$clientesRTA[id]\">
                <td width=\"60%\" data-role=\"changeUrl\" ><a href=\"#\">$clientesRTA[usuario]</a></td>
                <td width=\"200\" data-role=\"changeStatus\" class=\"changeStatus\">
                  <a href=\"#\" class=\"activo\" data-role=\"$state_\">Activo</a>
                </td>
                <td data-role=\"changePassword\"><a href=\"#\" title=\"$clientesRTA[contrasenia]\"> ******** </a></td>
              </tr>";
          endif;
          }
        ?>
        </tbody>
      </table>
    </div>

    <div id="userInactivos" class="listUser table-responsive">
      <p style=" background: red; border-radius: 6px; border: 1px solid black; display: inline-block; color: white; padding: 5px; "> Cuidado, la X elimina </p>
      <table class="table table-striped table-hover "> 
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Status</th>
          <th>Cambiar Clave</th>
        </tr>
      </thead>
        <tbody>
         <?php 
         $queryClientes = mysqli_query($cnx, $qClientes);
        while( $clientesRTA = mysqli_fetch_assoc($queryClientes) ){
          if($clientesRTA['state'] == 2):
            $state_ = 1;
            $imagenUsuario = '../upload/logos/'.$clientesRTA['logo'];
            echo "<tr data-role=\"$clientesRTA[id]\">
                <td width=\"60%\" data-role=\"changeUrl\" ><a href=\"#\">$clientesRTA[usuario]</a></td>
                <td width=\"200\" data-role=\"changeStatus\" class=\"changeStatus\">
                  <a href=\"#\" class=\"inactivo\" data-role=\"$state_\">Inactivo</a>
                  <a href=\"#\" class=\"close\" data-role=\"delete\" >&times;</a>
                </td>
                <td data-role=\"changePassword\"><a href=\"#\" title=\"$clientesRTA[contrasenia]\"> ******** </a></td>
              </tr>";
          endif;
          }
        ?>
        </tbody>
      </table>
    </div>
  </div> <!-- ./row -->
</div> 
<script type="text/javascript">
  panel = document.getElementById('panel');

  //userActivos
  panel.getElementsByTagName('h2')[0].onclick = function(){
    this.classList.add('active');

    panel = document.getElementById('panel');
    h2 = panel.getElementsByTagName('h2')[1]
    h2.classList.remove('active');

    document.getElementById('userActivos').classList.add('active');
    document.getElementById('userInactivos').classList.remove('active');
  };

  //userInactivos
  panel.getElementsByTagName('h2')[1].onclick = function(){
    this.classList.add('active')

    panel = document.getElementById('panel');
    h2 = panel.getElementsByTagName('h2')[0];
    h2.classList.remove('active');

    document.getElementById('userActivos').classList.remove('active');
    document.getElementById('userInactivos').classList.add('active');
  };

</script>
<?php include('../include/footer.php'); ?>