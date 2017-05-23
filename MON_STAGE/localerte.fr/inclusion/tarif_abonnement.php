<?php
	require_once(PWD_INCLUSION.'sql.php');
	
	define('TARIF_ABONNEMENT_IDENTIFIANT_DEFAUT',NULL);
	define('TARIF_ABONNEMENT_PRIX_HT_DEFAUT',NULL);
	define('TARIF_ABONNEMENT_TVA_DEFAUT',NULL);
	define('TARIF_ABONNEMENT_DELAI_DEFAUT',0);
	define('TARIF_ABONNEMENT_PAYPAL_DEFAUT',NULL);
	
	class ld_tarif_abonnement extends ld_sql
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
			$this->champs['identifiant']=TARIF_ABONNEMENT_IDENTIFIANT_DEFAUT;
			$this->champs['prix_ht']=TARIF_ABONNEMENT_PRIX_HT_DEFAUT;
			$this->champs['tva']=TARIF_ABONNEMENT_TVA_DEFAUT;
			$this->champs['delai']=TARIF_ABONNEMENT_DELAI_DEFAUT;
			$this->champs['paypal']=TARIF_ABONNEMENT_PAYPAL_DEFAUT;
			
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
					delai,
					paypal
				from tarif_abonnement
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['prix_ht']=$occurrence['prix_ht'];
			$this->champs['tva']=$occurrence['tva'];
			$this->champs['delai']=$occurrence['delai'];
			$this->champs['paypal']=$occurrence['paypal'];
			return true;
		}
	}
?>