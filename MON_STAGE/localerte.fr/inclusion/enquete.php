<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'enquete.php');
	
	$define_erreur=0;
	
	define('ENQUETE_ADHERENT_IDENTIFIANT_DEFAUT','');
	define('ENQUETE_ADHERENT_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));
	
	define('ENQUETE_ADHERENT_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('ENQUETE_ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));
	
	define('ENQUETE_ADHERENT_EMAIL_MIN',6);
	define('ENQUETE_ADHERENT_EMAIL_MAX',255);
	define('ENQUETE_ADHERENT_EMAIL_NULL',false);
	define('ENQUETE_ADHERENT_EMAIL_DEFAUT',NULL);
	define('ENQUETE_ADHERENT_EMAIL_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('ENQUETE_ADHERENT_EMAIL_ERREUR_FILTRE',pow(2,$define_erreur++));

	define('ENQUETE_ENREGISTREMENT_NULL',false);
	define('ENQUETE_ENREGISTREMENT_DEFAUT',NULL);
	
	define('ENQUETE_QUESTION1_ENUM','0,1,2,3,4,5');
	define('ENQUETE_QUESTION2_ENUM','0,1,2,3,4,5');
	define('ENQUETE_QUESTION3_ENUM','0,1,2,3,4,5');
	define('ENQUETE_QUESTION4_ENUM','OUI', 'NON');
	define('ENQUETE_QUESTION5_ENUM','0,1,2,3,4,5');
	define('ENQUETE_QUESTION1_NULL',false);
	define('ENQUETE_QUESTION2_NULL',false);
	define('ENQUETE_QUESTION3_NULL',false);
	define('ENQUETE_QUESTION4_NULL',false);
	define('ENQUETE_QUESTION5_NULL',false);
	define('ENQUETE_QUESTION1_DEFAUT',NULL);
	define('ENQUETE_QUESTION2_DEFAUT',NULL);
	define('ENQUETE_QUESTION3_DEFAUT',NULL);
	define('ENQUETE_QUESTION4_DEFAUT',NULL);
	define('ENQUETE_QUESTION5_DEFAUT',NULL);
	/*define('ENQUETE_QUESTION1_ERREUR',pow(2,$define_erreur++));
	define('ENQUETE_QUESTION2_ERREUR',pow(2,$define_erreur++));
	define('ENQUETE_QUESTION3_ERREUR',pow(2,$define_erreur++));
	define('ENQUETE_QUESTION4_ERREUR',pow(2,$define_erreur++));
	define('ENQUETE_QUESTION5_ERREUR',pow(2,$define_erreur++));*/
	
	define('ENQUETE_LIBRE_MIN',0);
	define('ENQUETE_LIBRE_MAX',512);
	define('ENQUETE_LIBRE_DEFAUT','');
	//define('ENQUETE_LIBRE_ERREUR_LONGUEUR',pow(2,$define_erreur++));

	define('ENQUETE_TOTAL_ERREUR',pow(2,$define_erreur)-1);

	unset($define_erreur);
	
	class ld_enquete extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_enquete()
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
			
			$this->champs['adherent_identifiant']=ENQUETE_ADHERENT_IDENTIFIANT_DEFAUT;
			$this->champs['adherent_nouveau_identifiant']=ENQUETE_ADHERENT_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['adherent_email']=ENQUETE_ADHERENT_EMAIL_DEFAUT;
			$this->champs['enregistrement']=ENQUETE_ENREGISTREMENT_DEFAUT;
			$this->champs['question1']=ENQUETE_QUESTION1_DEFAUT;
			$this->champs['question2']=ENQUETE_QUESTION2_DEFAUT;
			$this->champs['question3']=ENQUETE_QUESTION3_DEFAUT;
			$this->champs['question4']=ENQUETE_QUESTION4_DEFAUT;
			$this->champs['question5']=ENQUETE_QUESTION5_DEFAUT;
			$this->champs['libre']=ENQUETE_LIBRE_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=ENQUETE_TOTAL_ERREUR;

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
				if($variable!='enregistrement')
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
		
		function __wakeup() {
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			} return true;
		}
		
		private function verifier($mode)
		{
			if($mode=='supprimer')
			{
				$this->executer
				('
					select count(adherent_identifiant) as nombre
					from enquete
					where
						adherent_identifiant=\''.addslashes($this->champs['adherent_identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=ENQUETE_ADHERENT_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(adherent_identifiant) as nombre
					from enquete
					where
						adherent_identifiant=\''.addslashes($this->champs['adherent_identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=ENQUETE_ADHERENT_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~ENQUETE_ADHERENT_IDENTIFIANT_ERREUR;
				//NOUVEAU IDENTIFIANT
				$this->executer
				('
					select count(adherent_identifiant) as nombre
					from enquete
					where
						adherent_identifiant=\''.addslashes($this->champs['adherent_nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and adherent_identifiant<>\''.addslashes($this->champs['adherent_identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=ENQUETE_ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~ENQUETE_ADHERENT_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//EMAIL
				if((!ENQUETE_ADHERENT_EMAIL_NULL || $this->champs['adherent_email']!==NULL) && (strlen($this->champs['adherent_email'])<ENQUETE_ADHERENT_EMAIL_MIN || strlen($this->champs['adherent_email'])>ENQUETE_ADHERENT_EMAIL_MAX))
					$this->erreur|=ENQUETE_ADHERENT_EMAIL_ERREUR_LONGUEUR;
				else
					$this->erreur&=~ENQUETE_ADHERENT_EMAIL_ERREUR_LONGUEUR;
				if((!ENQUETE_ADHERENT_EMAIL_NULL || $this->champs['adherent_email']!==NULL) && !preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['adherent_email']))
					$this->erreur|=ENQUETE_ADHERENT_EMAIL_ERREUR_FILTRE;
				else
					$this->erreur&=~ENQUETE_ADHERENT_EMAIL_ERREUR_FILTRE;
			}
		}
		
		public function lire($champ='identifiant')
		{
			$this->executer
			('
				select
					adherent_identifiant,
					adherent_email,
					unix_timestamp(enregistrement) as enregistrement,
					question1,
					question2,
					question3,
					question4,
					question5,
					libre
				from enquete
				where
					'.(($champ=='email')?('email=\''.addslashes($this->champs['email']).'\''):('identifiant=\''.addslashes($this->champs['identifiant']).'\'')).'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['adherent_identifiant']=$occurrence['adherent_identifiant'];
			$this->champs['adherent_nouveau_identifiant']=$occurrence['adherent_identifiant'];
			$this->champs['adherent_email']=$occurrence['adherent_email'];
			$this->champs['enregistrement']=$occurrence['enregistrement'];
			$this->champs['question1']=$occurrence['question1'];
			$this->champs['question2']=$occurrence['question2'];
			$this->champs['question3']=$occurrence['question3'];
			$this->champs['question4']=$occurrence['question4'];
			$this->champs['question5']=$occurrence['question5'];
			$this->champs['libre']=$occurrence['libre'];
			return true;
		}
		
		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					delete from enquete
					where
						adherent_identifiant=\''.addslashes($this->champs['adherent_identifiant']).'\'
				');
				$this->champs['adherent_identifiant']=ENQUETE_ADHERENT_IDENTIFIANT_DEFAUT;
				$this->champs['adherent_nouveau_identifiant']=ENQUETE_ADHERENT_NOUVEAU_IDENTIFIANT_DEFAUT;
			}
			return $this->erreur;
		}
		
		public function ajouter()
		{
			$this->verifier('ajouter');
			if(!$this->erreur)
			{
				$this->champs['enregistrement']=time();
			
				$this->executer
				('
					insert into enquete
					(
						adherent_identifiant,
						adherent_email,
						enregistrement,
						question1,
						question2,
						question3,
						question4,
						question5,
						libre
					)
					values
					(
						\''.addslashes($this->champs['adherent_nouveau_identifiant']).'\',
						'.(($this->champs['adherent_email']!==NULL)?('\''.addslashes($this->champs['adherent_email']).'\''):('null')).',
						'.(($this->champs['enregistrement']!==NULL)?('\''.addslashes(date(SQL_DATETIME,MAINTENANT)).'\''):('null')).',
						'.(($this->champs['question1']!==NULL)?('\''.addslashes($this->champs['question1']).'\''):('null')).',
						'.(($this->champs['question2']!==NULL)?('\''.addslashes($this->champs['question2']).'\''):('null')).',
						'.(($this->champs['question3']!==NULL)?('\''.addslashes($this->champs['question3']).'\''):('null')).',
						'.(($this->champs['question4']!==NULL)?('\''.addslashes($this->champs['question4']).'\''):('null')).',
						'.(($this->champs['question5']!==NULL)?('\''.addslashes($this->champs['question5']).'\''):('null')).',
						'.(($this->champs['libre']!==NULL)?('\''.addslashes($this->champs['libre']).'\''):('null')).'
					)
				');
				$this->champs['adherent_identifiant']=$this->champs['adherent_nouveau_identifiant'];
			}
			return $this->erreur;
		}
		
		public function modifier()
		{
			$this->verifier('modifier');
			if(!$this->erreur)
			{
				$enquete=new ld_enquete();
				$enquete->identifiant=$this->champs['adherent_identifiant'];
				$enquete->lire();

				$this->executer
				('
					update enquete
					set
						adherent_identifiant=\''.addslashes($this->champs['adherent_nouveau_identifiant']).'\',
						adherent_email='.(($this->champs['email']!==NULL)?('\''.addslashes($this->champs['adherent_email']).'\''):('null')).',
						question1='.(($this->champs['question1']!==NULL)?('\''.addslashes($this->champs['question1']).'\''):('null')).',
						question2='.(($this->champs['question2']!==NULL)?('\''.addslashes($this->champs['question2']).'\''):('null')).',
						question3='.(($this->champs['question3']!==NULL)?('\''.addslashes($this->champs['question3']).'\''):('null')).',
						question4='.(($this->champs['question4']!==NULL)?('\''.addslashes($this->champs['question4']).'\''):('null')).',
						question5='.(($this->champs['question5']!==NULL)?('\''.addslashes($this->champs['question5']).'\''):('null')).',
						libre='.(($this->champs['libre']!==NULL)?('\''.addslashes($this->champs['libre']).'\''):('null')).'
					where
						adherent_identifiant=\''.addslashes($this->champs['adherent_identifiant']).'\'
				');
				
				$this->champs['adherent_identifiant']=$this->champs['adherent_nouveau_identifiant'];
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