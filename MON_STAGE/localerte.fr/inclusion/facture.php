<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'facture_ligne.php');
	require_once(PWD_INCLUSION.'facture_pdf.php');
	require_once(PWD_INCLUSION.'tarif_abonnement.php');
	require_once(PWD_INCLUSION.'tarif_forfait.php');
	require_once(PWD_INCLUSION.'abonnement.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'fichier.php');
	require_once(PWD_INCLUSION.'adherent.php');

	$define_erreur=0;

	define('FACTURE_IDENTIFIANT_DEFAUT','');
	define('FACTURE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));

	define('FACTURE_NOUVEAU_IDENTIFIANT_MIN',1);
	define('FACTURE_NOUVEAU_IDENTIFIANT_MAX',9);
	define('FACTURE_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('FACTURE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('FACTURE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('FACTURE_ADHERENT_DEFAUT',NULL);
	define('FACTURE_ADHERENT_NULL',true);
	define('FACTURE_ADHERENT_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_MODE_ENUM','CB,CHEQUE,WHA,PAYPAL');
	define('FACTURE_MODE_NULL',true);
	define('FACTURE_MODE_DEFAUT',NULL);
	define('FACTURE_MODE_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_STATUT_ENUM','ATTENTE,PAYE,ANNULE');
	define('FACTURE_STATUT_NULL',false);
	define('FACTURE_STATUT_DEFAUT',NULL);
	
	define('FACTURE_EMISSION_NULL',false);
	define('FACTURE_EMISSION_DEFAUT',NULL);
	
	define('FACTURE_PAIEMENT_NULL',true);
	define('FACTURE_PAIEMENT_DEFAUT',NULL);
	
	define('FACTURE_ADRESSE_MIN',1);
	define('FACTURE_ADRESSE_MAX',50);
	define('FACTURE_ADRESSE_NULL',true);
	define('FACTURE_ADRESSE_DEFAUT',NULL);
	define('FACTURE_ADRESSE_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_COMPLEMENT_ADRESSE_MIN',1);
	define('FACTURE_COMPLEMENT_ADRESSE_MAX',50);
	define('FACTURE_COMPLEMENT_ADRESSE_NULL',true);
	define('FACTURE_COMPLEMENT_ADRESSE_DEFAUT',NULL);
	define('FACTURE_COMPLEMENT_ADRESSE_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_CODE_POSTAL_NULL',true);
	define('FACTURE_CODE_POSTAL_DEFAUT',NULL);
	define('FACTURE_CODE_POSTAL_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_VILLE_MIN',1);
	define('FACTURE_VILLE_MAX',50);
	define('FACTURE_VILLE_NULL',true);
	define('FACTURE_VILLE_DEFAUT',NULL);
	define('FACTURE_VILLE_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_RAISON_SOCIALE_MIN',1);
	define('FACTURE_RAISON_SOCIALE_MAX',50);
	define('FACTURE_RAISON_SOCIALE_NULL',true);
	define('FACTURE_RAISON_SOCIALE_DEFAUT',NULL);
	define('FACTURE_RAISON_SOCIALE_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_NOM_MIN',1);
	define('FACTURE_NOM_MAX',50);
	define('FACTURE_NOM_NULL',true);
	define('FACTURE_NOM_DEFAUT',NULL);
	define('FACTURE_NOM_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_PRENOM_MIN',1);
	define('FACTURE_PRENOM_MAX',50);
	define('FACTURE_PRENOM_NULL',true);
	define('FACTURE_PRENOM_DEFAUT',NULL);
	define('FACTURE_PRENOM_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_DOMAINE_MIN',1);
	define('FACTURE_DOMAINE_MAX',20);
	define('FACTURE_DOMAINE_NULL',false);
	define('FACTURE_DOMAINE_DEFAUT',NULL);
	define('FACTURE_DOMAINE_ERREUR',pow(2,$define_erreur++));
	
	define('FACTURE_FACTURE_LIGNE_MIN',1);
	define('FACTURE_FACTURE_LIGNE_MAX',10000);
	define('FACTURE_FACTURE_LIGNE_DEFAUT','array,ld_facture_ligne');
	define('FACTURE_FACTURE_LIGNE_ERREUR_TAILLE',pow(2,$define_erreur++));
	define('FACTURE_FACTURE_LIGNE_ERREUR_CLASSE',pow(2,$define_erreur++));
	
	define('FACTURE_TOTAL_ERREUR', pow(2,$define_erreur++)-1);
	
	unset($define_erreur);

	class ld_facture extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_facture()
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
			$this->champs['identifiant']=FACTURE_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=FACTURE_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['adherent']=FACTURE_ADHERENT_DEFAUT;
			$this->champs['mode']=FACTURE_MODE_DEFAUT;
			$this->champs['statut']=FACTURE_STATUT_DEFAUT;
			$this->champs['emission']=FACTURE_EMISSION_DEFAUT;
			$this->champs['paiement']=FACTURE_PAIEMENT_DEFAUT;
			$this->champs['adresse']=FACTURE_ADRESSE_DEFAUT;
			$this->champs['complement_adresse']=FACTURE_COMPLEMENT_ADRESSE_DEFAUT;
			$this->champs['code_postal']=FACTURE_CODE_POSTAL_DEFAUT;
			$this->champs['ville']=FACTURE_VILLE_DEFAUT;
			$this->champs['raison_sociale']=FACTURE_RAISON_SOCIALE_DEFAUT;
			$this->champs['nom']=FACTURE_NOM_DEFAUT;
			$this->champs['prenom']=FACTURE_PRENOM_DEFAUT;
			$this->champs['domaine']=FACTURE_DOMAINE_DEFAUT;
			$this->champs['facture_ligne']=array();
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
			
			$this->erreur=FACTURE_TOTAL_ERREUR;
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
				if($variable!='statut' && $variable!='emission' && $variable!='paiement' && $variable!='facture_ligne' && $variable!='occurrence' && $variable!='maximum' && $variable!='minimum' && $variable!='moyenne' && $variable!='total' && $variable!='debut' && $variable!='fin')
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
				case 'facture_ligne_ajouter':
					if(sizeof($parametre)==2 && is_a($parametre[0],'ld_facture_ligne') && preg_match('/^(ajouter|modifier)$/',$parametre[1]))
					{
						$clef=sizeof($this->champs['facture_ligne']);
						$this->champs['facture_ligne'][$clef]['objet']=$parametre[0];
						$this->champs['facture_ligne'][$clef]['mode']=$parametre[1];
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: facture_ligne_ajouter (ld_facture_ligne, \'ajouter\' | \'modifier\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'facture_ligne_modifier':
					if(sizeof($parametre)==3 && is_a($parametre[0],'ld_facture_ligne') && preg_match('/^(ajouter|modifier)$/',$parametre[2]) && is_int($parametre[1]) && isset($this->champs['facture_ligne'][$parametre[1]]))
					{
						$this->champs['facture_ligne'][$parametre[1]]['objet']=$parametre[0];
						$this->champs['facture_ligne'][$parametre[1]]['mode']=$parametre[2];
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: facture_ligne_modifier (ld_facture_ligne, clef, \'ajouter\' | \'modifier\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'facture_ligne_supprimer':
					if(sizeof($parametre)==1 && is_int($parametre[0]))
					{
						unset($this->champs['facture_ligne'][$parametre[0]]);
						$this->champs['facture_ligne']=array_values($this->champs['facture_ligne']);
						return true;
					}
					
					trigger_error('Param&egrave;tres incorrect: facture_ligne_supprimer (clef)'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'facture_ligne_trouver':
					if(sizeof($parametre)==2 && preg_match('/^(identifiant|nouveau_identifiant)$/',$parametre[1]))
					{
						foreach($this->champs['facture_ligne'] as $clef=>$tableau)
						{
							switch($parametre[1])
							{
								case 'identifiant':
									if($tableau['objet']->identifiant==$parametre[0])
										return $clef;
									break;
								case 'nouveau_identifiant':
									if($tableau['objet']->nouveau_identifiant==$parametre[0])
										return $clef;
									break;
							}
						}
						
						return false;
					}
					
					trigger_error('Param&egrave;tres incorrect: facture_ligne_trouver (identifiant, \'alerte\' | \'nouveau_alerte\' | \'identifiant\' | \'nouveau_identifiant\')'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'facture_ligne_lire':
					if(sizeof($parametre)==1 && is_int($parametre[0]))
					{
						if(isset($this->champs['facture_ligne'][$parametre[0]]))
							return $this->champs['facture_ligne'][$parametre[0]];
						
						return false;
					}
					
					trigger_error('Param&egrave;tres incorrect: facture_ligne_lire (clef)'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
				case 'facture_ligne_compter':
					return sizeof($this->champs['facture_ligne']);
					break;
				default:
					trigger_error('Fonction '.$function.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
			}
		}
		
		/*function facture_ligne_ajouter($objet,$mode)
		{
			return $this->__call('facture_ligne_ajouter',array($objet,$mode));
		}*/
		
		/*function facture_ligne_modifier($objet,$clef,$mode)
		{
			return $this->__call('facture_ligne_modifier',array($objet,$clef,$mode));
		}*/
		
		/*function facture_ligne_supprimer($clef)
		{
			return $this->__call('facture_ligne_supprimer',array($clef));
		}*/
		
		/*function facture_ligne_trouver($identifiant,$champ)
		{
			return $this->__call('facture_ligne_trouver',array($idnetifiant,$champ));
		}*/
		
		/*function facture_ligne_lire($clef)
		{
			return $this->__call('facture_ligne_lire',array($clef));
		}*/
		
		/*function facture_ligne_compter()
		{
			return $this->__call('facture_ligne_compter');
		}*/
		
		private function verifier($mode)
		{
			if($mode=='supprimer')
			{
				$this->executer
				('
					select count(identifiant) as nombre
					from facture
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
						and statut=\'ATTENTE\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=FACTURE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			elseif($mode=='payer')
			{
				$this->executer
				('
					select count(identifiant) as nombre
					from facture
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
						and statut=\'ATTENTE\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=FACTURE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
				//MODE
				if((!FACTURE_MODE_NULL || $this->champs['mode']!==NULL) && array_search($this->champs['mode'],explode(',',FACTURE_MODE_ENUM))===false)
					$this->erreur|=FACTURE_MODE_ERREUR;
				else
					$this->erreur&=~FACTURE_MODE_ERREUR;
			}
			elseif($mode=='annuler')
			{
				$this->executer
				('
					select count(identifiant) as nombre
					from facture
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=FACTURE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from facture
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=FACTURE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~FACTURE_IDENTIFIANT_ERREUR;
				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<FACTURE_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>FACTURE_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=FACTURE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~FACTURE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from facture
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=FACTURE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~FACTURE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//ADHERENT
				$this->executer
				('
					select count(identifiant) as nombre
					from adherent
					where
						identifiant=\''.addslashes($this->champs['adherent']).'\'
				');
				$this->donner_suivant($occurrence);
				if((!FACTURE_ADHERENT_NULL || $this->champs['adherent']!==NULL) && !$occurrence['nombre'])
					$this->erreur|=FACTURE_ADHERENT_ERREUR;
				else
					$this->erreur&=~FACTURE_ADHERENT_ERREUR;
				//MODE
				if((!FACTURE_MODE_NULL || $this->champs['mode']!==NULL) && array_search($this->champs['mode'],explode(',',FACTURE_MODE_ENUM))===false)
					$this->erreur|=FACTURE_MODE_ERREUR;
				else
					$this->erreur&=~FACTURE_MODE_ERREUR;
				//ADRESSE
				if((!FACTURE_ADRESSE_NULL || $this->champs['adresse']!==NULL) && (strlen($this->champs['adresse'])<FACTURE_ADRESSE_MIN || strlen($this->champs['adresse'])>FACTURE_ADRESSE_MAX))
					$this->erreur|=FACTURE_ADRESSE_ERREUR;
				else
					$this->erreur&=~FACTURE_ADRESSE_ERREUR;
				//COMPLEMENT_ADRESSE
				if((!FACTURE_COMPLEMENT_ADRESSE_NULL || $this->champs['complement_adresse']!==NULL) && (strlen($this->champs['complement_adresse'])<FACTURE_COMPLEMENT_ADRESSE_MIN || strlen($this->champs['complement_adresse'])>FACTURE_COMPLEMENT_ADRESSE_MAX))
					$this->erreur|=FACTURE_COMPLEMENT_ADRESSE_ERREUR;
				else
					$this->erreur&=~FACTURE_COMPLEMENT_ADRESSE_ERREUR;
				//CODE_POSTAL
				if((!FACTURE_CODE_POSTAL_NULL || $this->champs['code_postal']!==NULL) && !preg_match('/'.STRING_FILTRE_CODE_POSTAL.'/',$this->champs['code_postal']))
					$this->erreur|=FACTURE_CODE_POSTAL_ERREUR;
				else
					$this->erreur&=~FACTURE_CODE_POSTAL_ERREUR;
				//VILLE
				if((!FACTURE_VILLE_NULL || $this->champs['ville']!==NULL) && (strlen($this->champs['ville'])<FACTURE_VILLE_MIN || strlen($this->champs['ville'])>FACTURE_VILLE_MAX))
					$this->erreur|=FACTURE_VILLE_ERREUR;
				else
					$this->erreur&=~FACTURE_VILLE_ERREUR;
				//RAISON_SOCIALE
				if((!FACTURE_RAISON_SOCIALE_NULL || $this->champs['raison_sociale']!==NULL) && (strlen($this->champs['raison_sociale'])<FACTURE_RAISON_SOCIALE_MIN || strlen($this->champs['raison_sociale'])>FACTURE_RAISON_SOCIALE_MAX))
					$this->erreur|=FACTURE_RAISON_SOCIALE_ERREUR;
				else
					$this->erreur&=~FACTURE_RAISON_SOCIALE_ERREUR;
				//NOM
				if((!FACTURE_NOM_NULL || $this->champs['nom']!==NULL) && (strlen($this->champs['nom'])<FACTURE_NOM_MIN || strlen($this->champs['nom'])>FACTURE_NOM_MAX))
					$this->erreur|=FACTURE_NOM_ERREUR;
				else
					$this->erreur&=~FACTURE_NOM_ERREUR;
				//PRENOM
				if((!FACTURE_PRENOM_NULL || $this->champs['prenom']!==NULL) && (strlen($this->champs['prenom'])<FACTURE_PRENOM_MIN || strlen($this->champs['prenom'])>FACTURE_PRENOM_MAX))
					$this->erreur|=FACTURE_PRENOM_ERREUR;
				else
					$this->erreur&=~FACTURE_PRENOM_ERREUR;
				//DOMAINE
				if((!FACTURE_DOMAINE_NULL || $this->champs['domaine']!==NULL) && (strlen($this->champs['domaine'])<FACTURE_DOMAINE_MIN || strlen($this->champs['domaine'])>FACTURE_DOMAINE_MAX))
					$this->erreur|=FACTURE_DOMAINE_ERREUR;
				else
					$this->erreur&=~FACTURE_DOMAINE_ERREUR;
				//FACTURE_LIGNE
				if(sizeof($this->champs['facture_ligne'])<FACTURE_FACTURE_LIGNE_MIN || sizeof($this->champs['facture_ligne'])>FACTURE_FACTURE_LIGNE_MAX)
					$this->erreur|=FACTURE_FACTURE_LIGNE_ERREUR_TAILLE;
				else
					$this->erreur&=~FACTURE_FACTURE_LIGNE_ERREUR_TAILLE;
				$this->erreur&=~FACTURE_FACTURE_LIGNE_ERREUR_CLASSE;
				switch($mode)
				{
					case 'ajouter':
						$identifiant=array();
						foreach($this->champs['facture_ligne'] as $clef=>$valeur)
						{
							if($valeur['objet']->facture!=$this->champs['nouveau_identifiant'])
								$this->erreur|=FACTURE_FACTURE_LIGNE_ERREUR_CLASSE;
							
							if($valeur['mode']=='modifier')
								$this->erreur|=FACTURE_FACTURE_LIGNE_ERREUR_CLASSE;
							
							if(array_search($valeur['objet']->nouveau_identifiant,$identifiant)!==false)
								$this->erreur|=FACTURE_FACTURE_LIGNE_ERREUR_CLASSE;
							
							$resultat=$valeur['objet']->tester('ajouter');
							
							$erreur=FACTURE_LIGNE_TOTAL_ERREUR-
								FACTURE_LIGNE_FACTURE_ERREUR;
							if($resultat & $erreur)
								$this->erreur|=FACTURE_FACTURE_LIGNE_ERREUR_CLASSE;
							
							$identifiant[]=$valeur['objet']->nouveau_identifiant;
						}
						break;
					case 'modifier':
						$identifiant=array();
						foreach($this->champs['facture_ligne'] as $clef=>$valeur)
						{
							if($valeur['objet']->facture!=$this->champs['nouveau_identifiant'])
								$this->erreur|=FACTURE_FACTURE_LIGNE_ERREUR_CLASSE;
							
							if(array_search($valeur['objet']->nouveau_identifiant,$identifiant)!==false)
								$this->erreur|=FACTURE_FACTURE_LIGNE_ERREUR_CLASSE;
							
							$resultat=$valeur['objet']->tester($valeur['mode']);
							
							if($this->champs['nouveau_identifiant']!=$this->champs['identifiant'])
								$erreur=FACTURE_LIGNE_TOTAL_ERREUR-
								FACTURE_LIGNE_FACTURE_ERREUR;
							else
								$erreur=FACTURE_LIGNE_TOTAL_ERREUR;
							if($resultat & $erreur)
								$this->erreur|=FACTURE_FACTURE_LIGNE_ERREUR_CLASSE;
							
							$identifiant[]=$valeur['objet']->nouveau_identifiant;
						}
				}
			}
		}
	
		public function lire()
		{
			$this->executer
			('
				SELECT
					identifiant,
					adherent,
					mode,
					statut,
					unix_timestamp(emission) as emission,
					unix_timestamp(paiement) as paiement,
					adresse,
					complement_adresse,
					code_postal,
					ville,
					raison_sociale,
					nom,
					prenom,
					domaine
				FROM facture
				WHERE
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['adherent']=$occurrence['adherent'];
			$this->champs['mode']=$occurrence['mode'];
			$this->champs['statut']=$occurrence['statut'];
			$this->champs['emission']=$occurrence['emission'];
			$this->champs['paiement']=$occurrence['paiement'];
			$this->champs['adresse']=$occurrence['adresse'];
			$this->champs['complement_adresse']=$occurrence['complement_adresse'];
			$this->champs['code_postal']=$occurrence['code_postal'];
			$this->champs['ville']=$occurrence['ville'];
			$this->champs['raison_sociale']=$occurrence['raison_sociale'];
			$this->champs['nom']=$occurrence['nom'];
			$this->champs['prenom']=$occurrence['prenom'];
			$this->champs['domaine']=$occurrence['domaine'];
			
			$this->champs['facture_ligne']=array();
			$this->executer
			('
				select identifiant
				from facture_ligne
				where
					facture=\''.addslashes($this->champs['identifiant']).'\'
			');
			while($this->donner_suivant($occurrence))
			{
				$facture_ligne=new ld_facture_ligne();
				$facture_ligne->identifiant=$occurrence['identifiant'];
				$facture_ligne->lire();
				
				$clef=sizeof($this->champs['facture_ligne']);
				
				$this->champs['facture_ligne'][$clef]['objet']=$facture_ligne;
				$this->champs['facture_ligne'][$clef]['mode']='modifier';
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
					delete FROM facture
					WHERE
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
						and statut=\'ATTENTE\'
				');
				$this->champs['identifiant']=FACTURE_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=FACTURE_NOUVEAU_IDENTIFIANT_DEFAUT;
			}
			return $this->erreur;
		}
		
		public function ajouter()
		{
			$this->verifier('ajouter');
			if(!$this->erreur)
			{
				$this->champs['mode']=NULL;
				$this->champs['statut']='ATTENTE';
				$this->champs['emission']=time();
				$this->champs['paiement']=NULL;
				
				$this->executer
				('
					INSERT INTO facture
					(
						identifiant,
						adherent,
						mode,
						statut,
						emission,
						paiement,
						adresse,
						complement_adresse,
						code_postal,
						ville,
						raison_sociale,
						nom,
						prenom,
						domaine
					)
					VALUES
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['adherent']!==NULL)?('\''.addslashes($this->champs['adherent']).'\''):('null')).',
						'.(($this->champs['mode']!==NULL)?('\''.addslashes($this->champs['mode']).'\''):('null')).',
						'.(($this->champs['statut']!==NULL)?('\''.addslashes($this->champs['statut']).'\''):('null')).',
						'.(($this->champs['emission']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['emission'])).'\''):('null')).',
						'.(($this->champs['paiement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['paiement'])).'\''):('null')).',
						'.(($this->champs['adresse']!==NULL)?('\''.addslashes($this->champs['adresse']).'\''):('null')).',
						'.(($this->champs['complement_adresse']!==NULL)?('\''.addslashes($this->champs['complement_adresse']).'\''):('null')).',
						'.(($this->champs['code_postal']!==NULL)?('\''.addslashes($this->champs['code_postal']).'\''):('null')).',
						'.(($this->champs['ville']!==NULL)?('\''.addslashes($this->champs['ville']).'\''):('null')).',
						'.(($this->champs['raison_sociale']!==NULL)?('\''.addslashes($this->champs['raison_sociale']).'\''):('null')).',
						'.(($this->champs['nom']!==NULL)?('\''.addslashes($this->champs['nom']).'\''):('null')).',
						'.(($this->champs['prenom']!==NULL)?('\''.addslashes($this->champs['prenom']).'\''):('null')).',
						'.(($this->champs['domaine']!==NULL)?('\''.addslashes($this->champs['domaine']).'\''):('null')).'
					)
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				
				foreach($this->champs['facture_ligne'] as $clef=>$valeur)
					$valeur['objet']->ajouter();
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
					UPDATE facture
					SET
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						adherent='.(($this->champs['adherent']!==NULL)?('\''.addslashes($this->champs['adherent']).'\''):('null')).',
						adresse='.(($this->champs['adresse']!==NULL)?('\''.addslashes($this->champs['adresse']).'\''):('null')).',
						complement_adresse='.(($this->champs['complement_adresse']!==NULL)?('\''.addslashes($this->champs['complement_adresse']).'\''):('null')).',
						code_postal='.(($this->champs['code_postal']!==NULL)?('\''.addslashes($this->champs['code_postal']).'\''):('null')).',
						ville='.(($this->champs['ville']!==NULL)?('\''.addslashes($this->champs['ville']).'\''):('null')).',
						raison_sociale='.(($this->champs['raison_sociale']!==NULL)?('\''.addslashes($this->champs['raison_sociale']).'\''):('null')).',
						nom='.(($this->champs['nom']!==NULL)?('\''.addslashes($this->champs['nom']).'\''):('null')).',
						prenom='.(($this->champs['prenom']!==NULL)?('\''.addslashes($this->champs['prenom']).'\''):('null')).',
						domaine='.(($this->champs['domaine']!==NULL)?('\''.addslashes($this->champs['domaine']).'\''):('null')).'
					WHERE
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
						and statut=\'ATTENTE\'
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				
				$identifiant=array();
				foreach($this->champs['facture_ligne'] as $clef=>$valeur)
					$identifiant[]=$valeur['objet']->identifiant;
				
				$this->executer
				('
					select identifiant
					from facture_ligne
					where
						facture=\''.addslashes($this->champs['identifiant']).'\'
						and identifiant not in (\''.implode('\',\'',array_map('addslashes',$identifiant)).'\')
				');
				while($this->donner_suivant($occurrence))
				{
					$facture_ligne=new ld_facture_ligne();
					$facture_ligne->identifiant=$occurrence['identifiant'];
					$facture_ligne->supprimer();
				}
				
				foreach($this->champs['facture_ligne'] as $clef=>$valeur)
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

		public function annuler()
		{
			$this->verifier('annuler');
			if(!$this->erreur)
			{
				$this->champs['statut']='ANNULE';
				$this->executer
				('
					update facture
					set
						statut='.(($this->champs['statut']!==NULL)?('\''.addslashes($this->champs['statut']).'\''):('null')).'
					WHERE
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
			}
			return $this->erreur;
		}

		public function payer($mode=NULL)
		{
			$this->verifier('payer');
			if(!$this->erreur)
			{
				$this->champs['mode']=$mode;
				$this->champs['statut']='PAYE';
				$this->champs['paiement']=time();
				
				$this->executer
				('
					UPDATE facture
					SET 
						paiement='.(($this->champs['paiement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['paiement'])).'\''):('null')).',
						mode='.(($this->champs['mode']!==NULL)?('\''.addslashes($this->champs['mode']).'\''):('null')).',
						statut='.(($this->champs['statut']!==NULL)?('\''.addslashes($this->champs['statut']).'\''):('null')).'
					WHERE
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				
				$this->lire();
				
				foreach($this->champs['facture_ligne'] as $clef=>$valeur)
				{
					$tarif_abonnement=new ld_tarif_abonnement();
					$tarif_abonnement->identifiant=preg_replace('/^mobi_/','',$valeur['objet']->reference);
					if($tarif_abonnement->lire())
					{
						$abonnement=new ld_abonnement();
						$abonnement->identifiant='';
						$abonnement->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_abonnement','identifiant',ABONNEMENT_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
						$abonnement->adherent=$this->champs['adherent'];
						$abonnement->delai=$tarif_abonnement->delai;
						$abonnement->domaine=(preg_match('/^mobi_/',$valeur['objet']->reference)?'www.localerte.mobi':'www.localerte.fr');
						$erreur=$abonnement->ajouter();
					}
					
					$tarif_forfait=new ld_tarif_forfait();
					$tarif_forfait->identifiant=preg_replace('/^mobi_/','',$valeur['objet']->reference);
					if($tarif_forfait->lire())
					{
						$code=$tarif_forfait->donner();
						for($i=0;$i<sizeof($code);$i++)
							$code[$i]='(\''.addslashes($this->champs['identifiant']).'\', \''.addslashes($code[$i]).'\')';
						$this->executer
						('
							insert into facture_code
							(facture, code)
							values
							'.implode(', ',$code).'
						');
					}
				}
			}
			return $this->erreur;
		}
		
		public function envoyer($mode='normal')
		{
			if(!$this->lire())
				return false;
			
			$preference=new ld_preference();
			
			$adherent=new ld_adherent();
			$adherent->identifiant=$this->champs['adherent'];
			if(!$adherent->lire())
				return false;
			return true;
			$mail=new ld_mail();
			$mail->de=$_SERVER['HTTP_HOST'].' - Adhérent <'.ini_get('sendmail_from').'>';
			$mail->a=$adherent->email;
			
			switch($mode)
			{
				case 'normal';
					switch($this->champs['statut'])
					{
						case 'ATTENTE':
							$mail->sujet='Facture '.$this->champs['identifiant'].' en attente';
							$mail->text=file_get_contents(PWD_INCLUSION.'prive/mail_facture_attente.txt');
							break;
						case 'PAYE':
							$mail->copie_cachee_a=$preference->comptabilite_email;
							$mail->sujet='Facture '.$this->champs['identifiant'].' réglée';
							$mail->text=file_get_contents(PWD_INCLUSION.'prive/mail_facture_paye.txt');
							break;
						case 'ANNULE':
							$mail->sujet='Facture '.$this->champs['identifiant'].' annulée';
							$mail->text=file_get_contents(PWD_INCLUSION.'prive/mail_facture_annule.txt');
							break;
					}
					break;
				case 'forfait':
					$mail->sujet='Forfait de codes d\'accès';
					$mail->text=file_get_contents(PWD_INCLUSION.'prive/mail_forfait.txt');
					
					$this->executer
					('
						select code
						from facture_code
						where facture=\''.addslashes($this->champs['identifiant']).'\'
					');
					
					$code=array();
					while($this->donner_suivant($occurrence))
						$code[]=$occurrence['code'];
					
					if(!sizeof($code))
						return false;
					
					$mail->text=str_replace('%CODE%',implode(CRLF,$code),$mail->text);
					break;
			}
			
			$mail->text=str_replace('%FACTURE%','http://'.$_SERVER['HTTP_HOST'].'/f_'.urlencode($adherent->code).'_'.urlencode($this->champs['identifiant']).'.html',$mail->text);
			$mail->text=str_replace('%REFERENCE%',$this->champs['identifiant'],$mail->text);
			$mail->text=str_replace('%ADHERENT%',$adherent->identifiant,$mail->text);
			$mail->text=str_replace('%HTTP_HOST%',$_SERVER['HTTP_HOST'],$mail->text);
			$mail->text=str_replace('%CONSULTATION%','http://'.$_SERVER['HTTP_HOST'].'/l_'.urlencode($adherent->code).'.html',$mail->text);
			$resultat=$mail->envoyer();
			
			return $resultat;
		}
		
		public function compter($date, $periodicite, $mode, $domaine=array('www.localerte.fr','www.localerte.mobi'),$ca=true)
		{
			if(array_search($periodicite,explode(',',ABONNEMENT_PERIODICITE_ENUM))!==false && preg_match('/^(ABONNEMENT|ABONNEMENT_V2|ABONNEMENT_V2.5|ABONNEMENT_AB|ABONNEMENT_VF|ABONNEMENT_OR|ABONNEMENT_NULL|ABONNEMENT_CHEQUE|ABONNEMENT_CB|ABONNEMENT_WHA|ABONNEMENT_PAYPAL|FORFAIT)$/',$mode))
			{
				$correspondance_periodicite=array('H'=>'%k','S'=>'%w','M'=>'%e','A'=>'%c');
				$strrnd=strrnd(32,7);
				$requete='CREATE TEMPORARY TABLE `'.$strrnd.'` ('.CRLF;
				$requete.='periode smallint(5) unsigned NOT NULL,'.CRLF;
				$requete.='nombre decimal(10,2) unsigned NOT NULL default \'0\','.CRLF;
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
					case 'ABONNEMENT':
						$valeur='and facture_ligne.reference rlike \'^(mobi_)?(ab|vf|or)[0-9]+$\'';
						break;
					case 'ABONNEMENT_V2':
						$valeur='and facture_ligne.reference rlike \'^(mobi_)?(ab0003|ab0004|ab0005|ab0006|ab0007|ab0008|ab0009|ab0010|ab0011|ab0012)\'';
						break;
					case 'ABONNEMENT_V2.5':
						$valeur='and facture_ligne.reference not rlike \'^(mobi_)?(ab0003|ab0004|ab0005|ab0006|ab0007|ab0008|ab0009|ab0010|ab0011|ab0012)\'';
						break;
					case 'ABONNEMENT_AB':
						$valeur='and facture_ligne.reference not rlike \'^(mobi_)?(ab0003|ab0004|ab0005|ab0006|ab0007|ab0008|ab0009|ab0010|ab0011|ab0012)\'
							and facture_ligne.reference rlike \'^(mobi_)?ab[0-9]+$\'';
						break;
					case 'ABONNEMENT_VF':
						$valeur='and facture_ligne.reference rlike \'^(mobi_)?vf[0-9]+$\'';
						break;
					case 'ABONNEMENT_OR':
						$valeur='and facture_ligne.reference rlike \'^(mobi_)?or[0-9]+$\'';
						break;
					case 'ABONNEMENT_NULL':
						$valeur='and facture.mode is null';
						break;
					case 'ABONNEMENT_CHEQUE':
						$valeur='and facture.mode=\'CHEQUE\'';
						break;
					case 'ABONNEMENT_CB':
						$valeur='and facture.mode=\'CB\'';
						break;
					case 'ABONNEMENT_WHA':
						$valeur='and facture.mode=\'WHA\'';
						break;
					case 'ABONNEMENT_PAYPAL':
						$valeur='and facture.mode=\'PAYPAL\'';
						break;
					case 'FORFAIT':
						$valeur='and facture_ligne.reference rlike \'^(mobi_)?fo[0-9]+$\'';
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
						'.($ca?'sum(round(facture_ligne.prix_ht*facture_ligne.quantite,2))':'sum(facture_ligne.quantite)').' as nombre,
						(((date_format(facture.paiement,\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).' as periode
					from facture
						inner join facture_ligne on facture.identifiant=facture_ligne.facture
					where facture.paiement>=\''.date(SQL_DATETIME,$debut).'\'
						and facture.paiement<\''.date(SQL_DATETIME,$fin).'\'
						'.$valeur.'
						and facture.statut=\'PAYE\'
						'.(sizeof($domaine)?'and facture.domaine in (\''.implode('\', \'',array_map('addslashes',$domaine)).'\')':'').'
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
	}
	
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='voir' && isset($_REQUEST['adherent']) && isset($_REQUEST['identifiant']))
	{
		$facture=new ld_facture();
		$facture->identifiant=$_REQUEST['identifiant'];
		if($facture->lire())
		{
			$adherent=new ld_adherent();
			$adherent->identifiant=$facture->adherent;
			if($adherent->lire() && $adherent->code==$_REQUEST['adherent'])
			{
				$facture_pdf=new ld_facture_pdf();
				$contenu=$facture_pdf->creer($_REQUEST['identifiant'],'S');
				
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename=facture_'.$facture->identifiant.'.pdf');
				header('Content-Length: '.strlen($contenu));
				die($contenu);
			}
		}
	}
?>