<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	$define_erreur=0;
	
	define('ABONNEMENT_PERIODICITE_ENUM','H,S,M,A');
	
	define('ABONNEMENT_IDENTIFIANT_DEFAUT','');
	define('ABONNEMENT_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('ABONNEMENT_NOUVEAU_IDENTIFIANT_MIN',1);
	define('ABONNEMENT_NOUVEAU_IDENTIFIANT_MAX',9);
	define('ABONNEMENT_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('ABONNEMENT_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ABONNEMENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('ABONNEMENT_ADHERENT_DEFAUT',NULL);
	define('ABONNEMENT_ADHERENT_NULL',false);
	define('ABONNEMENT_ADHERENT_ERREUR',pow(2,$define_erreur++));
	
	define('ABONNEMENT_DELAI_MIN',1);
	define('ABONNEMENT_DELAI_MAX',86400000);
	define('ABONNEMENT_DELAI_NULL',false);
	define('ABONNEMENT_DELAI_DEFAUT',NULL);
	define('ABONNEMENT_DELAI_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('ABONNEMENT_DELAI_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ABONNEMENT_ENREGISTREMENT_NULL',false);
	define('ABONNEMENT_ENREGISTREMENT_DEFAUT',NULL);
	
	define('ABONNEMENT_PREMIERE_UTILISATION_NULL',true);
	define('ABONNEMENT_PREMIERE_UTILISATION_DEFAUT',NULL);
	
	define('ABONNEMENT_DERNIERE_UTILISATION_NULL',true);
	define('ABONNEMENT_DERNIERE_UTILISATION_DEFAUT',NULL);
	
	define('ABONNEMENT_DOMAINE_MIN',1);
	define('ABONNEMENT_DOMAINE_MAX',20);
	define('ABONNEMENT_DOMAINE_NULL',false);
	define('ABONNEMENT_DOMAINE_DEFAUT',NULL);
	define('ABONNEMENT_DOMAINE_ERREUR',pow(2,$define_erreur++));
	
	define('ABONNEMENT_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_abonnement extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_abonnement()
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
			$this->champs['identifiant']=ABONNEMENT_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=ABONNEMENT_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['adherent']=ABONNEMENT_ADHERENT_DEFAUT;
			$this->champs['delai']=ABONNEMENT_DELAI_DEFAUT;
			$this->champs['enregistrement']=ABONNEMENT_ENREGISTREMENT_DEFAUT;
			$this->champs['premiere_utilisation']=ABONNEMENT_PREMIERE_UTILISATION_DEFAUT;
			$this->champs['derniere_utilisation']=ABONNEMENT_DERNIERE_UTILISATION_DEFAUT;
			$this->champs['domaine']=ABONNEMENT_DOMAINE_DEFAUT;
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
			
			$this->erreur=ABONNEMENT_TOTAL_ERREUR;

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
				if($variable!='enregistrement' && $variable!='premiere_utilisation' && $variable!='derniere_utilisation' && $variable!='occurrence' && $variable!='maximum' && $variable!='minimum' && $variable!='moyenne' && $variable!='total' && $variable!='debut' && $variable!='fin')
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
					from abonnement
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=ABONNEMENT_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from abonnement
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=ABONNEMENT_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~ABONNEMENT_IDENTIFIANT_ERREUR;
				//NOUVEAU IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<ABONNEMENT_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>ABONNEMENT_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=ABONNEMENT_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ABONNEMENT_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from abonnement
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ABONNEMENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~ABONNEMENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//ADHERENT
				$this->executer
				('
					select count(identifiant) as nombre
					from adherent
					where
						identifiant=\''.addslashes($this->champs['adherent']).'\'
				');
				$this->donner_suivant($occurrence);
				if((!ABONNEMENT_ADHERENT_NULL || $this->champs['adherent']!==NULL) && !$occurrence['nombre'])
					$this->erreur|=ABONNEMENT_ADHERENT_ERREUR;
				else
					$this->erreur&=~ABONNEMENT_ADHERENT_ERREUR;
				//DELAI
				if((!ABONNEMENT_DELAI_NULL || $this->champs['delai']!==NULL) && (intval($this->champs['delai'])<ABONNEMENT_DELAI_MIN || intval($this->champs['delai'])>ABONNEMENT_DELAI_MAX))
					$this->erreur|=ABONNEMENT_DELAI_ERREUR_VALEUR;
				else
					$this->erreur&=~ABONNEMENT_DELAI_ERREUR_VALEUR;
				if((!ABONNEMENT_DELAI_NULL || $this->champs['delai']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['delai']))
					$this->erreur|=ABONNEMENT_DELAI_ERREUR_FILTRE;
				else
					$this->erreur&=~ABONNEMENT_DELAI_ERREUR_FILTRE;
				//DOMAINE
				if((!ABONNEMENT_DOMAINE_NULL || $this->champs['domaine']!==NULL) && (strlen($this->champs['domaine'])<ABONNEMENT_DOMAINE_MIN || strlen($this->champs['domaine'])>ABONNEMENT_DOMAINE_MAX))
					$this->erreur|=ABONNEMENT_DOMAINE_ERREUR;
				else
					$this->erreur&=~ABONNEMENT_DOMAINE_ERREUR;
			}
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					identifiant,
					adherent,
					delai,
					unix_timestamp(enregistrement) as enregistrement,
					unix_timestamp(premiere_utilisation) as premiere_utilisation,
					unix_timestamp(derniere_utilisation) as derniere_utilisation,
					domaine
				from abonnement
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['adherent']=$occurrence['adherent'];
			$this->champs['delai']=$occurrence['delai'];
			$this->champs['enregistrement']=$occurrence['enregistrement'];
			$this->champs['premiere_utilisation']=$occurrence['premiere_utilisation'];
			$this->champs['derniere_utilisation']=$occurrence['derniere_utilisation'];
			$this->champs['domaine']=$occurrence['domaine'];
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from abonnement
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=ABONNEMENT_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=ABONNEMENT_NOUVEAU_IDENTIFIANT_DEFAUT;
			}
			return $this->erreur;
		}
		
		public function ajouter()
		{
			$this->verifier('ajouter');
			if(!$this->erreur)
			{
				$this->champs['enregistrement']=time();
				$this->champs['premiere_utilisation']=NULL;
				$this->champs['derniere_utilisation']=NULL;
				
				$this->executer
				('
					insert into abonnement
					(
						identifiant,
						adherent,
						delai,
						enregistrement,
						premiere_utilisation,
						derniere_utilisation,
						domaine
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['adherent']!==NULL)?('\''.addslashes($this->champs['adherent']).'\''):('null')).',
						'.(($this->champs['delai']!==NULL)?('\''.addslashes($this->champs['delai']).'\''):('null')).',
						'.(($this->champs['enregistrement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['enregistrement'])).'\''):('null')).',
						'.(($this->champs['premiere_utilisation']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['premiere_utilisation'])).'\''):('null')).',
						'.(($this->champs['derniere_utilisation']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['derniere_utilisation'])).'\''):('null')).',
						'.(($this->champs['domaine']!==NULL)?('\''.addslashes($this->champs['domaine']).'\''):('null')).'
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
					update abonnement
					set
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						adherent='.(($this->champs['adherent']!==NULL)?('\''.addslashes($this->champs['adherent']).'\''):('null')).',
						delai='.(($this->champs['delai']!==NULL)?('\''.addslashes($this->champs['delai']).'\''):('null')).',
						domaine='.(($this->champs['domaine']!==NULL)?('\''.addslashes($this->champs['domaine']).'\''):('null')).'
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
		
		public function compter($date, $periodicite, $mode, $domaine=array('www.localerte.fr','www.localerte.mobi'),$ca=NULL)
		{
			if(array_search($periodicite,explode(',',ABONNEMENT_PERIODICITE_ENUM))!==false && preg_match('/^(ENREGISTREMENT|ENREGISTREMENT_X7|PREMIERE_UTILISATION|DERNIERE_UTILISATION)$/',$mode))
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
					case 'ENREGISTREMENT':
						$champ='enregistrement';
						$multiplicateur=1;
						break;
					case 'PREMIERE_UTILISATION':
						$champ='premiere_utilisation';
						$multiplicateur=1;
						break;
					case 'DERNIERE_UTILISATION':
						$champ='derniere_utilisation';
						$multiplicateur=1;
						break;
					case 'ENREGISTREMENT_X7':
						$champ='enregistrement';
						$multiplicateur=7;
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
						count(distinct identifiant)*'.$multiplicateur.' as nombre,
						(((date_format('.$champ.',\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).' as periode
					from abonnement
					where '.$champ.'>=\''.date(SQL_DATETIME,$debut).'\'
						and '.$champ.'<\''.date(SQL_DATETIME,$fin).'\'
						'.(sizeof($domaine)?'and domaine in (\''.implode('\', \'',array_map('addslashes',$domaine)).'\')':'').'
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
		
		private function utiliser($identifiant)
		{
			$this->executer
			('
				select
					identifiant,
					delai,
					unix_timestamp(premiere_utilisation) as premiere_utilisation
				from abonnement
				where adherent=\''.addslashes($identifiant).'\'
					and
					(
						premiere_utilisation is null
						or date_add(premiere_utilisation, interval delai second)>=\''.addslashes(date(SQL_DATETIME,time())).'\'
					)
				order by enregistrement
				limit 1
			');
			
			if(!$this->donner_suivant($occurrence))
				return 'ABONNEMENT_DELAI_PERIME';
			else
			{
				if(!is_array($occurrence))
					return $occurrence;
				
				if($occurrence['premiere_utilisation']===NULL)
					$occurrence['premiere_utilisation']=time();
				
				$occurrence['derniere_utilisation']=time();
				
				$this->executer
				('
					update abonnement
					set
						premiere_utilisation=\''.addslashes(date(SQL_DATETIME,$occurrence['premiere_utilisation'])).'\',
						derniere_utilisation=\''.addslashes(date(SQL_DATETIME,$occurrence['derniere_utilisation'])).'\'
					where identifiant=\''.addslashes($occurrence['identifiant']).'\'					
				');

				return $occurrence;
			}
		}
		
		public function identifier($identifiant)
		{
			$adherent=new ld_adherent();
			$adherent->identifiant=$identifiant;
			if(!$adherent->lire())
				return 'ABONNEMENT_ADHERENT_INCONNU';
			
			$this->executer
			('
				select count(identifiant) as nombre
				from abonnement
				where adherent=\''.addslashes($adherent->identifiant).'\'
			');
			$this->donner_suivant($occurrence);
			if(!$occurrence['nombre'])
				return 'ABONNEMENT_AUCUN';
			
			return $this->controler($adherent->identifiant);
		}
		
		public function controler($identifiant)
		{
			$occurrence=$this->utiliser($identifiant);
			
			if(!is_array($occurrence))
				return $occurrence;
			
			$this->identifiant=$occurrence['identifiant'];
			$this->lire();
			
			return 'ABONNEMENT_UTILISABLE';
		}
	}
?>