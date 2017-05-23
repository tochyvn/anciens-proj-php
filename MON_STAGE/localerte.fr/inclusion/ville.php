<?php
	require_once(PWD_INCLUSION.'sql.php');
	
	define('VILLE_IDENTIFIANT_DEFAUT',NULL);
	define('VILLE_DEPARTEMENT_DEFAUT',NULL);
	define('VILLE_NOM_DEFAUT',NULL);
	define('VILLE_CODE_POSTAL_DEFAUT',NULL);
	define('VILLE_LONGITUDE_DEFAUT',0);
	define('VILLE_LATITUDE_DEFAUT',0);
	
	class ld_ville extends ld_sql
	{
		private /*var*/ $champs;
		
		/*function ld_softbounce()
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
			$this->champs['identifiant']=VILLE_IDENTIFIANT_DEFAUT;
			$this->champs['departement']=VILLE_DEPARTEMENT_DEFAUT;
			$this->champs['nom']=VILLE_NOM_DEFAUT;
			$this->champs['code_postal']=VILLE_CODE_POSTAL_DEFAUT;
			$this->champs['longitude']=VILLE_LONGITUDE_DEFAUT;
			$this->champs['latitude']=VILLE_LATITUDE_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
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
			$this->executer
			('
				select
					identifiant,
					departement,
					nom,
					code_postal,
					longitude,
					latitude
				from ville
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['departement']=$occurrence['departement'];
			$this->champs['nom']=$occurrence['nom'];
			$this->champs['code_postal']=$occurrence['code_postal'];
			$this->champs['longitude']=$occurrence['longitude'];
			$this->champs['latitude']=$occurrence['latitude'];
			return true;
		}
	}
?>