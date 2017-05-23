<?php
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('SOCKET_HTTP_URL_MIN',1);
	define('SOCKET_HTTP_URL_MAX',2048);
	define('SOCKET_HTTP_URL_DEFAUT','');
	define('SOCKET_HTTP_URL_ERREUR_LONGUEUR',pow(2,$define_erreur++));
	define('SOCKET_HTTP_URL_ERREUR_FILTRE',pow(2,$define_erreur++));
	
	define('SOCKET_HTTP_DELAI_MIN',1);
	define('SOCKET_HTTP_DELAI_MAX',3600);
	define('SOCKET_HTTP_DELAI_DEFAUT',30);
	define('SOCKET_HTTP_DELAI_ERREUR',pow(2,$define_erreur++));
	
	define('SOCKET_HTTP_METHODE_ENUM','GET,POST,HEAD');
	define('SOCKET_HTTP_METHODE_DEFAUT','GET');
	define('SOCKET_HTTP_METHODE_ERREUR',pow(2,$define_erreur++));
	
	define('SOCKET_HTTP_VERSION_ENUM','1.0');
	define('SOCKET_HTTP_VERSION_DEFAUT','1.0');
	define('SOCKET_HTTP_VERSION_ERREUR',pow(2,$define_erreur++));
	
	define('SOCKET_HTTP_ENTETE_DEFAUT','');
	
	define('SOCKET_HTTP_CORPS_DEFAUT','');
	
	define('SOCKET_HTTP_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_socket_http
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_socket_http()
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
			
			$this->champs['url']=SOCKET_HTTP_URL_DEFAUT;
			$this->champs['delai']=SOCKET_HTTP_DELAI_DEFAUT;
			$this->champs['methode']=SOCKET_HTTP_METHODE_DEFAUT;
			$this->champs['version']=SOCKET_HTTP_VERSION_DEFAUT;
			$this->champs['entete']=SOCKET_HTTP_ENTETE_DEFAUT;
			$this->champs['corps']=SOCKET_HTTP_CORPS_DEFAUT;
			
			$this->effacer();
		}
		
		/*function __destruct()
		{
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
				if($variable!='resultat_errno' && $variable!='resultat_errstr' && $variable!='resultat_entete' && $variable!='resultat_corps')
				{
					$this->champs[$variable]=$valeur;
					$this->effacer();
				}
				else
				{
					trigger_error('Variable '.$variable.' non modifiable'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
				}
			}
			else
			{
				trigger_error('Variable '.$variable.' non définie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		private function verifier()
		{
			//URL
			if(strlen($this->champs['url'])<SOCKET_HTTP_URL_MIN && strlen($this->champs['url'])>SOCKET_HTTP_URL_MAX)
				$this->erreur|=SOCKET_HTTP_URL_ERREUR_LONGUEUR;
			else
				$this->erreur&=~SOCKET_HTTP_URL_ERREUR_LONGUEUR;
			if(!preg_match('/'.STRING_FILTRE_URL.'/',$this->champs['url']))
				$this->erreur|=SOCKET_HTTP_URL_ERREUR_FILTRE;
			else
				$this->erreur&=~SOCKET_HTTP_URL_ERREUR_FILTRE;
			//DELAI
			if($this->champs['delai']<SOCKET_HTTP_DELAI_MIN || $this->champs['delai']>SOCKET_HTTP_DELAI_MAX)
				$this->erreur|=SOCKET_HTTP_DELAI_ERREUR;
			else
				$this->erreur&=~SOCKET_HTTP_DELAI_ERREUR;
			//METHODE
			if(array_search($this->champs['methode'],explode(',',SOCKET_HTTP_METHODE_ENUM))==0 && array_search($this->champs['methode'],explode(',',SOCKET_HTTP_METHODE_ENUM))!==0)
				$this->erreur|=SOCKET_HTTP_METHODE_ERREUR;
			else
				$this->erreur&=~SOCKET_HTTP_METHODE_ERREUR;
			//VERSION
			if(array_search($this->champs['version'],explode(',',SOCKET_HTTP_VERSION_ENUM))==0 && array_search($this->champs['version'],explode(',',SOCKET_HTTP_VERSION_ENUM))!==0)
				$this->erreur|=SOCKET_HTTP_VERSION_ERREUR;
			else
				$this->erreur&=~SOCKET_HTTP_VERSION_ERREUR;
		}
		
		private function effacer()
		{
			$this->champs['resultat_errno']='';
			$this->champs['resultat_errstr']='';
			$this->champs['resultat_reponse']='';
			$this->champs['resultat_entete']=array();
			$this->champs['resultat_corps']='';
			
			$this->erreur=SOCKET_HTTP_TOTAL_ERREUR;
		}
		
		public function executer($mode='NOCACHE')
		{
			if($this->champs['methode']=='HEAD')
				$mode='NOCACHE';
			
			$this->verifier();
			if(!$this->erreur)
			{
				$this->effacer();
				
				$url=parse_url($this->champs['url']);
				
				if(!isset($url['path']))
					$url['path']='/';
				
				if(!isset($url['port']))
					$url['port']=80;
				
				if(!isset($url['user']))
					$url['user']='';

				if(!isset($url['pass']))
					$url['pass']='';
				
				if(is_array($this->champs['corps']))
				{
					$corps='';
					foreach($this->champs['corps'] as $clef=>$valeur)
					{
						if($corps!='')
							$corps.='&';
						$corps.=urlencode($clef).'='.urlencode($valeur);
					}
				}
				else
					$corps=$this->champs['corps'];
				
				$requete=$this->champs['methode'].' '.$url['path'].((isset($url['query']))?('?'.$url['query']):('')).' HTTP/'.$this->champs['version'].CRLF;
				if(!preg_match('/Host: .+\r\n/i',$this->champs['entete']))
					$requete.='Host: '.$url['host'].CRLF;
				if(!preg_match('/Connection: .+\r\n/i',$this->champs['entete']))
					$requete.='Connection: Close'.CRLF;
				if($corps!='')
				{
					if(!preg_match('/Content-Type: .+\r\n/i',$this->champs['entete']))
						$requete.='Content-Type: application/x-www-form-urlencoded'.CRLF;
					if(!preg_match('/Content-Length: .+\r\n/i',$this->champs['entete']))
						$requete.='Content-Length: '.strlen($corps).CRLF;
				}
				if($url['user']!='')
				{
					if(!preg_match('/Authorization: .+\r\n/i',$this->champs['entete']))
						$requete.='Authorization: Basic '.base64_encode($url['user'].':'.$url['pass']).CRLF;
				}
				$requete.=$this->champs['entete'];
				if(!preg_match('/User-Agent: .+\r\n/i',$this->champs['entete']))
					$requete.='User-Agent: ld_socket_http 0.1'.CRLF;
				$requete.=CRLF;
				
				$requete.=$corps;
				
				//print('<pre>'.$requete.'</pre>');
				
				if($socket=fsockopen((($url['scheme']=='https')?('ssl://'):('')).$url['host'],$url['port'],$this->champs['resultat_errno'],$this->champs['resultat_errstr'],$this->champs['delai']))
				{
					fwrite($socket,$requete,strlen($requete));
					
					$entete='';
					
					switch($mode)
					{
						default:
						case 'NOCACHE':
							$resultat='';
							$temps=time();
							while(!feof($socket))
							{
								$ligne=fgets($socket,128);
								$resultat.=$ligne;
								if($ligne!='')
									$temps=time();
								if(time()>$this->champs['delai']+$temps)
									return false;
							}
							
							fclose($socket);
							
							$this->champs['resultat_reponse']=substr($resultat,0,strpos($resultat,CRLF));
							if(strpos($resultat,CRLF.CRLF)!==false)
								list($entete,$this->champs['resultat_corps'])=explode(CRLF.CRLF,substr($resultat,strpos($resultat,CRLF)+2),2);
							else
							{	
								$entete=$resultat;
								$this->champs['resultat_corps']='';
							}
							break;
						case 'CACHE':
							$this->champs['resultat_corps']=PWD_INCLUSION.'prive/temp/ld_socket_http_'.uniqid(0);
							
							$fichier=fopen($this->champs['resultat_corps'],'w');
							
							$resultat='';
							$temps=time();
							while(!feof($socket))
							{
								$ligne=fgets($socket,128);
								if(!isset($entete))
								{
									$resultat.=$ligne;
									if(strpos($resultat,CRLF.CRLF)!==false)
									{
										$this->champs['resultat_reponse']=substr($resultat,0,strpos($resultat,CRLF));
										list($entete,$reste)=explode(CRLF.CRLF,substr($resultat,strpos($resultat,CRLF)+2),2);
										fputs($fichier,$reste,strlen($reste));
										unset($resultat);
									}
								}
								else
									fputs($fichier,$ligne,strlen($ligne));
								if($ligne!='')
									$temps=time();
								if(time()>$this->champs['delai']+$temps)
								{
									fclose($fichier);
									unlink($this->champs['resultat_corps']);
									return false;
								}
							}
							
							fclose($fichier);
							break;
					}
					
					$entete=explode(CRLF,$entete);
					for($i=0;$i<sizeof($entete);$i++)
					{
						if(strpos($entete[$i],': ')!==false)
						{
							list($clef,$valeur)=explode(': ',$entete[$i]);
							$this->champs['resultat_entete'][$clef]=$valeur;
						}
					}
					
					return true;
				}
				
				return false;
			}
			
			return $this->erreur;
		}
		
		public function tester()
		{
			$this->verifier();
			return $this->erreur;
		}
	}
?>