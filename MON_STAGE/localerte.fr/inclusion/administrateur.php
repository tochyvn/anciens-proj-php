<?php
	define('ADMINISTRATEUR_PSEUDONYME_DEFAUT',NULL);
	define('ADMINISTRATEUR_PASSE_DEFAUT',NULL);
	
	class ld_administrateur
	{
		private /*var*/ $champs;
		
		/*function ld_administrateur()
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
			$this->champs['pseudonyme']=ADMINISTRATEUR_PSEUDONYME_DEFAUT;
			$this->champs['passe']=ADMINISTRATEUR_PASSE_DEFAUT;
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
		
		public function lire()
		{
			if(($this->champs['pseudonyme']!='cron' || $this->champs['passe']!='fiVus19--2') && ($this->champs['pseudonyme']!='assistant' || $this->champs['passe']!='6A8fiY6p') && ($this->champs['pseudonyme']!='aicom' || $this->champs['passe']!='fiVus19--2'))
			//if(($this->champs['pseudonyme']!='aicom' || $this->champs['passe']!='rote15/-2') && ($this->champs['pseudonyme']!='lingoustes' || $this->champs['passe']!='cfte/*54'))
				return false;
			return true;
		}
		
		public function autoriser($uri)
		{
			$tableau['cron']=NULL;
			$tableau['aicom']=NULL;
			$tableau['assistant']=array(
				'/administration/preference.php'
			);
			if($tableau[$this->champs['pseudonyme']]==NULL || array_search($_SERVER['PHP_SELF'],$tableau[$this->champs['pseudonyme']])===false)
			//if(strpos($uri,URL_ADMINISTRATION.'index.php')===0 || strpos($uri,URL_ADMINISTRATION.'administrateur_identification.php')===0 || $this->champs['pseudonyme']=='aicom' || ($this->champs['pseudonyme']=='lingoustes' && strpos($uri,URL_ADMINISTRATION.'statistiques.php')===0))
				return true;
			return false;
		}
	}
?>