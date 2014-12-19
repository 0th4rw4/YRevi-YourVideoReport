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
class image_jpeg{
	public function mostrar($src){
		global $urlArchivos; //Rquiere que se arme  antes de llamar la funcion
		global $confReport;

	$sourceHTML = '
		<p class="text-center">
		<img src="'.$urlArchivos.$src.'" />
		</p>
		<p class="text-center"><a href="'.$urlArchivos.$src.'">Descargar Imagen</a></p>
	';

		echo $sourceHTML;
	}
	public function insertar(){

	}
}
?>
