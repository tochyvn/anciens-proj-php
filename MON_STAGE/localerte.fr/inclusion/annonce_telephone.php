<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('ANNONCE_TELEPHONE_ANNONCE_DEFAUT','');
	define('ANNONCE_TELEPHONE_ANNONCE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_TELEPHONE_NOUVEAU_ANNONCE_DEFAUT','');
	define('ANNONCE_TELEPHONE_NOUVEAU_ANNONCE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_TELEPHONE_TELEPHONE_DEFAUT','');
	
	define('ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_MIN',10);
	define('ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_MAX',10);
	define('ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_DEFAUT','');
	define('ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ANNONCE_TELEPHONE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_TELEPHONE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_annonce_telephone extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_annonce_telephone()
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
			$this->champs['annonce']=ANNONCE_TELEPHONE_ANNONCE_DEFAUT;
			$this->champs['nouveau_annonce']=ANNONCE_TELEPHONE_NOUVEAU_ANNONCE_DEFAUT;
			$this->champs['telephone']=ANNONCE_TELEPHONE_TELEPHONE_DEFAUT;
			$this->champs['nouveau_telephone']=ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=ANNONCE_TELEPHONE_TOTAL_ERREUR;

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
					select count(*) as nombre
					from annonce_telephone
					where
						annonce=\''.addslashes($this->champs['annonce']).'\'
						and telephone=\''.addslashes($this->champs['telephone']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=ANNONCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//ANNONCE
				$this->executer
				('
					select count(identifiant) as nombre
					from annonce
					where
						identifiant=\''.addslashes($this->champs['annonce']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=ANNONCE_TELEPHONE_ANNONCE_ERREUR;
				else
					$this->erreur&=~ANNONCE_TELEPHONE_ANNONCE_ERREUR;
				//NOUVEAU_ANNONCE
				$this->executer
				('
					select count(identifiant) as nombre
					from annonce
					where
						identifiant=\''.addslashes($this->champs['nouveau_annonce']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur|=ANNONCE_TELEPHONE_NOUVEAU_ANNONCE_ERREUR;
				else
					$this->erreur&=~ANNONCE_TELEPHONE_NOUVEAU_ANNONCE_ERREUR;
				//TELEPHONE
				//NOUVEAU_TELEPHONE
				if(strlen($this->champs['nouveau_telephone'])<ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_MIN || strlen($this->champs['nouveau_telephone'])>ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_MAX)
					$this->erreur|=ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_LONGUEUR;
				if(!preg_match('/'.STRING_FILTRE_TELEPHONE_STRICT_FR.'/',$this->champs['nouveau_telephone']))
					$this->erreur|=ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_FILTRE;
				else
					$this->erreur&=~ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_FILTRE;
				//IDENTIFIANT
				$this->executer
				('
					select count(*) as nombre
					from annonce_telephone
					where
						annonce=\''.addslashes($this->champs['nouveau_annonce']).'\'
						and telephone=\''.addslashes($this->champs['nouveau_telephone']).'\'
						'.(($mode=='modifier')?('and annonce<>\''.addslashes($this->champs['annonce']).'\' and telephone<>\''.addslashes($this->champs['telephone']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ANNONCE_TELEPHONE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~ANNONCE_TELEPHONE_IDENTIFIANT_ERREUR;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					annonce,
					telephone as telephone
				from annonce_telephone
				where
					annonce=\''.addslashes($this->champs['annonce']).'\'
					and telephone=\''.addslashes($this->champs['telephone']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['annonce']=$occurrence['annonce'];
			$this->champs['nouveau_annonce']=$occurrence['annonce'];
			$this->champs['telephone']=$occurrence['telephone'];
			$this->champs['nouveau_telephone']=$occurrence['telephone'];
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from annonce_telephone
					where
						annonce=\''.addslashes($this->champs['annonce']).'\'
						and telephone=\''.addslashes($this->champs['telephone']).'\'
				');
				$this->champs['annonce']=ANNONCE_TELEPHONE_ANNONCE_DEFAUT;
				$this->champs['nouveau_annonce']=ANNONCE_TELEPHONE_NOUVEAU_ANNONCE_DEFAUT;
				$this->champs['telephone']=ANNONCE_TELEPHONE_TELEPHONE_DEFAUT;
				$this->champs['nouveau_telephone']=ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_DEFAUT;
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
					insert into annonce_telephone
					(
						annonce,
						telephone
					)
					values
					(
						\''.addslashes($this->champs['nouveau_annonce']).'\',
						\''.addslashes($this->champs['nouveau_telephone']).'\'
					)
				');
				$this->champs['annonce']=$this->champs['nouveau_annonce'];
				$this->champs['telephone']=$this->champs['nouveau_telephone'];
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
					update annonce_telephone
					set
						annonce=\''.addslashes($this->champs['nouveau_annonce']).'\',
						telephone=\''.addslashes($this->champs['nouveau_telephone']).'\'
					where
						annonce=\''.addslashes($this->champs['annonce']).'\'
						and telephone=\''.addslashes($this->champs['telephone']).'\'
				');
				$this->champs['annonce']=$this->champs['nouveau_annonce'];
				$this->champs['telephone']=$this->champs['nouveau_telephone'];
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