<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'code.php');
	
	define('TARIF_FORFAIT_IDENTIFIANT_DEFAUT',NULL);
	define('TARIF_FORFAIT_PRIX_HT_DEFAUT',NULL);
	define('TARIF_FORFAIT_TVA_DEFAUT',NULL);
	define('TARIF_FORFAIT_NOMBRE_DEFAUT',0);
	
	class ld_tarif_forfait extends ld_sql
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
			$this->champs['identifiant']=TARIF_FORFAIT_IDENTIFIANT_DEFAUT;
			$this->champs['prix_ht']=TARIF_FORFAIT_PRIX_HT_DEFAUT;
			$this->champs['tva']=TARIF_FORFAIT_TVA_DEFAUT;
			$this->champs['nombre']=TARIF_FORFAIT_NOMBRE_DEFAUT;
			
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
					prix_ht,
					tva,
					nombre
				from tarif_forfait
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['prix_ht']=$occurrence['prix_ht'];
			$this->champs['tva']=$occurrence['tva'];
			$this->champs['nombre']=$occurrence['nombre'];
			return true;
		}
		
		public function donner()
		{
			$code=new ld_code();
			
			$resultat=array();			
			for($i=0;$i<$this->champs['nombre'];$i++)
				$resultat[]=$code->creer('forfait');
			
			return $resultat;
		}
	}
?>