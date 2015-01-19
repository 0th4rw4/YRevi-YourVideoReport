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
$usuarioClienteNuevo = isset($_POST['usuarioClienteNuevo'])? $_POST['usuarioClienteNuevo']:false;
$contraseniaNuevo = isset($_POST['contraseniaNuevo']) ? $_POST['contraseniaNuevo']:false;
$logoClienteArray = isset($_FILES['logoCliente']) ? $_FILES['logoCliente'] : false;

if($addClientes):

foreach($usuarioClienteNuevo as $clave => $valor) :

  $nombreClienteNuevo = isset($nombreClienteNuevo[$clave])? mysqli_real_escape_string($cnx, $nombreClienteNuevo[$clave]):false;
  $usuarioClienteNuevo = isset($usuarioClienteNuevo[$clave])?mysqli_real_escape_string($cnx, $usuarioClienteNuevo[$clave]):false;
  $contraseniaNuevo = isset($contraseniaNuevo[$clave])?mysqli_real_escape_string($cnx, $contraseniaNuevo[$clave]):false;
  $logoCliente = isset($logoClienteArray['tmp_name'][$clave]) ? $logoClienteArray['tmp_name'][$clave] :false;
  $logoClienteNombreArchivo = isset($logoCliente) ? urlencode($logoClienteArray['name'][$clave]) :false ;



if($addClientes == "true" && $usuarioClienteNuevo && $nombreClienteNuevo && $logoCliente ){
  if(!$contraseniaNuevo) $contraseniaNuevo = $usuarioClienteNuevo.'5546';

  $insert = "INSERT INTO usuarios (usuario, contrasenia, nombre, logo ";
  $insert .= ")VALUES('$usuarioClienteNuevo', '$contraseniaNuevo', '$nombreClienteNuevo','$logoClienteNombreArchivo'";
  $insert .= " );";
  
  $query = mysqli_query($cnx, $insert);

  if($query) $_SESSION['error.addUser'] = 'Usuarios cargados con exito';
  else $_SESSION['error.addUser'] = 'Error al insertar usuarios';

  $dir = '../'.$directorioReportes.'/'.$usuarioClienteNuevo;
  mkdir($dir, 0775);
  copy($logoCliente, '../'.$directorioLogos.'/'.$logoClienteNombreArchivo);
}
elseif($addClientes == "true") $_SESSION['error.addUser'] = 'Faltan Datos';
else $_SESSION['error.addUser'] = false;

endforeach;
endif;
?>

<div class="container admin">
	<h2>Alta clientes</h2>
  <p class="help-block"> Todos los campos son obligatorios</p>
  <?php 
    if($_SESSION['error.addUser']) {
    echo '<div class="text-warning"><p class="bg-warning text-center">'.$_SESSION['error.addUser'].'</p></div>'; 
    $_SESSION['error.addUser'] = false ;
    } 
  ?>
    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="admin.addUser.php">
    	<input type="hidden" name="addClientes" value="true" />

 <div class="form-group">
    <label for="nombreClienteNuevo" class="col-sm-2 control-label">Nombre Cliente</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="nombreClienteNuevo" placeholder="Cliente" name="nombreClienteNuevo[]" >
    </div>

     <label for="usuarioClienteNuevo" class="col-sm-2 control-label">URL Dominio Cliente</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="usuarioClienteNuevo" placeholder="Ej: puntorojomarketing.com" name="usuarioClienteNuevo[]" >
    </div>
  </div>


 <div class="form-group">
     <div class="col-sm-6">
      <label for="contraseniaNuevo" class="col-sm-4 control-label">Contraseña Cliente</label>
     <div class="col-sm-8">
      <input type="text" class="form-control" id="contraseniaNuevo" name="contraseniaNuevo[]" >
    </div>
    <p class="help-block col-sm-8 col-sm-offset-4">Default url+5546 ej: puntorojomarketing.com5546</p>
    </div>
     
     <div class="col-sm-6 ">
      <label for="tituloArchivo" class="col-sm-3 control-label">Logo Cliente</label>
      <input type="file"  id="logoCliente" name="logoCliente[]" class="col-sm-9" />
      <p class="help-block col-sm-12 text-center">Logo preferiblemente con transparencias en PNG</p>
    </div>
  </div>


 


  <div class="form-group">
    <div class="col-sm-2 col-sm-offset-5">
      <button type="submit" class="btn btn-default">Cargar Cliente</button>
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
    div.listUser tbody tr td.changeStatus a {
      display: inline-block; 
      padding: 0.5em 1em; 
      border-radius: 3px; 
      color: white;
    }
    /*div.listUser tbody tr td.changeStatus a:hover { background-color: grey;}*/

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
$qClientes = "SELECT * FROM usuarios WHERE id_nivel = 2 ORDER BY id ASC;";
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
          <th>Logo</th>
          <th>Cliente</th>
          <th>Dominio</th>
          <th>Status</th>
          <th>Cambiar Clave</th>
        </tr>
      </thead>
        <tbody>
        <?php 
        while( $clientesRTA = mysqli_fetch_assoc($queryClientes) ){
          if($clientesRTA['state'] == 1):
        $imagenUsuario = '../upload/logos/'.$clientesRTA['logo'];
        echo "<tr data-role=\"$clientesRTA[id]\">
            <td data-role=\"changeLogo\" ><a href=\"#\" ><img src=\"$imagenUsuario\" alt=\"logo\"  /></a></td>
            <td data-role=\"changeName\" ><a href=\"#\">$clientesRTA[nombre]</a></td>
            <td data-role=\"changeUrl\" ><a href=\"#\">$clientesRTA[usuario]</a></td>
            <td data-role=\"changeStatus\" class=\"changeStatus\"><a href=\"#\" class=\"activo\" data-role=\"$clientesRTA[state]\">Activo</a></td>
            <td data-role=\"changePassword\"><a href=\"#\" title=\"$clientesRTA[contrasenia]\">*********</a></td>
          </tr>";
          endif;
          }
        ?>
        </tbody>
      </table>
    </div>

    <div id="userInactivos" class="listUser table-responsive">
      <table class="table table-striped table-hover "> 
      <thead>
        <tr>
          <th>Logo</th>
          <th>Cliente</th>
          <th>Dominio</th>
          <th>Status</th>
          <th>Cambiar Clave</th>
        </tr>
      </thead>
        <tbody>
         <?php 
         $queryClientes = mysqli_query($cnx, $qClientes);
        while( $clientesRTA = mysqli_fetch_assoc($queryClientes) ){
          if($clientesRTA['state'] == 2):
        $imagenUsuario = '../upload/logos/'.$clientesRTA['logo'];
        echo "<tr data-role=\"$clientesRTA[id]\">
            <td data-role=\"changeLogo\" ><a href=\"#\" ><img src=\"$imagenUsuario\" alt=\"logo\"  /></a></td>
            <td data-role=\"changeName\" ><a href=\"#\">$clientesRTA[nombre]</a></td>
            <td data-role=\"changeUrl\" ><a href=\"#\">$clientesRTA[usuario]</a></td>
            <td data-role=\"changeStatus\" class=\"changeStatus\"><a href=\"#\" class=\"inactivo\" data-role=\"$clientesRTA[state]\">Inactivo</a></td>
            <td data-role=\"changePassword\"><a href=\"#\" title=\"$clientesRTA[contrasenia]\">*********</a></td>
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