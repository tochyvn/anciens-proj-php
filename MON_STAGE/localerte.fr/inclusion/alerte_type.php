<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('ALERTE_TYPE_ALERTE_DEFAUT','');
	define('ALERTE_TYPE_ALERTE_ERREUR',pow(2,$define_erreur++));
	
	define('ALERTE_TYPE_NOUVEAU_ALERTE_DEFAUT','');
	define('ALERTE_TYPE_NOUVEAU_ALERTE_ERREUR',pow(2,$define_erreur++));
	
	define('ALERTE_TYPE_TYPE_DEFAUT','');
	define('ALERTE_TYPE_TYPE_ERREUR',pow(2,$define_erreur++));
	
	define('ALERTE_TYPE_NOUVEAU_TYPE_DEFAUT','');
	define('ALERTE_TYPE_NOUVEAU_TYPE_ERREUR',pow(2,$define_erreur++));
	
	define('ALERTE_TYPE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('ALERTE_TYPE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_alerte_type extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_alerte_type()
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
			$this->champs['alerte']=ALERTE_TYPE_ALERTE_DEFAUT;
			$this->champs['nouveau_alerte']=ALERTE_TYPE_NOUVEAU_ALERTE_DEFAUT;
			$this->champs['type']=ALERTE_TYPE_TYPE_DEFAUT;
			$this->champs['nouveau_type']=ALERTE_TYPE_NOUVEAU_TYPE_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=ALERTE_TYPE_TOTAL_ERREUR;

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
					from alerte_type
					where
						alerte=\''.addslashes($this->champs['alerte']).'\'
						and type=\''.addslashes($this->champs['type']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=ALERTE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//ALERTE
				$this->executer
				('
					select count(identifiant) as nombre
					from alerte
					where
						identifiant=\''.addslashes($this->champs['alerte']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=ALERTE_TYPE_ALERTE_ERREUR;
				else
					$this->erreur&=~ALERTE_TYPE_ALERTE_ERREUR;
				//NOUVEAU_ALERTE
				$this->executer
				('
					select count(identifiant) as nombre
					from alerte
					where
						identifiant=\''.addslashes($this->champs['nouveau_alerte']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur|=ALERTE_TYPE_NOUVEAU_ALERTE_ERREUR;
				else
					$this->erreur&=~ALERTE_TYPE_NOUVEAU_ALERTE_ERREUR;
				//TYPE
				$this->executer
				('
					select count(identifiant) as nombre
					from type
					where
						identifiant=\''.addslashes($this->champs['type']).'\'
						and parent is null
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=ALERTE_TYPE_TYPE_ERREUR;
				else
					$this->erreur&=~ALERTE_TYPE_TYPE_ERREUR;
				//NOUVEAU_TYPE
				$this->executer
				('
					select count(identifiant) as nombre
					from type
					where
						identifiant=\''.addslashes($this->champs['nouveau_type']).'\'
						and parent is null
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur|=ALERTE_TYPE_NOUVEAU_TYPE_ERREUR;
				else
					$this->erreur&=~ALERTE_TYPE_NOUVEAU_TYPE_ERREUR;
				//IDENTIFIANT
				$this->executer
				('
					select count(*) as nombre
					from alerte_type
					where
						alerte=\''.addslashes($this->champs['nouveau_alerte']).'\'
						and type=\''.addslashes($this->champs['nouveau_type']).'\'
						'.(($mode=='modifier')?('and alerte<>\''.addslashes($this->champs['alerte']).'\' and type<>\''.addslashes($this->champs['type']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ALERTE_TYPE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~ALERTE_TYPE_IDENTIFIANT_ERREUR;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					alerte,
					type
				from alerte_type
				where
					alerte=\''.addslashes($this->champs['alerte']).'\'
					and type=\''.addslashes($this->champs['type']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['alerte']=$occurrence['alerte'];
			$this->champs['nouveau_alerte']=$occurrence['alerte'];
			$this->champs['type']=$occurrence['type'];
			$this->champs['nouveau_type']=$occurrence['type'];
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from alerte_type
					where
						alerte=\''.addslashes($this->champs['alerte']).'\'
						and type=\''.addslashes($this->champs['type']).'\'
				');
				$this->champs['alerte']=ALERTE_TYPE_ALERTE_DEFAUT;
				$this->champs['nouveau_alerte']=ALERTE_TYPE_NOUVEAU_ALERTE_DEFAUT;
				$this->champs['type']=ALERTE_TYPE_TYPE_DEFAUT;
				$this->champs['nouveau_type']=ALERTE_TYPE_NOUVEAU_TYPE_DEFAUT;
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
					insert into alerte_type
					(
						alerte,
						type
					)
					values
					(
						\''.addslashes($this->champs['nouveau_alerte']).'\',
						\''.addslashes($this->champs['nouveau_type']).'\'
					)
				');
				$this->champs['alerte']=$this->champs['nouveau_alerte'];
				$this->champs['type']=$this->champs['nouveau_type'];
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
					update alerte_type
					set
						alerte=\''.addslashes($this->champs['nouveau_alerte']).'\',
						type=\''.addslashes($this->champs['nouveau_type']).'\'
					where
						alerte=\''.addslashes($this->champs['alerte']).'\'
						and type=\''.addslashes($this->champs['type']).'\'
				');
				$this->champs['alerte']=$this->champs['nouveau_alerte'];
				$this->champs['type']=$this->champs['nouveau_type'];
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