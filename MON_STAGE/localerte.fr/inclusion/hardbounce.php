<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('HARDBOUNCE_IDENTIFIANT_DEFAUT','');
	define('HARDBOUNCE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('HARDBOUNCE_NOUVEAU_IDENTIFIANT_MIN',1);
	define('HARDBOUNCE_NOUVEAU_IDENTIFIANT_MAX',9);
	define('HARDBOUNCE_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('HARDBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('HARDBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('HARDBOUNCE_EXPRESSION_MIN',1);
	define('HARDBOUNCE_EXPRESSION_MAX',255);
	define('HARDBOUNCE_EXPRESSION_NULL',false);
	define('HARDBOUNCE_EXPRESSION_DEFAUT',NULL);
	define('HARDBOUNCE_EXPRESSION_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('HARDBOUNCE_EXPRESSION_ERREUR_PATTERN',pow(2,$define_erreur++));
	
	define('HARDBOUNCE_CASSE_ENUM','SENSIBLE,INSENSIBLE');
	define('HARDBOUNCE_CASSE_NULL',false);
	define('HARDBOUNCE_CASSE_DEFAUT','SENSIBLE');
	define('HARDBOUNCE_CASSE_ERREUR',pow(2,$define_erreur++));
	
	define('HARDBOUNCE_NEGATIF_ENUM','OUI,NON');
	define('HARDBOUNCE_NEGATIF_NULL',false);
	define('HARDBOUNCE_NEGATIF_DEFAUT','NON');
	define('HARDBOUNCE_NEGATIF_ERREUR',pow(2,$define_erreur++));
	
	define('HARDBOUNCE_DESCRIPTION_MIN',0);
	define('HARDBOUNCE_DESCRIPTION_MAX',200);
	define('HARDBOUNCE_DESCRIPTION_NULL',false);
	define('HARDBOUNCE_DESCRIPTION_DEFAUT',NULL);
	define('HARDBOUNCE_DESCRIPTION_ERREUR',pow(2,$define_erreur++));
	
	define('HARDBOUNCE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_hardbounce extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_hardbounce()
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
			$this->champs['identifiant']=HARDBOUNCE_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=HARDBOUNCE_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['expression']=HARDBOUNCE_EXPRESSION_DEFAUT;
			$this->champs['casse']=HARDBOUNCE_CASSE_DEFAUT;
			$this->champs['negatif']=HARDBOUNCE_NEGATIF_DEFAUT;
			$this->champs['description']=HARDBOUNCE_DESCRIPTION_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=HARDBOUNCE_TOTAL_ERREUR;

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
		
		private function verifier($mode)
		{
			if($mode=='supprimer')
			{
				$this->executer
				('
					select count(identifiant) as nombre
					from hardbounce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=HARDBOUNCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from hardbounce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=HARDBOUNCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~HARDBOUNCE_IDENTIFIANT_ERREUR;
				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<HARDBOUNCE_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>HARDBOUNCE_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=HARDBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~HARDBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from hardbounce
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=HARDBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~HARDBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//EXPRESSION
				if((!HARDBOUNCE_EXPRESSION_NULL || $this->champs['expression']!==NULL) && (strlen($this->champs['expression'])<HARDBOUNCE_EXPRESSION_MIN || strlen($this->champs['description'])>HARDBOUNCE_EXPRESSION_MAX))
					$this->erreur|=HARDBOUNCE_EXPRESSION_ERREUR_LONGUEUR;
				else
					$this->erreur&=~HARDBOUNCE_EXPRESSION_ERREUR_LONGUEUR;
				if((!HARDBOUNCE_EXPRESSION_NULL || $this->champs['expression']!==NULL) && @preg_match('/'.$this->champs['expression'].'/','a')===false)
					$this->erreur|=HARDBOUNCE_EXPRESSION_ERREUR_PATTERN;
				else
					$this->erreur&=~HARDBOUNCE_EXPRESSION_ERREUR_PATTERN;
				//CASSE
				if((!HARDBOUNCE_CASSE_NULL || $this->champs['casse']!==NULL) && array_search($this->champs['casse'],explode(',',HARDBOUNCE_CASSE_ENUM))===false)
					$this->erreur|=HARDBOUNCE_CASSE_ERREUR;
				else
					$this->erreur&=~HARDBOUNCE_CASSE_ERREUR;
				//NEGATIF
				if((!HARDBOUNCE_NEGATIF_NULL || $this->champs['negatif']!==NULL) && array_search($this->champs['negatif'],explode(',',HARDBOUNCE_NEGATIF_ENUM))===false)
					$this->erreur|=HARDBOUNCE_NEGATIF_ERREUR;
				else
					$this->erreur&=~HARDBOUNCE_NEGATIF_ERREUR;
				//DESCRIPTION
				if((!HARDBOUNCE_DESCRIPTION_NULL || $this->champs['description']!==NULL) && (strlen($this->champs['description'])<HARDBOUNCE_DESCRIPTION_MIN || strlen($this->champs['description'])>HARDBOUNCE_DESCRIPTION_MAX))
					$this->erreur|=HARDBOUNCE_DESCRIPTION_ERREUR;
				else
					$this->erreur&=~HARDBOUNCE_DESCRIPTION_ERREUR;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					identifiant,
					expression,
					casse,
					negatif,
					description
				from hardbounce
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['expression']=$occurrence['expression'];
			$this->champs['casse']=$occurrence['casse'];
			$this->champs['negatif']=$occurrence['negatif'];
			$this->champs['description']=$occurrence['description'];
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from hardbounce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=HARDBOUNCE_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=HARDBOUNCE_NOUVEAU_IDENTIFIANT_DEFAUT;
			}
			return $this->erreur;
		}
		
		public function ajouter()
		{
			$this->verifier('ajouter');
			if(!$this->erreur)
			{
				$this->executer
				('
					insert into hardbounce
					(
						identifiant,
						expression,
						casse,
						negatif,
						description
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['expression']!==NULL)?('\''.addslashes($this->champs['expression']).'\''):('null')).',
						'.(($this->champs['casse']!==NULL)?('\''.addslashes($this->champs['casse']).'\''):('null')).',
						'.(($this->champs['negatif']!==NULL)?('\''.addslashes($this->champs['negatif']).'\''):('null')).',
						'.(($this->champs['description']!==NULL)?('\''.addslashes($this->champs['description']).'\''):('null')).'
					)
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
			}
			return $this->erreur;
		}
		
		public function modifier()
		{
			$this->verifier('modifier');
			if(!$this->erreur)
			{
				$this->executer
				('
					update hardbounce
					set
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						expression='.(($this->champs['expression']!==NULL)?('\''.addslashes($this->champs['expression']).'\''):('null')).',
						casse='.(($this->champs['casse']!==NULL)?('\''.addslashes($this->champs['casse']).'\''):('null')).',
						negatif='.(($this->champs['negatif']!==NULL)?('\''.addslashes($this->champs['negatif']).'\''):('null')).',
						description='.(($this->champs['description']!==NULL)?('\''.addslashes($this->champs['description']).'\''):('null')).'
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
			}
			return $this->erreur;
		}
		
		public function tester($mode)
		{
			$this->verifier($mode);
			return $this->erreur;
		}
		
		public function chercher($chaine)
		{
			$this->executer
			('
				select count(identifiant) as nombre
				from hardbounce
				where
					(
						negatif=\'NON\'
						and casse=\'INSENSIBLE\'
						and \''.addslashes($chaine).'\' rlike expression
					)
					or
					(
						negatif=\'OUI\'
						and casse=\'INSENSIBLE\'
						and \''.addslashes($chaine).'\' not rlike expression
					)
					or
					(
						negatif=\'NON\'
						and casse=\'SENSIBLE\'
						and binary \''.addslashes($chaine).'\' rlike binary expression
					)
					or
					(
						negatif=\'OUI\'
						and casse=\'SENSIBLE\'
						and binary \''.addslashes($chaine).'\' not rlike binary expression
					)
			');
			$this->donner_suivant($occurrence);
			return $occurrence['nombre'];
		}
	}
?>