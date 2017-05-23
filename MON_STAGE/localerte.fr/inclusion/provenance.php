<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('PROVENANCE_IDENTIFIANT_DEFAUT','');
	define('PROVENANCE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('PROVENANCE_NOUVEAU_IDENTIFIANT_MIN',1);
	define('PROVENANCE_NOUVEAU_IDENTIFIANT_MAX',9);
	define('PROVENANCE_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('PROVENANCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('PROVENANCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('PROVENANCE_CODE_MIN',1);
	define('PROVENANCE_CODE_MAX',30);
	define('PROVENANCE_CODE_NULL',false);
	define('PROVENANCE_CODE_DEFAUT',NULL);
	define('PROVENANCE_CODE_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('PROVENANCE_CODE_ERREUR_UNIQUE',pow(2,$define_erreur++));
	
	define('PROVENANCE_DESIGNATION_MIN',1);
	define('PROVENANCE_DESIGNATION_MAX',50);
	define('PROVENANCE_DESIGNATION_NULL',false);
	define('PROVENANCE_DESIGNATION_DEFAUT',NULL);
	define('PROVENANCE_DESIGNATION_ERREUR',pow(2,$define_erreur++));
	
	define('PROVENANCE_URL_MIN',0);
	define('PROVENANCE_URL_MAX',2048);
	define('PROVENANCE_URL_NULL',false);
	define('PROVENANCE_URL_DEFAUT',NULL);
	define('PROVENANCE_URL_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('PROVENANCE_URL_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('PROVENANCE_COULEUR_NULL',false);
	define('PROVENANCE_COULEUR_DEFAUT',NULL);
	define('PROVENANCE_COULEUR_ERREUR_FILTRE',pow(2,$define_erreur++));
	define('PROVENANCE_COULEUR_ERREUR_UNIQUE',pow(2,$define_erreur++));
	
	define('PROVENANCE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_provenance extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_provenance()
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
			$this->champs['identifiant']=PROVENANCE_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=PROVENANCE_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['code']=PROVENANCE_CODE_DEFAUT;
			$this->champs['designation']=PROVENANCE_DESIGNATION_DEFAUT;
			$this->champs['url']=PROVENANCE_URL_DEFAUT;
			$this->champs['couleur']=PROVENANCE_COULEUR_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=PROVENANCE_TOTAL_ERREUR;

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
					from provenance
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=PROVENANCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from provenance
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=PROVENANCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~PROVENANCE_IDENTIFIANT_ERREUR;
				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<PROVENANCE_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>PROVENANCE_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=PROVENANCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~PROVENANCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from provenance
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=PROVENANCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~PROVENANCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//CODE
				if((!PROVENANCE_CODE_NULL || $this->champs['code']!==NULL) && (strlen($this->champs['code'])<PROVENANCE_CODE_MIN || strlen($this->champs['url'])>PROVENANCE_CODE_MAX))
					$this->erreur|=PROVENANCE_CODE_ERREUR_LONGUEUR;
				else
					$this->erreur&=~PROVENANCE_CODE_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from provenance
					where
						code=\''.addslashes($this->champs['code']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=PROVENANCE_CODE_ERREUR_UNIQUE;
				else
					$this->erreur&=~PROVENANCE_CODE_ERREUR_UNIQUE;
				//DESIGNATION
				if((!PROVENANCE_DESIGNATION_NULL || $this->champs['designation']!==NULL) && (strlen($this->champs['designation'])<PROVENANCE_DESIGNATION_MIN || strlen($this->champs['url'])>PROVENANCE_DESIGNATION_MAX))
					$this->erreur|=PROVENANCE_DESIGNATION_ERREUR;
				else
					$this->erreur&=~PROVENANCE_DESIGNATION_ERREUR;
				//URL
				if((!PROVENANCE_URL_NULL || $this->champs['url']!==NULL) && (strlen($this->champs['url'])<PROVENANCE_URL_MIN || strlen($this->champs['url'])>PROVENANCE_URL_MAX))
					$this->erreur|=PROVENANCE_URL_ERREUR_LONGUEUR;
				else
					$this->erreur&=~PROVENANCE_URL_ERREUR_LONGUEUR;
				if((!PROVENANCE_URL_NULL || $this->champs['url']!==NULL) && !preg_match('/'.STRING_FILTRE_URL.'/',$this->champs['url']))
					$this->erreur|=PROVENANCE_URL_ERREUR_FILTRE;
				else
					$this->erreur&=~PROVENANCE_URL_ERREUR_FILTRE;
				//COULEUR
				if((!PROVENANCE_COULEUR_NULL || $this->champs['couleur']!==NULL) && !preg_match('/'.STRING_FILTRE_COULEUR.'/',$this->champs['couleur']))
					$this->erreur|=PROVENANCE_COULEUR_ERREUR_FILTRE;
				else
					$this->erreur&=~PROVENANCE_COULEUR_ERREUR_FILTRE;
				$this->executer
				('
					select count(identifiant) as nombre
					from provenance
					where
						couleur=\''.addslashes($this->champs['couleur']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=PROVENANCE_COULEUR_ERREUR_UNIQUE;
				else
					$this->erreur&=~PROVENANCE_COULEUR_ERREUR_UNIQUE;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					identifiant,
					code,
					designation,
					url,
					couleur
				from provenance
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['code']=$occurrence['code'];
			$this->champs['designation']=$occurrence['designation'];
			$this->champs['url']=$occurrence['url'];
			$this->champs['couleur']=$occurrence['couleur'];
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from provenance
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=PROVENANCE_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=PROVENANCE_NOUVEAU_IDENTIFIANT_DEFAUT;
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
					insert into provenance
					(
						identifiant,
						code,
						designation,
						url,
						couleur
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['code']!==NULL)?('\''.addslashes($this->champs['code']).'\''):('null')).',
						'.(($this->champs['designation']!==NULL)?('\''.addslashes($this->champs['designation']).'\''):('null')).',
						'.(($this->champs['url']!==NULL)?('\''.addslashes($this->champs['url']).'\''):('null')).',
						'.(($this->champs['couleur']!==NULL)?('\''.addslashes($this->champs['couleur']).'\''):('null')).'
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
					update provenance
					set
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						code='.(($this->champs['code']!==NULL)?('\''.addslashes($this->champs['code']).'\''):('null')).',
						designation='.(($this->champs['designation']!==NULL)?('\''.addslashes($this->champs['designation']).'\''):('null')).',
						url='.(($this->champs['url']!==NULL)?('\''.addslashes($this->champs['url']).'\''):('null')).',
						couleur='.(($this->champs['couleur']!==NULL)?('\''.addslashes($this->champs['couleur']).'\''):('null')).'
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
	}
?>