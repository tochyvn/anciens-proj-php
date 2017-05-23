<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	$define_erreur=0;
	
	define('ADHERENT_ANNONCE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_adherent_annonce extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_adherent_annonce()
		{
			if(floatval(phpversion())<5)
			{
				$func_get_args=func_get_args();
				call_user_func_array(array(&$this,'__construct'),$func_get_args);
				foreach($this->champs as $clef=>$valeur)
					$this->{$clef}=&$this->champs[$clef];
			}
		}*/
		
		function __construct()
		{
			$this->champs=array();
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=ADHERENT_ANNONCE_TOTAL_ERREUR;

		}
		
		/*function __destruct()
		{
			$this->fermer();
		}*/
		
		function __get($variable)
		{
			if(array_key_exists($variable,$this->champs))
				return $this->champs[$variable];
			else
			{
				trigger_error('Variable '.$variable.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		function __set($variable,$valeur)
		{
			if(array_key_exists($variable,$this->champs))
			{
				if(1)
					$this->champs[$variable]=$valeur;
				else
				{
					trigger_error('Variable '.$variable.' non modifiable'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
				}
			}
			else
			{
				trigger_error('Variable '.$variable.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		public function enregistrer($adherent,$annonce)
		{
			$this->executer
			('
				insert ignore into adherent_annonce
				values
				(\''.addslashes($adherent).'\', \''.implode('\', \''.addslashes(date(SQL_DATETIME)).'\'), (\''.addslashes($adherent).'\', \'',array_map('addslashes',$annonce)).'\', \''.addslashes(date(SQL_DATETIME)).'\')
				on duplicate key update lu=\''.addslashes(date(SQL_DATETIME)).'\'
			');
			
			return true;
		}
	}
?>