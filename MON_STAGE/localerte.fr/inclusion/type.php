<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('TYPE_IDENTIFIANT_DEFAUT','');
	define('TYPE_IDENTIFIANT_ERREUR_EXISTANCE',pow(2,$define_erreur++));
	define('TYPE_IDENTIFIANT_ERREUR_REFERENCE',pow(2,$define_erreur++));
	
	define('TYPE_NOUVEAU_IDENTIFIANT_MIN',1);
	define('TYPE_NOUVEAU_IDENTIFIANT_MAX',9);
	define('TYPE_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('TYPE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('TYPE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('TYPE_PARENT_NULL',true);
	define('TYPE_PARENT_DEFAUT',NULL);
	define('TYPE_PARENT_ERREUR',pow(2,$define_erreur++));
	
	define('TYPE_DESIGNATION_MIN',1);
	define('TYPE_DESIGNATION_MAX',50);
	define('TYPE_DESIGNATION_NULL',false);
	define('TYPE_DESIGNATION_DEFAUT',NULL);
	define('TYPE_DESIGNATION_ERREUR',pow(2,$define_erreur++));
	
	define('TYPE_POSITION_MIN',0);
	define('TYPE_POSITION_MAX',999999999);
	define('TYPE_POSITION_DEFAUT',NULL);
	define('TYPE_POSITION_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('TYPE_POSITION_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('TYPE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_type extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_type()
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
			$this->champs['identifiant']=TYPE_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=TYPE_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['parent']=TYPE_PARENT_DEFAUT;
			$this->champs['designation']=TYPE_DESIGNATION_DEFAUT;
			$this->champs['position']=TYPE_POSITION_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=TYPE_TOTAL_ERREUR;

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
				$this->erreur=0;
				$this->executer
				('
					select count(identifiant) as nombre
					from type
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur|=TYPE_IDENTIFIANT_ERREUR_EXISTANCE;
				$this->executer
				('
					select count(identifiant) as nombre
					from
						(
							select alerte as identifiant
							from alerte_type
							where alerte in
								(
									select alerte
									from alerte_type
									where
										type=\''.addslashes($this->champs['identifiant']).'\'
								)
							group by alerte having count(type)=1
						) alerte
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=TYPE_IDENTIFIANT_ERREUR_REFERENCE;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from type
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=TYPE_IDENTIFIANT_ERREUR_EXISTANCE;
				else
					$this->erreur&=~TYPE_IDENTIFIANT_ERREUR_EXISTANCE;
				$this->erreur&=~TYPE_IDENTIFIANT_ERREUR_REFERENCE;
				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<TYPE_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>TYPE_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=TYPE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~TYPE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from type
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=TYPE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~TYPE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//PARENT
				$this->executer
				('
					select count(identifiant) as nombre
					from type
					where
						identifiant=\''.addslashes($this->champs['parent']).'\'
						and parent is null
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if((!TYPE_PARENT_NULL || $this->champs['parent']!==NULL) && !$occurrence['nombre'])
					$this->erreur|=TYPE_PARENT_ERREUR;
				else
					$this->erreur&=~TYPE_PARENT_ERREUR;
				//DESIGNATION
				if((!TYPE_DESIGNATION_NULL || $this->champs['designation']!==NULL) && (strlen($this->champs['designation'])<TYPE_DESIGNATION_MIN || strlen($this->champs['designation'])>TYPE_DESIGNATION_MAX))
					$this->erreur|=TYPE_DESIGNATION_ERREUR;
				else
					$this->erreur&=~TYPE_DESIGNATION_ERREUR;
				//POSITION
				if(($this->champs['parent']===NULL && (intval($this->champs['position'])<TYPE_POSITION_MIN || intval($this->champs['position'])>TYPE_POSITION_MAX)) || ($this->champs['parent']!==NULL && $this->champs['position']!==NULL))
					$this->erreur|=TYPE_POSITION_ERREUR_VALEUR;
				else
					$this->erreur&=~TYPE_POSITION_ERREUR_VALEUR;
				if($this->champs['parent']===NULL && !preg_match('/'.STRING_FILTRE_ENTIER.'/',$this->champs['position']))
					$this->erreur|=TYPE_POSITION_ERREUR_FILTRE;
				else
					$this->erreur&=~TYPE_POSITION_ERREUR_FILTRE;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					identifiant,
					parent,
					designation,
					position
				from type
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['parent']=$occurrence['parent'];
			$this->champs['designation']=$occurrence['designation'];
			$this->champs['position']=$occurrence['position'];
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from type
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=TYPE_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=TYPE_NOUVEAU_IDENTIFIANT_DEFAUT;
				$this->gerer_position();
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
					insert into type
					(
						identifiant,
						parent,
						designation,
						position
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['parent']!==NULL)?('\''.addslashes($this->champs['parent']).'\''):('null')).',
						'.(($this->champs['designation']!==NULL)?('\''.addslashes($this->champs['designation']).'\''):('null')).',
						'.(($this->champs['position']!==NULL)?('\''.addslashes(($this->champs['position']-0.5)).'\''):('null')).'
					)
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				$this->gerer_position();
			}
			return $this->erreur;
		}
		
		public function modifier()
		{
			$this->verifier('modifier');
			if(!$this->erreur)
			{
				$type=new ld_type();
				$type->identifiant=$this->champs['identifiant'];
				if($type->lire())
				{
					if($this->champs['position']<$type->position)
						$ecart=0.5;
					else
						$ecart=-0.5;
				}
				else
					$ecart=0;
				
				$this->executer
				('
					update type
					set
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						parent='.(($this->champs['parent']!==NULL)?('\''.addslashes($this->champs['parent']).'\''):('null')).',
						designation='.(($this->champs['designation']!==NULL)?('\''.addslashes($this->champs['designation']).'\''):('null')).',
						position='.(($this->champs['position']!==NULL)?('\''.addslashes(($this->champs['position']-$ecart)).'\''):('null')).'
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				$this->gerer_position();
			}
			return $this->erreur;
		}
		
		public function tester($mode)
		{
			$this->verifier($mode);
			return $this->erreur;
		}
		
		private function gerer_position()
		{
			$this->executer('set @position=0');
			$this->executer
			('
				update type
				set position=(@position:=@position+1)
				where position is not null
				order by position
			');
		}
	}
?>