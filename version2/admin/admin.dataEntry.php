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
/*
  Quiero un list para los diferentes tipos de datos a mostrar
*/
if(! ( $_SESSION['nivel']=='1' || $_SESSION['nivel']=='0' )  )
  header("Location: index.php");

//Validacion de datos
$addDatos = isset($_POST['addDatos'])?$_POST['addDatos']:false;

$id_Cliente = isset($_POST['emailCliente'])?mysqli_real_escape_string($cnx,$_POST['emailCliente']):false;
$tituloYoutube = isset($_POST['tituloYoutube'])?mysqli_real_escape_string($cnx,$_POST['tituloYoutube']):false;
$urlYoutube = $tituloYoutube && isset($_POST['urlYoutube'] )?mysqli_real_escape_string($cnx,$_POST['urlYoutube']):false;
$comentario = isset($_POST['comentario'] )?mysqli_real_escape_string($cnx,$_POST['comentario']):false;
$tituloArchivo = isset($_POST['tituloArchivo'])?mysqli_real_escape_string($cnx,$_POST['tituloArchivo']):false;
$archivo = $tituloArchivo && isset( $_FILES['archivo'] ) ? $_FILES['archivo']['tmp_name'] : false;
$nombreArchivo = $archivo ? urlencode( $_FILES['archivo']['name'] ) :false ;
$tipoArchivo = $archivo ? $_FILES['archivo']['type'] : false;

$fecha = $_POST['anio'].'-'.$_POST['mes'].'-'.$_POST['dia'];

$error = 0;
$crearArchivo = false;
//Entrada de datos

if($addDatos == "true"  && $fecha && $id_Cliente){
  if( $tituloYoutube && $urlYoutube) {//Ingresar URL Youtube

  $insert = "INSERT INTO entradas(fecha, id_cliente, titulo, url, file_type";
  if($comentario) $insert .= ",comentario";
  
  $insert .= ")VALUES('$fecha', '$id_Cliente', '$tituloYoutube', '$urlYoutube', 'video/youtube'";
  if($comentario) $insert .= ",'$comentario'";

  $insert .= " );";
  $query = mysqli_query($cnx, $insert);

  if($query) $_SESSION['error.addDatos'] = 'Datos Ingresados con exito!!';
  else $_SESSION['error.addDatos'] = 'Error al insertar datos';
  }
  else $error++;

  if( $tituloArchivo && $nombreArchivo ) {//Ingresar Archivos

  $insert = "INSERT INTO entradas(fecha, id_cliente, titulo, url, file_type";
  if($comentario) $insert .= ",comentario";
  
  $insert .= ")VALUES('$fecha', '$id_Cliente', '$tituloArchivo', '$nombreArchivo', '$tipoArchivo' ";
  if($comentario) $insert .= ",'$comentario'";

  $insert .= " );";
  $query = mysqli_query($cnx, $insert);

  if($query) {
    $_SESSION['error.addDatos'] = 'Datos Ingresados con exito!!';
    $crearArchivo = true;
  }
  else $_SESSION['error.addDatos'] = 'Error al insertar datos';
  }
  else $error++;


  if($crearArchivo){

  	$select2 = "SELECT usuario, id FROM usuarios WHERE id = '$id_Cliente';";
  	$query2 = mysqli_query($cnx, $select2);

  	while($userCliente = mysqli_fetch_assoc($query2)){
  		$directorio = '../'.$directorioReportes.'/'.$userCliente['usuario'].'/'.$fecha;
	}
  	@ mkdir($directorio, 0775);

  	if( ! copy($archivo, $directorio.'/'.$nombreArchivo) ) 
  		echo 'el archivo ya existe';
  }

  
  if($error > 1) $_SESSION['error.addDatos'] = 'Faltan Datos';
}
elseif($addDatos == "true") $_SESSION['error.addDatos'] = 'Faltan Datos';
else $_SESSION['error.addDatos'] = false;

//Codigo para la interfaz grafica

$id_Cliente = array();

$qClientes = "SELECT 
  id, 
  usuario, 
  id_nivel, 
  nombre,
  DATE_FORMAT(NOW(), '%Y') as anioNow,
  DATE_FORMAT(NOW(), '%c') as mesNow,
  DATE_FORMAT(NOW(), '%d') as diaNow
FROM usuarios WHERE id_nivel = 2 AND state = 1 ORDER BY id;";
$queryClientes = mysqli_query($cnx, $qClientes);

?>

<div class="container admin">
    <h2>Carga de Reportes</h2>

  <?php 
    if($_SESSION['error.addDatos']) {
    echo '<div class="text-warning"><p class="bg-warning text-center">'.$_SESSION['error.addDatos'].'</p></div>'; 
    $_SESSION['error.addDatos'] = false ;
    } 
  ?>

      <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="index.php">
      <input type="hidden" name="addDatos" value="true" />
  <div class="form-group">
    <label for="emailCliente" class="col-sm-2 control-label">URL Cliente</label>
    <div class="col-sm-10">
      <select id="emailCliente" name="emailCliente" class="form-control">
        <?php 
          while($clienteRTA=mysqli_fetch_assoc($queryClientes)){
            $anioNow = $clienteRTA['anioNow'];
            $mesNow = $clienteRTA['mesNow'];
            $diaNow = $clienteRTA['diaNow'];
            echo '<option value="'.$clienteRTA['id'].'">'.$clienteRTA['nombre'].' - '.$clienteRTA['usuario'].'</option>';
          }
        ?>
      </select>
    </div>
  </div>

    <div class="form-group">
   <label class="col-sm-2 col-sm-offset-2 control-label">Fecha</label>
    <div class="col-sm-4">
       <select id="mes" name="mes" class="col-sm-6">
        <?php 
          foreach($calendario as $numMes => $mes){
            if ($numMes == $mesNow)
              echo '<option selected="selected" value="'.$numMes.'">'.$mes.'</option>';
            else
              echo '<option value="'.$numMes.'">'.$mes.'</option>';
          }
        ?>
      </select>
      <select id="anio" name="anio" class="col-sm-6">
        <?php
          foreach($anio as $anioCada){
            if ($anioCada == $anioNow)
              echo '<option selected="selected" value="'.$anioNow.'">'.$anioNow.'</option>';
            else
              echo '<option value="'.$anioCada.'">'.$anioCada.'</option>';
          }
        ?>
      </select>
      <input type="hidden" name="dia" value="01">
    </div>
  </div>

  <div class="form-group">
    <label for="tituloYoutube" class="col-sm-2 control-label">Titulo Video Youtube</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="tituloYoutube" placeholder="Titulo" name="tituloYoutube" value="<?php echo $tituloYoutube ?>">
    </div>

     <label for="urlYoutube" class="col-sm-2 control-label">URL</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="urlYoutube" placeholder="URL" name="urlYoutube" value="<?php echo $urlYoutube ?>">
    </div>
  </div>

<?php /*

  <div class="form-group">
    <p class="col-sm-12 text-center">Opcional 2</p>
    <label for="tituloArchivo" class="col-sm-2 control-label">Titulo Archivo</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="tituloArchivo" placeholder="Titulo" name="tituloArchivo"  value="<?php echo $tituloArchivo ?>">
    </div>

    <div class="col-sm-4">
      <input type="file"  id="archivo" name="archivo">
      <p class="help-block">No metan virus, esto lo va a descargar el cliente en forma directa</p>
    </div>
  </div>
*/?>
  <div class="form-group">
    <p class="col-sm-12 text-center">Opcional</p>
    <label for="comentario" class="col-sm-2 control-label">Comentario</label>
    <div class="col-sm-10">
    	<textarea class="form-control" rows="3" id="comentario" name="comentario" placeholder="Comentario que acompaña el archivo"></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Cargar Datos</button>
    </div>
  </div>
</form>
</div>

<script type="text/javascript">
/*
  $("form").submit( function(event){
    event.preventDefault();
    var addDatos = $("#addDatos").value;
    var emailCliente= $("#emailCliente").value;
    var tituloYoutube = $("#tituloYoutube").value;
    var urlYoutube = $("#urlYoutube").value;
    var comentario = $("#comentario").value;

    $.ajax({
      type:"POST",
      url:"index.php",
      data:"addDatos="+addDatos+"&emailCliente="+emailCliente+"&tituloYoutube="+tituloYoutube+"&urlYoutube="+urlYoutube+"&comentario="+comentario,
      async:false,
      success: function( datos ){
        alert(datos);
      }
    });
  });
  */
  
</script>