<?php
	function duree($nombre,$chaine='%jj %hh %mm %ss',$mode='s')
	{
		switch($mode)
		{
			case 's':
				$seconde=$nombre%60;
				$chaine=str_replace('%s',$seconde,$chaine);
				$nombre=floor($nombre/60);
				$minute=$nombre%60;
				$chaine=str_replace('%m',$minute,$chaine);
				$nombre=floor($nombre/60);
				$heure=$nombre%24;
				$chaine=str_replace('%h',$heure,$chaine);
				$nombre=floor($nombre/24);
				$jour=$nombre;
				$chaine=str_replace('%j',$jour,$chaine);
				return $chaine;
				break;
		}
	}
?>