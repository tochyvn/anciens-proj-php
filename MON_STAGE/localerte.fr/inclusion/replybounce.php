<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('REPLYBOUNCE_IDENTIFIANT_DEFAUT','');
	define('REPLYBOUNCE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('REPLYBOUNCE_NOUVEAU_IDENTIFIANT_MIN',1);
	define('REPLYBOUNCE_NOUVEAU_IDENTIFIANT_MAX',9);
	define('REPLYBOUNCE_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('REPLYBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('REPLYBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('REPLYBOUNCE_EXPRESSION_MIN',1);
	define('REPLYBOUNCE_EXPRESSION_MAX',255);
	define('REPLYBOUNCE_EXPRESSION_NULL',false);
	define('REPLYBOUNCE_EXPRESSION_DEFAUT',NULL);
	define('REPLYBOUNCE_EXPRESSION_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('REPLYBOUNCE_EXPRESSION_ERREUR_PATTERN',pow(2,$define_erreur++));
	
	define('REPLYBOUNCE_CASSE_ENUM','SENSIBLE,INSENSIBLE');
	define('REPLYBOUNCE_CASSE_NULL',false);
	define('REPLYBOUNCE_CASSE_DEFAUT','SENSIBLE');
	define('REPLYBOUNCE_CASSE_ERREUR',pow(2,$define_erreur++));
	
	define('REPLYBOUNCE_NEGATIF_ENUM','OUI,NON');
	define('REPLYBOUNCE_NEGATIF_NULL',false);
	define('REPLYBOUNCE_NEGATIF_DEFAUT','NON');
	define('REPLYBOUNCE_NEGATIF_ERREUR',pow(2,$define_erreur++));
	
	define('REPLYBOUNCE_ENDROIT_SET','ENTETE,CORPS');
	define('REPLYBOUNCE_ENDROIT_NULL',false);
	define('REPLYBOUNCE_ENDROIT_DEFAUT','ENTETE,CORPS');
	define('REPLYBOUNCE_ENDROIT_ERREUR',pow(2,$define_erreur++));
	
	define('REPLYBOUNCE_DESCRIPTION_MIN',0);
	define('REPLYBOUNCE_DESCRIPTION_MAX',200);
	define('REPLYBOUNCE_DESCRIPTION_NULL',false);
	define('REPLYBOUNCE_DESCRIPTION_DEFAUT',NULL);
	define('REPLYBOUNCE_DESCRIPTION_ERREUR',pow(2,$define_erreur++));
	
	define('REPLYBOUNCE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_replybounce extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_replybounce()
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
			$this->champs['identifiant']=REPLYBOUNCE_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=REPLYBOUNCE_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['expression']=REPLYBOUNCE_EXPRESSION_DEFAUT;
			$this->champs['casse']=REPLYBOUNCE_CASSE_DEFAUT;
			$this->champs['negatif']=REPLYBOUNCE_NEGATIF_DEFAUT;
			$this->champs['endroit']=REPLYBOUNCE_ENDROIT_DEFAUT;
			$this->champs['description']=REPLYBOUNCE_DESCRIPTION_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=REPLYBOUNCE_TOTAL_ERREUR;

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
					from replybounce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=REPLYBOUNCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from replybounce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=REPLYBOUNCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~REPLYBOUNCE_IDENTIFIANT_ERREUR;
				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<REPLYBOUNCE_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>REPLYBOUNCE_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=REPLYBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~REPLYBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from replybounce
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=REPLYBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~REPLYBOUNCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//EXPRESSION
				if((!REPLYBOUNCE_EXPRESSION_NULL || $this->champs['expression']!==NULL) && (strlen($this->champs['expression'])<REPLYBOUNCE_EXPRESSION_MIN || strlen($this->champs['description'])>REPLYBOUNCE_EXPRESSION_MAX))
					$this->erreur|=REPLYBOUNCE_EXPRESSION_ERREUR_LONGUEUR;
				else
					$this->erreur&=~REPLYBOUNCE_EXPRESSION_ERREUR_LONGUEUR;
				if((!REPLYBOUNCE_EXPRESSION_NULL || $this->champs['expression']!==NULL) && @preg_match('/'.$this->champs['expression'].'/','a')===false)
					$this->erreur|=REPLYBOUNCE_EXPRESSION_ERREUR_PATTERN;
				else
					$this->erreur&=~REPLYBOUNCE_EXPRESSION_ERREUR_PATTERN;
				//CASSE
				if((!REPLYBOUNCE_CASSE_NULL || $this->champs['casse']!==NULL) && array_search($this->champs['casse'],explode(',',REPLYBOUNCE_CASSE_ENUM))===false)
					$this->erreur|=REPLYBOUNCE_CASSE_ERREUR;
				else
					$this->erreur&=~REPLYBOUNCE_CASSE_ERREUR;
				//NEGATIF
				if((!REPLYBOUNCE_NEGATIF_NULL || $this->champs['negatif']!==NULL) && array_search($this->champs['negatif'],explode(',',REPLYBOUNCE_NEGATIF_ENUM))===false)
					$this->erreur|=REPLYBOUNCE_NEGATIF_ERREUR;
				else
					$this->erreur&=~REPLYBOUNCE_NEGATIF_ERREUR;
				//ENDROIT
				if((!REPLYBOUNCE_ENDROIT_NULL || $this->champs['endroit']!==NULL) && sizeof(array_diff(explode(',',$this->champs['endroit']),explode(',',REPLYBOUNCE_ENDROIT_SET))))
					$this->erreur|=REPLYBOUNCE_ENDROIT_ERREUR;
				else
					$this->erreur&=~REPLYBOUNCE_ENDROIT_ERREUR;
				//DESCRIPTION
				if((!REPLYBOUNCE_DESCRIPTION_NULL || $this->champs['description']!==NULL) && (strlen($this->champs['description'])<REPLYBOUNCE_DESCRIPTION_MIN || strlen($this->champs['description'])>REPLYBOUNCE_DESCRIPTION_MAX))
					$this->erreur|=REPLYBOUNCE_DESCRIPTION_ERREUR;
				else
					$this->erreur&=~REPLYBOUNCE_DESCRIPTION_ERREUR;
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
					endroit,
					description
				from replybounce
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
			$this->champs['endroit']=$occurrence['endroit'];
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
					delete from replybounce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=REPLYBOUNCE_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=REPLYBOUNCE_NOUVEAU_IDENTIFIANT_DEFAUT;
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
					insert into replybounce
					(
						identifiant,
						expression,
						casse,
						negatif,
						endroit,
						description
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['expression']!==NULL)?('\''.addslashes($this->champs['expression']).'\''):('null')).',
						'.(($this->champs['casse']!==NULL)?('\''.addslashes($this->champs['casse']).'\''):('null')).',
						'.(($this->champs['negatif']!==NULL)?('\''.addslashes($this->champs['negatif']).'\''):('null')).',
						'.(($this->champs['endroit']!==NULL)?('\''.addslashes($this->champs['endroit']).'\''):('null')).',
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
					update replybounce
					set
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						expression='.(($this->champs['expression']!==NULL)?('\''.addslashes($this->champs['expression']).'\''):('null')).',
						casse='.(($this->champs['casse']!==NULL)?('\''.addslashes($this->champs['casse']).'\''):('null')).',
						negatif='.(($this->champs['negatif']!==NULL)?('\''.addslashes($this->champs['negatif']).'\''):('null')).',
						endroit='.(($this->champs['endroit']!==NULL)?('\''.addslashes($this->champs['endroit']).'\''):('null')).',
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
		
		public function chercher($chaine,$endroit)
		{
			$query=array();
			for($i=0;$i<sizeof($endroit);$i++)
				$query[]='find_in_set(\''.$endroit[$i].'\',endroit)>0';
			
			$this->executer
			('
				select count(identifiant) as nombre
				from replybounce
				where
					(
						negatif=\'NON\'
						and casse=\'INSENSIBLE\'
						and \''.addslashes($chaine).'\' rlike expression
						'.((sizeof($query))?('and ('.implode(' or ',$query).')'):('and 0')).'
					)
					or
					(
						negatif=\'OUI\'
						and casse=\'INSENSIBLE\'
						and \''.addslashes($chaine).'\' not rlike expression
						'.((sizeof($query))?('and ('.implode(' or ',$query).')'):('and 0')).'
					)
					or
					(
						negatif=\'NON\'
						and casse=\'SENSIBLE\'
						and binary \''.addslashes($chaine).'\' rlike binary expression
						'.((sizeof($query))?('and ('.implode(' or ',$query).')'):('and 0')).'
					)
					or
					(
						negatif=\'OUI\'
						and casse=\'SENSIBLE\'
						and binary \''.addslashes($chaine).'\' not rlike binary expression
						'.((sizeof($query))?('and ('.implode(' or ',$query).')'):('and 0')).'
					)
			');
			$this->donner_suivant($occurrence);
			return $occurrence['nombre'];
		}
	}
?>