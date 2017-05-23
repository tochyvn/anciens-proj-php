<?php
	class ld_mysqli
	{
		private /*var*/ $ressource;
		private /*var*/ $resultat;
		
		/*function ld_mysql()
		{
			if(floatval(phpversion())<5)
			{
				$func_get_args=func_get_args();
				call_user_func_array(array(&$this,'__construct'),$func_get_args);
			}
		}*/
		
		function __construct()
		{
		}
		
		/*function __destruct()
		{
		}*/
		
		public function ouvrir()
		{
			switch(func_num_args())
			{
				case 4:
					list($serveur,$utilisateur,$passe,$base)=func_get_args();
					break;
				case 0:
					$serveur=SQL_SERVEUR;
					$utilisateur=SQL_UTILISATEUR;
					$passe=SQL_PASSE;
					$base=SQL_BASE;
					break;
				default:
					trigger_error('Nombre d\'arguments incorrect'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
					break;
			}
			if(!$this->ressource=mysqli_connect($serveur,$utilisateur,$passe,$base))
			{
				trigger_error(mysqli_error($this->ressource).' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			return true;
		}
		
		public function executer($requete,$reponse=true)
		{
			if($reponse)
			{
				if(!$this->resultat=mysqli_query($this->ressource,$requete))
				{
					trigger_error('<pre>'.$requete.'</pre> ----- '.mysqli_error($this->ressource).' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
				}
			}
			else
			{
				if(!$this->resultat=mysqli_real_query($this->ressource,$requete))
				{
					trigger_error('<pre>'.$requete.'</pre> ----- '.mysqli_error($this->ressource).' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
				}
			}
			return true;
		}
		
		public function fermer()
		{
			mysqli_close($this->ressource);
		}
		
		public function donner_identifiant()
		{
			return mysqli_insert_id($this->ressource);
		}
		
		public function donner_suivant(&$occurrence)
		{
			if(!$occurrence=mysqli_fetch_assoc($this->resultat))
				return false;
			return true;
		}
		
		public function donner_ligne_retourne()
		{
			return mysqli_num_rows($this->resultat);
		}
		
		public function donner_ligne_sans_limit()
		{
			if($this->executer('select found_rows() as nombre') && $this->donner_suivant($occurrence))
				return $occurrence['nombre'];
			return false;
		}
		
		public function donner_ligne_affecte()
		{
			return mysqli_affected_rows($this->ressource);
		}
	}
?>