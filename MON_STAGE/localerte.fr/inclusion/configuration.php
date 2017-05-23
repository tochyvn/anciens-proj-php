<?php
	function moteur_de_recherche($chemin)
	{
		if(!isset($_SERVER['HTTP_USER_AGENT']) || preg_match('/(MSIE|Netscape|Opera|Firefox|Safari|Wanadoo|Firebird|Konqueror)/i',$_SERVER['HTTP_USER_AGENT']))
			return false;
		if(func_num_args() && func_get_arg(0))
		{
			$fichier=@fopen($chemin,'a');
			@fwrite($fichier,date('d/m/Y H:i:s',time()).'	'.$_SERVER['HTTP_USER_AGENT'].'	'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\r\n");
			@fclose($fichier);
		}
		return true;
	}
?>