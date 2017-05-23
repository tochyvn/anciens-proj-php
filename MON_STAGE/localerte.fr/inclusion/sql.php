<?php
	require_once(PWD_INCLUSION.'mysql.php');
	require_once(PWD_INCLUSION.'mysqli.php');
	require_once(PWD_INCLUSION.'string.php');
	
	define('SQL_SERVEUR','localhost');
	define('SQL_UTILISATEUR','aicom');
	define('SQL_PASSE','fiVus19--2');
	define('SQL_BASE','localerte');
	
	define('SQL_DATETIME','Y-m-d H:i:s');
	define('_SQL_DATE','Y-m-d');
	
	class ld_sql extends ld_mysql
	{
		/*function ld_mysql()
		{
			if(floatval(phpversion())<5)
			{
				$func_get_args=func_get_args();
				call_user_func_array(array(&$this,'__construct'),$func_get_args);
			}
		}*/
		
		function __construct()
		{
		}
		
		/*function __destruct()
		{
		}*/
	}
	
	function sql_eviter_doublon_strrnd($nom_classe,$champ,$longueur,$mode,$inclusion=NULL,$parametre=NULL)
	{
		if($inclusion!==NULL)
			require_once($inclusion);
		eval('$classe=new '.$nom_classe.'('.(($parametre!==NULL)?($parametre):('')).');');
		do
		{
			eval('$classe->'.$champ.'=strrnd($longueur,$mode);');
		}
		while($classe->lire());
		eval('$resultat=$classe->'.$champ.';');
		return $resultat;
	}
?>
