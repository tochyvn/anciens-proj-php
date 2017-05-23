<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');

	$define_erreur=0;

	define('FACTURE_LIGNE_IDENTIFIANT_DEFAUT','');
	define('FACTURE_LIGNE_IDENTIFIANT_ERREUR',pow(2,$define_erreur++));

	define('FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_MIN',1);
	define('FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_MAX',9);
	define('FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_DEFAUT','');
	define('FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON',pow(2,$define_erreur++));

	define('FACTURE_LIGNE_FACTURE_DEFAUT',NULL);
	define('FACTURE_LIGNE_FACTURE_NULL',false);
	define('FACTURE_LIGNE_FACTURE_ERREUR',pow(2,$define_erreur++));

	define('FACTURE_LIGNE_REFERENCE_MIN',1);
	define('FACTURE_LIGNE_REFERENCE_MAX',12);
	define('FACTURE_LIGNE_REFERENCE_NULL',false);
	define('FACTURE_LIGNE_REFERENCE_DEFAUT',NULL);
	define('FACTURE_LIGNE_REFERENCE_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('FACTURE_LIGNE_REFERENCE_ERREUR_UNIQUE',pow(2,$define_erreur++));

	define('FACTURE_LIGNE_DESIGNATION_MIN',1);
	define('FACTURE_LIGNE_DESIGNATION_MAX',50);
	define('FACTURE_LIGNE_DESIGNATION_NULL',false);
	define('FACTURE_LIGNE_DESIGNATION_DEFAUT','');
	define('FACTURE_LIGNE_DESIGNATION_ERREUR',pow(2,$define_erreur++));

	define('FACTURE_LIGNE_PRIX_HT_MIN',0.01);
	define('FACTURE_LIGNE_PRIX_HT_MAX',99999.99);
	define('FACTURE_LIGNE_PRIX_HT_NULL',false);
	define('FACTURE_LIGNE_PRIX_HT_DEFAUT',NULL);
	define('FACTURE_LIGNE_PRIX_HT_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('FACTURE_LIGNE_PRIX_HT_ERREUR_FILTRE',pow(2,$define_erreur++));

	define('FACTURE_LIGNE_QUANTITE_MIN',1);
	define('FACTURE_LIGNE_QUANTITE_MAX',10000);
	define('FACTURE_LIGNE_QUANTITE_NULL',false);
	define('FACTURE_LIGNE_QUANTITE_DEFAUT',NULL);
	define('FACTURE_LIGNE_QUANTITE_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('FACTURE_LIGNE_QUANTITE_ERREUR_FILTRE',pow(2,$define_erreur++));

	define('FACTURE_LIGNE_TVA_MIN',0.01);
	define('FACTURE_LIGNE_TVA_MAX',100);
	define('FACTURE_LIGNE_TVA_NULL',NULL);
	define('FACTURE_LIGNE_TVA_DEFAUT',NULL);
	define('FACTURE_LIGNE_TVA_ERREUR_VALEUR',pow(2,$define_erreur++));
	define('FACTURE_LIGNE_TVA_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('FACTURE_LIGNE_TOTAL_ERREUR', pow(2,$define_erreur++)-1);
	
	unset($define_erreur);
	
	class ld_facture_ligne extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_facture_ligne()
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
			$this->champs['identifiant']=FACTURE_LIGNE_IDENTIFIANT_DEFAUT;
			$this->champs['nouveau_identifiant']=FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_DEFAUT;
			$this->champs['facture']=FACTURE_LIGNE_FACTURE_DEFAUT;
			$this->champs['reference']=FACTURE_LIGNE_REFERENCE_DEFAUT;
			$this->champs['designation']=FACTURE_LIGNE_DESIGNATION_DEFAUT;
			$this->champs['prix_ht']=FACTURE_LIGNE_PRIX_HT_DEFAUT;
			$this->champs['quantite']=FACTURE_LIGNE_QUANTITE_DEFAUT;
			$this->champs['tva']=FACTURE_LIGNE_TVA_DEFAUT;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=FACTURE_LIGNE_TOTAL_ERREUR;
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
				$this->executer
				('
					select count(facture.identifiant) as nombre
					from facture_ligne
						inner join facture on facture_ligne.facture=facture.identifiant
					where
						facture_ligne.identifiant=\''.addslashes($this->champs['identifiant']).'\'
						and facture.statut=\'ATTENTE\'
				');
				$this->donner_suivant($occurrence);
				if(!$occurrence['nombre'])
					$this->erreur=FACTURE_LIGNE_IDENTIFIANT_ERREUR;
				else
					$this->erreur=0;
			}
			else
			{
				//IDENTIFIANT
				$this->executer
				('
					select count(identifiant) as nombre
					from facture_ligne
					where
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->donner_suivant($occurrence);
				if($mode=='modifier' && !$occurrence['nombre'])
					$this->erreur|=FACTURE_LIGNE_IDENTIFIANT_ERREUR;
				else
					$this->erreur&=~FACTURE_LIGNE_IDENTIFIANT_ERREUR;
				//NOUVEAU_IDENTIFIANT
				if(strlen($this->champs['nouveau_identifiant'])<FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_MIN || strlen($this->champs['nouveau_identifiant'])>FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_MAX)
					$this->erreur|=FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				else
					$this->erreur&=~FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from facture_ligne
					where
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				else
					$this->erreur&=~FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_ERREUR_DOUBLON;
				//FACTURE
				$this->executer
				('
					select count(identifiant) as nombre
					from facture
					where
						identifiant=\''.addslashes($this->champs['facture']).'\'
				');
				$this->donner_suivant($occurrence);
				if((!FACTURE_LIGNE_FACTURE_NULL || $this->champs['facture']!==NULL) && !$occurrence['nombre'])
					$this->erreur|=FACTURE_LIGNE_FACTURE_ERREUR;
				else
					$this->erreur&=~FACTURE_LIGNE_FACTURE_ERREUR;
				//REFERENCE
				if((!FACTURE_LIGNE_REFERENCE_NULL || $this->champs['reference']!==NULL) && (strlen($this->champs['reference'])<FACTURE_LIGNE_REFERENCE_MIN || strlen($this->champs['reference'])>FACTURE_LIGNE_REFERENCE_MAX))
					$this->erreur|=FACTURE_LIGNE_REFERENCE_ERREUR_LONGUEUR;
				else
					$this->erreur&=~FACTURE_LIGNE_REFERENCE_ERREUR_LONGUEUR;
				$this->executer
				('
					select count(identifiant) as nombre
					from facture_ligne
					where
						reference=\''.addslashes($this->champs['reference']).'\'
						and facture=\''.addslashes($this->champs['facture']).'\'
						'.(($mode=='modifier')?('and identifiant<>\''.addslashes($this->champs['identifiant']).'\''):('')).'
				');
				$this->donner_suivant($occurrence);
				if($occurrence['nombre'])
					$this->erreur|=FACTURE_LIGNE_REFERENCE_ERREUR_UNIQUE;
				else
					$this->erreur&=~FACTURE_LIGNE_REFERENCE_ERREUR_UNIQUE;
				//DESIGNATION
				if((!FACTURE_LIGNE_DESIGNATION_NULL || $this->champs['designation']!==NULL) && (strlen($this->champs['designation'])<FACTURE_LIGNE_DESIGNATION_MIN || strlen($this->champs['designation'])>FACTURE_LIGNE_DESIGNATION_MAX))
					$this->erreur|=FACTURE_LIGNE_DESIGNATION_ERREUR;
				else
					$this->erreur&=~FACTURE_LIGNE_DESIGNATION_ERREUR;
				//PRIX_HT
				if((!FACTURE_LIGNE_PRIX_HT_NULL || $this->champs['prix_ht']!==NULL) && (floatval($this->champs['prix_ht'])<FACTURE_LIGNE_PRIX_HT_MIN || floatval($this->champs['prix_ht'])>FACTURE_LIGNE_PRIX_HT_MAX))
					$this->erreur|=FACTURE_LIGNE_PRIX_HT_ERREUR_VALEUR;
				else
					$this->erreur&=~FACTURE_LIGNE_PRIX_HT_ERREUR_VALEUR;
				if((!FACTURE_LIGNE_PRIX_HT_NULL || $this->champs['prix_ht']!==NULL) && !preg_match('/'.STRING_FILTRE_MONNAIE_POSITIF.'/',$this->champs['prix_ht']))
					$this->erreur|=FACTURE_LIGNE_PRIX_HT_ERREUR_FILTRE;
				else
					$this->erreur&=~FACTURE_LIGNE_PRIX_HT_ERREUR_FILTRE;
				//QUANTITE
				if((!FACTURE_LIGNE_QUANTITE_NULL || $this->champs['quantite']!==NULL) && (intval($this->champs['quantite'])<FACTURE_LIGNE_QUANTITE_MIN || intval($this->champs['quantite'])>FACTURE_LIGNE_QUANTITE_MAX))
					$this->erreur|=FACTURE_LIGNE_QUANTITE_ERREUR_VALEUR;
				else
					$this->erreur&=~FACTURE_LIGNE_QUANTITE_ERREUR_VALEUR;
				if((!FACTURE_LIGNE_QUANTITE_NULL || $this->champs['quantite']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['quantite']))
					$this->erreur|=FACTURE_LIGNE_QUANTITE_ERREUR_FILTRE;
				else
					$this->erreur&=~FACTURE_LIGNE_QUANTITE_ERREUR_FILTRE;
				//TVA
				if((!FACTURE_LIGNE_TVA_NULL || $this->champs['tva']!==NULL) && (floatval($this->champs['tva'])<FACTURE_LIGNE_TVA_MIN || floatval($this->champs['tva'])>FACTURE_LIGNE_TVA_MAX))
					$this->erreur|=FACTURE_LIGNE_TVA_ERREUR_VALEUR;
				else
					$this->erreur&=~FACTURE_LIGNE_TVA_ERREUR_VALEUR;
				if((!FACTURE_LIGNE_TVA_NULL || $this->champs['tva']!==NULL) && !preg_match('/'.STRING_FILTRE_MONNAIE_POSITIF.'/',$this->champs['tva']))
					$this->erreur|=FACTURE_LIGNE_TVA_ERREUR_FILTRE;
				else
					$this->erreur&=~FACTURE_LIGNE_TVA_ERREUR_FILTRE;
			}
		}

		public function lire()
		{
			$this->executer
			('
				SELECT
					identifiant,
					facture,
					reference,
					designation,
					prix_ht,
					quantite,
					tva
				FROM facture_ligne
				WHERE
					identifiant=\''.addslashes($this->champs['identifiant']).'\'
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['identifiant']=$occurrence['identifiant'];
			$this->champs['nouveau_identifiant']=$occurrence['identifiant'];
			$this->champs['facture']=$occurrence['facture'];
			$this->champs['reference']=$occurrence['reference'];
			$this->champs['designation']=$occurrence['designation'];
			$this->champs['prix_ht']=$occurrence['prix_ht'];
			$this->champs['quantite']=$occurrence['quantite'];
			$this->champs['tva']=$occurrence['tva'];
			return true;
		}

		public function supprimer()
		{
			$this->verifier('supprimer');
			if(!$this->erreur)
			{
				$this->executer
				('
					DELETE FROM facture_ligne
					WHERE
						identifiant=\''.addslashes($this->champs['identifiant']).'\'
				');
				$this->champs['identifiant']=FACTURE_LIGNE_IDENTIFIANT_DEFAUT;
				$this->champs['nouveau_identifiant']=FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_DEFAUT;
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
					INSERT INTO facture_ligne
					(
						identifiant,
						facture,
						reference,
						designation,
						prix_ht,
						quantite,
						tva
					)
					VALUES
					(
						\''.addslashes($this->champs['nouveau_identifiant']).'\',
						'.(($this->champs['facture']!==NULL)?('\''.addslashes($this->champs['facture']).'\''):('null')).',
						'.(($this->champs['reference']!==NULL)?('\''.addslashes($this->champs['reference']).'\''):('null')).',
						'.(($this->champs['designation']!==NULL)?('\''.addslashes($this->champs['designation']).'\''):('null')).',
						'.(($this->champs['prix_ht']!==NULL)?('\''.addslashes($this->champs['prix_ht']).'\''):('null')).',
						'.(($this->champs['quantite']!==NULL)?('\''.addslashes($this->champs['quantite']).'\''):('null')).',
						'.(($this->champs['tva']!==NULL)?('\''.addslashes($this->champs['tva']).'\''):('null')).'
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
					UPDATE facture_ligne
					SET
						identifiant=\''.addslashes($this->champs['nouveau_identifiant']).'\',
						facture='.(($this->champs['facture']!==NULL)?('\''.addslashes($this->champs['facture']).'\''):('null')).',
						reference='.(($this->champs['reference']!==NULL)?('\''.addslashes($this->champs['reference']).'\''):('null')).',
						designation='.(($this->champs['designation']!==NULL)?('\''.addslashes($this->champs['designation']).'\''):('null')).',
						prix_ht='.(($this->champs['prix_ht']!==NULL)?('\''.addslashes($this->champs['prix_ht']).'\''):('null')).',
						quantite='.(($this->champs['quantite']!==NULL)?('\''.addslashes($this->champs['quantite']).'\''):('null')).',
						tva='.(($this->champs['tva']!==NULL)?('\''.addslashes($this->champs['tva']).'\''):('null')).'
					WHERE
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
	}
	
?>