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
class video_youtube{
	public function mostrar($src){
		/*URL estandar copiada y pegada 
		https://www.youtube.com/watch?v=Fu2DcHzokew&giladas=true
		
		URL compuesta como deve ser insertada
		//www.youtube.com/embed/Fu2DcHzokew?rel=0
		*/

		$idVideo = explode('v=',$src);
		$idVideo = explode('&',$idVideo[1]);
		$srcVideo = '//www.youtube.com/embed/'.$idVideo[0].'?rel=0';
		
	$sourceHTML = '
		<iframe width="640" height="480" src="'.$srcVideo.'?rel=0" frameborder="0" allowfullscreen></iframe>
	';
		
	/*$sourceHTML = '
	<object width="560" height="315">
			<param name="movie" value="'.$srcVideo.'?hl=es_MX&amp;version=3&amp;rel=0"></param>
			<param name="allowFullScreen" value="true"></param>
			<param name="allowscriptaccess" value="always"></param>
			<embed src="'.$srcVideo.'?hl=es_MX&amp;version=3&amp;rel=0" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed>
		</object>
	';*/

	echo $sourceHTML;
	}

	public function insertar($src){

	}
}
?>
