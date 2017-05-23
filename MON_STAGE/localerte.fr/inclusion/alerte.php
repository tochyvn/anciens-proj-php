<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'alerte_type.php');
	
	$define_erreur=0;
	
	define('ALERTE_IDENTIFIANT_DEFAUT','');
	define('ALERTE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('ALERTE_NOUVEAU_IDENTIFIANT_MIN',1);
	define('ALERTE_NOUVEAU_IDENTIFIANT_MAX',9);
	define('ALERTE_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('ALERTE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ALERTE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('ALERTE_ADHERENT_NULL',false);
	define('ALERTE_ADHERENT_DEFAUT',NULL);
	define('ALERTE_ADHERENT_ERREUR',pow(2,$define_erreur++));
	
	define('ALERTE_VILLE_NULL',false);
	define('ALERTE_VILLE_DEFAUT',NULL);
	define('ALERTE_VILLE_ERREUR',pow(2,$define_erreur++));
	
	define('ALERTE_RAYON_MIN',5);
	define('ALERTE_RAYON_MAX',50);
	define('ALERTE_RAYON_NULL',false);
	define('ALERTE_RAYON_DEFAUT',20);
	define('ALERTE_RAYON_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('ALERTE_RAYON_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ALERTE_ENREGISTREMENT_NULL',false);
	define('ALERTE_ENREGISTREMENT_DEFAUT',NULL);
	
	define('ALERTE_MODIFICATION_NULL',false);
	define('ALERTE_MODIFICATION_DEFAUT',NULL);
	
	define('ALERTE_ALERTE_TYPE_MIN',1);
	define('ALERTE_ALERTE_TYPE_MAX',3);
	define('ALERTE_ALERTE_TYPE_DEFAUT','array,ld_alerte_type');
	define('ALERTE_ALERTE_TYPE_ERREUR_TAILLE',pow(2,$define_erreur++));
	define('ALERTE_ALERTE_TYPE_ERREUR_CLASSE',pow(2,$define_erreur++));
	
	define('ALERTE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_alerte extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_alerte()
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
			$this->champs['identifiant']=ALERTE_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=ALERTE_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['adherent']=ALERTE_ADHERENT_DEFAUT;
			$this->champs['ville']=ALERTE_VILLE_DEFAUT;
			$this->champs['rayon']=ALERTE_RAYON_DEFAUT;
			$this->champs['enregistrement']=ALERTE_ENREGISTREMENT_DEFAUT;
			$this->champs['modification']=ALERTE_MODIFICATION_DEFAUT;
			$this->champs['alerte_type']=array();
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=ALERTE_TOTAL_ERREUR;

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
				if($variable!='alerte_type')
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
		
		function __call($function,$parametre)
		{
			switch($function)
			{
				case 'alerte_type_ajouter':
					if(sizeof($parametre)==2 && is_a($parametre[0],'ld_alerte_type') && preg_match('/^(ajouter|modifier)$/',$parametre[1]))
					{
						$clef=sizeof($this->champs['alerte_type']);
						$this->champs['alerte_type'][$clef]['objet']=$parametre[0];
						$this->champs['alerte_type'][$clef]['mode']=$parametre[1];
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: alerte_type_ajouter (ld_alerte_type, \'ajouter\' | \'modifier\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'alerte_type_modifier':
					if(sizeof($parametre)==3 && is_a($parametre[0],'ld_alerte_type') && preg_match('/^(ajouter|modifier)$/',$parametre[2]) && is_int($parametre[1]) && isset($this->champs['alerte_type'][$parametre[1]]))
					{
						$this->champs['alerte_type'][$parametre[1]]['objet']=$parametre[0];
						$this->champs['alerte_type'][$parametre[1]]['mode']=$parametre[2];
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: alerte_type_modifier (ld_alerte_type, clef, \'ajouter\' | \'modifier\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'alerte_type_supprimer':
					if(sizeof($parametre)==1 && is_int($parametre[0]))
					{
						unset($this->champs['alerte_type'][$parametre[0]]);
						$this->champs['alerte_type']=array_values($this->champs['alerte_type']);
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: alerte_type_supprimer (clef)'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'alerte_type_trouver':
					if(sizeof($parametre)==2 && preg_match('/^(type|nouveau_type)$/',$parametre[1]))
					{
						foreach($this->champs['alerte_type'] as $clef=>$tableau)
						{
							switch($parametre[1])
							{
								case 'type':
									if($tableau['objet']->type==$parametre[0])
										return $clef;
									break;
								case 'nouveau_type':
									if($tableau['objet']->nouveau_type==$parametre[0])
										return $clef;
									break;
							}
						}
						
						return false;
					}
					
					trigger_error('Param&egrave;tres incorrect: alerte_type_trouver (identifiant, \'alerte\' | \'nouveau_alerte\' | \'type\' | \'nouveau_type\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'alerte_type_lire':
					if(sizeof($parametre)==1 && is_int($parametre[0]))
					{
						if(isset($this->champs['alerte_type'][$parametre[0]]))
							return $this->champs['alerte_type'][$parametre[0]];
						
						return false;
					}
					
					trigger_error('Param&egrave;tres incorrect: alerte_type_lire (clef)'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'alerte_type_compter':
					return sizeof($this->champs['alerte_type']);
					break;
				default:
					trigger_error('Fonction '.$function.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
			}
		}
		
		/*function alerte_type_ajouter($objet,$mode)
		{
			return $this->__call('alerte_type_ajouter',array($objet,$mode));
		}*/
		
		/*function alerte_type_modifier($objet,$clef,$mode)
		{
			return $this->__call('alerte_type_modifier',array($objet,$clef,$mode));
		}*/
		
		/*function alerte_type_supprimer($clef)
		{
			return $this->__call('alerte_type_supprimer',array($clef));
		}*/
		
		/*function alerte_type_trouver($identifiant,$champ)
		{
			return $this->__call('alerte_type_trouver',array($idnetifiant,$champ));
		}*/
		
		/*function alerte_type_lire($clef)
		{
			return $this->__call('alerte_type_lire',array($clef));
		}*/
		
		/*function alerte_type_compter()
		{
			return $this->__call('alerte_type_compter');
		}*/
		
		private function verifier($mode)
		{
			if($mode=='supprimer')
			{
				$this->executer
				('
					select count(identifiant) as nombre
					from alerte
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=ALERTE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from alerte
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=ALERTE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~ALERTE_IDENTIFIANT_ERREUR;
				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<ALERTE_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>ALERTE_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=ALERTE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ALERTE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from alerte
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ALERTE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~ALERTE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//ADHERENT
				$this->executer
				('
					select count(identifiant) as nombre
					from adherent
					where
						identifiant=\''.addslashes($this->champs['adherent']).'\'
				');
				$this->donner_suivant($occurrence);
				if((!ALERTE_ADHERENT_NULL || $this->champs['adherent']!==NULL) && !$occurrence['nombre'])
					$this->erreur|=ALERTE_ADHERENT_ERREUR;
				else
					$this->erreur&=~ALERTE_ADHERENT_ERREUR;
				//VILLE
				$this->executer
				('
					select count(identifiant) as nombre
					from ville
					where
						identifiant=\''.addslashes($this->champs['ville']).'\'
				');
				$this->donner_suivant($occurrence);
				if((!ALERTE_VILLE_NULL || $this->champs['ville']!==NULL) && !$occurrence['nombre'])
					$this->erreur|=ALERTE_VILLE_ERREUR;
				else
					$this->erreur&=~ALERTE_VILLE_ERREUR;
				//RAYON
				if((!ALERTE_RAYON_NULL || $this->champs['rayon']!==NULL) && (intval($this->champs['rayon'])<ALERTE_RAYON_MIN || intval($this->champs['rayon'])>ALERTE_RAYON_MAX))
					$this->erreur|=ALERTE_RAYON_ERREUR_VALEUR;
				else
					$this->erreur&=~ALERTE_RAYON_ERREUR_VALEUR;
				if((!ALERTE_RAYON_NULL || $this->champs['rayon']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['rayon']))
					$this->erreur|=ALERTE_RAYON_ERREUR_FILTRE;
				else
					$this->erreur&=~ALERTE_RAYON_ERREUR_FILTRE;
				//ALERTE_TYPE
				if(sizeof($this->champs['alerte_type'])<ALERTE_ALERTE_TYPE_MIN || sizeof($this->champs['alerte_type'])>ALERTE_ALERTE_TYPE_MAX)
					$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_TAILLE;
				else
					$this->erreur&=~ALERTE_ALERTE_TYPE_ERREUR_TAILLE;
				$this->erreur&=~ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
				switch($mode)
				{
					case 'ajouter':
						$type=array();
						foreach($this->champs['alerte_type'] as $clef=>$valeur)
						{
							if($valeur['objet']->nouveau_alerte!=$this->champs['nouveau_identifiant'] || $valeur['objet']->alerte!=$this->champs['identifiant'])
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							if($valeur['mode']=='modifier')
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							if(array_search($valeur['objet']->nouveau_type,$type)!==false)
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							$resultat=$valeur['objet']->tester('ajouter');
							
							if($resultat & ALERTE_TYPE_NOUVEAU_TYPE_ERREUR)
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							$type[]=$valeur['objet']->nouveau_type;
						}
						break;
					case 'modifier':
						$type=array();
						foreach($this->champs['alerte_type'] as $clef=>$valeur)
						{
							if($valeur['objet']->nouveau_alerte!=$this->champs['nouveau_identifiant'] || $valeur['objet']->alerte!=$this->champs['identifiant'])
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							if(array_search($valeur['objet']->nouveau_type,$type)!==false)
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							$resultat=$valeur['objet']->tester($valeur['mode']);
							
							if($resultat & ALERTE_TYPE_NOUVEAU_TYPE_ERREUR)
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							if($resultat & ALERTE_TYPE_IDENTIFIANT_ERREUR)
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							if($valeur['mode']=='modifier' && ($resultat & ALERTE_TYPE_ALERTE_ERREUR || $resultat & ALERTE_TYPE_TYPE_ERREUR))
								$this->erreur|=ALERTE_ALERTE_TYPE_ERREUR_CLASSE;
							
							$type[]=$valeur['objet']->nouveau_type;
						}
				}				
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					identifiant,
					adherent,
					ville,
					rayon,
					unix_timestamp(enregistrement) as enregistrement,
					unix_timestamp(modification) as modification
				from alerte
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['adherent']=$occurrence['adherent'];
			$this->champs['ville']=$occurrence['ville'];
			$this->champs['rayon']=$occurrence['rayon'];
			$this->champs['enregistrement']=$occurrence['enregistrement'];
			$this->champs['modification']=$occurrence['modification'];
			
			$this->champs['alerte_type']=array();
			$this->executer
			('
				select type
				from alerte_type
				where
					alerte=\''.addslashes($this->champs['identifiant']).'\'
			');
			while($this->donner_suivant($occurrence))
			{
				$alerte_type=new ld_alerte_type();
				$alerte_type->alerte=$this->champs['identifiant'];
				$alerte_type->type=$occurrence['type'];
				$alerte_type->lire();
				
				$clef=sizeof($this->champs['alerte_type']);
				
				$this->champs['alerte_type'][$clef]['objet']=$alerte_type;
				$this->champs['alerte_type'][$clef]['mode']='modifier';
			}
			
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from alerte
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=ALERTE_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=ALERTE_NOUVEAU_IDENTIFIANT_DEFAUT;
			}
			return $this->erreur;
		}
		
		public function ajouter()
		{
			$this->verifier('ajouter');
			if(!$this->erreur)
			{
				$this->champs['enregistrement']=time();
				$this->champs['modification']=time();
				
				$this->executer
				('
					insert into alerte
					(
						identifiant,
						adherent,
						ville,
						rayon,
						enregistrement,
						modification
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['adherent']!==NULL)?('\''.addslashes($this->champs['adherent']).'\''):('null')).',
						'.(($this->champs['ville']!==NULL)?('\''.addslashes($this->champs['ville']).'\''):('null')).',
						'.(($this->champs['rayon']!==NULL)?('\''.addslashes($this->champs['rayon']).'\''):('null')).',
						'.(($this->champs['enregistrement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['enregistrement'])).'\''):('null')).',
						'.(($this->champs['modification']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['modification'])).'\''):('null')).'
					)
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				
				foreach($this->champs['alerte_type'] as $clef=>$valeur)
					$valeur['objet']->ajouter();
			}
			return $this->erreur;
		}
		
		public function modifier()
		{
			$this->verifier('modifier');
			if(!$this->erreur)
			{
				$this->champs['modification']=time();
				
				$this->executer
				('
					update alerte
					set
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						adherent='.(($this->champs['adherent']!==NULL)?('\''.addslashes($this->champs['adherent']).'\''):('null')).',
						ville='.(($this->champs['ville']!==NULL)?('\''.addslashes($this->champs['ville']).'\''):('null')).',
						rayon='.(($this->champs['rayon']!==NULL)?('\''.addslashes($this->champs['rayon']).'\''):('null')).',
						modification='.(($this->champs['modification']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['modification'])).'\''):('null')).'
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				
				$type=array();
				foreach($this->champs['alerte_type'] as $clef=>$valeur)
					$type[]=$valeur['objet']->type;
				
				$this->executer
				('
					select type
					from alerte_type
					where
						alerte=\''.addslashes($this->champs['identifiant']).'\'
						and type not in (\''.implode('\',\'',array_map('addslashes',$type)).'\')
				');
				while($this->donner_suivant($occurrence))
				{
					$alerte_type=new ld_alerte_type();
					$alerte_type->alerte=$this->champs['identifiant'];
					$alerte_type->type=$occurrence['type'];
					$alerte_type->supprimer();
				}
				
				foreach($this->champs['alerte_type'] as $clef=>$valeur)
				{
					if($valeur['mode']!='modifier')
						$valeur['objet']->ajouter();
					else
						$valeur['objet']->modifier();
				}
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