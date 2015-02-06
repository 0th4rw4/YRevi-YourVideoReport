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
include_once('cliente.header.php');
if(! isset($_SESSION['nivel'])  )
  header("Location: index.php");

$error = array();

$nombre = !empty($_POST['nombre']) ? mysqli_real_escape_string($cnx,$_POST['nombre']) : $error['nombre'] = false;
//$email = !empty($_POST['email']) ? mysqli_real_escape_string($cnx,$_POST['email']) : $error['email'] = false;
//$cargo = !empty($_POST['cargo']) ? mysqli_real_escape_string($cnx,$_POST['cargo']) : $error['cargo'] = false;
$sugerencia = !empty($_POST['sugerencia']) ? mysqli_real_escape_string($cnx,$_POST['sugerencia']) : $error['sugerencia'] = false;
$usuarioCliente = !empty($_POST['usuarioCliente']) ? mysqli_real_escape_string($cnx,$_POST['usuarioCliente']) : $error['usuarioCliente'] = false;

if( count($error) <= 0 ){
	$sugerenciaInsert = "INSERT INTO sugerencias
	(nombre, email, cargo, sugerencia, cliente, fecha) VALUES
	('$nombre', NULL, NULL, '$sugerencia', '$usuarioCliente', NOW() ); ";

	$sugerenciaQuery = mysqli_query($cnx, $sugerenciaInsert);
	if(!$sugerenciaQuery) $error['mysql'] = false;
	else $error['exito'] = true;
}

if(!isset($_POST['errores'])) $error = false;
?>

<div class="container cliente">
<p class="sugerenciasTexto col-sm-12 text-center font-light">¿Nuestro servicio no es perfecto? Valoramos su ayuda para mejorar </p>
<form class="form-horizontal col-sm-6 col-sm-offset-3" role="form" name="sugerencias" id="sugerencias" method="post" action="cliente.libroSugerencias.php">
	<input type="hidden" name="usuarioCliente" value="<?php echo $_SESSION['login']; ?>" />
  <input type="hidden" name="errores" value="true" />
	<div class="form-group">
		<label for="nombre" class="col-sm-12">Nombre</label>
    	<div class="col-sm-12">
    		<input type="text" class="form-control" id="nombre" name="nombre" placeholder="¿Cual es su Nombre?" />
	    </div>
  	</div>
	<div class="form-group">
		<label for="sugerencia" class="col-sm-12">Sugerencia</label>
    	<div class="col-sm-12">
	    	<textarea class="form-control" rows="6" id="sugerencia" name="sugerencia" placeholder="Dejenos un comentario sobre el servicio que recibe en Punto Rojo"></textarea>
	    </div>
  	</div>
   <div class="form-group">
    	<div class="col-sm-12">
      		<button type="submit" class="btn btn-default" data-target="#modal">Enviar</button>
    	</div>
   </div>
   <div class="error">
   <?php
  if($error){
   	echo '<div class="text-warning"><p class="bg-warning text-center">';
   		foreach($error as $campo => $valor){
			if(!$valor) echo 'Falta el campo '.$campo.'<br/>';
			if($campo == "exito") echo 'Sugerencia recibida. Muchas gracias';
		}
	   echo '</p></div>';
    }
	?>
   </div>
</form>
</div>

<?php /*
<script type="text/javascript">

	 $("form").submit( function(event){
    event.preventDefault();

    var nombre = $("#nombre").value;
    //var email= $("#email").value;
    //var cargo = $("#cargo").value;
    var sugerencia = $("#sugerencia").value;
    var usuarioCliente = $("#usuarioCliente").value;

    $.ajax({
      type:"POST",
      url:"ajax.sugerencias.php",
      data:"nombre="+nombre+"&sugerencia="+sugerencia+"&usuarioCliente="+usuarioCliente,
      async:false,
      success: function( datos ){
        $("#nombre").css("background-color","none");
        $("#sugerencia").css("background-color","none");

        var datosOjb = JSON.parse(datos);
        for(var i in datosOjb ){
          if(datosOjb[i] == false) $("#"+i).css("background-color","rgba(255,0,0,0.1)");
          
          if(datosOjb[i] == true) $("#"+i).css("background-color","rgba(0,255,0,0.1)");
        }
          //errno
       //$("#error").
       
      }
    });
  });

</script>
<?php */
include_once('../include/footer.php');
?>