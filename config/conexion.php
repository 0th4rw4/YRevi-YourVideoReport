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
ini_set('display_errors', 0 );

$cnx = mysqli_connect('localhost','USERNAME','PASSWORD','YRevi');

@ session_start();

$root_url = 'http://yrevi.local';


if(! isset($_SESSION['login']) && $loop!=true)
  header("Location: $root_url/index.php?loop=true");

if($loop!=true){
  $url = $root_url;
  include('../modulos/index.php');
  include('config.php');
}
?>