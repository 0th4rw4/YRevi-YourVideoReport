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
ini_set('display_errors', 1 );
//$cnx = mysqli_connect('localhost','cz000045_badmin','s4r4c4tung413X','cz000045_seguimiento');
$cnx = mysqli_connect('localhost','root','PuntoRojo1970','puntoRojo');
@ session_start();
if(! isset($_SESSION['login']) && $loop!=true)
  header("Location: http://localhost/proyectos/puntoRojo/administracionPuntoRojo/version2/index.php?loop=true");

if($loop!=true){
$url = 'http://localhost/proyectos/puntoRojo/administracionPuntoRojo/version2/';
include('../modulos/index.php');
$directorioReportes = 'upload/reportes'; //upload/reportes/cliente@empresa.com/2014/01/imagen.jpg
$directorioLogos = 'upload/logos';
$dirImgs = 'img';
$confReport = array(
  "imgWidth" => '200px;',
  "imgHeight" => '200px;'
);
$calendario = array ( 
  1 => 'Enero',
  2 => 'Febrero',
  3 => 'Marzo',
  4 => 'Abril',
  5 => 'Mayo',
  6 => 'Junio',
  7 => 'Julio',
  8 => 'Agosto',
  9 => 'Septiembre',
  10 => 'Octubre',
  11 => 'Noviembre',
  12 => 'Diciembre'
  );
$now = array();
@ $now['year'] = (date("n") != 1) ? date("Y") : ( date("Y") -1 );
@ $now['month'] = (date("n") != 1) ? (date("n") - 1) : 12 ;
@ $now['day'] = 01;

$anio = array();
$anioNumero = 2010;
for($i = 0; $i < 30 ; $i++){
  array_push($anio, $anioNumero);
  $anioNumero++;
}
}
?>