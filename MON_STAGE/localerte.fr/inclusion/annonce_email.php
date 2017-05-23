<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('ANNONCE_EMAIL_ANNONCE_DEFAUT','');
	define('ANNONCE_EMAIL_ANNONCE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_EMAIL_NOUVEAU_ANNONCE_DEFAUT','');
	define('ANNONCE_EMAIL_NOUVEAU_ANNONCE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_EMAIL_EMAIL_DEFAUT','');
	
	define('ANNONCE_EMAIL_NOUVEAU_EMAIL_MIN',6);
	define('ANNONCE_EMAIL_NOUVEAU_EMAIL_MAX',255);
	define('ANNONCE_EMAIL_NOUVEAU_EMAIL_DEFAUT','');
	define('ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ANNONCE_EMAIL_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_EMAIL_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_annonce_email extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_annonce_email()
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
			$this->champs['annonce']=ANNONCE_EMAIL_ANNONCE_DEFAUT;
			$this->champs['nouveau_annonce']=ANNONCE_EMAIL_NOUVEAU_ANNONCE_DEFAUT;
			$this->champs['email']=ANNONCE_EMAIL_EMAIL_DEFAUT;
			$this->champs['nouveau_email']=ANNONCE_EMAIL_NOUVEAU_EMAIL_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=ANNONCE_EMAIL_TOTAL_ERREUR;

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
					from annonce_email
					where
						annonce=\''.addslashes($this->champs['annonce']).'\'
						and email=\''.addslashes($this->champs['email']).'\'
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
					$this->erreur|=ANNONCE_EMAIL_ANNONCE_ERREUR;
				else
					$this->erreur&=~ANNONCE_EMAIL_ANNONCE_ERREUR;
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
					$this->erreur|=ANNONCE_EMAIL_NOUVEAU_ANNONCE_ERREUR;
				else
					$this->erreur&=~ANNONCE_EMAIL_NOUVEAU_ANNONCE_ERREUR;
				//EMAIL
				//NOUVEAU_EMAIL
				if(strlen($this->champs['nouveau_email'])<ANNONCE_EMAIL_NOUVEAU_EMAIL_MIN || strlen($this->champs['nouveau_email'])>ANNONCE_EMAIL_NOUVEAU_EMAIL_MAX)
					$this->erreur|=ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_LONGUEUR;
				if(!preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['nouveau_email']))
					$this->erreur|=ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_FILTRE;
				else
					$this->erreur&=~ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_FILTRE;
				//IDENTIFIANT
				$this->executer
				('
					select count(*) as nombre
					from annonce_email
					where
						annonce=\''.addslashes($this->champs['nouveau_annonce']).'\'
						and email=\''.addslashes($this->champs['nouveau_email']).'\'
						'.(($mode=='modifier')?('and annonce<>\''.addslashes($this->champs['annonce']).'\' and email<>\''.addslashes($this->champs['email']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ANNONCE_EMAIL_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~ANNONCE_EMAIL_IDENTIFIANT_ERREUR;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					annonce,
					email
				from annonce_email
				where
					annonce=\''.addslashes($this->champs['annonce']).'\'
					and email=\''.addslashes($this->champs['email']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['annonce']=$occurrence['annonce'];
			$this->champs['nouveau_annonce']=$occurrence['annonce'];
			$this->champs['email']=$occurrence['email'];
			$this->champs['nouveau_email']=$occurrence['email'];
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from annonce_email
					where
						annonce=\''.addslashes($this->champs['annonce']).'\'
						and email=\''.addslashes($this->champs['email']).'\'
				');
				$this->champs['annonce']=ANNONCE_EMAIL_ANNONCE_DEFAUT;
				$this->champs['nouveau_annonce']=ANNONCE_EMAIL_NOUVEAU_ANNONCE_DEFAUT;
				$this->champs['email']=ANNONCE_EMAIL_EMAIL_DEFAUT;
				$this->champs['nouveau_email']=ANNONCE_EMAIL_NOUVEAU_EMAIL_DEFAUT;
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
					insert into annonce_email
					(
						annonce,
						email
					)
					values
					(
						\''.addslashes($this->champs['nouveau_annonce']).'\',
						\''.addslashes($this->champs['nouveau_email']).'\'
					)
				');
				$this->champs['annonce']=$this->champs['nouveau_annonce'];
				$this->champs['email']=$this->champs['nouveau_email'];
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
					update annonce_email
					set
						annonce=\''.addslashes($this->champs['nouveau_annonce']).'\',
						email=\''.addslashes($this->champs['nouveau_email']).'\'
					where
						annonce=\''.addslashes($this->champs['annonce']).'\'
						and email=\''.addslashes($this->champs['email']).'\'
				');
				$this->champs['annonce']=$this->champs['nouveau_annonce'];
				$this->champs['email']=$this->champs['nouveau_email'];
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