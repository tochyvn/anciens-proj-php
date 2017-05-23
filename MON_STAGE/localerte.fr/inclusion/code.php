<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('CODE_PERIODICITE_ENUM','H,S,M,A');
	
	define('CODE_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_code extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		private /*var*/ $maintenant;

		/*function ld_code()
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
			
			$this->erreur=CODE_TOTAL_ERREUR;
			$this->maintenant=time();

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
				if($variable!='occurrence' && $variable!='maximum' && $variable!='minimum' && $variable!='moyenne' && $variable!='total' && $variable!='debut' && $variable!='fin')
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
		
		public function creer($type)
		{
			if(!preg_match('/^(enquete|inactivite|forfait|inscription)$/',$type))
				return false;
			
			switch($type)
			{
				case 'enquete':
					$pattern='[2-9A-HJKMNP-Z]{8}';
					$prefixe='';
					$suffixe='';
					$longueur=8;
					$mode=3;
					$adherent=NULL;
					$date_debut=NULL;
					$date_fin=NULL;
					$nombre_autorise=1;
					$nombre_effectue=NULL;
					$delai=NULL;
					$date_premiere_connexion=NULL;
					$date_connexion=NULL;
					$appartenance='ENQUETE';
					break;
				case 'inactivite':
					$pattern='[2-9A-HJKMNP-Z]{8}';
					$prefixe='';
					$suffixe='';
					$longueur=8;
					$mode=3;
					$adherent=NULL;
					$date_debut=NULL;
					$date_fin=NULL;
					$nombre_autorise=1;
					$nombre_effectue=NULL;
					$delai=NULL;
					$date_premiere_connexion=NULL;
					$date_connexion=NULL;
					$appartenance='INACTIVITE';
					break;
				case 'forfait':
					$pattern='[2-9A-HJKMNP-Z]{8}';
					$prefixe='';
					$suffixe='';
					$longueur=8;
					$mode=3;
					$adherent=NULL;
					$date_debut=NULL;
					$date_fin=NULL;
					$nombre_autorise=1;
					$nombre_effectue=NULL;
					$delai=NULL;
					$date_premiere_connexion=NULL;
					$date_connexion=NULL;
					$appartenance='FORFAIT';
					break;
				case 'inscription':
					$pattern='[2-9A-HJKMNP-Z]{8}';
					$prefixe='';
					$suffixe='';
					$longueur=8;
					$mode=3;
					$adherent=NULL;
					$date_debut=NULL;
					$date_fin=NULL;
					$nombre_autorise=1;
					$nombre_effectue=NULL;
					$delai=NULL;
					$date_premiere_connexion=NULL;
					$date_connexion=NULL;
					$appartenance='INSCRIPTION';
					break;
			}
			
			$trouve=false;
			
			do
			{
				$code=$prefixe.strrnd($longueur,$mode).$suffixe;
				if(preg_match('/'.$pattern.'/',$code))
				{
					$this->executer
					('
						insert ignore into code
						(
							reference,
							adherent,
							date_debut,
							date_fin,
							nombre_autorise,
							nombre_effectue,
							delai,
							date_premiere_connexion,
							date_connexion,
							appartenance
						)
						values
						(
							\''.addslashes($code).'\',
							'.(($adherent!==NULL)?('\''.addslashes($adherent).'\''):('null')).',
							'.(($date_debut!==NULL)?('\''.addslashes($date_debut).'\''):('null')).',
							'.(($date_fin!==NULL)?('\''.addslashes($date_fin).'\''):('null')).',
							'.(($nombre_autorise!==NULL)?('\''.addslashes($nombre_autorise).'\''):('null')).',
							'.(($nombre_effectue!==NULL)?('\''.addslashes($nombre_effectue).'\''):('null')).',
							'.(($delai!==NULL)?('\''.addslashes($delai).'\''):('null')).',
							'.(($date_premiere_connexion!==NULL)?('\''.addslashes($date_premiere_connexion).'\''):('null')).',
							'.(($date_connexion!==NULL)?('\''.addslashes($date_connexion).'\''):('null')).',
							'.(($appartenance!==NULL)?('\''.addslashes($appartenance).'\''):('null')).'
						)
					');
					
					if($this->donner_ligne_affecte())
						$trouve=true;
				}
			}
			while(!$trouve);
			
			return $code;
		}
		
		public function donner($code)
		{
			$occurrence=$this->utiliser($code);
			
			if(is_array($occurrence))
				return 'CODE_DEJA_DONNE';
			
			if($occurrence!='CODE_INDISPONIBLE_POSSESSION')
				return $occurrence;
			
			$this->executer
			('
				update code
				set
					adherent=null,
					date_debut=null,
					date_fin=null,
					appartenance=\'GRATUIT\',
					nombre_autorise=1,
					delai=null,
					nombre_effectue=null,
					date_premiere_connexion=null,
					date_connexion=null
				where reference=\''.addslashes($code).'\'
			');
			
			return 'CODE_DONNE';
		}
		
		private function utiliser($code)
		{
			$this->executer
			('
				select
					reference,
					adherent,
					appartenance,
					unix_timestamp(date_debut) as debut,
					unix_timestamp(date_fin) as fin,
					nombre_autorise,
					delai,
					nombre_effectue,
					unix_timestamp(date_premiere_connexion) as date_premiere_connexion
				from code
				where reference=\''.addslashes($code).'\'
				limit 1
			');
			
			if(!$this->donner_suivant($occurrence))
				return 'CODE_INCONNU';
			else
			{
				if($occurrence['appartenance']===NULL)
					return 'CODE_INDISPONIBLE_POSSESSION';
				
				if($occurrence['debut']!==NULL && $occurrence['debut']>$this->maintenant)
					return 'CODE_INDISPONIBLE_DEBUT';
				
				if($occurrence['fin']!==NULL && $occurrence['fin']<$this->maintenant)
					return 'CODE_INDISPONIBLE_FIN';
				
				return $occurrence;
			}
		}
		
		public function identifier($code,$adherent)
		{
			$occurrence=$this->utiliser($code);
			
			if(!is_array($occurrence))
				return $occurrence;
			
			$this->executer
			('
				select identifiant
				from adherent
				where identifiant=\''.addslashes($adherent).'\'
			');
			if(!$this->donner_ligne_retourne())
				return 'CODE_ADHERENT_INEXISTANT';
			
			if($occurrence['nombre_autorise']!==NULL && (int)$occurrence['nombre_effectue']>=$occurrence['nombre_autorise'])
				return 'CODE_IDENTIFICATION_PERIME';
			
			(int)$occurrence['nombre_effectue']++;
			
			if($occurrence['date_premiere_connexion']===NULL)
				$occurrence['date_premiere_connexion']=$this->maintenant;
			
			$occurrence['date_connexion']=$this->maintenant;
			
			$this->executer
			('
				update code
				set
					adherent=\''.addslashes($adherent).'\',
					nombre_effectue=\''.addslashes($occurrence['nombre_effectue']).'\',
					date_premiere_connexion=\''.addslashes(date(SQL_DATETIME,$occurrence['date_premiere_connexion'])).'\',
					date_connexion=\''.addslashes(date(SQL_DATETIME,$occurrence['date_connexion'])).'\'
				where reference=\''.addslashes($code).'\'					
			');
			
			return $this->controler($code,$adherent);
		}
		
		public function controler($code,$adherent)
		{
			$occurrence=$this->utiliser($code);
			
			if(!is_array($occurrence))
				return $occurrence;
			
			if($occurrence['adherent']!=$adherent)
				return 'CODE_ADHERENT_NON_PROPRIETAIRE';
			
			if($occurrence['delai']!==NULL && $occurrence['date_premiere_connexion']+$occurrence['delai']<$this->maintenant)
				return 'CODE_DELAI_PERIME';
			
			return 'CODE_UTILISABLE';
		}
		
		public  function logguer($reference,$adherent,$enregistrement,$resultat,$passerelle,$domaine){
			$this->executer('
				insert into code_log
				(
					reference,
					adherent,
					enregistrement,
					resultat,
					passerelle,
					domaine
				)
				values
				(
					\''.addslashes($reference).'\',
					\''.(int)$adherent.'\',
					\''.addslashes($enregistrement).'\',
					\''.addslashes($resultat).'\',
					\''.addslashes($passerelle).'\',
					\''.addslashes($domaine).'\'
				)
			');
		}
		
		public function compter($date, $periodicite, $mode)
		{
			if(array_search($periodicite,explode(',',CODE_PERIODICITE_ENUM))!==false && preg_match('/^(INACTIVITE|GRATUIT|PAYANT)$/',$mode))
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
					case 'PAYANT':
						$query='and appartenance=\'AFONE\'';
						break;
					case 'GRATUIT':
						$query='and appartenance=\'GRATUIT\'';
						break;
					case 'INACTIVITE':
						$query='and appartenance=\'INACTIVITE\'';
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
						count(distinct reference) as nombre,
						(((date_format(date_connexion,\''.$correspondance_periodicite[$periodicite].'\')'.(($periodicite=='S')?('+6)%7)+1)'):(')))')).' as periode
					from code
					where  date_connexion>=\''.date(SQL_DATETIME,$debut).'\'
						and  date_connexion<\''.date(SQL_DATETIME,$fin).'\'
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
	
	if(isset($_REQUEST['code_test']))
	{
		$code=new ld_code();
		//echo $code->creer('inactivite');
	}
?>