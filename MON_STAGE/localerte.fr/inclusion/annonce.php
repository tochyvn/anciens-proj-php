<?php
	define('REPETITION',str_repeat(' ',4096));
	define('INTERVAL',100);
	define('PAUSE',100);
	define('TENTATIVE',3);
	
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'annonce_email.php');
	require_once(PWD_INCLUSION.'annonce_telephone.php');
	require_once(PWD_INCLUSION.'date.php');
	require_once(PWD_INCLUSION.'fichier.php');
	require_once(PWD_INCLUSION.'exclusion.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	$define_erreur=0;
	
	define('ANNONCE_PERIODICITE_ENUM','H,S,M,A');
	
	define('ANNONCE_IDENTIFIANT_DEFAUT','');
	define('ANNONCE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_NOUVEAU_IDENTIFIANT_MIN',1);
	define('ANNONCE_NOUVEAU_IDENTIFIANT_MAX',9);
	define('ANNONCE_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('ANNONCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ANNONCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('ANNONCE_PARUTION_JOUR_DEFAUT',NULL);
	define('ANNONCE_PARUTION_MOIS_DEFAUT',NULL);
	define('ANNONCE_PARUTION_ANNEE_DEFAUT',NULL);
	define('ANNONCE_PARUTION_NULL',false);
	define('ANNONCE_PARUTION_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_PROVENANCE_NULL',false);
	define('ANNONCE_PROVENANCE_DEFAUT',NULL);
	define('ANNONCE_PROVENANCE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_REFERENCE_MIN',1);
	define('ANNONCE_REFERENCE_MAX',50);
	define('ANNONCE_REFERENCE_NULL',false);
	define('ANNONCE_REFERENCE_DEFAUT',NULL);
	define('ANNONCE_REFERENCE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_PROVENANCE_REFERENCE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_VILLE_NULL',false);
	define('ANNONCE_VILLE_DEFAUT',NULL);
	define('ANNONCE_VILLE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_TYPE_NULL',false);
	define('ANNONCE_TYPE_DEFAUT',NULL);
	define('ANNONCE_TYPE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_MEUBLE_ENUM','OUI,NON');
	define('ANNONCE_MEUBLE_NULL',true);
	define('ANNONCE_MEUBLE_DEFAUT',NULL);
	define('ANNONCE_MEUBLE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_LOYER_MIN',0.01);
	define('ANNONCE_LOYER_MAX',9999.99);
	define('ANNONCE_LOYER_NULL',true);
	define('ANNONCE_LOYER_DEFAUT',NULL);
	define('ANNONCE_LOYER_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('ANNONCE_LOYER_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ANNONCE_DESCRIPTIF_MIN',1);
	define('ANNONCE_DESCRIPTIF_MAX',10000);
	define('ANNONCE_DESCRIPTIF_NULL',false);
	define('ANNONCE_DESCRIPTIF_DEFAUT',NULL);
	define('ANNONCE_DESCRIPTIF_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_STATUT_ENUM','PARTICULIER,PROFESSIONNEL');
	define('ANNONCE_STATUT_NULL',true);
	define('ANNONCE_STATUT_DEFAUT',NULL);
	define('ANNONCE_STATUT_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_IMAGE_MAX',2048);
	define('ANNONCE_IMAGE_NULL',true);
	define('ANNONCE_IMAGE_DEFAUT',NULL);
	define('ANNONCE_IMAGE_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ANNONCE_IMAGE_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ANNONCE_URL_MAX',2048);
	define('ANNONCE_URL_NULL',true);
	define('ANNONCE_URL_DEFAUT',NULL);
	define('ANNONCE_URL_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ANNONCE_URL_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ANNONCE_ETAT_ENUM','VALIDE,REFUS');
	define('ANNONCE_ETAT_NULL',false);
	define('ANNONCE_ETAT_DEFAUT','VALIDE');
	define('ANNONCE_ETAT_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_COMMENTAIRE_MIN',0);
	define('ANNONCE_COMMENTAIRE_MAX',200);
	define('ANNONCE_COMMENTAIRE_NULL',false);
	define('ANNONCE_COMMENTAIRE_DEFAUT',NULL);
	define('ANNONCE_COMMENTAIRE_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_DATE_ENREGISTREMENT_NULL',false);
	define('ANNONCE_DATE_ENREGISTREMENT_DEFAUT',NULL);
	
	define('ANNONCE_ANNONCE_EMAIL_MIN',0);
	define('ANNONCE_ANNONCE_EMAIL_MAX',10);
	define('ANNONCE_ANNONCE_EMAIL_DEFAUT','array,ld_annonce_email');
	define('ANNONCE_ANNONCE_EMAIL_ERREUR_TAILLE',pow(2,$define_erreur++));
	define('ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE',pow(2,$define_erreur++));
	
	define('ANNONCE_ANNONCE_TELEPHONE_MIN',0);
	define('ANNONCE_ANNONCE_TELEPHONE_MAX',10);
	define('ANNONCE_ANNONCE_TELEPHONE_DEFAUT','array,ld_annonce_telephone');
	define('ANNONCE_ANNONCE_TELEPHONE_ERREUR_TAILLE',pow(2,$define_erreur++));
	define('ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE',pow(2,$define_erreur++));
	
	define('ANNONCE_CONTACT_ERREUR',pow(2,$define_erreur++));
	
	define('ANNONCE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_annonce extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_annonce()
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
			$this->champs['identifiant']=ANNONCE_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=ANNONCE_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['parution_jour']=ANNONCE_PARUTION_JOUR_DEFAUT;
			$this->champs['parution_mois']=ANNONCE_PARUTION_MOIS_DEFAUT;
			$this->champs['parution_annee']=ANNONCE_PARUTION_ANNEE_DEFAUT;
			$this->champs['provenance']=ANNONCE_PROVENANCE_DEFAUT;
			$this->champs['reference']=ANNONCE_REFERENCE_DEFAUT;
			$this->champs['ville']=ANNONCE_VILLE_DEFAUT;
			$this->champs['type']=ANNONCE_TYPE_DEFAUT;
			$this->champs['meuble']=ANNONCE_MEUBLE_DEFAUT;
			$this->champs['loyer']=ANNONCE_LOYER_DEFAUT;
			$this->champs['descriptif']=ANNONCE_DESCRIPTIF_DEFAUT;
			$this->champs['statut']=ANNONCE_STATUT_DEFAUT;
			$this->champs['image']=ANNONCE_IMAGE_DEFAUT;
			$this->champs['url']=ANNONCE_URL_DEFAUT;
			$this->champs['etat']=ANNONCE_ETAT_DEFAUT;
			$this->champs['commentaire']=ANNONCE_COMMENTAIRE_DEFAUT;
			$this->champs['enregistrement']=ANNONCE_DATE_ENREGISTREMENT_DEFAUT;
			$this->champs['annonce_email']=array();
			$this->champs['annonce_telephone']=array();
			$this->champs['occurrence']=array();
			$this->champs['maximum']=0;
			$this->champs['minimum']=0;
			$this->champs['moyenne']=0;
			$this->champs['total']=0;
			$this->champs['debut']=NULL;
			$this->champs['fin']=NULL;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=ANNONCE_TOTAL_ERREUR;

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
				if($variable!='annonce_email' && $variable!='annonce_telephone' && $variable!='enregistrement' && $variable!='modification' && $variable!='occurrence' && $variable!='maximum' && $variable!='minimum' && $variable!='moyenne' && $variable!='total' && $variable!='debut' && $variable!='fin')
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
				case 'annonce_email_ajouter':
					if(sizeof($parametre)==2 && is_a($parametre[0],'ld_annonce_email') && preg_match('/^(ajouter|modifier)$/',$parametre[1]))
					{
						$clef=sizeof($this->champs['annonce_email']);
						$this->champs['annonce_email'][$clef]['objet']=$parametre[0];
						$this->champs['annonce_email'][$clef]['mode']=$parametre[1];
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_email_ajouter (ld_annonce_email, \'ajouter\' | \'modifier\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_email_modifier':
					if(sizeof($parametre)==3 && is_a($parametre[0],'ld_annonce_email') && preg_match('/^(ajouter|modifier)$/',$parametre[2]) && is_int($parametre[1]) && isset($this->champs['annonce_email'][$parametre[1]]))
					{
						$this->champs['annonce_email'][$parametre[1]]['objet']=$parametre[0];
						$this->champs['annonce_email'][$parametre[1]]['mode']=$parametre[2];
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_email_modifier (ld_annonce_email, clef, \'ajouter\' | \'modifier\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_email_supprimer':
					if(sizeof($parametre)==1 && is_int($parametre[0]))
					{
						unset($this->champs['annonce_email'][$parametre[0]]);
						$this->champs['annonce_email']=array_values($this->champs['annonce_email']);
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_email_supprimer (clef)'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_email_trouver':
					if(sizeof($parametre)==2 && preg_match('/^(email|nouveau_email)$/',$parametre[1]))
					{
						foreach($this->champs['annonce_email'] as $clef=>$tableau)
						{
							switch($parametre[1])
							{
								case 'email':
									if($tableau['objet']->email==$parametre[0])
										return $clef;
									break;
								case 'nouveau_email':
									if($tableau['objet']->nouveau_email==$parametre[0])
										return $clef;
									break;
							}
						}
						
						return false;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_email_trouver (identifiant, \'annonce\' | \'nouveau_annonce\' | \'email\' | \'nouveau_email\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_email_lire':
					if(sizeof($parametre)==1 && is_int($parametre[0]))
					{
						if(isset($this->champs['annonce_email'][$parametre[0]]))
							return $this->champs['annonce_email'][$parametre[0]];
						
						return false;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_email_lire (clef)'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_email_compter':
					return sizeof($this->champs['annonce_email']);
					break;
				case 'annonce_telephone_ajouter':
					if(sizeof($parametre)==2 && is_a($parametre[0],'ld_annonce_telephone') && preg_match('/^(ajouter|modifier)$/',$parametre[1]))
					{
						$clef=sizeof($this->champs['annonce_telephone']);
						$this->champs['annonce_telephone'][$clef]['objet']=$parametre[0];
						$this->champs['annonce_telephone'][$clef]['mode']=$parametre[1];
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_telephone_ajouter (ld_annonce_telephone, \'ajouter\' | \'modifier\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_telephone_modifier':
					if(sizeof($parametre)==3 && is_a($parametre[0],'ld_annonce_telephone') && preg_match('/^(ajouter|modifier)$/',$parametre[2]) && is_int($parametre[1]) && isset($this->champs['annonce_telephone'][$parametre[1]]))
					{
						$this->champs['annonce_telephone'][$parametre[1]]['objet']=$parametre[0];
						$this->champs['annonce_telephone'][$parametre[1]]['mode']=$parametre[2];
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_telephone_modifier (ld_annonce_telephone, clef, \'ajouter\' | \'modifier\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_telephone_supprimer':
					if(sizeof($parametre)==1 && is_int($parametre[0]))
					{
						unset($this->champs['annonce_telephone'][$parametre[0]]);
						$this->champs['annonce_telephone']=array_values($this->champs['annonce_telephone']);
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_telephone_supprimer (clef)'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_telephone_trouver':
					if(sizeof($parametre)==2 && preg_match('/^(telephone|nouveau_telephone)$/',$parametre[1]))
					{
						foreach($this->champs['annonce_telephone'] as $clef=>$tableau)
						{
							switch($parametre[1])
							{
								case 'telephone':
									if($tableau['objet']->telephone==$parametre[0])
										return $clef;
									break;
								case 'nouveau_telephone':
									if($tableau['objet']->nouveau_telephone==$parametre[0])
										return $clef;
									break;
							}
						}
						
						return false;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_telephone_trouver (identifiant, \'annonce\' | \'nouveau_annonce\' | \'telephone\' | \'nouveau_telephone\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_telephone_lire':
					if(sizeof($parametre)==1 && is_int($parametre[0]))
					{
						if(isset($this->champs['annonce_telephone'][$parametre[0]]))
							return $this->champs['annonce_telephone'][$parametre[0]];
						
						return false;
					}
					
					trigger_error('Param&egrave;tres incorrect: annonce_telephone_lire (clef)'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'annonce_telephone_compter':
					return sizeof($this->champs['annonce_telephone']);
					break;
				default:
					trigger_error('Fonction '.$function.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
			}
		}
		
		/*function annonce_email_ajouter($objet,$mode)
		{
			return $this->__call('annonce_email_ajouter',array($objet,$mode));
		}*/
		
		/*function annonce_email_modifier($objet,$clef,$mode)
		{
			return $this->__call('annonce_email_modifier',array($objet,$clef,$mode));
		}*/
		
		/*function annonce_email_supprimer($clef)
		{
			return $this->__call('annonce_email_supprimer',array($clef));
		}*/
		
		/*function annonce_email_trouver($identifiant,$champ)
		{
			return $this->__call('annonce_email_trouver',array($idnetifiant,$champ));
		}*/
		
		/*function annonce_email_lire($clef)
		{
			return $this->__call('annonce_email_lire',array($clef));
		}*/
		
		/*function annonce_email_compter()
		{
			return $this->__call('annonce_email_compter');
		}*/
		
		/*function annonce_telephone_ajouter($objet,$mode)
		{
			return $this->__call('annonce_telephone_ajouter',array($objet,$mode));
		}*/
		
		/*function annonce_telephone_modifier($objet,$clef,$mode)
		{
			return $this->__call('annonce_telephone_modifier',array($objet,$clef,$mode));
		}*/
		
		/*function annonce_telephone_supprimer($clef)
		{
			return $this->__call('annonce_telephone_supprimer',array($clef));
		}*/
		
		/*function annonce_telephone_trouver($identifiant,$champ)
		{
			return $this->__call('annonce_telephone_trouver',array($idnetifiant,$champ));
		}*/
		
		/*function annonce_telephone_lire($clef)
		{
			return $this->__call('annonce_telephone_lire',array($clef));
		}*/
		
		/*function annonce_telephone_compter()
		{
			return $this->__call('annonce_telephone_compter');
		}*/
		
		private function verifier($mode)
		{
			if($mode=='supprimer')
			{
				$this->executer
				('
					select count(identifiant) as nombre
					from annonce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=ANNONCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from annonce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=ANNONCE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~ANNONCE_IDENTIFIANT_ERREUR;
				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<ANNONCE_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>ANNONCE_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=ANNONCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ANNONCE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from annonce
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ANNONCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~ANNONCE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//PARUTION
				if((!ANNONCE_PARUTION_NULL || $this->champs['parution_jour']!==NULL || $this->champs['parution_mois']!==NULL || $this->champs['parution_annee']!==NULL) && (!checkdate($this->champs['parution_mois'],$this->champs['parution_jour'],$this->champs['parution_annee']) || mktime(0,0,0,$this->champs['parution_mois'],$this->champs['parution_jour'],$this->champs['parution_annee'])>time()))
					$this->erreur|=ANNONCE_PARUTION_ERREUR;
				else
					$this->erreur&=~ANNONCE_PARUTION_ERREUR;
				//PROVENANCE
				$this->executer
				('
					select count(identifiant) as nombre
					from provenance
					where
						identifiant=\''.addslashes($this->champs['provenance']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur|=ANNONCE_PROVENANCE_ERREUR;
				else
					$this->erreur&=~ANNONCE_PROVENANCE_ERREUR;
				//REFERENCE
				if((!ANNONCE_REFERENCE_NULL || $this->champs['reference']!==NULL) && (strlen($this->champs['reference'])<ANNONCE_REFERENCE_MIN || strlen($this->champs['reference'])>ANNONCE_REFERENCE_MAX))
					$this->erreur|=ANNONCE_REFERENCE_ERREUR;
				else
					$this->erreur&=~ANNONCE_REFERENCE_ERREUR;
				//PROVENANCE_REFERENCE
				$this->executer
				('
					select count(identifiant) as nombre
					from annonce
					where
						provenance'.(($this->champs['provenance']!==NULL)?('=\''.addslashes($this->champs['provenance']).'\''):(' is null')).'
						and reference'.(($this->champs['reference']!==NULL)?('=\''.addslashes($this->champs['reference']).'\''):(' is null')).'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ANNONCE_PROVENANCE_REFERENCE_ERREUR;
				else
					$this->erreur&=~ANNONCE_PROVENANCE_REFERENCE_ERREUR;
				//VILLE
				$this->executer
				('
					select count(identifiant) as nombre
					from ville
					where
						identifiant=\''.addslashes($this->champs['ville']).'\'
				');
				$this->donner_suivant($occurrence);
				if((!ANNONCE_VILLE_NULL || $this->champs['ville']!==NULL) && !$occurrence['nombre'])
					$this->erreur|=ANNONCE_VILLE_ERREUR;
				else
					$this->erreur&=~ANNONCE_VILLE_ERREUR;
				//TYPE
				$this->executer
				('
					select count(identifiant) as nombre
					from type
					where
						identifiant=\''.addslashes($this->champs['type']).'\'
				');
				$this->donner_suivant($occurrence);
				if((!ANNONCE_TYPE_NULL || $this->champs['type']!==NULL) && !$occurrence['nombre'])
					$this->erreur|=ANNONCE_TYPE_ERREUR;
				else
					$this->erreur&=~ANNONCE_TYPE_ERREUR;
				//MEUBLE
				if((!ANNONCE_MEUBLE_NULL || $this->champs['meuble']!==NULL) && array_search($this->champs['meuble'],explode(',',ANNONCE_MEUBLE_ENUM))===false)
					$this->erreur|=ANNONCE_MEUBLE_ERREUR;
				else
					$this->erreur&=~ANNONCE_MEUBLE_ERREUR;
				//LOYER
				if((!ANNONCE_LOYER_NULL || $this->champs['loyer']!==NULL) && (floatval($this->champs['loyer'])<ANNONCE_LOYER_MIN || floatval($this->champs['loyer'])>ANNONCE_LOYER_MAX))
					$this->erreur|=ANNONCE_LOYER_ERREUR_VALEUR;
				else
					$this->erreur&=~ANNONCE_LOYER_ERREUR_VALEUR;
				if((!ANNONCE_LOYER_NULL || $this->champs['loyer']!==NULL) && !preg_match('/'.STRING_FILTRE_MONNAIE_POSITIF.'/',$this->champs['loyer']))
					$this->erreur|=ANNONCE_LOYER_ERREUR_FILTRE;
				else
					$this->erreur&=~ANNONCE_LOYER_ERREUR_FILTRE;
				//DESCRIPTIF
				if((!ANNONCE_DESCRIPTIF_NULL || $this->champs['descriptif']!==NULL) && (strlen($this->champs['descriptif'])<ANNONCE_DESCRIPTIF_MIN || strlen($this->champs['descriptif'])>ANNONCE_DESCRIPTIF_MAX))
					$this->erreur|=ANNONCE_DESCRIPTIF_ERREUR;
				else
					$this->erreur&=~ANNONCE_DESCRIPTIF_ERREUR;
				//STATUT
				if((!ANNONCE_STATUT_NULL || $this->champs['statut']!==NULL) && array_search($this->champs['statut'],explode(',',ANNONCE_STATUT_ENUM))===false)
					$this->erreur|=ANNONCE_STATUT_ERREUR;
				else
					$this->erreur&=~ANNONCE_STATUT_ERREUR;
				//IMAGE
				if((!ANNONCE_IMAGE_NULL || $this->champs['image']!==NULL) && strlen($this->champs['image'])>ANNONCE_IMAGE_MAX)
					$this->erreur|=ANNONCE_IMAGE_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ANNONCE_IMAGE_ERREUR_LONGUEUR;
				if((!ANNONCE_IMAGE_NULL || $this->champs['image']!==NULL) && !preg_match('/'.STRING_FILTRE_URL.'/',$this->champs['image']))
					$this->erreur|=ANNONCE_IMAGE_ERREUR_FILTRE;
				else
					$this->erreur&=~ANNONCE_IMAGE_ERREUR_FILTRE;
				//URL
				if((!ANNONCE_URL_NULL || $this->champs['url']!==NULL) && strlen($this->champs['url'])>ANNONCE_URL_MAX)
					$this->erreur|=ANNONCE_URL_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ANNONCE_URL_ERREUR_LONGUEUR;
				if((!ANNONCE_URL_NULL || $this->champs['url']!==NULL) && !preg_match('/'.STRING_FILTRE_URL.'/',$this->champs['url']))
					$this->erreur|=ANNONCE_URL_ERREUR_FILTRE;
				else
					$this->erreur&=~ANNONCE_URL_ERREUR_FILTRE;
				//ETAT
				if((!ANNONCE_ETAT_NULL || $this->champs['etat']!==NULL) && array_search($this->champs['etat'],explode(',',ANNONCE_ETAT_ENUM))===false)
					$this->erreur|=ANNONCE_ETAT_ERREUR;
				else
					$this->erreur&=~ANNONCE_ETAT_ERREUR;
				//COMMENTAIRE
				if((!ANNONCE_COMMENTAIRE_NULL || $this->champs['commentaire']!==NULL) && (strlen($this->champs['commentaire'])<ANNONCE_COMMENTAIRE_MIN || strlen($this->champs['commentaire'])>ANNONCE_COMMENTAIRE_MAX))
					$this->erreur|=ANNONCE_COMMENTAIRE_ERREUR;
				else
					$this->erreur&=~ANNONCE_COMMENTAIRE_ERREUR;
				//ANNONCE_EMAIL
				if(sizeof($this->champs['annonce_email'])<ANNONCE_ANNONCE_EMAIL_MIN || sizeof($this->champs['annonce_email'])>ANNONCE_ANNONCE_EMAIL_MAX)
					$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_TAILLE;
				else
					$this->erreur&=~ANNONCE_ANNONCE_EMAIL_ERREUR_TAILLE;
				$this->erreur&=~ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
				switch($mode)
				{
					case 'ajouter':
						$email=array();
						foreach($this->champs['annonce_email'] as $clef=>$valeur)
						{
							if($valeur['objet']->nouveau_annonce!=$this->champs['nouveau_identifiant'] || $valeur['objet']->annonce!=$this->champs['identifiant'])
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							if($valeur['mode']=='modifier')
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							if(array_search($valeur['objet']->nouveau_email,$email)!==false)
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							$resultat=$valeur['objet']->tester('ajouter');
							
							if($resultat & ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_LONGUEUR || $resultat & ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_FILTRE)
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							$email[]=$valeur['objet']->nouveau_email;
						}
						break;
					case 'modifier':
						$email=array();
						foreach($this->champs['annonce_email'] as $clef=>$valeur)
						{
							if($valeur['objet']->nouveau_annonce!=$this->champs['nouveau_identifiant'] || $valeur['objet']->annonce!=$this->champs['identifiant'])
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							if(array_search($valeur['objet']->nouveau_email,$email)!==false)
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							$resultat=$valeur['objet']->tester($valeur['mode']);
							
							if($resultat & ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_LONGUEUR || $resultat & ANNONCE_EMAIL_NOUVEAU_EMAIL_ERREUR_FILTRE)
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							if($resultat & ANNONCE_EMAIL_IDENTIFIANT_ERREUR)
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							if($valeur['mode']=='modifier' && $resultat & ANNONCE_EMAIL_ANNONCE_ERREUR )
								$this->erreur|=ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE;
							
							$email[]=$valeur['objet']->nouveau_email;
						}
				}				
				//ANNONCE_TELEPHONE
				if(sizeof($this->champs['annonce_telephone'])<ANNONCE_ANNONCE_TELEPHONE_MIN || sizeof($this->champs['annonce_telephone'])>ANNONCE_ANNONCE_TELEPHONE_MAX)
					$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_TAILLE;
				else
					$this->erreur&=~ANNONCE_ANNONCE_TELEPHONE_ERREUR_TAILLE;
				$this->erreur&=~ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
				switch($mode)
				{
					case 'ajouter':
						$telephone=array();
						foreach($this->champs['annonce_telephone'] as $clef=>$valeur)
						{
							if($valeur['objet']->nouveau_annonce!=$this->champs['nouveau_identifiant'] || $valeur['objet']->annonce!=$this->champs['identifiant'])
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							if($valeur['mode']=='modifier')
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							if(array_search($valeur['objet']->nouveau_telephone,$telephone)!==false)
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							$resultat=$valeur['objet']->tester('ajouter');
							
							if($resultat & ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_LONGUEUR || $resultat & ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_FILTRE)
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							$telephone[]=$valeur['objet']->nouveau_telephone;
						}
						break;
					case 'modifier':
						$telephone=array();
						foreach($this->champs['annonce_telephone'] as $clef=>$valeur)
						{
							if($valeur['objet']->nouveau_annonce!=$this->champs['nouveau_identifiant'] || $valeur['objet']->annonce!=$this->champs['identifiant'])
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							if(array_search($valeur['objet']->nouveau_telephone,$telephone)!==false)
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							$resultat=$valeur['objet']->tester($valeur['mode']);
							
							if($resultat & ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_LONGUEUR || $resultat & ANNONCE_TELEPHONE_NOUVEAU_TELEPHONE_ERREUR_FILTRE)
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							if($resultat & ANNONCE_TELEPHONE_IDENTIFIANT_ERREUR)
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							if($valeur['mode']=='modifier' && $resultat & ANNONCE_TELEPHONE_ANNONCE_ERREUR)
								$this->erreur|=ANNONCE_ANNONCE_TELEPHONE_ERREUR_CLASSE;
							
							$telephone[]=$valeur['objet']->nouveau_telephone;
						}
				}
				//CONTACT
				if($this->champs['url']===NULL)
					$this->erreur|=ANNONCE_CONTACT_ERREUR;
				else
					$this->erreur&=~ANNONCE_CONTACT_ERREUR;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					identifiant,
					day(parution) as parution_jour,
					month(parution) as parution_mois,
					year(parution) as parution_annee,
					provenance,
					reference,
					type,
					meuble,
					ville,
					loyer,
					descriptif,
					statut,
					image,
					url,
					etat,
					commentaire,
					unix_timestamp(enregistrement) as enregistrement,
					unix_timestamp(modification) as modification
				from annonce
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['parution_jour']=$occurrence['parution_jour'];
			$this->champs['parution_mois']=$occurrence['parution_mois'];
			$this->champs['parution_annee']=$occurrence['parution_annee'];
			$this->champs['provenance']=$occurrence['provenance'];
			$this->champs['reference']=$occurrence['reference'];
			$this->champs['type']=$occurrence['type'];
			$this->champs['meuble']=$occurrence['meuble'];
			$this->champs['ville']=$occurrence['ville'];
			$this->champs['loyer']=$occurrence['loyer'];
			$this->champs['descriptif']=$occurrence['descriptif'];
			$this->champs['statut']=$occurrence['statut'];
			$this->champs['image']=$occurrence['image'];
			$this->champs['url']=$occurrence['url'];
			$this->champs['etat']=$occurrence['etat'];
			$this->champs['commentaire']=$occurrence['commentaire'];
			$this->champs['enregistrement']=$occurrence['enregistrement'];
			$this->champs['modification']=$occurrence['modification'];
			
			$this->champs['annonce_email']=array();
			$this->executer
			('
				select email
				from annonce_email
				where
					annonce=\''.addslashes($this->champs['identifiant']).'\'
			');
			while($this->donner_suivant($occurrence))
			{
				$annonce_email=new ld_annonce_email();
				$annonce_email->annonce=$this->champs['identifiant'];
				$annonce_email->email=$occurrence['email'];
				$annonce_email->lire();
				
				$clef=sizeof($this->champs['annonce_email']);
				
				$this->champs['annonce_email'][$clef]['objet']=$annonce_email;
				$this->champs['annonce_email'][$clef]['mode']='modifier';
			}
			
			$this->champs['annonce_telephone']=array();
			$this->executer
			('
				select telephone as telephone
				from annonce_telephone
				where
					annonce=\''.addslashes($this->champs['identifiant']).'\'
			');
			while($this->donner_suivant($occurrence))
			{
				$annonce_telephone=new ld_annonce_telephone();
				$annonce_telephone->annonce=$this->champs['identifiant'];
				$annonce_telephone->telephone=$occurrence['telephone'];
				$annonce_telephone->lire();
				
				$clef=sizeof($this->champs['annonce_telephone']);
				
				$this->champs['annonce_telephone'][$clef]['objet']=$annonce_telephone;
				$this->champs['annonce_telephone'][$clef]['mode']='modifier';
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
					delete from annonce
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=ANNONCE_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=ANNONCE_NOUVEAU_IDENTIFIANT_DEFAUT;
			}
			return $this->erreur;
		}
		
		public function ajouter()
		{
			$this->verifier('ajouter');
			if(!$this->erreur)
			{
				$this->champs['enregistrement']=time();
				$this->champs['modification']=$this->champs['enregistrement'];
				
				$this->executer
				('
					insert into annonce
					(
						identifiant,
						parution,
						provenance,
						reference,
						type,
						meuble,
						ville,
						loyer,
						descriptif,
						statut,
						image,
						url,
						etat,
						commentaire,
						enregistrement,
						modification
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['parution_jour']!==NULL && $this->champs['parution_mois']!==NULL && $this->champs['parution_annee']!==NULL)?('\''.addslashes(date(_SQL_DATE,mktime(0,0,0,$this->champs['parution_mois'],$this->champs['parution_jour'],$this->champs['parution_annee']))).'\''):('null')).',
						'.(($this->champs['provenance']!==NULL)?('\''.addslashes($this->champs['provenance']).'\''):('null')).',
						'.(($this->champs['reference']!==NULL)?('\''.addslashes($this->champs['reference']).'\''):('null')).',
						'.(($this->champs['type']!==NULL)?('\''.addslashes($this->champs['type']).'\''):('null')).',
						'.(($this->champs['meuble']!==NULL)?('\''.addslashes($this->champs['meuble']).'\''):('null')).',
						'.(($this->champs['ville']!==NULL)?('\''.addslashes($this->champs['ville']).'\''):('null')).',
						'.(($this->champs['loyer']!==NULL)?('\''.addslashes($this->champs['loyer']).'\''):('null')).',
						'.(($this->champs['descriptif']!==NULL)?('\''.addslashes($this->champs['descriptif']).'\''):('null')).',
						'.(($this->champs['statut']!==NULL)?('\''.addslashes($this->champs['statut']).'\''):('null')).',
						'.(($this->champs['image']!==NULL)?('\''.addslashes($this->champs['image']).'\''):('null')).',
						'.(($this->champs['url']!==NULL)?('\''.addslashes($this->champs['url']).'\''):('null')).',
						'.(($this->champs['etat']!==NULL)?('\''.addslashes($this->champs['etat']).'\''):('null')).',
						'.(($this->champs['commentaire']!==NULL)?('\''.addslashes($this->champs['commentaire']).'\''):('null')).',
						'.(($this->champs['enregistrement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['enregistrement'])).'\''):('null')).',
						'.(($this->champs['modification']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['modification'])).'\''):('null')).'
					)
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				
				foreach($this->champs['annonce_email'] as $clef=>$valeur)
					$valeur['objet']->ajouter();
				
				foreach($this->champs['annonce_telephone'] as $clef=>$valeur)
					$valeur['objet']->ajouter();
			}
			return $this->erreur;
		}
		
		public function modifier()
		{
			$this->verifier('modifier');
			if(!$this->erreur)
			{
				$annonce=new ld_annonce();
				$annonce->identifiant=$this->champs['identifiant'];
				$annonce->lire();
				if($annonce->etat!=$this->champs['etat'] && $this->champs['etat']=='REFUS')
					$this->executer
					('
						delete from liste
						where
							identifiant=\''.addslashes($this->champs['identifiant']).'\'
					');
				
				$this->champs['modification']=time();
				
				$this->executer
				('
					update annonce
					set
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						parution='.(($this->champs['parution_jour']!==NULL && $this->champs['parution_mois']!==NULL && $this->champs['parution_annee']!==NULL)?('\''.addslashes(date(_SQL_DATE,mktime(0,0,0,$this->champs['parution_mois'],$this->champs['parution_jour'],$this->champs['parution_annee']))).'\''):('null')).',
						provenance='.(($this->champs['provenance']!==NULL)?('\''.addslashes($this->champs['provenance']).'\''):('null')).',
						reference='.(($this->champs['reference']!==NULL)?('\''.addslashes($this->champs['reference']).'\''):('null')).',
						type='.(($this->champs['type']!==NULL)?('\''.addslashes($this->champs['type']).'\''):('null')).',
						meuble='.(($this->champs['meuble']!==NULL)?('\''.addslashes($this->champs['meuble']).'\''):('null')).',
						ville='.(($this->champs['ville']!==NULL)?('\''.addslashes($this->champs['ville']).'\''):('null')).',
						loyer='.(($this->champs['loyer']!==NULL)?('\''.addslashes($this->champs['loyer']).'\''):('null')).',
						descriptif='.(($this->champs['descriptif']!==NULL)?('\''.addslashes($this->champs['descriptif']).'\''):('null')).',
						statut='.(($this->champs['statut']!==NULL)?('\''.addslashes($this->champs['statut']).'\''):('null')).',
						image='.(($this->champs['image']!==NULL)?('\''.addslashes($this->champs['image']).'\''):('null')).',
						url='.(($this->champs['url']!==NULL)?('\''.addslashes($this->champs['url']).'\''):('null')).',
						etat='.(($this->champs['etat']!==NULL)?('\''.addslashes($this->champs['etat']).'\''):('null')).',
						commentaire='.(($this->champs['commentaire']!==NULL)?('\''.addslashes($this->champs['commentaire']).'\''):('null')).',
						enregistrement='.(($this->champs['enregistrement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['enregistrement'])).'\''):('null')).',
						modification='.(($this->champs['modification']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['modification'])).'\''):('null')).'
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				
				$email=array();
				foreach($this->champs['annonce_email'] as $clef=>$valeur)
					$email[]=$valeur['objet']->email;
				
				$this->executer
				('
					select email
					from annonce_email
					where
						annonce=\''.addslashes($this->champs['identifiant']).'\'
						and email not in (\''.implode('\',\'',array_map('addslashes',$email)).'\')
				');
				while($this->donner_suivant($occurrence))
				{
					$annonce_email=new ld_annonce_email();
					$annonce_email->annonce=$this->champs['identifiant'];
					$annonce_email->email=$occurrence['email'];
					$annonce_email->supprimer();
				}
				
				foreach($this->champs['annonce_email'] as $clef=>$valeur)
				{
					if($valeur['mode']!='modifier')
						$valeur['objet']->ajouter();
					else
						$valeur['objet']->modifier();
				}
				
				$telephone=array();
				foreach($this->champs['annonce_telephone'] as $clef=>$valeur)
					$telephone[]=$valeur['objet']->telephone;
				
				$this->executer
				('
					select telephone as telephone
					from annonce_telephone
					where
						annonce=\''.addslashes($this->champs['identifiant']).'\'
						and telephone not in (\''.implode('\',\'',array_map('addslashes',$telephone)).'\')
				');
				while($this->donner_suivant($occurrence))
				{
					$annonce_telephone=new ld_annonce_telephone();
					$annonce_telephone->annonce=$this->champs['identifiant'];
					$annonce_telephone->telephone=$occurrence['telephone'];
					$annonce_telephone->supprimer();
				}
				
				foreach($this->champs['annonce_telephone'] as $clef=>$valeur)
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
		
		public function importer($chemin,$strrnd_mode,$compteur)
		{
			$preference=new ld_preference();
			
			$ecrire=create_function('$id,$message',
			'
				print
				(\'
					<script language="javascript">
						document.getElementById(\\\'\'.ma_htmlentities($id).\'\\\').innerHTML=\\\'\'.ma_htmlentities($message).\'\\\';
					</script>
					<noscript>\'.ma_htmlentities($message).\'<br /></noscript>\'.REPETITION.\'
				\');
				flush();
			');
			
			$est_brule=create_function('$champ,$tableau',
			'
				for($i=0;$i<sizeof($tableau);$i++)
					if(preg_match(\'/\'.preg_quote($champ,\'/\').\'/\',$tableau[$i]))
						return true;
				
				return false;
			');
			
			$recherche_tous=array
			(
				'/:point virgule:/',
				'/:saut ligne:/',
				'/:saut paragraphe:/',
				'/:guillemet:/'
			);
			$remplacement_tous=array
			(
				';',
				CR,
				LF,
				'"'
			);
			
			$recherche_type=array
			(
				'/ +/',
				'/(^ +| +$)/',
				'/(^|[^A-Z])([1-9])( |\r\n|\r|\n)?pi.ces?([^A-Z]|$)/i',
				'/T([0-9]) et plus/i',
				'/ et plus/'
			);
			$remplacement_type=array
			(
				' ',
				'',
				'$2',
				'T$1',
				''
			);
			
			$recherche_titre_descriptif=array
			(
				'/(dans|ds)[^a-z]+(une?[^a-z]+)?((beau|belle)[^a-z]+)?(mais\.|maison|villa|pavillon|demeure|bastide)/i',
				'/(rdc|rez de chauss[ée])[^a-z]+(de|d\'une?)[^a-z]+((beau|belle)[^a-z]+)?(mais\.|maison|villa|pavillon|demeure|bastide)/i',
				'/[é|e]tage[^a-z]+(de|d\'une?)[^a-z]+((beau|belle)[^a-z]+)?(mais\.|maison|villa|pavillon|demeure|bastide)/i'
			);
			
			$remplacement_titre_descriptif=array
			(
				' ',
				' ',
				' '
			);
			
			$type_niveau1=array
			(
				'mais\.'=>'maison',
				'maisons?'=>'maison',
				'villas?'=>'villa',
				'pavillons?'=>'pavillon',
				'demeures?'=>'demeure',
				'bastides?'=>'bastide',
				'mas'=>'mas'
			);
			$type_niveau2=array
			(
				'loft'=>'loft',
				'duplex'=>'duplex',
				'triplex'=>'triplex',
				'(T|F)1(bis)?'=>'T1',
				'(T|F)2(bis)?'=>'T2',
				'(T|F)3(bis)?'=>'T3',
				'(T|F)4(bis)?'=>'T4',
				'(T|F)5(bis)?'=>'T5',
				'(T|F)6(bis)?'=>'T6',
				'(T|F)7(bis)?'=>'T7',
				'(T|F)8(bis)?'=>'T8',
				'(T|F)9(bis)?'=>'T9',
				'Type 1(bis)?'=>'T1',
				'Type 2(bis)?'=>'T2',
				'Type 3(bis)?'=>'T3',
				'Type 4(bis)?'=>'T4',
				'Type 5(bis)?'=>'T5',
				'Type 6(bis)?'=>'T6',
				'Type 7(bis)?'=>'T7',
				'Type 8(bis)?'=>'T8',
				'Type 9(bis)?'=>'T9',
				'studios?'=>'studio',
				'studettes?'=>'studette',
				'bateaux?'=>'bateau',
				'p.niches?'=>'péniche'
			);
			$type_niveau3=array
			(
				'(1|une) ?(pi.ce|pce)'=>'T1',
				'(2|deux) ?(pi.ce|pce)s?'=>'T2',
				'(3|trois) ?(pi.ce|pce)s?'=>'T3',
				'(4|quatre) ?(pi.ce|pce)s?'=>'T4',
				'(5|cinq) ?(pi.ce|pce)s?'=>'T5',
				'(6|six) ?(pi.ce|pce)s?'=>'T6',
				'(7|sept) ?(pi.ce|pce)s?'=>'T7',
				'(8|huit) ?(pi.ce|pce)s?'=>'T8',
				'(9|huit) ?(pi.ce|pce)s?'=>'T9',
				'(1|une) ?(chambre|ch|chbre)'=>'T2',
				'(2|deux) ?(chambre|ch|chbre)s?'=>'T3',
				'(3|trois) ?(chambre|ch|chbre)s?'=>'T4',
				'(4|quatre) ?(chambre|ch|chbre)s?'=>'T5',
				'(5|cinq) ?(chambre|ch|chbre)s?'=>'T6',
				'(6|six) ?(chambre|ch|chbre)s?'=>'T7',
				'(7|sept) ?(chambre|ch|chbre)s?'=>'T8',
				'(8|huit) ?(chambre|ch|chbre)s?'=>'T9'
			);
			$type_niveau4=array
			(
				'loca(l|aux)'=>'local',
				'bureaux?'=>'bureau',
				'ateliers?'=>'atelier',
				'hangars?'=>'hangar',
				'entrep.ts?'=>'entrepôt',
				'(garage|gge)s?'=>'garage',
				'(park(ing)|pkg)?'=>'parking',
				'caves?'=>'cave',
				'box'=>'box',
				'colocation'=>'colocation',
				'chambre de bonne'=>'ch. de bonne',
				'fermes?'=>'ferme',
				'fermettes?'=>'fermette'
			);
			
			$this->executer
			('
			 	select type.identifiant
				from type
					left join type parent on type.parent=parent.identifiant
				where type.designation=\'maison\'
					or parent.designation=\'maison\'
			');
			$type_maison_identifiant=array();
			while($this->donner_suivant($occurrence))
				$type_maison_identifiant[]=$occurrence['identifiant'];
			
			$type_non_niveau1=array
			(
				'appart',
				'studio',
				'studette',
				'f1',
				'f2',
				't1',
				't2'
			);
			
			$type_maison_recherche=array
			(
				'(T|F)1(bis)?'=>'T1',
				'(T|F)2(bis)?'=>'T2',
				'Type 1(bis)?'=>'T1',
				'Type 2(bis)?'=>'T2',
				'studios?'=>'studio',
				'studettes?'=>'studette'
			);
			
			$recherche_ville=array
			(
				'/-/',
				'/(^|[^A-Z])ST([^A-Z]|$)/',
				'/(^|[^A-Z])STE([^A-Z]|$)/',
				'/(^|[^A-Z])S?\/([^A-Z]|$)/',
				'/(^|[^A-Z])D /',
				'/(^|[^A-Z])L /',
				'/\' /',
				'/ CEDEX.*/',
				'/(^|[^A-Z])(A )?[0-9]+ ?KM (DE )?|AUTOUR DE |SECTEUR (DE )?|PROCHE (DE )?/',
				'/(^|[^A-Z])(SUD|NORD|EST|OUEST) DE /',
				'/(^|[^A-Z])(SUD|NORD|EST|OUEST) /',
				'/ (SUD|NORD|EST|OUEST)([^A-Z]|$)/',
				'/ CENTRE$/',
				'/^CENTRE /',
				'/^REGION /',
				'/[^A-Z]+\((LE|LA|LES|L\')\)$/',
				'/ \([^\/0-9]+\)/',
				'/ +/',
				'/(^ +| +$)/'
			);
			$remplacement_ville=array
			(
				' ',
				'$1SAINT$2',
				'$1SAINTE$2',
				'$1SUR$2',
				'$1D\'',
				'$1L\'',
				'\'',
				'',
				'',
				'$1',
				'$1',
				'$2',
				'',
				'',
				'',
				'$1 ',
				'',
				' ',
				''
			);
			
			$brule=array();
			if($preference->http_exclusion!==NULL)
			{
				$telechargement=false;
				for($i=0;$i<TENTATIVE && !$telechargement;$i++)
					$telechargement=($contenu=@file_get_contents($preference->http_exclusion));
				if($telechargement)
					$brule=explode(CRLF,trim($contenu));
				else
					print('Impossible de t&eacute;l&eacute;charger les brul&eacute;s<br />');
			}
			
			$constante=get_defined_constants(true);
			$erreur=array();
			foreach($constante['user'] as $clef=>$valeur)
				if(preg_match('/^ANNONCE_.+_ERREUR/',$clef) && !preg_match('/^ANNONCE_TOTAL_ERREUR$/',$clef) && !preg_match('/^(ANNONCE_EMAIL|ANNONCE_TELEPHONE)/',$clef))
				{
					$erreur[$clef]['valeur']=$valeur;
					$erreur[$clef]['nombre']=0;
				}
			
			$total=0;
			$debut=time();
			
			$importe=0;
			$ajoute=0;
			$modifie=0;
			$rejete=0;
			$exclu=0;
			$surtaxe=0;
			$brule=0;
			$taille_errone=0;
			$nouveau=0;
			
			set_time_limit(0);
			$memory_limit=ini_get('memory_limit');
			ini_set('memory_limit',-1);
			$max_execution_time=ini_get('max_execution_time');
			//ini_set('max_execution_time',0);
			//$ignore_user_abort=ignore_user_abort(false);
			//$ignore_user_abort=ignore_user_abort(true);
			
			if(!is_file($chemin) || !($fichier=fopen($chemin,'r')))
				return false;
			
			$log_chemin=tempnam(PWD_INCLUSION.'prive/temp/','');
			$log_fichier=fopen($log_chemin,'w');
			
			print('<span class="important">Chemin: '.ma_htmlentities($chemin).'</span><br />'.REPETITION);
			print('<span class="important">D&eacute;but du traitement de l\'import: '.strftime(STRING_DATETIMECOMLPLET).'</span><br />'.REPETITION);
			flush();
			
			print('<div id="nombre_'.$compteur.'">Nombre: ind&eacute;fini</div>'.REPETITION);
			print('<div id="importe_'.$compteur.'">Import&eacute;: '.$importe.'</div>'.REPETITION);
			print('<div id="ajoute_'.$compteur.'">Ajout&eacute;: '.$ajoute.'</div>'.REPETITION);
			print('<div id="modifie_'.$compteur.'">Modifi&eacute;: '.$modifie.'</div>'.REPETITION);
			print('<div id="rejete_'.$compteur.'">R&eacute;jet&eacute;: '.$rejete.'</div>'.REPETITION);
			print('<div id="exclu_'.$compteur.'">Exclu: '.$exclu.'</div>'.REPETITION);
			print('<div id="surtaxe_'.$compteur.'">Surtaxe: '.$surtaxe.'</div>'.REPETITION);
			print('<div id="brule_'.$compteur.'">Brul&eacute;: '.$brule.'</div>'.REPETITION);
			print('<div id="taille_errone_'.$compteur.'">Taille erron&eacute;e: '.$taille_errone.'</div>'.REPETITION);
			flush();
			
			$provenance=array();
			$type=array();
			$ville=array();
			
			while(!feof($fichier))
			{
				$champs=fgetcsv($fichier,8192,';','"');
				$taille=sizeof($champs);
				
				if($taille>=11)
				{
					for($i=0;$i<$taille;$i++)
						$champs[$i]=preg_replace($recherche_tous,$remplacement_tous,$champs[$i]);
					
					if($taille>=16 && $champs[9]!='')
						$titre_desctiptif=$champs[9].' '.$champs[8];
					else
						$titre_desctiptif=$champs[8];
					
					$titre_desctiptif=str_replace(CRLF,' ',$titre_desctiptif);
					$titre_desctiptif=str_replace(CR,' ',$titre_desctiptif);
					$titre_desctiptif=str_replace(LF,' ',$titre_desctiptif);
					$titre_desctiptif=preg_replace('/ +/',' ',$titre_desctiptif);
					
					$exclusion=new ld_exclusion();
					if(!$exclusion->chercher($titre_desctiptif))
					{
						
						$this->__construct();
						
						//PROVENANCE
						$array_search=array_search($champs[0],$provenance);
						if($array_search!==false)
							$this->champs['provenance']=$array_search;
						else
						{
							$this->executer
							('
								select identifiant
								from provenance
								where code=\''.addslashes($champs[0]).'\'
							');
							if($this->donner_suivant($occurrence))
							{
								$this->champs['provenance']=$occurrence['identifiant'];
								$provenance[$occurrence['identifiant']]=$champs[0];
							}
							else
								$this->champs['provenance']=NULL;
						}
						
						//REFERENCE
						$this->champs['reference']=$champs[3];
						
						//IDENTIFIANT NOUVEAU_IDENTIFIANT
						$this->executer
						('
							select identifiant
							from annonce
							where provenance=\''.addslashes($this->champs['provenance']).'\'
								and reference=\''.addslashes($this->champs['reference']).'\'
						');
						if(!$this->donner_suivant($occurrence))
						{
							$this->champs['identifiant']='';
							$this->champs['nouveau_identifiant']=sql_eviter_doublon_strrnd('ld_annonce','identifiant',ANNONCE_NOUVEAU_IDENTIFIANT_MAX,$strrnd_mode);
							$this->champs['etat']='VALIDE';
							$mode='ajouter';
							$ajoute++;
						}
						else
						{
							$this->champs['identifiant']=$occurrence['identifiant'];
							$this->lire();
							if($this->champs['nouveau_identifiant'])
							
							$mode='modifier';
							$modifie++;
						}
						
						//PARUTION
						if(preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/',$champs[2]))
							list($this->champs['parution_jour'],$this->champs['parution_mois'],$this->champs['parution_annee'])=explode('/',$champs[2]);
						else
						{
							$this->champs['parution_jour']=NULL;
							$this->champs['parution_mois']=NULL;
							$this->champs['parution_annee']=NULL;
						}
						
						//if($this->champs['parution_mois']==12 && $this->champs['parution_annee']==2009)
						//	$this->champs['parution_annee']=2008;
						
						//DESCRIPTION
						$this->champs['descriptif']=$champs[8];
						
						//TYPE
						$champs[6]=preg_replace($recherche_type,$remplacement_type,$champs[6]);
						
						$this->champs['type']=NULL;
						
						if(isset($type[$champs[6]]))
							$this->champs['type']=$type[$champs[6]];
						else
						{
							$this->executer
							('
								select
									identifiant,
									designation
								from type
								where designation=\''.addslashes($champs[6]).'\'
							');
								
							$occurrence=array();
							while($this->donner_suivant($occurrence[]));
							unset($occurrence[sizeof($occurrence)-1]);
								
							switch(sizeof($occurrence))
							{
								case 0:
									$type[$champs[6]]=NULL;
									break;
								default:
								case 1:
									$this->champs['type']=$occurrence[0]['identifiant'];
									$type[$champs[6]]=$occurrence[0]['identifiant'];
									break;
							}
						}
						
						if($this->champs['type']===NULL)
						{
							$designation='';
							$non_niveau1=false;
							$temp=preg_replace($recherche_titre_descriptif,$remplacement_titre_descriptif,$titre_desctiptif);
							
							reset($type_non_niveau1);
							while(!$non_niveau1 && list($recherche,$remplacement)=each($type_non_niveau1))
								if(preg_match('/(^|[^A-Z])('.$recherche.')([^A-Z]|$)/i',$temp))
									$non_niveau1=true;
							
							reset($type_niveau1);
							while(!$non_niveau1 && $designation=='' && list($recherche,$remplacement)=each($type_niveau1))
								if(preg_match('/(^|[^A-Z])('.$recherche.')([^A-Z]|$)/i',$temp))
									$designation=$remplacement;
							
							reset($type_niveau2);
							while($designation=='' && list($recherche,$remplacement)=each($type_niveau2))
								if(preg_match('/(^|[^A-Z])('.$recherche.')([^A-Z]|$)/i',$temp))
									$designation=$remplacement;
							
							reset($type_niveau3);
							while($designation=='' && list($recherche,$remplacement)=each($type_niveau3))
								if(preg_match('/(^|[^A-Z])('.$recherche.')([^A-Z]|$)/i',$temp))
									$designation=$remplacement;
							
							reset($type_niveau4);
							while($designation=='' && list($recherche,$remplacement)=each($type_niveau4))
								if(preg_match('/(^|[^A-Z])('.$recherche.')([^A-Z]|$)/i',$temp))
									$designation=$remplacement;
							
							if($designation=='' && preg_match('/^([1-9])$/',$champs[6],$resultat))
								$designation='T'.$resultat[1];
							
							if(isset($type[$designation]))
								$this->champs['type']=$type[$designation];
							else
							{
								$this->executer
								('
									select
										identifiant,
										designation
									from type
									where designation=\''.addslashes($designation).'\'
								');
								
								$occurrence=array();
								while($this->donner_suivant($occurrence[]));
								unset($occurrence[sizeof($occurrence)-1]);
									
								switch(sizeof($occurrence))
								{
									case 0:
										$type[$designation]=NULL;
										break;
									default:
									case 1:
										$this->champs['type']=$occurrence[0]['identifiant'];
										$type[$designation]=$occurrence[0]['identifiant'];
										break;
								}
							}
							
							//TYPE MAISON
							/*if(array_search($this->champs['type'],$type_maison_identifiant)!==false)
							{
								$designation='';
								$temp=preg_replace($recherche_titre_descriptif,$remplacement_titre_descriptif,$titre_desctiptif);
								
								reset($type_maison_recherche);
								while($designation=='' && list($recherche,$remplacement)=each($type_maison_recherche))
									if(preg_match('/(^|[^A-Z])('.$recherche.')([^A-Z]|$)/i',$temp))
										$designation=$remplacement;
								
								if(isset($type[$designation]))
									$this->champs['type']=$type[$designation];
								else
								{
									$this->executer
									('
										select
											identifiant,
											designation
										from type
										where designation=\''.addslashes($designation).'\'
									');
									
									$occurrence=array();
									while($this->donner_suivant($occurrence[]));
									unset($occurrence[sizeof($occurrence)-1]);
										
									switch(sizeof($occurrence))
									{
										case 0:
											$type[$designation]=NULL;
											break;
										default:
										case 1:
											$this->champs['type']=$occurrence[0]['identifiant'];
											$type[$designation]=$occurrence[0]['identifiant'];
											break;
									}
								}
								
								if($designation!='')
									echo $this->champs['nouveau_identifiant'].' '.$designation.'<br />';
							}*/
						}
						
						//VILLE
						$champs[4]=strtoupper(sans_accent($champs[4]));
						$champs[4]=preg_replace($recherche_ville,$remplacement_ville,$champs[4]);
						if(strlen($champs[5])==1)
							$champs[5]='0'.$champs[5];
						
						if(preg_match('/^PARIS[^0-9]*([0-9]+)([^0-9]|$)/',$champs[4],$resultat) && strlen($champs[5])<5)
						{
							switch(strlen($resultat[1]))
							{
								case 1:
									$champs[4]='PARIS';
									$champs[5]='7500'.$resultat[1];
									break;
								case 2:
									$champs[4]='PARIS';
									$champs[5]='750'.$resultat[1];
									break;
								case 5:
									if(strpos($resultat[1],'750')===0)
									{
										$champs[4]='PARIS';
										$champs[5]=$resultat[1];
									}
									break;
							}
						}
						
						if(preg_match('/^MARSEILLE[^0-9]*([0-9]+)([^0-9]|$)/',$champs[4],$resultat) && strlen($champs[5])<5)
						{
							switch(strlen($resultat[1]))
							{
								case 1:
									$champs[4]='MARSEILLE';
									$champs[5]='1300'.$resultat[1];
									break;
								case 2:
									$champs[4]='MARSEILLE';
									$champs[5]='130'.$resultat[1];
									break;
								case 5:
									if(strpos($resultat[1],'130')===0)
									{
										$champs[4]='MARSEILLE';
										$champs[5]=$resultat[1];
									}
									break;
							}
						}
						
						if(preg_match('/^LYON[^0-9]*([0-9]+)([^0-9]|$)/',$champs[4],$resultat) && strlen($champs[5])<5)
						{
							switch(strlen($resultat[1]))
							{
								case 1:
									$champs[4]='LYON';
									$champs[5]='6900'.$resultat[1];
									break;
								case 2:
									$champs[4]='LYON';
									$champs[5]='690'.$resultat[1];
									break;
								case 5:
									if(strpos($resultat[1],'690')===0)
									{
										$champs[4]='LYON';
										$champs[5]=$resultat[1];
									}
									break;
							}
						}
						
						$this->champs['ville']=NULL;
						
						if(isset($ville[$champs[4].(0x0).$champs[5]]))
							$this->champs['ville']=$ville[$champs[4].(0x0).$champs[5]];
						
						//RECHERCHE EXACTE SUR LE CODE_POSTAL
						if(strlen($champs[5])==5)
						{
							if(isset($ville[$champs[5]]))
								$this->champs['ville']=$ville[$champs[5]];
							else
							{
								$this->executer
								('
									select
										identifiant,
										nom
									from ville
									where code_postal=\''.addslashes($champs[5]).'\'
								');
								
								$occurrence=array();
								while($this->donner_suivant($occurrence[]));
								unset($occurrence[sizeof($occurrence)-1]);
								
								switch(sizeof($occurrence))
								{
									case 0:
										$ville[$champs[5]]=NULL;
										break;
									case 1:
										$this->champs['ville']=$occurrence[0]['identifiant'];
										$ville[$champs[5]]=$occurrence[0]['identifiant'];
										break;
									default:
										for($i=0,$j=0,$position=NULL;$i<sizeof($occurrence) && $j<2;$i++)
											if($occurrence[$i]['nom']==$champs[4])
											{
												$j++;
												$position=$i;
											}
										
										if($j==1)
										{
											$this->champs['ville']=$occurrence[$position]['identifiant'];
											$ville[$champs[4].(0x0).$champs[5]]=$occurrence[$position]['identifiant'];
										}
										break;
								}
								
								unset($occurrence);
							}
						}
						
						//RECHERCHE APPROXIMATIVE SUR L'ENSEMBLE CODE POSTAL VILLE
						if($this->champs['ville']===NULL && ($champs[4]!='' || $champs[5]!=''))
						{
							if(isset($ville[$champs[4].(0x0).$champs[5]]))
								$this->champs['ville']=$ville[$champs[4].(0x0).$champs[5]];
							else
							{
								$this->executer
								('
									select
										identifiant,
										nom
									from ville
									where nom like \'%'.addslashes($champs[4]).'%\'
										and code_postal like \''.addslashes($champs[5]).'%\'
								');
								
								$occurrence=array();
								while($this->donner_suivant($occurrence[]));
								unset($occurrence[sizeof($occurrence)-1]);
								
								switch(sizeof($occurrence))
								{
									case 0:
										$ville[$champs[4].(0x0).$champs[5]]=NULL;
										break;
									case 1:
										$this->champs['ville']=$occurrence[0]['identifiant'];
										$ville[$champs[4].(0x0).$champs[5]]=$occurrence[0]['identifiant'];
										break;
									default:
										for($i=0,$j=0,$position=NULL;$i<sizeof($occurrence) && $j<2;$i++)
											if($occurrence[$i]['nom']==$champs[4])
											{
												$j++;
												$position=$i;
											}
										
										if($j==1)
										{
											$this->champs['ville']=$occurrence[$position]['identifiant'];
											$ville[$champs[4].(0x0).$champs[5]]=$occurrence[$position]['identifiant'];
										}
										break;
								}
								
								unset($occurrence);
							}
						}
						
						//RECHERCHE APPROXIMATIVE SUR LE CODE POSTAL
						if($this->champs['ville']===NULL && $champs[4]!='')
						{
							if(isset($ville[$champs[4]]))
								$this->champs['ville']=$ville[$champs[4]];
							else
							{
								$this->executer
								('
									select
										identifiant,
										nom
									from ville
									where nom like \'%'.addslashes($champs[4]).'%\'
								');
								
								$occurrence=array();
								while($this->donner_suivant($occurrence[]));
								unset($occurrence[sizeof($occurrence)-1]);
								
								switch(sizeof($occurrence))
								{
									case 0:
										$ville[$champs[4]]=NULL;
										break;
									case 1:
										$this->champs['ville']=$occurrence[0]['identifiant'];
										$ville[$champs[4]]=$occurrence[0]['identifiant'];
										break;
									default:
										for($i=0,$j=0,$position=NULL;$i<sizeof($occurrence) && $j<2;$i++)
											if($occurrence[$i]['nom']==$champs[4])
											{
												$j++;
												$position=$i;
											}
										
										if($j==1)
										{
											$this->champs['ville']=$occurrence[$position]['identifiant'];
											$ville[$champs[4].(0x0).$champs[5]]=$occurrence[$position]['identifiant'];
										}
										break;
								}
								
								unset($occurrence);
							}
						}
						
						//RECHERCHE APPROXIMATIF SUR LES MOTS COMPOSANT LA VILLE ET SUR LE CODE POSTAL
						if($this->champs['ville']===NULL && $champs[4]!='' && strlen($champs[5])==5)
						{
							$compose=preg_split('/[^A-Z]+/',preg_replace('/(^|[^A-Z])(L|LE|LA|LES|SUR)([^A-Z]|$)/','$1',$champs[4]));
							
							$this->executer
							('
								select
									identifiant,
									nom
								from ville
								where
									(nom like \'%'.implode('%\' or nom like \'%',array_map('addslashes',$compose)).'%\')
									and code_postal=\''.addslashes($champs[5]).'\'
							');
							
							$occurrence=array();
							while($this->donner_suivant($occurrence[]));
							unset($occurrence[sizeof($occurrence)-1]);
							
							switch(sizeof($occurrence))
							{
								case 0:
									$ville[$champs[4].(0x0).$champs[5]]=NULL;
									break;
								case 1:
									$this->champs['ville']=$occurrence[0]['identifiant'];
									$ville[$champs[4].(0x0).$champs[5]]=$occurrence[0]['identifiant'];
									break;
								default:
									for($i=0,$k=0,$position=NULL;$i<sizeof($occurrence) && $k<2;$i++)
									{
										for($j=0;$j<sizeof($compose);$j++)
										{
											if($occurrence[$i]['nom']==$compose[$j])
											{
												$k++;
												$position=$i;
											}
										}
									}
									
									if($k==1)
									{
										$this->champs['ville']=$occurrence[$position]['identifiant'];
										$ville[$champs[4].(0x0).$champs[5]]=$occurrence[$position]['identifiant'];
									}
									break;
							}
							
							unset($occurrence);
						}
						
						//RECHERCHE DANS L'ANNONCE DE LA VILLE SELON LE CODE_POSTAL
						if($this->champs['ville']===NULL && strlen($champs[5])==5)
						{
							$this->executer
							('
								select
									identifiant,
									nom
								from ville
								where code_postal=\''.addslashes($champs[5]).'\'
							');
							
							$occurrence=array();
							while($this->donner_suivant($occurrence[]))
							{
								$occurrence[sizeof($occurrence)-1]['nom']=preg_replace('/[^A-Z0-9]+/',' ',$occurrence[sizeof($occurrence)-1]['nom']);
								$occurrence[sizeof($occurrence)-1]['nom']=preg_replace('/ +/',' ',$occurrence[sizeof($occurrence)-1]['nom']);
							}
							unset($occurrence[sizeof($occurrence)-1]);
							
							if(sizeof($occurrence)>1)
							{
								$chaine=preg_replace('/[^A-Z0-9]+/',' ',strtoupper(sans_accent($titre_desctiptif)));
								$chaine=preg_replace('/ +/',' ',$chaine);
								$chaine=preg_replace('/^ +/','',$chaine);
								$chaine=preg_replace('/ +$/','',$chaine);
								
								$compose=array();
								$correspondance=array();
								
								$trouve=0;
								$position=NULL;
								for($i=0;$i<sizeof($occurrence);$i++)
								{
									if(preg_match('/(^|[^A-Z0-9])'.preg_quote($occurrence[$i]['nom'],'/').'([^A-Z0-9]|$)/',$chaine))
									{
										$trouve++;
										$position=$i;
									}
									
									$tableau=preg_split('/[^A-Z0-9]+/',$occurrence[$i]['nom']);
									$tableau=array_unique($tableau);
									$tableau=array_values($tableau);
									
									for($j=0;$j<sizeof($tableau);$j++)
									{
										if(strlen($tableau[$j])>4)
										{
											$compose[]=$tableau[$j];
											$correspondance[]=$occurrence[$i]['identifiant'];
										}
									}
								}
								
								if($trouve==1)
									$this->champs['ville']=$occurrence[$position]['identifiant'];
								else
								{
									$correspondance_unique=array();
									
									$trouve=0;
									$position=NULL;
									for($i=0;$i<sizeof($compose);$i++)
										if(preg_match('/(^|[^A-Z0-9])'.preg_quote($compose[$i],'/').'([^A-Z0-9]|$)/',$chaine) && array_search($correspondance[$i],$correspondance_unique)===false)
										{
											$trouve++;
											$position=$i;
											$correspondance_unique[]=$correspondance[$i];
										}
									
									if($trouve==1)
										$this->champs['ville']=$correspondance[$position];
								}
							}
							
							unset($occurrence);
						}
						//RECHERCHE APPROXIMATIVE SUR L'ENSEMBLE CODE POSTAL VILLE
						if($this->champs['ville']===NULL && $champs[4]!='' && strlen($champs[5])==2)
						{
							$this->executer
							('
								select
									identifiant,
									nom
								from ville
								where nom like \''.addslashes($champs[4]).'\'
									and code_postal like \''.addslashes($champs[5]).'%\'
								order by code_postal
							');
							
							$occurrence=array();
							while($this->donner_suivant($occurrence[]));
							unset($occurrence[sizeof($occurrence)-1]);
							
							switch(sizeof($occurrence))
							{
								case 0:
									$ville[$champs[4].(0x0).$champs[5]]=NULL;
									break;
								case 1:
									$this->champs['ville']=$occurrence[0]['identifiant'];
									$ville[$champs[4].(0x0).$champs[5]]=$occurrence[0]['identifiant'];
									break;
								default:
									for($i=1,$j=true;$i<sizeof($occurrence) && $j;$i++)
										if($occurrence[$i-1]['nom']!=$occurrence[$i]['nom'])
											$j=false;
									
									if($j)
									{
										$this->champs['ville']=$occurrence[0]['identifiant'];
										$ville[$champs[4].(0x0).$champs[5]]=$occurrence[0]['identifiant'];
									}
									break;
							}
								
							unset($occurrence);
						}
						
						//LOYER
						if(preg_match('/'.STRING_FILTRE_MONNAIE_POSITIF.'/',$champs[7]))
							$this->champs['loyer']=floatval($champs[7]);
						elseif($champs[7]=='')
							$this->champs['loyer']=NULL;
						else
							$this->champs['loyer']=$champs[7];
						
						//COMMENTAIRE
						$this->champs['commentaire']='';
						
						//STATUT
						if($taille>=16 && $champs[10]!='')
							$this->champs['statut']=strtoupper($champs[10]);
						else
							$this->champs['statut']=NULL;
						
						//MEUBLE
						if($taille>=16 && $champs[11]!='')
							$this->champs['meuble']=strtoupper($champs[11]);
						else
						{
							if(preg_match('/[^0-9A-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝ](MBL|MEBL|MEUBL)(E|É)E?[^0-9A-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝ]/i',$titre_desctiptif))
								$this->champs['meuble']='OUI';
							else
								$this->champs['meuble']=NULL;
						}
							
						//IMAGE
						if($taille>=16 && $champs[12]!='')
							$this->champs['image']=$champs[12];
						else
							$this->champs['image']=NULL;
						
						//URL
						if($taille>=16 && $champs[13]!='')
							$this->champs['url']=$champs[13];
						else
							$this->champs['url']=NULL;
						
						//ANNONCE_EMAIL
						if($taille>=16)
							$email=$champs[14];
						else
							$email=$champs[9];
						
						if($email=='' && preg_match('/'.STRING_TROUVE_EMAIL.'/',$titre_desctiptif,$resultat))
							$email=$resultat[1];
						
						$clef=NULL;
						if($email!='')
						{
							$clef=$this->__call('annonce_email_trouver',array($email,'email'));
							if($clef===false)
							{
								$annonce_email=new ld_annonce_email();
								$annonce_email->annonce=$this->champs['identifiant'];
								$annonce_email->nouveau_annonce=$this->champs['nouveau_identifiant'];
								$annonce_email->email='';
								$annonce_email->nouveau_email=$email;
								
								$this->__call('annonce_email_ajouter',array($annonce_email,'ajouter'));
								$clef=$this->__call('annonce_email_compter',array())-1;
							}
						}
						
						for($i=$this->__call('annonce_email_compter',array())-1;$i>=0;$i--)
							if($i!==$clef)
								$this->__call('annonce_email_supprimer',array($i));
						
						//ANNONCE_TELEPHONE
						$enregistre=true;
						$trouve=false;
						for($i=($taille>=16)?(15):(10);$i<$taille && !$trouve;$i++)
							if($champs[$i]!='')
								$trouve=true;
						
						if(!$trouve && preg_match_all('/((33|0)([ \.\/-]?[0-9]){9})/',$titre_desctiptif,$resultat))
						{
							for($i=0;$i<sizeof($resultat[1]);$i++)
							{
								$champs[$i+$taille-1]=preg_replace('/[^0-9]/','',$resultat[1][$i]);
								$champs[$i+$taille-1]=preg_replace('/^33/','0',$champs[$i+$taille-1]);
							}
						}
						
						$trouve=false;
						for($i=($taille>=16)?(15):(10);$i<$taille && !$trouve;$i++)
						{
							if($champs[$i]!='' && preg_match('/^08/',$champs[$i]) && !preg_match('/^(0800|0804|0805|0809|0810|0811|0819|0860)/',$champs[$i]))
								$trouve=true;
						}
						
						if(!$trouve)
						{
							$trouve=false;
							for($i=($taille>=16)?(15):(10);$i<$taille && !$trouve;$i++)
							{
								if($champs[$i]!='' && $est_brule($champs[$i],$brule))
									$trouve=true;
							}
							
							if(!$trouve)
							{
								$clef=array();
								for($i=($taille>=16)?(15):(10);$i<$taille;$i++)
								{
									if($champs[$i]!='' && preg_match('/'.STRING_FILTRE_TELEPHONE_STRICT_FR.'/',$champs[$i]))
									{
										$j=sizeof($clef);
										$clef[$j]=$this->__call('annonce_telephone_trouver',array($champs[$i],'telephone'));
										if($clef[$j]===false)
										{
											$clef[$j]=$this->__call('annonce_telephone_trouver',array($champs[$i],'nouveau_telephone'));
											if($clef[$j]===false)
											{
												$annonce_telephone=new ld_annonce_telephone();
												$annonce_telephone->annonce=$this->champs['identifiant'];
												$annonce_telephone->nouveau_annonce=$this->champs['nouveau_identifiant'];
												$annonce_telephone->telephone='';
												$annonce_telephone->nouveau_telephone=$champs[$i];
												
												$this->__call('annonce_telephone_ajouter',array($annonce_telephone,'ajouter'));
												$clef[$j]=$this->__call('annonce_telephone_compter',array())-1;
											}
										}
									}
								}
								
								for($i=$this->__call('annonce_telephone_compter',array())-1;$i>=0;$i--)
									if(array_search($i,$clef)===false)
										$this->__call('annonce_telephone_supprimer',array($i));
							}
							else
							{
								$brule++;
								$enregistre=false;
							}
						}
						else
						{
							$surtaxe++;
							$enregistre=false;
						}

						if($enregistre)
						{
							if($mode!='modifier')
								$resultat=$this->ajouter();
							else
								$resultat=$this->modifier();
							
							if(!$resultat)
							{
								if($mode!='modifier') $nouveau++;
								$importe++;
							}
							else
							{
								$rejete++;
								
								$champs[]=$resultat;
								
								foreach($erreur as $clef=>$valeur)
								{
									if($resultat & $erreur[$clef]['valeur'])
									{
										$erreur[$clef]['nombre']++;
										$champs[]=1;
									}
									else
										$champs[]=0;
								}
								
								fputcsv($log_fichier,$champs,';','"');
								
								if($resultat & ANNONCE_PARUTION_ERREUR)
								{
									//print('PARUTION -> '.$champs[2].'<br />');
								}
								
								if($resultat & ANNONCE_URL_ERREUR_FILTRE)
								{
									//print('URL -> '.$champs[12].'<br />');
								}
								
								if($resultat & ANNONCE_LOYER_ERREUR_VALEUR)
								{
									//print('LOYER -> '.$champs[7].'<br />');
									//print_r($champs);
								}
								
								if($resultat & ANNONCE_LOYER_ERREUR_FILTRE)
								{
									//print('LOYER -> '.$champs[7].'<br />');
								}
								
								if($resultat & ANNONCE_TYPE_ERREUR)
								{
									//print('TYPE -> '.((isset($designation))?($designation):('')).' -> '.$champs[6].' -> '.$this->champs['type'].' -> '.$titre_desctiptif.'<br />');
								}
								
								if($resultat & ANNONCE_VILLE_ERREUR)
								{
									//if($champs[4]!='MONACO')
									//print('VILLE -> '.$champs[4].' -> '.$champs[5].'-> '.(($taille>=16)?($champs[9]):('')).'-> '.(($taille>=16)?($champs[13]):('')).' -> '.$titre_desctiptif.'<br />');
								}
								
								if($resultat & ANNONCE_MEUBLE_ERREUR)
								{
									//print('MEUBLE -> '.$champs[11].'<br />');
								}
								
								if($resultat & ANNONCE_DESCRIPTIF_ERREUR)
								{
									//print('DESCRIPTION -> '.$champs[8].'<br />');
									//print_r($champs);
								}

								if($resultat & ANNONCE_ANNONCE_EMAIL_ERREUR_TAILLE || $resultat & ANNONCE_ANNONCE_EMAIL_ERREUR_CLASSE)
								{
									//print('EMAIL -> '.$champs[14].'<br />');
									//print_r($champs);
								}
							}
						}
					}
					else
						$exclu++;
				}
				elseif(!feof($fichier))
					$taille_errone++;
				
				if(($importe+$rejete+$brule+$exclu+$taille_errone)%INTERVAL==0)
				{
					$ecrire('nombre_'.$compteur.'','Nombre: '.($importe+$rejete+$brule+$exclu+$taille_errone));
					$ecrire('ajoute_'.$compteur.'','A ajouter: '.$ajoute);
					$ecrire('modifie_'.$compteur.'','A modifier: '.$modifie);
					$ecrire('importe_'.$compteur.'','Importé: '.$importe);
					$ecrire('rejete_'.$compteur.'','Rejeté: '.$rejete);
					$ecrire('exclu_'.$compteur.'','Exclu: '.$exclu);
					$ecrire('surtaxe_'.$compteur.'','Surtaxe: '.$surtaxe);
					$ecrire('brule_'.$compteur.'','Brulé: '.$brule);
					$ecrire('taille_errone_'.$compteur.'','Taille erronée: '.$taille_errone);
				}
						
				usleep(PAUSE);
			}
			
			$ecrire('nombre_'.$compteur.'','Nombre: '.($importe+$rejete+$brule+$exclu+$taille_errone));
			$ecrire('ajoute_'.$compteur.'','A ajouter: '.$ajoute);
			$ecrire('modifie_'.$compteur.'','A modifier: '.$modifie);
			$ecrire('importe_'.$compteur.'','Importé: '.$importe);
			$ecrire('rejete_'.$compteur.'','Rejeté: '.$rejete);
			$ecrire('exclu_'.$compteur.'','Exclu: '.$exclu);
			$ecrire('surtaxe_'.$compteur.'','Surtaxe: '.$surtaxe);
			$ecrire('brule_'.$compteur.'','Brulé: '.$brule);
			$ecrire('taille_errone_'.$compteur.'','Taille erronée: '.$taille_errone);
			
			$total=$importe+$rejete+$exclu+$brule+$taille_errone;
			
			$this->executer
			('
				insert into statistiques_annonce
				(
					jour,
					total,
					insertion,
					ajout
				)
				values
				(
					\''.date('Y-m-d').'\',
					'.$total.',
					'.$importe.',
					'.$nouveau.'
				)
				on duplicate key update
					total=total+'.$total.',
					insertion=insertion+'.$importe.',
					ajout=ajout+'.$nouveau.'
			');
			
			print('<span class="important">Fin du traitement de l\'import: '.duree(time()-$debut,'%mm %ss').'</span><br />'.REPETITION);
			print('<span class="important">Taux d\'import: '.(($total)?(round($importe*100/$total,2)):('0')).'%</span><br />'.REPETITION);
			print('<span class="important">Taux d\'erreur: '.(($total)?(round(($rejete+$taille_errone)*100/$total,2)):('0')).'%</span><br />'.REPETITION);
			flush();
				
			print('<pre>');
			$contenu=print_r($erreur,true);
			$contenu=preg_replace('/(\[nombre\] => [1-9]([0-9]+)?)/','<span class="important">$1</span>',$contenu);
			print($contenu);
			print('</pre>');
			
			fclose($log_fichier);
			print('<span class="important">Voir les logs: </span><a href="'.str_replace(PWD_INCLUSION,URL_INCLUSION,$log_chemin).'" target="_blank" type="text/plain">T&eacute;l&eacute;charger</a><br />'.REPETITION);
			
			print('<br />'.REPETITION);
			flush();
			
			fclose($fichier);
			
			ini_set('max_execution_time',$max_execution_time);
			//ignore_user_abort($ignore_user_abort);
			ini_set('memory_limit',$memory_limit);
			
			return true;
		}
		
		public function lister($date=NULL)
		{
			$this->executer('set foreign_key_checks=0');
			$this->executer('set unique_checks=0');
			
			$uniqid=uniqid();
			$this->executer('create temporary table `'.$uniqid.'` as select * from liste limit 0');
			
			$preference=new ld_preference();
			
			$this->executer
			('
				insert into `'.$uniqid.'`
				select
					annonce.identifiant,
					annonce.meuble,
					annonce.loyer,
					annonce.descriptif,
					annonce.statut,
					annonce.image,
					annonce.url,
					ville.identifiant,
					ville.nom,
					ville.code_postal,
					type.identifiant,
					type.designation,
					annonce.parution,
					annonce.enregistrement,
					annonce.modification,
					/*group_concat(distinct annonce_telephone.telephone separator \', \')*/null as telephone,
					/*group_concat(distinct annonce_email.email separator \', \')*/null as email,
					provenance.identifiant,
					provenance.designation,
					provenance.couleur,
					mid(preg_replace(\'/[^a-zA-Z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]+/\',\'\',annonce.descriptif),10,100)
				from annonce
					inner join ville on annonce.ville=ville.identifiant
					inner join type on annonce.type=type.identifiant
					inner join provenance on annonce.provenance=provenance.identifiant
					/*left join annonce_telephone on annonce.identifiant=annonce_telephone.annonce*/
					/*left join annonce_email on annonce.identifiant=annonce_email.annonce*/
				where 1
					/*and annonce.parution>\''.addslashes(date(SQL_DATETIME,mktime(23,59,59,date('m'),date('d')-$preference->annonce_affiche_dernier_jour,date('Y')))).'\'*/
					and annonce.etat=\'VALIDE\'
					/*and ville.latitude<>0*/
					/*and ville.longitude<>0*/
					'.(($date!==NULL)?('and annonce.modification>=\''.addslashes(date(SQL_DATETIME,$date)).'\''):('')).'
					/*'.(($date!==NULL)?('and (annonce.modification>=\''.addslashes(date(SQL_DATETIME,$date)).'\' or annonce.enregistrement>=\''.addslashes(date(SQL_DATETIME,$date)).'\')'):('')).'*/
					/*and provenance.identifiant<>926178183*/
				/*group by annonce.identifiant*/
			');
			
			
			$this->executer('alter ignore table `'.$uniqid.'` add unique tmp_doublon (doublon)');
			$this->executer('alter table `'.$uniqid.'` drop index tmp_doublon');
			
			
			$preference=new ld_preference();
			$preference->acces_bloque='OUI';
			$preference->modifier();
			
			$this->executer('truncate table liste');
			$this->executer('insert into liste select * from `'.$uniqid.'`');
			
			$this->executer
			('
				insert into statistiques_liste
				(
					enregistrement,
					total,
					ajout
				)
				select
					now(),
					(select count(*) from liste),
					(select count(*) from liste where !datediff(enregistrement,now()))
			');
			
			$preference=new ld_preference();
			$preference->acces_bloque='NON';
			$preference->modifier();
			
			$this->executer('set foreign_key_checks=1');
			$this->executer('set unique_checks=1');
			
			return true;
		}
		
		public function compter($date, $periodicite, $provenance, $mode)
		{
			if(array_search($periodicite,explode(',',ANNONCE_PERIODICITE_ENUM))!==false && preg_match('/^(TOUTES|SANS_TELEPHONE_ET_EMAIL|SANS_STATUT|SANS_LOYER)$/',$mode))
			{
				$correspondance_periodicite=array('H'=>'%k','S'=>'%w','M'=>'%e','A'=>'%c');
				$strrnd=strrnd(32,7);
				$requete='CREATE TEMPORARY TABLE `'.$strrnd.'` ('.CRLF;
				$requete.='periode smallint(5) unsigned NOT NULL,'.CRLF;
				$requete.='nombre int(10) unsigned NOT NULL default \'0\','.CRLF;
				$requete.='PRIMARY KEY  (periode)'.CRLF;
				$requete.=') ENGINE=MyISAM;'.CRLF;
				$this->executer($requete);
				
				switch($periodicite)
				{
					case 'H':
						$debut=mktime(0,0,0,date('m',$date),date('d',$date),date('Y',$date));
						$fin=mktime(0,0,0,date('m',$date),date('d',$date)+1,date('Y',$date));
						for($date=$debut;$date<$fin;$date=mktime(date('H',$date)+1,date('i',$date),date('s',$date),date('m',$date),date('d',$date),date('Y',$date)))
							$this->executer('insert into `'.$strrnd.'` (periode) value ((((date_format(\''.addslashes(date(SQL_DATETIME,$date)).'\',\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).');');
						break;
					case 'S':
					    $debut=mktime(0,0,0,date('m',$date),date('d',$date)-(((date('w',$date)+6)%7)),date('Y',$date));
						$fin=mktime(0,0,0,date('m',$debut),date('d',$debut)+7,date('Y',$debut));
						for($date=$debut;$date<$fin;$date=mktime(date('H',$date),date('i',$date),date('s',$date),date('m',$date),date('d',$date)+1,date('Y',$date)))
							$this->executer('insert into `'.$strrnd.'` (periode) value ((((date_format(\''.addslashes(date(SQL_DATETIME,$date)).'\',\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).');');
						break;
					case 'M':
						$debut=mktime(0,0,0,date('m',$date),1,date('Y',$date));
						$fin=mktime(0,0,0,date('m',$date)+1,1,date('Y',$date));
						for($date=$debut;$date<$fin;$date=mktime(date('H',$date),date('i',$date),date('s',$date),date('m',$date),date('d',$date)+1,date('Y',$date)))
							$this->executer('insert into `'.$strrnd.'` (periode) value ((((date_format(\''.addslashes(date(SQL_DATETIME,$date)).'\',\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).');');
						break;
					case 'A':
						$debut=mktime(0,0,0,1,1,date('Y',$date));
						$fin=mktime(0,0,0,1,1,date('Y',$date)+1);
						for($date=$debut;$date<$fin;$date=mktime(date('H',$date),date('i',$date),date('s',$date),date('m',$date)+1,date('d',$date),date('Y',$date)))
							$this->executer('insert into `'.$strrnd.'` (periode) value ((((date_format(\''.addslashes(date(SQL_DATETIME,$date)).'\',\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).');');
						break;
				}
				
				switch($mode)
				{
					case 'TOUTES':
						$requete='';
						break;
					case 'SANS_TELEPHONE_ET_EMAIL':
						$requete=
						'
							and telephone is null
							and email is null
						';
						break;
					case 'SANS_STATUT':
						$requete='and statut is null';
						break;
					case 'SANS_LOYER':
						$requete='and loyer is null';
						break;
				}
				
				$this->executer
				('
					replace `'.$strrnd.'`
					(
						nombre,
						periode
					)
					select
						count(distinct identifiant) as nombre,
						(((date_format(parution,\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).' as periode
					from liste
					where provenance_identifiant=\''.addslashes($provenance).'\'
						/*and enregistrement>=\''.date(SQL_DATETIME,$debut).'\'
						and enregistrement<\''.date(SQL_DATETIME,$fin).'\'*/
						'.$requete.'
					group by periode;
				');
					
				$this->executer
				('
					select
						nombre,
						periode
					from `'.$strrnd.'`
					order by periode,nombre;
				');
				
				$this->champs['occurrence']=array();
				$this->champs['maximum']=0;
				$this->champs['minimum']=0;
				$this->champs['moyenne']=0;
				$this->champs['total']=0;
				$this->champs['debut']=$debut;
				$this->champs['fin']=$fin;
				
				while($this->donner_suivant($this->champs['occurrence'][]))
				{
					$total=$this->champs['occurrence'][sizeof($this->champs['occurrence'])-1]['nombre'];
					if($this->champs['maximum']<$total)
						$this->champs['maximum']=$total;
					if(sizeof($this->champs['occurrence'])==1 || $this->champs['minimum']>$total)
						$this->champs['minimum']=$total;
					$this->champs['total']+=$total;
				}
				unset($this->champs['occurrence'][sizeof($this->champs['occurrence'])-1]);
				
				$this->champs['moyenne']=$this->champs['total']/sizeof($this->champs['occurrence']);
				
				$this->executer('drop table `'.$strrnd.'`');
				
				return true;
			}
			
			return false;
		}
		
		public function croiser($date, $periodicite, $provenance, $mode)
		{
			if(!is_array($mode))
				$mode[]=$mode;
			
			$mode=array_values($mode);
			
			$a=new ld_annonce();
			$b=new ld_annonce();
			
			if(!$a->compter($date, $periodicite, $provenance, $mode[0]) || !$b->compter($date, $periodicite, $provenance, $mode[1]))
				return false;
			
			$this->champs['occurrence']=array();
			$this->champs['maximum']=0;
			$this->champs['minimum']=0;
			$this->champs['moyenne']=0;
			$this->champs['total']=0;
			$this->champs['debut']=NULL;
			$this->champs['fin']=NULL;
			
			for($i=0;$i<sizeof($a->occurrence);$i++)
			{
				$this->champs['occurrence'][$i]['nombre']=($a->occurrence[$i]['nombre'])?(round($b->occurrence[$i]['nombre']*100/$a->occurrence[$i]['nombre'])):(0);
				$this->champs['occurrence'][$i]['periode']=$a->occurrence[$i]['periode'];
				$this->champs['maximum']=($a->maximum)?(round($b->maximum*100/$a->maximum)):(0);
				$this->champs['minimum']=($a->minimum)?(round($b->minimum*100/$a->minimum)):(0);
				$this->champs['moyenne']=($a->moyenne)?(round($b->moyenne*100/$a->moyenne)):(0);
				$this->champs['total']=($a->total)?(round($b->total*100/$a->total)):(0);
				$this->champs['debut']=$a->debut;
				$this->champs['fin']=$a->fin;
			}
			
			return true;
		}
	}
	
	if(isset($_REQUEST['test']))
	{
		$annonce=new ld_annonce();
		$annonce->importer('/var/www/vhost/aicom/prive/localerte/capture/capture_6.txt',1,0);
	}
?>