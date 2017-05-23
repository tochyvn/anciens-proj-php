<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('WHA_PERIODICITE_ENUM','H,S,M,A');
	
	define('WHA_IDENTIFIANT_DEFAUT','');
	
	define('WHA_NOUVEAU_IDENTIFIANT_MIN',1);
	define('WHA_NOUVEAU_IDENTIFIANT_MAX',9);
	define('WHA_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('WHA_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('WHA_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('WHA_ADHERENT_NULL',true);
	define('WHA_ADHERENT_DEFAUT',NULL);
	define('WHA_ADHERENT_ERREUR',pow(2,$define_erreur++));
	
	define('WHA_ENREGISTREMENT_DEFAUT',NULL);
	
	define('WHA_PRIX_MIN',0.01);
	define('WHA_PRIX_MAX',9999.99);
	define('WHA_PRIX_NULL',false);
	define('WHA_PRIX_DEFAUT',NULL);
	define('WHA_PRIX_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('WHA_PRIX_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('WHA_DOMAINE_MIN',1);
	define('WHA_DOMAINE_MAX',20);
	define('WHA_DOMAINE_NULL',false);
	define('WHA_DOMAINE_DEFAUT',NULL);
	define('WHA_DOMAINE_ERREUR',pow(2,$define_erreur++));
	
	define('WHA_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_wha extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_wha()
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
			$this->champs['identifiant']=WHA_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=WHA_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['adherent']=WHA_ADHERENT_DEFAUT;
			$this->champs['enregistrement']=WHA_ENREGISTREMENT_DEFAUT;
			$this->champs['prix']=WHA_PRIX_DEFAUT;
			$this->champs['domaine']=WHA_DOMAINE_DEFAUT;
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
			
			$this->erreur=WHA_TOTAL_ERREUR;

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
				if($variable!='enregistrement' && $variable!='occurrence' && $variable!='maximum' && $variable!='minimum' && $variable!='moyenne' && $variable!='total' && $variable!='debut' && $variable!='fin')
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
		
		private function verifier()
		{
			//IDENTIFIANT
			//NOUVEAU IDENTIFIANT
			if(strlen($this->champs['nouveau_identifiant'])<WHA_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>WHA_NOUVEAU_IDENTIFIANT_MAX)
				$this->erreur|=WHA_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
			else
				$this->erreur&=~WHA_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
			$this->executer
			('
				select count(identifiant) as nombre
				from wha
				where
					identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
			');
			$this->donner_suivant($occurrence);
			if($occurrence['nombre'])
				$this->erreur|=WHA_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
			else
				$this->erreur&=~WHA_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
			//ADHERENT
			$this->executer
			('
				select count(identifiant) as nombre
				from adherent
				where
					identifiant=\''.addslashes($this->champs['adherent']).'\'
			');
			$this->donner_suivant($occurrence);
			if((!WHA_ADHERENT_NULL || $this->champs['adherent']!==NULL) && !$occurrence['nombre'])
				$this->erreur|=WHA_ADHERENT_ERREUR;
			else
				$this->erreur&=~WHA_ADHERENT_ERREUR;
			//PRIX
			if((!WHA_PRIX_NULL || $this->champs['prix']!==NULL) && (floatval($this->champs['prix'])<WHA_PRIX_MIN || floatval($this->champs['prix'])>WHA_PRIX_MAX))
				$this->erreur|=WHA_PRIX_ERREUR_VALEUR;
			else
				$this->erreur&=~WHA_PRIX_ERREUR_VALEUR;
			if((!WHA_PRIX_NULL || $this->champs['prix']!==NULL) && !preg_match('/'.STRING_FILTRE_MONNAIE_POSITIF.'/',$this->champs['prix']))
				$this->erreur|=WHA_PRIX_ERREUR_FILTRE;
			else
				$this->erreur&=~WHA_PRIX_ERREUR_FILTRE;
			//DOMAINE
			if((!WHA_DOMAINE_NULL || $this->champs['domaine']!==NULL) && (strlen($this->champs['domaine'])<WHA_DOMAINE_MIN || strlen($this->champs['domaine'])>WHA_DOMAINE_MAX))
				$this->erreur|=WHA_DOMAINE_ERREUR;
			else
				$this->erreur&=~WHA_DOMAINE_ERREUR;
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					identifiant,
					adherent,
					unix_timestamp(enregistrement) as enregistrement,
					prix,
					domaine
				from wha
				where
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['adherent']=$occurrence['adherent'];
			$this->champs['enregistrement']=$occurrence['enregistrement'];
			$this->champs['prix']=$occurrence['prix'];
			$this->champs['domaine']=$occurrence['domaine'];
			return true;
		}
		
		public function ajouter()
		{
			$this->verifier();
			if(!$this->erreur)
			{
				$this->champs['enregistrement']=time();
				
				$this->executer
				('
					insert into wha
					(
						identifiant,
						adherent,
						enregistrement,
						prix,
						domaine
					)
					values
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['adherent']!==NULL)?('\''.addslashes($this->champs['adherent']).'\''):('null')).',
						'.(($this->champs['enregistrement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['enregistrement'])).'\''):('null')).',
						'.(($this->champs['prix']!==NULL)?('\''.addslashes($this->champs['prix']).'\''):('null')).',
						'.(($this->champs['domaine']!==NULL)?('\''.addslashes($this->champs['domaine']).'\''):('null')).'
					)
				');
				$this->champs['identifiant']=$this->champs['nouveau_identifiant'];
			}
			return $this->erreur;
		}
		
		public function tester()
		{
			$this->verifier();
			return $this->erreur;
		}
		
		public function compter($date, $periodicite, $domaine=array('www.localerte.fr','www.localerte.mobi'),$ca=true)
		{
			if(array_search($periodicite,explode(',',WHA_PERIODICITE_ENUM))!==false)
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
				
				$this->executer
				('
					replace `'.$strrnd.'`
					(
						nombre,
						periode
					)
					select
						'.($ca?'sum(prix)':'count(prix)').' as nombre,
						(((date_format(enregistrement,\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).' as periode
					from wha
					where enregistrement>=\''.date(SQL_DATETIME,$debut).'\'
						and enregistrement<\''.date(SQL_DATETIME,$fin).'\'
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
	}
	
	//A SUPPRIMER QUAND WHA AURA CHANGE LE LIEN D'ANNULATION
	if(isset($_REQUEST['mp_securite']))
	{
		require_once(PWD_INCLUSION.'configuration.php');
		header('location: '.url_use_trans_sid('http://www.localerte.fr/wha_annulation?'.http_build_query($_REQUEST)));
		die();
	}
?>