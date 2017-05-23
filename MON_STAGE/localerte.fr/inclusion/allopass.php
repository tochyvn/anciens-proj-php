<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('ALLOPASS_PERIODICITE_ENUM','H,S,M,A');
	
	define('ALLOPASS_REFERENCE_DEFAUT','');
	
	define('ALLOPASS_NOUVEAU_REFERENCE_MIN',8);
	define('ALLOPASS_NOUVEAU_REFERENCE_MAX',8);
	define('ALLOPASS_NOUVEAU_REFERENCE_DEFAUT','');
	define('ALLOPASS_NOUVEAU_REFERENCE_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ALLOPASS_NOUVEAU_REFERENCE_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('ALLOPASS_PALIER_MIN',0);
	define('ALLOPASS_PALIER_MAX',9999999999);
	define('ALLOPASS_PALIER_NULL',true);
	define('ALLOPASS_PALIER_DEFAUT',NULL);
	define('ALLOPASS_PALIER_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('ALLOPASS_PALIER_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ALLOPASS_ADHERENT_NULL',false);
	define('ALLOPASS_ADHERENT_DEFAUT',NULL);
	define('ALLOPASS_ADHERENT_ERREUR',pow(2,$define_erreur++));
	
	define('ALLOPASS_ENREGISTREMENT_DEFAUT',NULL);
	
	define('ALLOPASS_PRIX_MIN',0);
	define('ALLOPASS_PRIX_MAX',9999.99);
	define('ALLOPASS_PRIX_NULL',false);
	define('ALLOPASS_PRIX_DEFAUT',NULL);
	define('ALLOPASS_PRIX_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('ALLOPASS_PRIX_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('ALLOPASS_DOMAINE_MIN',1);
	define('ALLOPASS_DOMAINE_MAX',20);
	define('ALLOPASS_DOMAINE_NULL',false);
	define('ALLOPASS_DOMAINE_DEFAUT',NULL);
	define('ALLOPASS_DOMAINE_ERREUR',pow(2,$define_erreur++));
	
	define('ALLOPASS_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_allopass extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_allopass()
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
			$this->champs['reference']=ALLOPASS_REFERENCE_DEFAUT;
			$this->champs['nouveau_reference']=ALLOPASS_NOUVEAU_REFERENCE_DEFAUT;
			$this->champs['palier']=ALLOPASS_PALIER_DEFAUT;
			$this->champs['adherent']=ALLOPASS_ADHERENT_DEFAUT;
			$this->champs['enregistrement']=ALLOPASS_ENREGISTREMENT_DEFAUT;
			$this->champs['prix']=ALLOPASS_PRIX_DEFAUT;
			$this->champs['domaine']=ALLOPASS_DOMAINE_DEFAUT;
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
			
			$this->erreur=ALLOPASS_TOTAL_ERREUR;

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
			//REFERENCE
			//NOUVEAU REFERENCE
			if(strlen($this->champs['nouveau_reference'])<ALLOPASS_NOUVEAU_REFERENCE_MIN || strlen($this->champs['nouveau_reference'])>ALLOPASS_NOUVEAU_REFERENCE_MAX)
				$this->erreur|=ALLOPASS_NOUVEAU_REFERENCE_ERREUR_LONGUEUR;
			else
				$this->erreur&=~ALLOPASS_NOUVEAU_REFERENCE_ERREUR_LONGUEUR;
			$this->executer
			('
				select count(reference) as nombre
				from allopass
				where
					reference=\''.addslashes($this->champs['nouveau_reference']).'\'
			');
			$this->donner_suivant($occurrence);
			if($occurrence['nombre'])
				$this->erreur|=ALLOPASS_NOUVEAU_REFERENCE_ERREUR_DOUBLON;
			else
				$this->erreur&=~ALLOPASS_NOUVEAU_REFERENCE_ERREUR_DOUBLON;
			//PALIER
			if((!ALLOPASS_PALIER_NULL || $this->champs['palier']!==NULL) && (intval($this->champs['palier'])<ALLOPASS_PALIER_MIN || intval($this->champs['palier'])>ALLOPASS_PALIER_MAX))
				$this->erreur|=ALLOPASS_PALIER_ERREUR_VALEUR;
			else
				$this->erreur&=~ALLOPASS_PALIER_ERREUR_VALEUR;
			if((!ALLOPASS_PALIER_NULL || $this->champs['palier']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['palier']))
				$this->erreur|=ALLOPASS_PALIER_ERREUR_FILTRE;
			else
				$this->erreur&=~ALLOPASS_PALIER_ERREUR_FILTRE;
			//ADHERENT
			$this->executer
			('
				select count(identifiant) as nombre
				from adherent
				where
					identifiant=\''.addslashes($this->champs['adherent']).'\'
			');
			$this->donner_suivant($occurrence);
			if((!ALLOPASS_ADHERENT_NULL || $this->champs['adherent']!==NULL) && !$occurrence['nombre'])
				$this->erreur|=ALLOPASS_ADHERENT_ERREUR;
			else
				$this->erreur&=~ALLOPASS_ADHERENT_ERREUR;
			//PRIX
			if((!ALLOPASS_PRIX_NULL || $this->champs['prix']!==NULL) && (floatval($this->champs['prix'])<ALLOPASS_PRIX_MIN || floatval($this->champs['prix'])>ALLOPASS_PRIX_MAX))
				$this->erreur|=ALLOPASS_PRIX_ERREUR_VALEUR;
			else
				$this->erreur&=~ALLOPASS_PRIX_ERREUR_VALEUR;
			if((!ALLOPASS_PRIX_NULL || $this->champs['prix']!==NULL) && !preg_match('/'.STRING_FILTRE_MONNAIE_POSITIF.'/',$this->champs['prix']))
				$this->erreur|=ALLOPASS_PRIX_ERREUR_FILTRE;
			else
				$this->erreur&=~ALLOPASS_PRIX_ERREUR_FILTRE;
			//DOMAINE
			if((!ALLOPASS_DOMAINE_NULL || $this->champs['domaine']!==NULL) && (strlen($this->champs['domaine'])<ALLOPASS_DOMAINE_MIN || strlen($this->champs['domaine'])>ALLOPASS_DOMAINE_MAX))
				$this->erreur|=ALLOPASS_DOMAINE_ERREUR;
			else
				$this->erreur&=~ALLOPASS_DOMAINE_ERREUR;
		}
		
		public function lire()
		{
			$this->executer
			('
				select
					reference,
					palier,
					adherent,
					unix_timestamp(enregistrement) as enregistrement,
					prix,
					domaine
				from allopass
				where
					reference=\''.addslashes($this->champs['reference']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['reference']=$occurrence['reference'];
			$this->champs['nouveau_reference']=$occurrence['reference'];
			$this->champs['palier']=$occurrence['palier'];
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
					insert into allopass
					(
						reference,
						palier,
						adherent,
						enregistrement,
						prix,
						domaine
					)
					values
					(
						\''.addslashes($this->champs['nouveau_reference']).'\',
						'.(($this->champs['palier']!==NULL)?('\''.addslashes($this->champs['palier']).'\''):('null')).',
						'.(($this->champs['adherent']!==NULL)?('\''.addslashes($this->champs['adherent']).'\''):('null')).',
						'.(($this->champs['enregistrement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,$this->champs['enregistrement'])).'\''):('null')).',
						'.(($this->champs['prix']!==NULL)?('\''.addslashes($this->champs['prix']).'\''):('null')).',
						'.(($this->champs['domaine']!==NULL)?('\''.addslashes($this->champs['domaine']).'\''):('null')).'
					)
				');
				$this->champs['reference']=$this->champs['nouveau_reference'];
			}
			return $this->erreur;
		}
		
		public function tester()
		{
			$this->verifier();
			return $this->erreur;
		}
		
		public function compter($date, $periodicite, $mode, $domaine=array('www.localerte.fr','www.localerte.mobi'),$ca=true)
		{
			if(array_search($periodicite,explode(',',ALLOPASS_PERIODICITE_ENUM))!==false && preg_match('/^(GRATUIT|PAYANT|GRATUIT_V2|PAYANT_V2|PAYANT_V2_088|PAYANT_V2_105|PAYANT_V2_120|PAYANT_V2_167|GRATUIT_V2.5|PAYANT_V2.5|PAYANT_V2.5_088|PAYANT_V2.5_105|PAYANT_V2.5_120|PAYANT_V2.5_167|PAYANT_V2.6_085|PAYANT_V2.6_105)$/',$mode))
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
					case 'PAYANT':
						$query='and prix>0';
						break;
					case 'GRATUIT':
						$query='and prix=0';
						break;
					case 'PAYANT_V2':
						$query='and prix>0 and palier in (270837,481363)';
						break;
					case 'PAYANT_V2_088':
						$query='and prix=0.88 and palier in (270837,481363)';
						break;
					case 'PAYANT_V2_105':
						$query='and prix=1.05 and palier in (270837,481363)';
						break;
					case 'PAYANT_V2_120':
						$query='and prix=1.20 and palier in (270837,481363)';
						break;
					case 'PAYANT_V2.5_167':
						$query='and prix=1.67 and palier in (1226338)';
						break;
					case 'GRATUIT_V2':
						$query='and prix=0 and palier in (270837,481363)';
						break;
					case 'PAYANT_V2.5':
						$query='and prix>0 and palier in (1042318,1042319)';
						break;
					case 'PAYANT_V2.5_088':
						$query='and prix=0.88 and palier in (1042318,1042319)';
						break;
					case 'PAYANT_V2.5_105':
						$query='and prix=1.05 and palier in (1042318,1042319)';
						break;
					case 'PAYANT_V2.5_120':
						$query='and prix=1.20 and palier in (1042318,1042319)';
						break;
					case 'PAYANT_V2.5_167':
						$query='and prix=1.67 and palier in (1226338)';
						break;
					case 'GRATUIT_V2.5':
						$query='and prix=0 and palier in (1042318,1042319)';
						break;
					case 'PAYANT_V2.6_085':
						$query='and prix=0.85 and palier in (1307309)';
						break;
					case 'PAYANT_V2.6_105':
						$query='and prix=1.05 and palier in (1307309)';
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
						'.($ca?'sum(prix)':'count(*)').' as nombre,
						(((date_format(enregistrement,\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).' as periode
					from allopass
					where enregistrement>=\''.date(SQL_DATETIME,$debut).'\'
						and enregistrement<\''.date(SQL_DATETIME,$fin).'\'
						'.(sizeof($domaine)?'and domaine in (\''.implode('\', \'',array_map('addslashes',$domaine)).'\')':'').'
						'.$query.'
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
?>