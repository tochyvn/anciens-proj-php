<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'lalettredujour.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'ville.php');
	require_once(PWD_INCLUSION.'type.php');
	
	$define_erreur=0;
	
	define('ADHERENT_CRYPTAGE','rsyj4Tth7jt1BFjyjs35jsD7js8yA7XjsF5yj1s27Js6QrHDjR1K7des51yEZhjL68tUjrs2qs3yi4PlppmlFji3G54QvqYGsC3b5N46r84eFJwxTs4sweMH34pY3md4');
	define('ADHERENT_PERIODICITE_ENUM','H,S,M,A');
	
	define('ADHERENT_IDENTIFIANT_DEFAUT','');
	define('ADHERENT_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('ADHERENT_NOUVEAU_IDENTIFIANT_MIN',1);
	define('ADHERENT_NOUVEAU_IDENTIFIANT_MAX',9);
	define('ADHERENT_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('ADHERENT_EMAIL_MIN',6);
	define('ADHERENT_EMAIL_MAX',255);
	define('ADHERENT_EMAIL_NULL',false);
	define('ADHERENT_EMAIL_DEFAUT',NULL);
	define('ADHERENT_EMAIL_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ADHERENT_EMAIL_ERREUR_FILTRE',pow(2,$define_erreur++));
	define('ADHERENT_EMAIL_ERREUR_UNIQUE',pow(2,$define_erreur++));
	
	define('ADHERENT_PASSE_MIN',4);
	define('ADHERENT_PASSE_MAX',20);
	define('ADHERENT_PASSE_NULL',false);
	define('ADHERENT_PASSE_DEFAUT',NULL);
	define('ADHERENT_PASSE_ERREUR',pow(2,$define_erreur++));
	
	define('ADHERENT_DATE_ENREGISTREMENT_NULL',false);
	define('ADHERENT_DATE_ENREGISTREMENT_DEFAUT',NULL);

	define('ADHERENT_DATE_RESILIATION_NULL',true);
	define('ADHERENT_DATE_RESILIATION_DEFAUT',NULL);

	define('ADHERENT_DATE_ABONNEMENT_NULL',true);
	define('ADHERENT_DATE_ABONNEMENT_DEFAUT',NULL);
	
	define('ADHERENT_DATE_ACTION_NULL',true);
	define('ADHERENT_DATE_ACTION_DEFAUT',NULL);
	
	define('ADHERENT_DATE_VISITE_NULL',true);
	define('ADHERENT_DATE_VISITE_DEFAUT',NULL);
	
	define('ADHERENT_CONFIRMATION_DEFAUT',NULL);
	define('ADHERENT_CONFIRMATION_ERREUR',pow(2,$define_erreur++));
	
	define('ADHERENT_ABONNE_ENUM','OUI,NON');
	define('ADHERENT_ABONNE_NULL',false);
	define('ADHERENT_ABONNE_DEFAUT','OUI');
	define('ADHERENT_ABONNE_ERREUR',pow(2,$define_erreur++));
	
	define('ADHERENT_BRULE_ENUM','OUI,NON');
	define('ADHERENT_BRULE_NULL',false);
	define('ADHERENT_BRULE_DEFAUT','OUI');
	define('ADHERENT_BRULE_ERREUR',pow(2,$define_erreur++));
	
	define('ADHERENT_VALIDATION_ENUM','OUI,NON');
	define('ADHERENT_VALIDATION_NULL',false);
	define('ADHERENT_VALIDATION_DEFAUT','OUI');
	define('ADHERENT_VALIDATION_ERREUR',pow(2,$define_erreur++));
	
	define('ADHERENT_SPAMTRAP_ENUM','OUI,NON');
	define('ADHERENT_SPAMTRAP_NULL',false);
	define('ADHERENT_SPAMTRAP_DEFAUT','NON');
	define('ADHERENT_SPAMTRAP_ERREUR',pow(2,$define_erreur++));
	
	define('ADHERENT_CODE_MIN',32);
	define('ADHERENT_CODE_MAX',32);
	define('ADHERENT_CODE_NULL',false);
	define('ADHERENT_CODE_DEFAUT',NULL);
	
	define('ADHERENT_HARDBOUNCE_MIN',0);
	define('ADHERENT_HARDBOUNCE_MAX',pow(2,7));
	define('ADHERENT_HARDBOUNCE_NULL',false);
	define('ADHERENT_HARDBOUNCE_DEFAUT',0);
	define('ADHERENT_HARDBOUNCE_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('ADHERENT_HARDBOUNCE_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ADHERENT_SOFTBOUNCE_MIN',0);
	define('ADHERENT_SOFTBOUNCE_MAX',pow(2,7));
	define('ADHERENT_SOFTBOUNCE_NULL',false);
	define('ADHERENT_SOFTBOUNCE_DEFAUT',0);
	define('ADHERENT_SOFTBOUNCE_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('ADHERENT_SOFTBOUNCE_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ADHERENT_PLAINTE_MIN',0);
	define('ADHERENT_PLAINTE_MAX',pow(2,7));
	define('ADHERENT_PLAINTE_NULL',false);
	define('ADHERENT_PLAINTE_DEFAUT',0);
	define('ADHERENT_PLAINTE_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('ADHERENT_PLAINTE_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ADHERENT_VERSION_ENUM','V2,V2.5');
	define('ADHERENT_VERSION_NULL',false);
	define('ADHERENT_VERSION_DEFAUT','V2.5');
	define('ADHERENT_VERSION_ERREUR',pow(2,$define_erreur++));
	
	define('ADHERENT_BASCULE_NULL',true);
	define('ADHERENT_BASCULE_DEFAUT',NULL);
	
	define('ADHERENT_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_adherent extends ld_sql
	{
		private $erreur;
		private $champs;
		
		function __construct()
		{
			$this->champs=array();
			
			$this->champs['identifiant']=ADHERENT_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=ADHERENT_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['email']=ADHERENT_EMAIL_DEFAUT;
			$this->champs['passe']=ADHERENT_PASSE_DEFAUT;
			$this->champs['confirmation']=ADHERENT_CONFIRMATION_DEFAUT;
			$this->champs['date_enregistrement']=ADHERENT_DATE_ENREGISTREMENT_DEFAUT;
			$this->champs['date_resiliation']=ADHERENT_DATE_RESILIATION_DEFAUT;
			$this->champs['date_abonnement']=ADHERENT_DATE_ABONNEMENT_DEFAUT;
			$this->champs['date_action']=ADHERENT_DATE_ACTION_DEFAUT;
			$this->champs['date_visite']=ADHERENT_DATE_VISITE_DEFAUT;
			$this->champs['abonne']=ADHERENT_ABONNE_DEFAUT;
			$this->champs['brule']=ADHERENT_BRULE_DEFAUT;
			$this->champs['validation']=ADHERENT_VALIDATION_DEFAUT;
			$this->champs['spamtrap']=ADHERENT_SPAMTRAP_DEFAUT;
			$this->champs['code']=ADHERENT_CODE_DEFAUT;
			$this->champs['hardbounce']=ADHERENT_HARDBOUNCE_DEFAUT;
			$this->champs['softbounce']=ADHERENT_SOFTBOUNCE_DEFAUT;
			$this->champs['plainte']=ADHERENT_PLAINTE_DEFAUT;
			$this->champs['version']=ADHERENT_VERSION_DEFAUT;
			$this->champs['bascule']=ADHERENT_BASCULE_DEFAUT;
			
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
			$this->erreur=ADHERENT_TOTAL_ERREUR;
		}
		
		function __get($variable)
		{
			if(array_key_exists($variable,$this->champs))
			{
				return $this->champs[$variable];
			}
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
				if($variable!='date_enregistrement' && $variable!='date_resiliation' && $variable!='date_abonnement' && $variable!='date_action' && $variable!='date_visite' && $variable!='bascule' && $variable!='occurrence' && $variable!='maximum' && $variable!='minimum' && $variable!='moyenne' && $variable!='total' && $variable!='debut' && $variable!='fin')
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
					from adherent
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=ADHERENT_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			elseif($mode=='actionner')
			{
				$this->executer
				('
					select count(identifiant) as nombre
					from adherent
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
						and date_abonnement is not null
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
				{
					$this->erreur=ADHERENT_IDENTIFIANT_ERREUR;
				}
				else
				{
					$this->erreur=0;
				}
			}
			elseif($mode=='visiter')
			{
				$this->executer
				('
					select count(identifiant) as nombre
					from adherent
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
						and date_abonnement is not null
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
				{
					$this->erreur=ADHERENT_IDENTIFIANT_ERREUR;
				}
				else
				{
					$this->erreur=0;
				}
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from adherent
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=ADHERENT_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~ADHERENT_IDENTIFIANT_ERREUR;

				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<ADHERENT_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>ADHERENT_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from adherent
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//EMAIL
				if((!ADHERENT_EMAIL_NULL || $this->champs['email']!==NULL) && (strlen($this->champs['email'])<ADHERENT_EMAIL_MIN || strlen($this->champs['email'])>ADHERENT_EMAIL_MAX))
					$this->erreur|=ADHERENT_EMAIL_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ADHERENT_EMAIL_ERREUR_LONGUEUR;
				if((!ADHERENT_EMAIL_NULL || $this->champs['email']!==NULL) && !preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['email']))
					$this->erreur|=ADHERENT_EMAIL_ERREUR_FILTRE;
				else
					$this->erreur&=~ADHERENT_EMAIL_ERREUR_FILTRE;
				$this->executer
				('
					select count(identifiant) as nombre
					from adherent
					where
						email=\''.addslashes($this->champs['email']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ADHERENT_EMAIL_ERREUR_UNIQUE;
				else
					$this->erreur&=~ADHERENT_EMAIL_ERREUR_UNIQUE;
				//PASSE
				if((!ADHERENT_PASSE_NULL || $this->champs['passe']!==NULL) && (strlen($this->champs['passe'])<ADHERENT_PASSE_MIN || strlen($this->champs['passe'])>ADHERENT_PASSE_MAX))
					$this->erreur|=ADHERENT_PASSE_ERREUR;
				else
					$this->erreur&=~ADHERENT_PASSE_ERREUR;
				//CONFIRMATION
				if($this->champs['passe']!=$this->champs['confirmation'])
					$this->erreur|=ADHERENT_CONFIRMATION_ERREUR;
				else
					$this->erreur&=~ADHERENT_CONFIRMATION_ERREUR;
				//ABONNE
				if((!ADHERENT_ABONNE_NULL || $this->champs['abonne']!==NULL) && array_search($this->champs['abonne'],explode(',',ADHERENT_ABONNE_ENUM))===false)
					$this->erreur|=ADHERENT_ABONNE_ERREUR;
				else
					$this->erreur&=~ADHERENT_ABONNE_ERREUR;
				//BRULE
				if((!ADHERENT_BRULE_NULL || $this->champs['brule']!==NULL) && array_search($this->champs['brule'],explode(',',ADHERENT_BRULE_ENUM))===false)
					$this->erreur|=ADHERENT_BRULE_ERREUR;
				else
					$this->erreur&=~ADHERENT_BRULE_ERREUR;
				//VALIDATION
				if((!ADHERENT_VALIDATION_NULL || $this->champs['validation']!==NULL) && array_search($this->champs['validation'],explode(',',ADHERENT_VALIDATION_ENUM))===false)
					$this->erreur|=ADHERENT_VALIDATION_ERREUR;
				else
					$this->erreur&=~ADHERENT_VALIDATION_ERREUR;
				//SPAMTRAP
				if((!ADHERENT_SPAMTRAP_NULL || $this->champs['spamtrap']!==NULL) && array_search($this->champs['spamtrap'],explode(',',ADHERENT_SPAMTRAP_ENUM))===false)
					$this->erreur|=ADHERENT_SPAMTRAP_ERREUR;
				else
					$this->erreur&=~ADHERENT_SPAMTRAP_ERREUR;
				//HARDBOUNCE
				if((!ADHERENT_HARDBOUNCE_NULL || $this->champs['hardbounce']!==NULL) && (intval($this->champs['hardbounce'])<ADHERENT_HARDBOUNCE_MIN || intval($this->champs['hardbounce'])>ADHERENT_HARDBOUNCE_MAX))
					$this->erreur|=ADHERENT_HARDBOUNCE_ERREUR_VALEUR;
				else
					$this->erreur&=~ADHERENT_HARDBOUNCE_ERREUR_VALEUR;
				if((!ADHERENT_HARDBOUNCE_NULL || $this->champs['hardbounce']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['hardbounce']))
					$this->erreur|=ADHERENT_HARDBOUNCE_ERREUR_FILTRE;
				else
					$this->erreur&=~ADHERENT_HARDBOUNCE_ERREUR_FILTRE;
				//SOFTBOUNCE
				if((!ADHERENT_SOFTBOUNCE_NULL || $this->champs['softbounce']!==NULL) && (intval($this->champs['softbounce'])<ADHERENT_SOFTBOUNCE_MIN || intval($this->champs['softbounce'])>ADHERENT_SOFTBOUNCE_MAX))
					$this->erreur|=ADHERENT_SOFTBOUNCE_ERREUR_VALEUR;
				else
					$this->erreur&=~ADHERENT_SOFTBOUNCE_ERREUR_VALEUR;
				if((!ADHERENT_SOFTBOUNCE_NULL || $this->champs['softbounce']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['softbounce']))
					$this->erreur|=ADHERENT_SOFTBOUNCE_ERREUR_FILTRE;
				else
					$this->erreur&=~ADHERENT_SOFTBOUNCE_ERREUR_FILTRE;
				//PLAINTE
				if((!ADHERENT_PLAINTE_NULL || $this->champs['plainte']!==NULL) && (intval($this->champs['plainte'])<ADHERENT_PLAINTE_MIN || intval($this->champs['plainte'])>ADHERENT_PLAINTE_MAX))
					$this->erreur|=ADHERENT_PLAINTE_ERREUR_VALEUR;
				else
					$this->erreur&=~ADHERENT_PLAINTE_ERREUR_VALEUR;
				if((!ADHERENT_PLAINTE_NULL || $this->champs['plainte']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['plainte']))
					$this->erreur|=ADHERENT_PLAINTE_ERREUR_FILTRE;
				else
					$this->erreur&=~ADHERENT_PLAINTE_ERREUR_FILTRE;
				//VERSION
				if((!ADHERENT_VERSION_NULL || $this->champs['version']!==NULL) && array_search($this->champs['version'],explode(',',ADHERENT_VERSION_ENUM))===false)
					$this->erreur|=ADHERENT_VERSION_ERREUR;
				else
					$this->erreur&=~ADHERENT_VERSION_ERREUR;
			}
		}
		
		public function lire($champ='identifiant')
		{
			if($champ=='email') $condition='email=\''.addslashes($this->champs['email']).'\'';
			elseif($champ=='code') $condition='code=\''.addslashes($this->champs['code']).'\'';
			else $condition='identifiant=\''.addslashes($this->champs['identifiant']).'\'';
			
			$this->executer
			('
				select
					identifiant,
					email,
					passe,
					unix_timestamp(date_enregistrement) as date_enregistrement,
					unix_timestamp(date_resiliation) as date_resiliation,
					unix_timestamp(date_abonnement) as date_abonnement,
					unix_timestamp(date_action) as date_action,
					unix_timestamp(date_visite) as date_visite,
					abonne,
					brule,
					validation,
					spamtrap,
					code,
					hardbounce,
					softbounce,
					plainte,
					version,
					unix_timestamp(bascule) as bascule
				from adherent
				where
					'.$condition.'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['email']=$occurrence['email'];
			$this->champs['passe']=$occurrence['passe'];
			$this->champs['confirmation']=$occurrence['passe'];
			$this->champs['date_enregistrement']=$occurrence['date_enregistrement'];
			$this->champs['date_resiliation']=$occurrence['date_resiliation'];
			$this->champs['date_abonnement']=$occurrence['date_abonnement'];
			$this->champs['date_action']=$occurrence['date_action'];
			$this->champs['date_visite']=$occurrence['date_visite'];
			$this->champs['abonne']=$occurrence['abonne'];
			$this->champs['brule']=$occurrence['brule'];
			$this->champs['validation']=$occurrence['validation'];
			$this->champs['spamtrap']=$occurrence['spamtrap'];
			$this->champs['code']=$occurrence['code'];
			$this->champs['hardbounce']=$occurrence['hardbounce'];
			$this->champs['softbounce']=$occurrence['softbounce'];
			$this->champs['plainte']=$occurrence['plainte'];
			$this->champs['version']=$occurrence['version'];
			$this->champs['bascule']=$occurrence['bascule'];
			return true;
		}
		
		public function identifier($mode='normal')
		{

			switch($mode)
			{

				default:
					$this->executer
					('
						select
							identifiant
						from adherent
						where
							email=\''.addslashes($this->champs['email']).'\'
							and passe=\''.addslashes($this->champs['passe']).'\'
							and abonne=\'OUI\'
					');
					break;

				case 'cryptage':
					$this->executer
					('
						select
							identifiant
						from adherent
						where
							code=\''.addslashes($this->champs['identifiant']).'\'
							and abonne=\'OUI\'
						having count(identifiant)=1
					');
					break;
			}
			
			if(!$this->donner_suivant($occurrence))
			{
				return false;
			}
			
			$this->champs['identifiant']=$occurrence['identifiant'];
			return $this->lire();
		}
		
		public function supprimer()
		{

			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from adherent
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=ADHERENT_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=ADHERENT_NOUVEAU_IDENTIFIANT_DEFAUT;
			}
			return $this->erreur;
		}
		
		public function ajouter($lalettredujour=false)
		{

			$this->verifier('ajouter');
			if(!$this->erreur)
			{

				$this->champs['date_enregistrement']=time();
				$this->champs['date_action']=NULL;
				$this->champs['date_visite']=NULL;
				
				if($this->champs['abonne']=='OUI' && $this->champs['validation']=='OUI')
				{
					$this->champs['date_resiliation']=NULL;
					$this->champs['date_abonnement']=time();
				}
				
				if($this->champs['abonne']=='NON' || $this->champs['validation']=='NON')
				{
					$this->champs['date_resiliation']=time();
					$this->champs['date_abonnement']=NULL;
				}
				
				$this->champs['bascule']=time();
				
				$this->executer('select md5(encode(\''.addslashes(str_pad($this->champs['nouveau_identifiant'],9,'0',STR_PAD_LEFT)).'\',\''.addslashes(ADHERENT_CRYPTAGE).'\')) as cryptage');
				$this->donner_suivant($occurrence);
				$this->champs['code']=$occurrence['cryptage'];
				
				$this->executer
				('
					insert into adherent
					(
						identifiant,
						email,
						passe,
						date_enregistrement,
						date_resiliation,
						date_abonnement,
						date_action,
						date_visite,
						abonne,
						brule,
						validation,
						spamtrap,
						code,
						hardbounce,
						softbounce,
						plainte,
						version,
						bascule
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['email']!==NULL)?('\''.addslashes($this->champs['email']).'\''):('null')).',
						'.(($this->champs['passe']!==NULL)?('\''.addslashes($this->champs['passe']).'\''):('null')).',
						'.(($this->champs['date_enregistrement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_enregistrement'])).'\''):('null')).',
						'.(($this->champs['date_resiliation']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_resiliation'])).'\''):('null')).',
						'.(($this->champs['date_abonnement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_abonnement'])).'\''):('null')).',
						'.(($this->champs['date_action']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_action'])).'\''):('null')).',
						'.(($this->champs['date_visite']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_visite'])).'\''):('null')).',
						'.(($this->champs['abonne']!==NULL)?('\''.addslashes($this->champs['abonne']).'\''):('null')).',
						'.(($this->champs['brule']!==NULL)?('\''.addslashes($this->champs['brule']).'\''):('null')).',
						'.(($this->champs['validation']!==NULL)?('\''.addslashes($this->champs['validation']).'\''):('null')).',
						'.(($this->champs['spamtrap']!==NULL)?('\''.addslashes($this->champs['spamtrap']).'\''):('null')).',
						'.(($this->champs['code']!==NULL)?('\''.addslashes($this->champs['code']).'\''):('null')).',
						'.(($this->champs['hardbounce']!==NULL)?('\''.addslashes($this->champs['hardbounce']).'\''):('null')).',
						'.(($this->champs['softbounce']!==NULL)?('\''.addslashes($this->champs['softbounce']).'\''):('null')).',
						'.(($this->champs['plainte']!==NULL)?('\''.addslashes($this->champs['plainte']).'\''):('null')).',
						'.(($this->champs['version']!==NULL)?('\''.addslashes($this->champs['version']).'\''):('null')).',
						'.(($this->champs['bascule']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['bascule'])).'\''):('null')).'
					)
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				
				if($lalettredujour)
				{
					lalettredujour($this->champs['email'],'','','','','','','','','','SIMPLE OPT-IN','407434646','','','','','','LLDJ03','');
				}
			}
			return $this->erreur;
		}
		
		public function modifier($lalettredujour=false)
		{
			$this->verifier('modifier');
			if(!$this->erreur)
			{

				$adherent=new ld_adherent();
				$adherent->identifiant=$this->champs['identifiant'];
				$adherent->lire();
				if($adherent->abonne!=$this->champs['abonne'] || $adherent->validation!=$this->champs['validation'])
				{
					$this->champs['date_action']=NULL;
					$this->champs['date_visite']=NULL;
					
					if($this->champs['abonne']=='OUI' && $this->champs['validation']=='OUI')
					{
						$this->champs['date_resiliation']=NULL;
						$this->champs['date_abonnement']=time();
					}
					
					if($this->champs['abonne']=='NON' || $this->champs['validation']=='NON')
					{
						$this->champs['date_resiliation']=time();
						$this->champs['date_abonnement']=NULL;
					}
				}
				
				if($adherent->version!=$this->champs['version'])
				{
					$this->champs['bascule']=time();
				}
				
				$this->executer('select md5(encode(\''.addslashes(str_pad($this->champs['nouveau_identifiant'],9,'0',STR_PAD_LEFT)).'\',\''.addslashes(ADHERENT_CRYPTAGE).'\')) as cryptage');
				$this->donner_suivant($occurrence);
				$this->champs['code']=$occurrence['cryptage'];

				$this->executer
				('
					update adherent
					set
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						email='.(($this->champs['email']!==NULL)?('\''.addslashes($this->champs['email']).'\''):('null')).',
						passe='.(($this->champs['passe']!==NULL)?('\''.addslashes($this->champs['passe']).'\''):('null')).',
						date_resiliation='.(($this->champs['date_resiliation']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_resiliation'])).'\''):('null')).',
						date_abonnement='.(($this->champs['date_abonnement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_abonnement'])).'\''):('null')).',
						date_action='.(($this->champs['date_action']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_action'])).'\''):('null')).',
						date_visite='.(($this->champs['date_visite']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_visite'])).'\''):('null')).',
						abonne='.(($this->champs['abonne']!==NULL)?('\''.addslashes($this->champs['abonne']).'\''):('null')).',
						brule='.(($this->champs['brule']!==NULL)?('\''.addslashes($this->champs['brule']).'\''):('null')).',
						validation='.(($this->champs['validation']!==NULL)?('\''.addslashes($this->champs['validation']).'\''):('null')).',
						spamtrap='.(($this->champs['spamtrap']!==NULL)?('\''.addslashes($this->champs['spamtrap']).'\''):('null')).',
						code='.(($this->champs['code']!==NULL)?('\''.addslashes($this->champs['code']).'\''):('null')).',
						hardbounce='.(($this->champs['hardbounce']!==NULL)?('\''.addslashes($this->champs['hardbounce']).'\''):('null')).',
						softbounce='.(($this->champs['softbounce']!==NULL)?('\''.addslashes($this->champs['softbounce']).'\''):('null')).',
						plainte='.(($this->champs['plainte']!==NULL)?('\''.addslashes($this->champs['plainte']).'\''):('null')).',
						version='.(($this->champs['version']!==NULL)?('\''.addslashes($this->champs['version']).'\''):('null')).',
						bascule='.(($this->champs['bascule']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['bascule'])).'\''):('null')).'
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
				
				if($lalettredujour)
				{
					lalettredujour($this->champs['email'],'','','','','','','','','','SIMPLE OPT-IN','407434646','','','','','','LLDJ03','');
				}
			}
			return $this->erreur;
		}
		
		function actionner()
		{

			$this->verifier('actionner');
			if(!$this->erreur)
			{	
				$this->champs['date_action']=time();
				
				$this->executer
				('
					update adherent
					set
						date_action='.(($this->champs['date_action']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_action'])).'\''):('null')).'
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
			}
			return $this->erreur;
		}
		
		function visiter()
		{

			$this->verifier('visiter');
			if(!$this->erreur)
			{	
				$this->champs['date_visite']=time();
				
				$this->executer
				('
					update adherent
					set
						date_visite='.(($this->champs['date_visite']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['date_visite'])).'\''):('null')).'
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
			}
			return $this->erreur;
		}
		
		public function tester($mode)
		{

			$this->verifier($mode);
			return $this->erreur;
		}
		
		public function compter($date, $periodicite, $mode)
		{

			if(array_search($periodicite,explode(',',ADHERENT_PERIODICITE_ENUM))!==false && preg_match('/^(ABONNEMENT|DESABONNEMENT|ENREGISTREMENT)$/',$mode))
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
					case 'ABONNEMENT':
						$champ='date_abonnement';
						break;
					case 'DESABONNEMENT':
						$champ='date_resiliation';
						break;
					case 'ENREGISTREMENT':
						$champ='date_enregistrement';
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
						(((date_format('.$champ.',\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).' as periode
					from adherent
					where '.$champ.'>=\''.date(SQL_DATETIME,$debut).'\'
						and '.$champ.'<\''.date(SQL_DATETIME,$fin).'\'
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
		
		public function envoyer($mode,$parametre=array())
		{

			$preference=new ld_preference();
			
			if($this->lire() && (($this->champs['abonne']=='OUI' && $this->champs['brule']=='NON' && ($this->champs['validation']=='OUI' || $mode=='cheznous' || $mode=='code1') && $this->champs['spamtrap']=='NON' && ($preference->hardbounce_limite===NULL || $this->champs['hardbounce']<$preference->hardbounce_limite) && ($preference->softbounce_limite===NULL || $this->champs['softbounce']<$preference->softbounce_limite) && ($preference->plainte_limite===NULL || $this->champs['plainte']<$preference->plainte_limite)/* && !preg_match('/@(hotmail|live|msn)/',$this->champs['email'])*/) || preg_match('/aicom(123|147|456|789)@/',$this->champs['email'])))
			{
				$mail=new ld_mail();
				$mail->a=$this->champs['email'];
				$mail->retour_a=$preference->retour_email;
				$mail->reponse_a=$preference->reponse_email;
				$mail->http_desabonnement='http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html';
				$mail->mailto_desabonnement=$preference->desabonnement_email;
				
				switch($mode)
				{

					case 'passe':
					
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';;
						$mail->sujet='Rappel de votre mot de passe';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_passe_v25.txt');
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail->text=str_replace('%HTTP_HOST%',preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']),$mail->text);
						$mail->text=str_replace('%HTTP_ADHERENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/c_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%EMAIL%',$this->champs['email'],$mail->text);
						$mail->text=str_replace('%PASSE%',$this->champs['passe'],$mail->text);
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						return $mail->envoyer();
						
						break;

					case 'inscription':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='Location immo <'.$preference->expediteur_email.'>';
						$mail->sujet=isset($parametre['sujet'])?$parametre['sujet']:'Cherchez efficacement votre logement';//Ces annonces immobilieres vous concernent
						
						$mail->html=file_get_contents(PWD_INCLUSION.'prive/adherent_inscription_v25.new.html');
						
						$alertes=new ld_liste('select identifiant from alerte where adherent='.(int)$this->champs['identifiant'].' order by enregistrement, identifiant');
						if(!$alertes->total) return false;
						
						$tableau=array();
						for($i=0;$i<sizeof($alertes->occurrence);$i++)
						{
							
						 	$alerte=new ld_alerte();
						 	$alerte->identifiant=$alertes->occurrence[$i]['identifiant'];
						 	$alerte->lire();
							
						 	$ville=new ld_ville();
						 	$ville->identifiant=$alerte->ville;
						 	$ville->lire();
							
						 	$type=array();
						 	$type_identifiant=array();
						 	$type_designation=array();
						 	for($j=0;$j<$alerte->alerte_type_compter();$j++)
							{
						 		$objet=$alerte->alerte_type_lire($j);
						 		$types=new ld_liste('select identifiant from type where identifiant='.(int)$objet['objet']->type.' or parent='.(int)$objet['objet']->type);
								
						 		for($k=0;$k<sizeof($types->occurrence);$k++)
								{
						 			$type[$k]=new ld_type();
						 			$type[$k]->identifiant=$types->occurrence[$k]['identifiant'];
						 			$type[$k]->lire();
						 			$type_identifiant[]=$type[$k]->identifiant;
						 			if($types->occurrence[$k]['identifiant']==$objet['objet']->type) $type_designation[]=$type[$k]->designation;
						 		}
						 	}
							
						 	$annonces=new ld_liste
						 	('
						 		select sql_calc_found_rows
						 			liste.identifiant as identifiant,
						 			loyer,
						 			ville_nom as ville,
						 			ville_identifiant,
						 			liste.code_postal as code_postal,
						 			type_designation as type,
						 			statut,
						 			if(datediff(enregistrement,modification)=0,unix_timestamp(enregistrement),unix_timestamp(parution)) as parution,
						 			unix_timestamp(enregistrement) as enregistrement,
						 			(adherent_annonce.adherent is not null) as adherent_annonce,
						 			if(loyer is null,1,0) as loyer_not_null,
						 			image,
						 			ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),2),0) as distance,
						 			descriptif,
						 			url
						 		from
						 			liste
						 			inner join ville on liste.ville_identifiant=ville.identifiant
						 			left join adherent_annonce on adherent_annonce.adherent='.(int)$this->champs['identifiant'].' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
						 		where 1
						 			and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
						 			and type_identifiant in ('.implode(', ',$type_identifiant).')
						 		order by distance
								limit 10
						 	');
							
						 	if(sizeof($annonces->occurrence))
							{
						 		if(!isset($sujet)) $sujet='Votre recherche de '.implode(', ',$type_designation).' à '.ucwords(strtolower($ville->nom)).' et alentours';
								
						 		$tableau[$i]='';
								
						 		$tableau[$i].='<table width="600" align="center" cellspacing="0" cellpadding="6" border="0">';
						 		$tableau[$i].='<tr>';
						 		$tableau[$i].='<td><font face="Arial, Helvetica, sans-serif" color="#FE7503"><img src="http://static.localerte.fr/adherent/img/enveloppe.png" alt="" width="22" height="12">&nbsp;&nbsp;Votre recherche n&ordm;'.($i+1).'</font></td>';
						 		$tableau[$i].='</tr>';
						 		$tableau[$i].='</table>';
						 		$tableau[$i].='<table width="600" align="center" cellspacing="0" cellpadding="6" border="1" style="border-collapse:collapse; border-color:#D9D9D9;">';
						 		$tableau[$i].='<tr>';
						 		$tableau[$i].='<td colspan="5" align="center" style="border-color:#D9D9D9;" bgcolor="#D9D9D9"><font face="Arial, Helvetica, sans-serif" color="#777777"><img src="http://static.localerte.fr/adherent/img/maison.png" alt="" width="18" height="18">&nbsp;&nbsp;'.ma_htmlentities(implode(', ',$type_designation)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="http://static.localerte.fr/adherent/img/epingle.png" alt="" width="10" height="18">&nbsp;&nbsp;'.ma_htmlentities(ucwords(strtolower($ville->nom))).' <font size="2">('.$ville->code_postal.') dans un rayon de '.$alerte->rayon.'km</font></font></td>';
						 		$tableau[$i].='</tr>';
						 		$tableau[$i].='<tr>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Commune</strong></font></td>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Type</strong></font></td>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="right"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Loyer</strong></font></td>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="center">&nbsp;</td>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="center"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Date</strong></font></td>';
						 		$tableau[$i].='</tr>';
								
						 		foreach($annonces->occurrence as $annonce)
								{
						 			$annonce_moins_6h = time()-$annonce['enregistrement']<(3600*6);
						 			$annonce_moins_16h = time()-$annonce['enregistrement']<(3600*12) && time()-$annonce['enregistrement']>=(3600*4) ;
									
						 			$gras=$annonce['ville_identifiant']==$alerte->ville;
									
						 			$tableau[$i].='<tr>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;"><a href="%CONSULTATION%#'.uniqid().'" target="_blank"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities(ucwords(strtolower($annonce['ville']))).($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities($annonce['type']).($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;" align="right"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities($annonce['loyer']?round($annonce['loyer'],0):'- ').'&euro;'.($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;" align="center"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').($annonce_moins_16h?'- 12H':($annonce_moins_6h?'- 6H':'&nbsp;')).($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;" align="center"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities(strftime('%d/%m/%y',$annonce['parution'])).($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='</tr>';
						 		}
								
						 		$tableau[$i].='<tr>';
						 		$tableau[$i].='<td colspan="5" align="center"><a href="%CONSULTATION%" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#FE7503">... Affichez les annonces suivantes</font></a></td>';
						 		$tableau[$i].='</tr>';
						 		$tableau[$i].='</table>';
						 	}
						 }
						 if(!sizeof($tableau)) return false;
						
						 $mail->sujet=isset($sujet)?$sujet:$mail->sujet;
						 $mail->html=str_replace('%TABLEAU%',implode('<br>',$tableau),$mail->html);
						
						 $mail->html=str_replace('%SUJET%',ma_htmlentities($mail->sujet),$mail->html);
						 $mail->html=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						 $mail->html=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						 $mail->html=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						 $mail->html=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->html);
						
						 $liste=new ld_liste('select round(count(identifiant)*1.1) as nombre from liste');
						 $mail->html=str_replace('%DATECOMPLETE%',ma_htmlentities(strftime('%A %e %B %Y')),$mail->html);
						 $mail->html=str_replace('%AUJOURDHUI%',ma_htmlentities('Aujourd\'hui, '.number_format($liste->occurrence[0]['nombre'], 0, '.', ' ').' annonces vous attendent'),$mail->html);
						
						 $mail=$this->fr2com($mail);
						 //if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
 						 //if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						 $resultat=$mail->envoyer();
						 if($resultat===true)
						 	$this->executer
						 	('
						 		insert into statistiques_alerte
						 		(
						 			jour,
						 			mail,
						 			total
						 		)
						 		values
						 		(
						 			\''.date('Y-m-d').'\',
						 			\''.$mode.'\',
						 			1
						 		)
						 		on duplicate key update
						 			total=total+1
						 	');
						
						 return $resultat;
						
						 break;
					case 'cheznous.bak':
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet='CHEZNOUS .fr vous fait decouvrir LOCALERTE .fr';

						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_inscription_v25.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
						{

							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
							$this->executer
							('
								insert into statistiques_adherent
								(
									jour,
									inscrit_cheznous
								)
								values
								(
									\''.date('Y-m-d').'\',
									1
								)
								on duplicate key update
									inscrit_cheznous=inscrit_cheznous+1
							');
						}
						
						return $resultat;
						
						break;

					case 'cheznous.2012-11-06':
						
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet='CHEZNOUS .fr vous fait decouvrir LOCALERTE .fr';

						$mail->html=file_get_contents(PWD_INCLUSION.'prive/inscription_cheznous_v251.html');
						$mail->html=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
						{

							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
							$this->executer
							('
								insert into statistiques_adherent
								(
									jour,
									inscrit_cheznous
								)
								values
								(
									\''.date('Y-m-d').'\',
									1
								)
								on duplicate key update
									inscrit_cheznous=inscrit_cheznous+1
							');
						}
						
						return $resultat;
						
						break;

					case 'cheznous':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='Location immo <'.$preference->expediteur_email.'>';
						$mail->sujet=isset($parametre['sujet'])?$parametre['sujet']:'Cherchez efficacement votre logement';//Ces annonces immobilieres vous concernent
						
						$mail->html=file_get_contents(PWD_INCLUSION.'prive/adherent_cheznous_v25.new.html');
						
						$alertes=new ld_liste('select identifiant from alerte where adherent='.(int)$this->champs['identifiant'].' order by enregistrement, identifiant');
						if(!$alertes->total) return false;
						
						$tableau=array();
						for($i=0;$i<sizeof($alertes->occurrence);$i++)
						{
							
						 	$alerte=new ld_alerte();
						 	$alerte->identifiant=$alertes->occurrence[$i]['identifiant'];
						 	$alerte->lire();
							
						 	$ville=new ld_ville();
						 	$ville->identifiant=$alerte->ville;
						 	$ville->lire();
							
						 	$type=array();
						 	$type_identifiant=array();
						 	$type_designation=array();
						 	for($j=0;$j<$alerte->alerte_type_compter();$j++)
							{
						 		$objet=$alerte->alerte_type_lire($j);
						 		$types=new ld_liste('select identifiant from type where identifiant='.(int)$objet['objet']->type.' or parent='.(int)$objet['objet']->type);
								
						 		for($k=0;$k<sizeof($types->occurrence);$k++)
								{
						 			$type[$k]=new ld_type();
						 			$type[$k]->identifiant=$types->occurrence[$k]['identifiant'];
						 			$type[$k]->lire();
						 			$type_identifiant[]=$type[$k]->identifiant;
						 			if($types->occurrence[$k]['identifiant']==$objet['objet']->type) $type_designation[]=$type[$k]->designation;
						 		}
						 	}
							
						 	$annonces=new ld_liste
						 	('
						 		select sql_calc_found_rows
						 			liste.identifiant as identifiant,
						 			loyer,
						 			ville_nom as ville,
						 			ville_identifiant,
						 			liste.code_postal as code_postal,
						 			type_designation as type,
						 			statut,
						 			if(datediff(enregistrement,modification)=0,unix_timestamp(enregistrement),unix_timestamp(parution)) as parution,
						 			unix_timestamp(enregistrement) as enregistrement,
						 			(adherent_annonce.adherent is not null) as adherent_annonce,
						 			if(loyer is null,1,0) as loyer_not_null,
						 			image,
						 			ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),2),0) as distance,
						 			descriptif,
						 			url
						 		from
						 			liste
						 			inner join ville on liste.ville_identifiant=ville.identifiant
						 			left join adherent_annonce on adherent_annonce.adherent='.(int)$this->champs['identifiant'].' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
						 		where 1
						 			and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
						 			and type_identifiant in ('.implode(', ',$type_identifiant).')
						 		order by distance
								limit 10
						 	');
							
						 	if(sizeof($annonces->occurrence))
							{
						 		if(!isset($sujet)) $sujet='Votre recherche de '.implode(', ',$type_designation).' à '.ucwords(strtolower($ville->nom)).' et alentours';
								
						 		$tableau[$i]='';
								
						 		$tableau[$i].='<table width="600" align="center" cellspacing="0" cellpadding="6" border="0">';
						 		$tableau[$i].='<tr>';
						 		$tableau[$i].='<td><font face="Arial, Helvetica, sans-serif" color="#FE7503"><img src="http://static.localerte.fr/adherent/img/enveloppe.png" alt="" width="22" height="12">&nbsp;&nbsp;Votre recherche n&ordm;'.($i+1).'</font></td>';
						 		$tableau[$i].='</tr>';
						 		$tableau[$i].='</table>';
						 		$tableau[$i].='<table width="600" align="center" cellspacing="0" cellpadding="6" border="1" style="border-collapse:collapse; border-color:#D9D9D9;">';
						 		$tableau[$i].='<tr>';
						 		$tableau[$i].='<td colspan="5" align="center" style="border-color:#D9D9D9;" bgcolor="#D9D9D9"><font face="Arial, Helvetica, sans-serif" color="#777777"><img src="http://static.localerte.fr/adherent/img/maison.png" alt="" width="18" height="18">&nbsp;&nbsp;'.ma_htmlentities(implode(', ',$type_designation)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="http://static.localerte.fr/adherent/img/epingle.png" alt="" width="10" height="18">&nbsp;&nbsp;'.ma_htmlentities(ucwords(strtolower($ville->nom))).' <font size="2">('.$ville->code_postal.') dans un rayon de '.$alerte->rayon.'km</font></font></td>';
						 		$tableau[$i].='</tr>';
						 		$tableau[$i].='<tr>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Commune</strong></font></td>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Type</strong></font></td>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="right"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Loyer</strong></font></td>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="center">&nbsp;</td>';
						 		$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="center"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Date</strong></font></td>';
						 		$tableau[$i].='</tr>';
								
						 		foreach($annonces->occurrence as $annonce)
								{
						 			$annonce_moins_6h = time()-$annonce['enregistrement']<(3600*6);
						 			$annonce_moins_16h = time()-$annonce['enregistrement']<(3600*12) && time()-$annonce['enregistrement']>=(3600*4) ;
									
						 			$gras=$annonce['ville_identifiant']==$alerte->ville;
									
						 			$tableau[$i].='<tr>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;"><a href="%CONSULTATION%#'.uniqid().'" target="_blank"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities(ucwords(strtolower($annonce['ville']))).($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities($annonce['type']).($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;" align="right"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities($annonce['loyer']?round($annonce['loyer'],0):'- ').'&euro;'.($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;" align="center"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').($annonce_moins_16h?'- 12H':($annonce_moins_6h?'- 6H':'&nbsp;')).($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='<td style="border-color:#D9D9D9;" align="center"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities(strftime('%d/%m/%y',$annonce['parution'])).($gras?'</strong>':'').'</font></a></td>';
						 			$tableau[$i].='</tr>';
						 		}
								
						 		$tableau[$i].='<tr>';
						 		$tableau[$i].='<td colspan="5" align="center"><a href="%CONSULTATION%" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#FE7503">... Affichez les annonces suivantes</font></a></td>';
						 		$tableau[$i].='</tr>';
						 		$tableau[$i].='</table>';
						 	}
						 }
						 if(!sizeof($tableau)) return false;
						
						 $mail->sujet=isset($sujet)?$sujet:$mail->sujet;
						 $mail->html=str_replace('%TABLEAU%',implode('<br>',$tableau),$mail->html);
						
						 $mail->html=str_replace('%SUJET%',ma_htmlentities($mail->sujet),$mail->html);
						 $mail->html=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						 $mail->html=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						 $mail->html=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						 $mail->html=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->html);
						
						 $liste=new ld_liste('select round(count(identifiant)*1.1) as nombre from liste');
						 $mail->html=str_replace('%DATECOMPLETE%',ma_htmlentities(strftime('%A %e %B %Y')),$mail->html);
						 $mail->html=str_replace('%AUJOURDHUI%',ma_htmlentities('Aujourd\'hui, '.number_format($liste->occurrence[0]['nombre'], 0, '.', ' ').' annonces vous attendent'),$mail->html);
						
						 $mail=$this->fr2com($mail);
						 //if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						 //if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						 $resultat=$mail->envoyer();
						 if($resultat===true)
						 	$this->executer
						 	('
						 		insert into statistiques_alerte
						 		(
						 			jour,
						 			mail,
						 			total
						 		)
						 		values
						 		(
						 			\''.date('Y-m-d').'\',
						 			\''.$mode.'\',
						 			1
						 		)
						 		on duplicate key update
						 			total=total+1
						 	');
						 	$this->executer
						 	('
						 		insert into statistiques_adherent
						 		(
						 			jour,
						 			inscrit_cheznous
						 		)
						 		values
						 		(
						 			\''.date('Y-m-d').'\',
						 			1
						 		)
						 		on duplicate key update
						 			inscrit_cheznous=inscrit_cheznous+1
						 	');
						
						 return $resultat;
						
						 break;
					case 'cheznous-20131218':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet='Vos annonces du '.strftime('%A %e');
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_alerte_v25.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
						{
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
							$this->executer
							('
								insert into statistiques_adherent
								(
									jour,
									inscrit_cheznous
								)
								values
								(
									\''.date('Y-m-d').'\',
									1
								)
								on duplicate key update
									inscrit_cheznous=inscrit_cheznous+1
							');
						}
						
						return $resultat;
						
						break;
					case 'cheznous-text':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet=isset($parametre['sujet'])?$parametre['sujet']:'Vos annonces du '.strftime('%A %e');
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_alerte_v25.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
						{
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
							$this->executer
							('
								insert into statistiques_adherent
								(
									jour,
									inscrit_cheznous
								)
								values
								(
									\''.date('Y-m-d').'\',
									1
								)
								on duplicate key update
									inscrit_cheznous=inscrit_cheznous+1
							');
						}
						
						return $resultat;
						
						break;
					case 'code1':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE <'.$preference->expediteur_email.'>';
						
						$code_inactivite = new ld_code();
						$resultat=$code_inactivite->creer('inscription');
						
						$mail->sujet='Votre inscription e notre alerte immobiliere';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_code_1.txt');
						$mail->text=str_replace('%CODE_1%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/c1'.strtolower($resultat).'_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
						{
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
							$this->executer
							('
								insert into statistiques_adherent
								(
									jour,
									inscrit_cheznous
								)
								values
								(
									\''.date('Y-m-d').'\',
									1
								)
								on duplicate key update
									inscrit_cheznous=inscrit_cheznous+1
							');
						}
						
						return $resultat;

						break;
					case 'code2':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE <'.$preference->expediteur_email.'>';
						
						$code_inactivite = new ld_code();
						$resultat=$code_inactivite->creer('inscription');
						
						$mail->sujet='Votre code promo gratuit';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_code_2.txt');
						$mail->text=str_replace('%CODE_2%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/c2'.strtolower($resultat).'_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
						{
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
							$this->executer
							('
								insert into statistiques_adherent
								(
									jour,
									inscrit_cheznous
								)
								values
								(
									\''.date('Y-m-d').'\',
									1
								)
								on duplicate key update
									inscrit_cheznous=inscrit_cheznous+1
							');
						}
						
						return $resultat;

						break;
					case 'alerte-lolo-2':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='Karine Herault <'.$preference->expediteur_email.'>';
						$mail->sujet='Mise à jour de la liste %TYPES% à %VILLE% et environ';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_alerte_lolo-2.txt');
						
						$alertes=new ld_liste('select identifiant from alerte where adherent='.(int)$this->champs['identifiant'].' order by enregistrement, identifiant');
						if(!$alertes->total) return false;
						
						$i=0;
						
						$alerte=new ld_alerte();
						$alerte->identifiant=$alertes->occurrence[$i]['identifiant'];
						$alerte->lire();
						
						$ville=new ld_ville();
						$ville->identifiant=$alerte->ville;
						$ville->lire();
						
						$type=array();
						$type_identifiant=array();
						$type_designation=array();
						for($j=0;$j<$alerte->alerte_type_compter();$j++)
						{
							$objet=$alerte->alerte_type_lire($j);
							$types=new ld_liste('select identifiant from type where identifiant='.(int)$objet['objet']->type.' or parent='.(int)$objet['objet']->type);
							
							for($k=0;$k<sizeof($types->occurrence);$k++)
							{
								$type[$k]=new ld_type();
								$type[$k]->identifiant=$types->occurrence[$k]['identifiant'];
								$type[$k]->lire();
								$type_identifiant[]=$type[$k]->identifiant;
								if($types->occurrence[$k]['identifiant']==$objet['objet']->type) $type_designation[]=$type[$k]->designation;
							}
						}
						
						$mail->sujet=str_replace('%TYPES%',ma_htmlentities(implode(', ',$type_designation)),$mail->sujet);
						$mail->sujet=str_replace('%VILLE%',ma_htmlentities(ucwords(strtolower($ville->nom))),$mail->sujet);
						
						$mail->text=str_replace('%TYPES%',ma_htmlentities(implode(', ',$type_designation)),$mail->text);
						$mail->text=str_replace('%VILLE%',ma_htmlentities(ucwords(strtolower($ville->nom))),$mail->text);
						
						$annonces=new ld_liste
						('
							select sql_calc_found_rows
								liste.identifiant as identifiant,
								loyer,
								ville_nom as ville,
								ville_identifiant,
								liste.code_postal as code_postal,
								type_designation as type,
								statut,
								if(datediff(enregistrement,modification)=0,unix_timestamp(enregistrement),unix_timestamp(parution)) as parution,
								unix_timestamp(enregistrement) as enregistrement,
								(adherent_annonce.adherent is not null) as adherent_annonce,
								if(loyer is null,1,0) as loyer_not_null,
								image,
								ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),2),0) as distance,
								descriptif,
								url
							from
								liste
								inner join ville on liste.ville_identifiant=ville.identifiant
								left join adherent_annonce on adherent_annonce.adherent='.(int)$this->champs['identifiant'].' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
							where 1
								and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
								and type_identifiant in ('.implode(', ',$type_identifiant).')
							order by distance
							limit 2
						');
						
						if($annonces->total>=1)
							$mail->text=str_replace('%ANNONCE1%',CRLF.TAB.TAB.'1'.CRLF.TAB.TAB.$annonces->occurrence[0]['ville'].', '.$annonces->occurrence[0]['type'].', '.$annonces->occurrence[0]['loyer'].'€ '.CRLF.TAB.TAB.substr(str_replace(array(CRLF,CR,LF),' ',$annonces->occurrence[0]['descriptif']),0,65).'...',$mail->text);
						else
							$mail->text=str_replace('%ANNONCE1%','',$mail->text);
						
						if($annonces->total>=2)
							$mail->text=str_replace('%ANNONCE2%',CRLF.TAB.TAB.'2'.CRLF.TAB.TAB.$annonces->occurrence[1]['ville'].', '.$annonces->occurrence[1]['type'].', '.$annonces->occurrence[1]['loyer'].'€ '.CRLF.TAB.TAB.substr(str_replace(array(CRLF,CR,LF),' ',$annonces->occurrence[1]['descriptif']),0,65).'...',$mail->text);
						else
							$mail->text=str_replace('%ANNONCE2%','',$mail->text);
						
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'alerte-lolo':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='Laurent <'.$preference->expediteur_email.'>';
						$mail->sujet='Location Appart, Maison, Garage';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_alerte_lolo.txt');
						
						$alertes=new ld_liste('select identifiant from alerte where adherent='.(int)$this->champs['identifiant'].' order by enregistrement, identifiant');
						if(!$alertes->total) return false;
						
						$i=0;
						
						$alerte=new ld_alerte();
						$alerte->identifiant=$alertes->occurrence[$i]['identifiant'];
						$alerte->lire();
						
						$ville=new ld_ville();
						$ville->identifiant=$alerte->ville;
						$ville->lire();
						
						$type=array();
						$type_identifiant=array();
						$type_designation=array();
						for($j=0;$j<$alerte->alerte_type_compter();$j++)
						{
							$objet=$alerte->alerte_type_lire($j);
							$types=new ld_liste('select identifiant from type where identifiant='.(int)$objet['objet']->type.' or parent='.(int)$objet['objet']->type);
							
							for($k=0;$k<sizeof($types->occurrence);$k++)
							{
								$type[$k]=new ld_type();
								$type[$k]->identifiant=$types->occurrence[$k]['identifiant'];
								$type[$k]->lire();
								$type_identifiant[]=$type[$k]->identifiant;
								if($types->occurrence[$k]['identifiant']==$objet['objet']->type) $type_designation[]=$type[$k]->designation;
							}
						}
						
						$annonces=new ld_liste
						('
							select count(liste.identifiant) as nombre
							from
								liste
								inner join ville on liste.ville_identifiant=ville.identifiant
							where 1
								and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
								and type_identifiant in ('.implode(', ',$type_identifiant).')
						');
						
						$mail->text=str_replace('%TYPES%',ma_htmlentities(implode(', ',$type_designation)),$mail->text);
						$mail->text=str_replace('%VILLE%',ma_htmlentities(ucwords(strtolower($ville->nom))),$mail->text);
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'alerte':
					case 'alerte-new':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='Location immo <'.$preference->expediteur_email.'>';
						$mail->sujet=isset($parametre['sujet'])?$parametre['sujet']:'Trouvez rapidement votre logement';//Ces annonces immobilieres vous concernent
						
						$mail->html=file_get_contents(PWD_INCLUSION.'prive/adherent_alerte_v25.new.html');
						
						$alertes=new ld_liste('select identifiant from alerte where adherent='.(int)$this->champs['identifiant'].' order by enregistrement, identifiant');
						if(!$alertes->total) return false;
						
						$tableau=array();
						for($i=0;$i<sizeof($alertes->occurrence);$i++)
						{
							
							$alerte=new ld_alerte();
							$alerte->identifiant=$alertes->occurrence[$i]['identifiant'];
							$alerte->lire();
							
							$ville=new ld_ville();
							$ville->identifiant=$alerte->ville;
							$ville->lire();
							
							$type=array();
							$type_identifiant=array();
							$type_designation=array();
							for($j=0;$j<$alerte->alerte_type_compter();$j++)
							{
								$objet=$alerte->alerte_type_lire($j);
								$types=new ld_liste('select identifiant from type where identifiant='.(int)$objet['objet']->type.' or parent='.(int)$objet['objet']->type);
								
								for($k=0;$k<sizeof($types->occurrence);$k++)
								{
									$type[$k]=new ld_type();
									$type[$k]->identifiant=$types->occurrence[$k]['identifiant'];
									$type[$k]->lire();
									$type_identifiant[]=$type[$k]->identifiant;
									if($types->occurrence[$k]['identifiant']==$objet['objet']->type) $type_designation[]=$type[$k]->designation;
								}
							}
							
							$annonces=new ld_liste
							('
								select sql_calc_found_rows
									liste.identifiant as identifiant,
									loyer,
									ville_nom as ville,
									ville_identifiant,
									liste.code_postal as code_postal,
									type_designation as type,
									statut,
									if(datediff(enregistrement,modification)=0,unix_timestamp(enregistrement),unix_timestamp(parution)) as parution,
									unix_timestamp(enregistrement) as enregistrement,
									(adherent_annonce.adherent is not null) as adherent_annonce,
									if(loyer is null,1,0) as loyer_not_null,
									image,
									ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),2),0) as distance,
									descriptif,
									url
								from
									liste
									inner join ville on liste.ville_identifiant=ville.identifiant
									left join adherent_annonce on adherent_annonce.adherent='.(int)$this->champs['identifiant'].' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
								where 1
									and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
									and type_identifiant in ('.implode(', ',$type_identifiant).')
								order by distance
								limit 10
							');
							
							if(sizeof($annonces->occurrence))
							{
								if(!isset($sujet)) $sujet='Vos locations de '.implode(', ',$type_designation).' à '.ucwords(strtolower($ville->nom)).' et alentours';
								
								$tableau[$i]='';
								
								$tableau[$i].='<table width="600" align="center" cellspacing="0" cellpadding="6" border="0">';
								$tableau[$i].='<tr>';
								$tableau[$i].='<td><font face="Arial, Helvetica, sans-serif" color="#FE7503"><img src="http://static.localerte.fr/adherent/img/enveloppe.png" alt="" width="22" height="12">&nbsp;&nbsp;Votre recherche n&ordm;'.($i+1).'</font></td>';
								$tableau[$i].='</tr>';
								$tableau[$i].='</table>';
								$tableau[$i].='<table width="600" align="center" cellspacing="0" cellpadding="6" border="1" style="border-collapse:collapse; border-color:#D9D9D9;">';
								$tableau[$i].='<tr>';
								$tableau[$i].='<td colspan="5" align="center" style="border-color:#D9D9D9;" bgcolor="#D9D9D9"><font face="Arial, Helvetica, sans-serif" color="#777777"><img src="http://static.localerte.fr/adherent/img/maison.png" alt="" width="18" height="18">&nbsp;&nbsp;'.ma_htmlentities(implode(', ',$type_designation)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="http://static.localerte.fr/adherent/img/epingle.png" alt="" width="10" height="18">&nbsp;&nbsp;'.ma_htmlentities(ucwords(strtolower($ville->nom))).' <font size="2">('.$ville->code_postal.') dans un rayon de '.$alerte->rayon.'km</font></font></td>';
								$tableau[$i].='</tr>';
								$tableau[$i].='<tr>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Commune</strong></font></td>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Type</strong></font></td>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="right"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Loyer</strong></font></td>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="center">&nbsp;</td>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="center"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Date</strong></font></td>';
								$tableau[$i].='</tr>';
								
								foreach($annonces->occurrence as $annonce)
								{
									$annonce_moins_6h = time()-$annonce['enregistrement']<(3600*6);
									$annonce_moins_16h = time()-$annonce['enregistrement']<(3600*12) && time()-$annonce['enregistrement']>=(3600*4) ;
									
									$gras=$annonce['ville_identifiant']==$alerte->ville;
									
									$tableau[$i].='<tr>';
									$tableau[$i].='<td style="border-color:#D9D9D9;"><a href="%CONSULTATION%#'.uniqid().'" target="_blank"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities(ucwords(strtolower($annonce['ville']))).($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='<td style="border-color:#D9D9D9;"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities($annonce['type']).($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='<td style="border-color:#D9D9D9;" align="right"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities($annonce['loyer']?round($annonce['loyer'],0):'- ').'&euro;'.($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='<td style="border-color:#D9D9D9;" align="center"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').($annonce_moins_16h?'- 12H':($annonce_moins_6h?'- 6H':'&nbsp;')).($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='<td style="border-color:#D9D9D9;" align="center"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities(strftime('%d/%m/%y',$annonce['parution'])).($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='</tr>';
								}
								
								$tableau[$i].='<tr>';
								$tableau[$i].='<td colspan="5" align="center"><a href="%CONSULTATION%" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#FE7503">... Affichez les annonces suivantes</font></a></td>';
								$tableau[$i].='</tr>';
								$tableau[$i].='</table>';
							}
						}
						if(!sizeof($tableau)) return false;
						
						/*if(preg_match('/gmail/i',$this->champs['email'])) return $this->envoyer('alerte-text',isset($sujet)?array('sujet'=>$sujet):array());
						elseif(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$this->champs['email'])) return $this->envoyer('alerte-text',isset($sujet)?array('sujet'=>$sujet):array());
						else */$mail->sujet=isset($sujet)?$sujet:$mail->sujet;
						
						$mail->html=str_replace('%TABLEAU%',implode('<br>',$tableau),$mail->html);
						
						$mail->html=str_replace('%SUJET%',ma_htmlentities($mail->sujet),$mail->html);
						$mail->html=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->html);
						
						$liste=new ld_liste('select round(count(identifiant)*1.1) as nombre from liste');
						$mail->html=str_replace('%DATECOMPLETE%',ma_htmlentities(strftime('%A %e %B %Y')),$mail->html);
						$mail->html=str_replace('%AUJOURDHUI%',ma_htmlentities('Aujourd\'hui, '.number_format($liste->occurrence[0]['nombre'], 0, '.', ' ').' annonces vous attendent'),$mail->html);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);

						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'alerte-20131218':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet='Vos annonces du '.strftime('%A %e').' - alerte matinale';
						
						$mail->html=file_get_contents(PWD_INCLUSION.'prive/adherent_alerte_v25.html');
						$mail->html=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->html);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'alerte-text':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet=isset($parametre['sujet'])?$parametre['sujet']:'Vos annonces du '.strftime('%A %e').' - alerte matinale';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_alerte_v25.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'optimisation':
					case 'optimisation-new':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='Votre recherche de locations <'.$preference->expediteur_email.'>';
						$mail->sujet='Découvrez les nouvelles annonces du jour';
						
						$mail->html=file_get_contents(PWD_INCLUSION.'prive/adherent_optimisation_v25.new.html');
						
						$debut=strpos($mail->html,'%TABLEAU_DEBUT%')+strlen('%TABLEAU_DEBUT%');
						$fin=strpos($mail->html,'%TABLEAU_FIN%');
						$modele=substr($mail->html,$debut,$fin-$debut);
						
						$mail->html=preg_replace('/%TABLEAU_DEBUT%.*%TABLEAU_FIN%/s','%TABLEAU%',$mail->html);
						
						$alertes=new ld_liste('select identifiant from alerte where adherent='.(int)$this->champs['identifiant'].' order by enregistrement, identifiant');
						if(!$alertes->total) return false;
						
						$tableau=array();
						for($i=0;$i<sizeof($alertes->occurrence);$i++)
						{
							
							$alerte=new ld_alerte();
							$alerte->identifiant=$alertes->occurrence[$i]['identifiant'];
							$alerte->lire();
							
							$ville=new ld_ville();
							$ville->identifiant=$alerte->ville;
							$ville->lire();
							
							$type=array();
							$type_identifiant=array();
							$type_designation=array();
							for($j=0;$j<$alerte->alerte_type_compter();$j++)
							{
								$objet=$alerte->alerte_type_lire($j);
								$types=new ld_liste('select identifiant from type where identifiant='.(int)$objet['objet']->type.' or parent='.(int)$objet['objet']->type);
								
								for($k=0;$k<sizeof($types->occurrence);$k++)
								{
									$type[$k]=new ld_type();
									$type[$k]->identifiant=$types->occurrence[$k]['identifiant'];
									$type[$k]->lire();
									$type_identifiant[]=$type[$k]->identifiant;
									if($types->occurrence[$k]['identifiant']==$objet['objet']->type) $type_designation[]=$type[$k]->designation;
								}
							}
							
							$annonces=new ld_liste
							('
								select count(liste.identifiant) as nombre
								from
									liste
									inner join ville on liste.ville_identifiant=ville.identifiant
								where 1
									and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
									and type_identifiant in ('.implode(', ',$type_identifiant).')
							');
							
							if($annonces->occurrence[0]['nombre'])
							{
								$tableau[$i]=$modele;
								
								$tableau[$i]=str_replace('%TABLEAU_1%',$i+1,$tableau[$i]);
								$tableau[$i]=str_replace('%TABLEAU_2%',ma_htmlentities(implode(', ',$type_designation)),$tableau[$i]);
								$tableau[$i]=str_replace('%TABLEAU_3%',ma_htmlentities(ucwords(strtolower($ville->nom))),$tableau[$i]);
								$tableau[$i]=str_replace('%TABLEAU_4%',$alerte->rayon,$tableau[$i]);
								$tableau[$i]=str_replace('%TABLEAU_5%',$annonces->occurrence[0]['nombre'],$tableau[$i]);
								$tableau[$i]=str_replace('%TABLEAU_6%',$annonces->occurrence[0]['nombre']>1?'s':'',$tableau[$i]);
								$tableau[$i]=str_replace('%TABLEAU_7%',$annonces->occurrence[0]['nombre']>1?'ont':'a',$tableau[$i]);
								$tableau[$i]=str_replace('%TABLEAU_8%',$annonces->occurrence[0]['nombre']>1?'s':'',$tableau[$i]);
							}
						}
						if(!sizeof($tableau)) return false;
						
						/*if(preg_match('/gmail/i',$this->champs['email'])) return $this->envoyer('optimisation-text',isset($sujet)?array('sujet'=>$sujet):array());
						elseif(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$this->champs['email'])) return $this->envoyer('optimisation-text',isset($sujet)?array('sujet'=>$sujet):array());
						else */$mail->sujet=isset($sujet)?$sujet:$mail->sujet;
						
						$mail->html=str_replace('%TABLEAU%',implode('<br>',$tableau),$mail->html);
						
						$mail->html=str_replace('%SUJET%',ma_htmlentities($mail->sujet),$mail->html);
						$mail->html=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->html);
						
						$liste=new ld_liste('select round(count(identifiant)*1.1) as nombre from liste');
						$mail->html=str_replace('%DATECOMPLETE%',ma_htmlentities(strftime('%A %e %B %Y')),$mail->html);
						$mail->html=str_replace('%TOTAL_1%',number_format($liste->occurrence[0]['nombre'], 0, '.', ' '),$mail->html);
						$mail->html=str_replace('%TOTAL_2%',$liste->occurrence[0]['nombre']>1?'s':'',$mail->html);
						$mail->html=str_replace('%TOTAL_3%',$liste->occurrence[0]['nombre']>1?'ent':'',$mail->html);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'optimisation-lolo':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='Laurent <'.$preference->expediteur_email.'>';
						$mail->sujet='Nouvelles annonces d\'apparts, de maisons et de garages';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_optimisation_lolo.txt');
						
						$alertes=new ld_liste('select identifiant from alerte where adherent='.(int)$this->champs['identifiant'].' order by enregistrement, identifiant');
						if(!$alertes->total) return false;
						
						$i=0;
						
						$alerte=new ld_alerte();
						$alerte->identifiant=$alertes->occurrence[$i]['identifiant'];
						$alerte->lire();
						
						$ville=new ld_ville();
						$ville->identifiant=$alerte->ville;
						$ville->lire();
						
						$type=array();
						$type_identifiant=array();
						$type_designation=array();
						for($j=0;$j<$alerte->alerte_type_compter();$j++)
						{
							$objet=$alerte->alerte_type_lire($j);
							$types=new ld_liste('select identifiant from type where identifiant='.(int)$objet['objet']->type.' or parent='.(int)$objet['objet']->type);
							
							for($k=0;$k<sizeof($types->occurrence);$k++)
							{
								$type[$k]=new ld_type();
								$type[$k]->identifiant=$types->occurrence[$k]['identifiant'];
								$type[$k]->lire();
								$type_identifiant[]=$type[$k]->identifiant;
								if($types->occurrence[$k]['identifiant']==$objet['objet']->type) $type_designation[]=$type[$k]->designation;
							}
						}
						
						$annonces=new ld_liste
						('
							select count(liste.identifiant) as nombre
							from
								liste
								inner join ville on liste.ville_identifiant=ville.identifiant
							where 1
								and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
								and type_identifiant in ('.implode(', ',$type_identifiant).')
						');
						
						$mail->text=str_replace('%TYPES%',ma_htmlentities(implode(', ',$type_designation)),$mail->text);
						$mail->text=str_replace('%VILLE%',ma_htmlentities(ucwords(strtolower($ville->nom))),$mail->text);
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'optimisation-20141003':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='Location immo <'.$preference->expediteur_email.'>';
						$mail->sujet='Nous avons des logements pour vous';
						
						$mail->html=file_get_contents(PWD_INCLUSION.'prive/adherent_optimisation_v25.20141003.html');
						
						$alertes=new ld_liste('select identifiant from alerte where adherent='.(int)$this->champs['identifiant'].' order by enregistrement, identifiant');
						if(!$alertes->total) return false;
						
						$tableau=array();
						for($i=0;$i<sizeof($alertes->occurrence);$i++)
						{
							
							$alerte=new ld_alerte();
							$alerte->identifiant=$alertes->occurrence[$i]['identifiant'];
							$alerte->lire();
							
							$ville=new ld_ville();
							$ville->identifiant=$alerte->ville;
							$ville->lire();
							
							$type=array();
							$type_identifiant=array();
							$type_designation=array();
							for($j=0;$j<$alerte->alerte_type_compter();$j++)
							{
								$objet=$alerte->alerte_type_lire($j);
								$types=new ld_liste('select identifiant from type where identifiant='.(int)$objet['objet']->type.' or parent='.(int)$objet['objet']->type);
								
								for($k=0;$k<sizeof($types->occurrence);$k++)
								{
									$type[$k]=new ld_type();
									$type[$k]->identifiant=$types->occurrence[$k]['identifiant'];
									$type[$k]->lire();
									$type_identifiant[]=$type[$k]->identifiant;
									if($types->occurrence[$k]['identifiant']==$objet['objet']->type) $type_designation[]=$type[$k]->designation;
								}
							}
							
							$annonces=new ld_liste
							('
								select sql_calc_found_rows
									liste.identifiant as identifiant,
									loyer,
									ville_nom as ville,
									ville_identifiant,
									liste.code_postal as code_postal,
									type_designation as type,
									statut,
									if(datediff(enregistrement,modification)=0,unix_timestamp(enregistrement),unix_timestamp(parution)) as parution,
									unix_timestamp(enregistrement) as enregistrement,
									(adherent_annonce.adherent is not null) as adherent_annonce,
									if(loyer is null,1,0) as loyer_not_null,
									image,
									ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),2),0) as distance,
									descriptif,
									url
								from
									liste
									inner join ville on liste.ville_identifiant=ville.identifiant
									left join adherent_annonce on adherent_annonce.adherent='.(int)$this->champs['identifiant'].' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
								where 1
									and ifnull(round((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0)<'.addslashes($alerte->rayon).'
									and type_identifiant in ('.implode(', ',$type_identifiant).')
								order by distance
								limit 10
							');
							
							if(sizeof($annonces->occurrence))
							{
								if(!isset($sujet)) $sujet='Vos annonces à '.ucwords(strtolower($ville->nom)).' de '.implode(', ',$type_designation);
								
								$tableau[$i]='';
								
								$tableau[$i].='<table width="600" align="center" cellspacing="0" cellpadding="6" border="0">';
								$tableau[$i].='<tr>';
								$tableau[$i].='<td><font face="Arial, Helvetica, sans-serif" color="#FE7503"><img src="http://static.localerte.fr/adherent/img/enveloppe.png" alt="" width="22" height="12">&nbsp;&nbsp;Votre recherche n&ordm;'.($i+1).'</font></td>';
								$tableau[$i].='</tr>';
								$tableau[$i].='</table>';
								$tableau[$i].='<table width="600" align="center" cellspacing="0" cellpadding="6" border="1" style="border-collapse:collapse; border-color:#D9D9D9;">';
								$tableau[$i].='<tr>';
								$tableau[$i].='<td colspan="5" align="center" style="border-color:#D9D9D9;" bgcolor="#D9D9D9"><font face="Arial, Helvetica, sans-serif" color="#777777"><img src="http://static.localerte.fr/adherent/img/maison.png" alt="" width="18" height="18">&nbsp;&nbsp;'.ma_htmlentities(implode(', ',$type_designation)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="http://static.localerte.fr/adherent/img/epingle.png" alt="" width="10" height="18">&nbsp;&nbsp;'.ma_htmlentities(ucwords(strtolower($ville->nom))).' <font size="2">('.$ville->code_postal.') dans un rayon de '.$alerte->rayon.'km</font></font></td>';
								$tableau[$i].='</tr>';
								$tableau[$i].='<tr>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Commune</strong></font></td>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Type</strong></font></td>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="right"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Loyer</strong></font></td>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="center">&nbsp;</td>';
								$tableau[$i].='<td style="border-color:#D9D9D9;" bgcolor="#f2f2f2" align="center"><font face="Arial, Helvetica, sans-serif" color="#777777"><strong>Date</strong></font></td>';
								$tableau[$i].='</tr>';
								
								foreach($annonces->occurrence as $annonce)
								{
									$annonce_moins_6h = time()-$annonce['enregistrement']<(3600*6);
									$annonce_moins_16h = time()-$annonce['enregistrement']<(3600*12) && time()-$annonce['enregistrement']>=(3600*4) ;
									
									$gras=$annonce['ville_identifiant']==$alerte->ville;
									
									$tableau[$i].='<tr>';
									$tableau[$i].='<td style="border-color:#D9D9D9;"><a href="%CONSULTATION%#'.uniqid().'" target="_blank"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities(ucwords(strtolower($annonce['ville']))).($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='<td style="border-color:#D9D9D9;"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities($annonce['type']).($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='<td style="border-color:#D9D9D9;" align="right"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities($annonce['loyer']?round($annonce['loyer'],0):'- ').'&euro;'.($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='<td style="border-color:#D9D9D9;" align="center"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').($annonce_moins_16h?'- 12H':($annonce_moins_6h?'- 6H':'&nbsp;')).($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='<td style="border-color:#D9D9D9;" align="center"><a href="%CONSULTATION%#'.uniqid().'" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#1C5290">'.($gras?'<strong>':'').ma_htmlentities(strftime('%d/%m/%y',$annonce['parution'])).($gras?'</strong>':'').'</font></a></td>';
									$tableau[$i].='</tr>';
								}
								
								$tableau[$i].='<tr>';
								$tableau[$i].='<td colspan="5" align="center"><a href="%CONSULTATION%" target="_blank" style="text-decoration:none;"><font face="Arial, Helvetica, sans-serif" color="#FE7503">... Affichez les annonces suivantes</font></a></td>';
								$tableau[$i].='</tr>';
								$tableau[$i].='</table>';
							}
						}
						if(!sizeof($tableau)) return false;
						

						/*if(preg_match('/gmail/i',$this->champs['email'])) return $this->envoyer('optimisation-text',isset($sujet)?array('sujet'=>$sujet):array());
						elseif(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$this->champs['email'])) return $this->envoyer('optimisation-text',isset($sujet)?array('sujet'=>$sujet):array());
						else */$mail->sujet=isset($sujet)?$sujet:$mail->sujet;
						
						$mail->html=str_replace('%TABLEAU%',implode('<br>',$tableau),$mail->html);
						
						$mail->html=str_replace('%SUJET%',ma_htmlentities($mail->sujet),$mail->html);
						$mail->html=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->html);
						
						$liste=new ld_liste('select round(count(identifiant)*1.1) as nombre from liste');
						$mail->html=str_replace('%DATECOMPLETE%',ma_htmlentities(strftime('%A %e %B %Y')),$mail->html);
						$mail->html=str_replace('%AUJOURDHUI%',ma_htmlentities('Aujourd\'hui, '.number_format($liste->occurrence[0]['nombre'], 0, '.', ' ').' annonces vous attendent'),$mail->html);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'optimisation-20131218':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet='Vos annonces du '.strftime('%A %e').' - alerte de fin de journee';
						
						$mail->html=file_get_contents(PWD_INCLUSION.'prive/adherent_optimisation_v25.html');
						$mail->html=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->html);
						$mail->html=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->html);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'optimisation-text':
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet=isset($parametre['sujet'])?$parametre['sujet']:'Vos annonces du '.strftime('%A %e').' - alerte de fin de journee';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_optimisation_v25.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'vieux':
						
						return true;
						
						@setlocale(LC_TIME,'fr_FR','fr');
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet='Vos annonces du '.strftime('%A %e').'';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_vieux_v25.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						$resultat=$mail->envoyer();
						if($resultat===true)
							$this->executer
							('
								insert into statistiques_alerte
								(
									jour,
									mail,
									total
								)
								values
								(
									\''.date('Y-m-d').'\',
									\''.$mode.'\',
									1
								)
								on duplicate key update
									total=total+1
							');
						
						return $resultat;
						
						break;
					case 'rappel':
						
						return true;
						
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';
						$mail->sujet='Votre compte - IMPORTANT';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_rappel_v25.txt');
						$mail->text=str_replace('%POURSUITE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/a_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
					
						return $mail->envoyer();
						
						break;
					case 'veille':
						
						return true;
						
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';;
						$mail->sujet='Vous ne recevez plus votre alerte';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_veille_v25.txt');
						$mail->text=str_replace('%POURSUITE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/a_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						return $mail->envoyer();
						
						break;
					case 'aide':
						
						return true;
						
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';;
						$mail->sujet='Comment trouver votre location immobiliere ?';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_aide_v25.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%AIDE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/h_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						return $mail->envoyer();
						
						break;
					case 'enquete':
						
						return true;
						
						$code_inactivite = new ld_code();
						$resultat=$code_inactivite->creer('enquete');
						
						$mail->de='LOCALERTE - Service adherents <'.$preference->expediteur_email.'>';;
						$mail->sujet='Votre code promo - essai gratuit';
						
						$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_enquete_v25.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						$mail->text=str_replace('%CODE%',$resultat,$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						return $mail->envoyer();
						
						break;
					case 'inactivite':
						
						return $this->envoyer('alerte');
						
						//$resultat=file_get_contents('http://payment.allopass.com/api/freecode.apu?auth=102802/1042318/1607385&number=1&key=901e1b65bb0aa9a8fcbf5e897ef53f00&uid=6676830&max_use=1&xml=0');
						//$resultat=explode(LF,str_replace(LF.'  ',LF,$resultat));
						//if(isset($resultat[1]))
						//	$resultat=$resultat[1];
						//else
						//	$resultat='';
						
						$code_inactivite = new ld_code();
						$resultat=$code_inactivite->creer('inactivite');
						if($resultat!='' && $resultat!='003')
						{
							$mail->de='Location immo <'.$preference->expediteur_email.'>';//LOCALERTE - Service adherents
							$mail->sujet='Consultez gratuitement nos annonces pendant 24 heures';//Votre code promo - essai gratuit
							
							$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_inactivite_v25.txt');
							$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
							$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
							$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
							$mail->text=str_replace('%CODE%',$resultat,$mail->text);
							$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
					
							$mail=$this->fr2com($mail);
							//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
							//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
							
							$resultat=$mail->envoyer();
							if($resultat===true)
								$this->executer
								('
									insert into statistiques_alerte
									(
										jour,
										mail,
										total
									)
									values
									(
										\''.date('Y-m-d').'\',
										\''.$mode.'\',
										1
									)
									on duplicate key update
										total=total+1
								');
							
							return $resultat;
						}
						else
							return $this->envoyer('alerte');
						
						break;
						
					case 'abonnement_allopass':
					case 'abonnement_wha':
						
						return true;
						
						$mail->de='LOCALERTE - Direction <'.$preference->expediteur_email.'>';;
						$mail->sujet='Consultez nos annonces moins cher';

						if($mode=='abonnement_allopass')
							$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_merci_allopass.txt');
						else
							$mail->text=file_get_contents(PWD_INCLUSION.'prive/adherent_merci_wha.txt');
						$mail->text=str_replace('%CONSULTATION%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/l_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%PARAMETRE%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/f_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%DESABONNEMENT%','http://'.preg_replace('/www[1-2]/','www',$_SERVER['HTTP_HOST']).'/d_'.urlencode($this->champs['code']).'_'.date('Ymd').$mode.'.html',$mail->text);
						$mail->text=str_replace('%ENREGISTREMENT%',date('d/m/y',$this->champs['date_enregistrement']),$mail->text);
						
						$mail=$this->fr2com($mail);
						//if(preg_match('/@(gmail|googlemail)/i',$mail->a)) $mail=$this->fr2com($mail);
						//if(preg_match('/hotmail|live|msn|outlook|dbmail|dartybox/i',$mail->a))$mail=$this->fr2com($mail);
						
						return $mail->envoyer();
						
						break;
				}
			}
			return false;
		}
		
		private function fr2com($mail,$equivalent='localerte.fr')
		{
			$mail->de=str_replace('localerte.fr',$equivalent,$mail->de);
			$mail->reponse_a=str_replace('localerte.fr',$equivalent,$mail->reponse_a);
			$mail->retour_a=str_replace('localerte.fr',$equivalent,$mail->retour_a);
			$mail->http_desabonnement=str_replace('localerte.fr',$equivalent,$mail->http_desabonnement);
			$mail->mailto_desabonnement=str_replace('localerte.fr',$equivalent,$mail->mailto_desabonnement);
			$mail->html=str_replace('localerte.fr',$equivalent,$mail->html);
			$mail->text=str_replace('localerte.fr',$equivalent,$mail->text);
			return $mail;
		}
		
		public function statistiser()
		{
			$jour=date('Y-m-d');
			$this->executer('insert ignore into statistiques_adherent (jour) values (\''.$jour.'\')');
			$this->executer('update statistiques_adherent set inscrit=(select count(identifiant) as nombre from adherent where datediff(\''.$jour.'\',date_enregistrement)=0) where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_tous=(select count(identifiant) as nombre from adherent where abonne=\'OUI\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_7=(select count(identifiant) as nombre from adherent where datediff(\''.$jour.'\',date_enregistrement)>7 and abonne=\'OUI\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_14=(select count(identifiant) as nombre from adherent where datediff(\''.$jour.'\',date_enregistrement)>14 and abonne=\'OUI\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_21=(select count(identifiant) as nombre from adherent where datediff(\''.$jour.'\',date_enregistrement)>21 and abonne=\'OUI\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_28=(select count(identifiant) as nombre from adherent where datediff(\''.$jour.'\',date_enregistrement)>28 and abonne=\'OUI\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_orange=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@(orange|wanadoo)\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_laposte=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@laposte\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_voila=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@voila\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_hotmail=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@(live|msn|hotmail)\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_gmail=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@gmail\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_free=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@free\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_aol=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@aol\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_yahoo=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@(yahoo|ymail)\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_gmx=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@(gmx|caramail)\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_sfr=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and email rlike \'@(neuf|sfr)\.\') where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_avec_paiement=(select count(identifiant) as nombre from adherent where abonne=\'OUI\' and (identifiant in (select adherent from facture) or identifiant in (select adherent from code) or identifiant in (select adherent from wha))) where jour=\''.$jour.'\'');
			$this->executer('update statistiques_adherent set abonne_sans_paiement=abonne_tous-abonne_avec_paiement where jour=\''.$jour.'\'');
		}
	}
	
	if(isset($_REQUEST['adherent_test']))
	{
		require_once(PWD_INCLUSION.'liste.php');
		
		$liste=new ld_liste
		('
			select identifiant
			from adherent
			where
			/*email=\'laurent.davenne@aicom.fr\'
			or  email=\'aicom20141115@laposte.net\'
			or */ email=\'aicom20140929@gmail.com\'
			/*or  email=\'aicom20141115@outlook.fr\'
			or  email=\'aicom20140929@yahoo.fr\'
			or  email=\'aicom20140920@orange.fr\'
			or  email=\'aicom20140318@free.fr\'*/
		');
		
		for($i=0;$i<$liste->total;$i++)
		{
			$adherent=new ld_adherent();
			$adherent->identifiant=$liste->occurrence[$i]['identifiant'];
			
			//$adherent->envoyer('passe');
			//$adherent->envoyer('inscription');
			//$adherent->envoyer('cheznous');
			//$adherent->envoyer('alerte');
			//var_dump($adherent->envoyer('alerte-new'));
			//var_dump($adherent->envoyer('optimisation-new'));
			//var_dump($adherent->envoyer('alerte-lolo'));
			//var_dump($adherent->envoyer('optimisation-lolo'));
			var_dump($adherent->envoyer('alerte-lolo-2'));
			//$adherent->envoyer('inactivite');
			//$adherent->envoyer('rappel');
			//$adherent->envoyer('veille');
			//$adherent->envoyer('aide');
			//$adherent->envoyer('abonnement_wha');
			//$adherent->envoyer('abonnement_allopass');
			//$adherent->envoyer('enquete');
			print('Ok');
		}
	}
	
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='remonter')
	{
		$adherent=new ld_adherent();
		$adherent->statistiser();
	}
	
	/*if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='test_yannick')
	{
		$adherent=new ld_adherent();
		$adherent->identifiant=539916753;
		$adherent->envoyer('cheznous2');
	}*/

?>
