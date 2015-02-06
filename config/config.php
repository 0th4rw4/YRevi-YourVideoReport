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

$directorioReportes = 'upload/reportes'; //upload/reportes/cliente@empresa.com/2014/01/imagen.jpg
$directorioLogos = 'upload/logos'; 
$dirImgs = 'img';


//$root_url -> in conexion.php file
$title_default = 'Campañas YourVideoReport';
$own_name = 'YourVideoReport';
$logo_empresa = $root_url.'/'.$dirImgs.'/LogoEmpresa_0.png'; //Your Own Logo 
$logo_empresa2 = $root_url.'/'.$dirImgs.'/LogoEmpresa_1.png'; //Your Own Logo 



$confReport = array(
  "imgWidth" => '200px;',
  "imgHeight" => '200px;'
);

//Fecha para mostrar por Dafault
$now = array();
@ $now['year'] = (date("n") != 1) ? date("Y") : ( date("Y") -1 );
@ $now['month'] = (date("n") != 1) ? (date("n") - 1) : 12 ;
@ $now['day'] = 01;

//Listado de años para dar como opciones
$anio = array();
$anioNumero = 2013;
for($i = 0; $i < 10 ; $i++){
  array_push($anio, $anioNumero);
  $anioNumero++;
}

//Listado de meses para mostrar en español
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

?>