<?php
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('MAIL_DE_DEFAUT',NULL);
	define('MAIL_DE_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_REPONSE_A_DEFAUT',NULL);
	define('MAIL_REPONSE_A_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_RETOUR_A_DEFAUT',NULL);
	define('MAIL_RETOUR_A_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_ACCUSE_A_DEFAUT',NULL);
	define('MAIL_ACCUSE_A_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_A_DEFAUT',NULL);
	define('MAIL_A_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_COPIE_A_DEFAUT',NULL);
	define('MAIL_COPIE_A_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_COPIE_CACHEE_A_DEFAUT',NULL);
	define('MAIL_COPIE_CACHEE_A_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_HTTP_DESABONNEMENT_DEFAUT',NULL);
	define('MAIL_HTTP_DESABONNEMENT_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_MAILTO_DESABONNEMENT_DEFAUT',NULL);
	define('MAIL_MAILTO_DESABONNEMENT_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_SUJET_MIN',0);
	define('MAIL_SUJET_MAX',2048);
	define('MAIL_SUJET_DEFAUT',NULL);
	define('MAIL_SUJET_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_TEXT_DEFAUT',NULL);
	
	define('MAIL_HTML_DEFAUT',NULL);
	
	define('MAIL_FICHIER_DEFAUT',NULL);
	define('MAIL_FICHIER_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_TEXT_HTML_FICHIER_ERREUR',pow(2,$define_erreur++));
	
	define('MAIL_TOTAL_ERREUR',pow(2,$define_erreur)-1);
	
	unset($define_erreur);
	
	class ld_mail
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
			
		/*function ld_preference()
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
			
			$this->effacer();
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
				$this->champs[$variable]=$valeur;
			else
			{
				trigger_error('Variable '.$variable.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		private function verifier()
		{
			//DE
			if(!preg_match('/^('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)$/',$this->champs['de']))
				$this->erreur|=MAIL_DE_ERREUR;
			else
				$this->erreur&=~MAIL_DE_ERREUR;
			//REPONSE_A
			if($this->champs['reponse_a']!='' && !preg_match('/^('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)$/',$this->champs['reponse_a']))
				$this->erreur|=MAIL_REPONSE_A_ERREUR;
			else
				$this->erreur&=~MAIL_REPONSE_A_ERREUR;
			//RETOUR_A
			if($this->champs['retour_a']!='' && !preg_match('/^'.STRING_TROUVE_EMAIL.'$/',$this->champs['retour_a']))
				$this->erreur|=MAIL_RETOUR_A_ERREUR;
			else
				$this->erreur&=~MAIL_RETOUR_A_ERREUR;
			//ACCUSE_A
			if($this->champs['accuse_a']!='' && !preg_match('/^('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)$/',$this->champs['accuse_a']))
				$this->erreur|=MAIL_ACCUSE_A_ERREUR;
			else
				$this->erreur&=~MAIL_ACCUSE_A_ERREUR;
			//A
			if(!preg_match('/^('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)(, ('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)){0,}$/',$this->champs['a']))
				$this->erreur|=MAIL_A_ERREUR;
			else
				$this->erreur&=~MAIL_A_ERREUR;
			//COPIE_A
			if($this->champs['copie_a']!='' && !preg_match('/^('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)(, ('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)){0,}$/',$this->champs['copie_a']))
				$this->erreur|=MAIL_COPIE_A_ERREUR;
			else
				$this->erreur&=~MAIL_COPIE_A_ERREUR;
			//COPIE_CACHEE_A
			if($this->champs['copie_cachee_a']!='' && !preg_match('/^('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)(, ('.STRING_TROUVE_EMAIL.'|.+ <'.STRING_TROUVE_EMAIL.'>)){0,}$/',$this->champs['copie_cachee_a']))
				$this->erreur|=MAIL_COPIE_CACHEE_A_ERREUR;
			else
				$this->erreur&=~MAIL_COPIE_CACHEE_A_ERREUR;
			//HTTP_DESABONNEMENT
			if($this->champs['http_desabonnement']!='' && !preg_match('/^'.STRING_FILTRE_URL.'$/',$this->champs['http_desabonnement']))
				$this->erreur|=MAIL_HTTP_DESABONNEMENT_ERREUR;
			else
				$this->erreur&=~MAIL_HTTP_DESABONNEMENT_ERREUR;
			//MAILTO_DESABONNEMENT
			if($this->champs['mailto_desabonnement']!=NULL && !preg_match('/^'.STRING_TROUVE_EMAIL.'$/',$this->champs['mailto_desabonnement']))
				$this->erreur|=MAIL_MAILTO_DESABONNEMENT_ERREUR;
			else
				$this->erreur&=~MAIL_MAILTO_DESABONNEMENT_ERREUR;
			//SUJET
			if(strlen($this->champs['sujet'])<MAIL_SUJET_MIN || strlen($this->champs['sujet'])>MAIL_SUJET_MAX)
				$this->erreur|=MAIL_SUJET_ERREUR;
			else
				$this->erreur&=~MAIL_SUJET_ERREUR;
			//TEXT
			//HTML
			//FICHIER
			$this->erreur&=~MAIL_FICHIER_ERREUR;
			if(is_array($this->champs['fichier']))
			{
				foreach($this->champs['fichier'] as $clef=>$valeur)
					if(!isset($valeur['chemin']) || !file_exists($valeur['chemin']) || !is_readable($valeur['chemin']))
					{
						$this->erreur|=MAIL_FICHIER_ERREUR;
						break;
					}
			}
			//TEXT HTML FICHIER
			if($this->champs['text']=='' && $this->champs['html']=='' && (!is_array($this->champs['fichier']) || $this->erreur & MAIL_FICHIER_ERREUR))
				$this->erreur|=MAIL_TEXT_HTML_FICHIER_ERREUR;
			else
				$this->erreur&=~MAIL_TEXT_HTML_FICHIER_ERREUR;
		}
		
		private function coder($chaine)
		{
			return mb_encode_mimeheader($chaine,'ISO-8859-1', 'Q', LF);
		}
		
		private function coder_email($chaine)
		{
			$email=explode(', ',$chaine);
			for($i=0;$i<sizeof($email);$i++)
				if(preg_match('/.+ <'.STRING_TROUVE_EMAIL.'>$/',$email[$i]))
				{
					list($aencoder)=preg_split('/ <'.STRING_TROUVE_EMAIL.'>$/',$email[$i]);
					$email[$i]=str_replace($aencoder,$this->coder($aencoder),$email[$i]);
				}
			
			return implode(', ',$email);
		}
		
		public function effacer()
		{
			$this->champs['de']=MAIL_DE_DEFAUT;
			$this->champs['reponse_a']=MAIL_REPONSE_A_DEFAUT;
			$this->champs['retour_a']=MAIL_RETOUR_A_DEFAUT;
			$this->champs['accuse_a']=MAIL_ACCUSE_A_DEFAUT;
			$this->champs['a']=MAIL_A_DEFAUT;
			$this->champs['copie_a']=MAIL_COPIE_A_DEFAUT;
			$this->champs['copie_cachee_a']=MAIL_COPIE_CACHEE_A_DEFAUT;
			$this->champs['http_desabonnement']=MAIL_HTTP_DESABONNEMENT_DEFAUT;
			$this->champs['mailto_desabonnement']=MAIL_MAILTO_DESABONNEMENT_DEFAUT;
			$this->champs['sujet']=MAIL_SUJET_DEFAUT;
			$this->champs['text']=MAIL_TEXT_DEFAUT;
			$this->champs['html']=MAIL_HTML_DEFAUT;
			$this->champs['fichier']=MAIL_FICHIER_DEFAUT;
			
			$this->erreur=MAIL_TOTAL_ERREUR;
		}
		
		public function envoyer()
		{

			$this->verifier();
			if(!$this->erreur)
			{

				$envelope=array();
				$part=array();
				$i=0;
				
				if(($this->champs['text']!='' && $this->champs['html']!=''))
				{
					$i++;
					$part[$i]['type']=TYPEMULTIPART;
					$part[$i]['subtype']='alternative';
				}
				
				if($this->champs['text']!='')
				{
					$i++;
					$part[$i]['type']=TYPETEXT;
					$part[$i]['subtype']='plain';
					$part[$i]['charset']='iso-8859-1';
					$part[$i]['encoding']=ENC8BIT;
					$part[$i]['contents.data']=str_replace(CRLF,LF,$this->champs['text']);
				}
				
				if($this->champs['html']!='')
				{
					$i++;
					$part[$i]['type']=TYPETEXT;
					$part[$i]['subtype']='html';
					$part[$i]['charset']='iso-8859-1';
					$part[$i]['encoding']=ENC8BIT;
					$part[$i]['contents.data']=str_replace(CRLF,LF,$this->champs['html']);
				}
				
				$mail='';

				if(sizeof($part))
				{
					$mail=str_replace(CRLF,LF,imap_mail_compose($envelope,$part));
					$mail=substr($mail,stripos($mail,'Content-Type:'));
				}
				
				if(is_array($this->champs['fichier']) && sizeof($this->champs['fichier']))
				{

					$fichier=array();
					$j=0;
					
					foreach($this->champs['fichier'] as $clef=>$valeur)
						if(isset($valeur['chemin']) && file_exists($valeur['chemin']) && is_readable($valeur['chemin']))
						{
							if(!isset($valeur['nom']) || $valeur['nom']=='')
								$nom=basename($valeur['chemin']);
							else
								$nom=$valeur['nom'];
							
							$fichier[$j]['type']=TYPEAPPLICATION;
				            $fichier[$j]['encoding']=ENCBASE64;
				            $fichier[$j]['subtype']='octet-stream';
				            $fichier[$j]['disposition.type']='attachment; filename="'.$this->coder($nom).'"';
				            $fichier[$j]['contents.data']=chunk_split(base64_encode(file_get_contents($valeur['chemin'])));
							$j++;
						}
					
					if(sizeof($fichier))
					{
						$envelope=array();
						$part=array();
						$i=0;
						
						if($mail!='' || sizeof($fichier)>1)
						{
							$i++;
							$part[$i]['type']=TYPEMULTIPART;
							$part[$i]['subtype']='mixed';
						}
						
						if($mail!='')
						{
							$i++;
							$part[$i]['type']=TYPEOTHER;
							$part[$i]['contents.data']=$mail;
						}
						
						for($j=0;$j<sizeof($fichier);$j++)
							$part[++$i]=$fichier[$j];
						
						$mail=str_replace(CRLF,LF,imap_mail_compose($envelope,$part));
						$mail=substr($mail,stripos($mail,'Content-Type:'));
						$mail=str_ireplace('Content-Type: X-UNKNOWN/UNKNOWN'.LF.LF,'',$mail);
					}
				}
				
				if($mail!='')
				{
					list($entete,$corps)=explode(LF.LF,$mail,2);
					
					$entete='MIME-Version: 1.0'.LF.$entete;
					//$entete='X-Mailer: ld_mailer 1'.LF.$entete;
					if($this->champs['reponse_a']!='')
						$entete='Reply-To: '.$this->coder_email($this->champs['reponse_a']).LF.$entete;
					if($this->champs['accuse_a']!='')
						$entete='Disposition-Notification-To: '.$this->coder_email($this->champs['accuse_a']).LF.$entete;
					if($this->champs['copie_a']!='')
						$entete='Cc: '.$this->coder_email($this->champs['copie_a']).LF.$entete;
					if($this->champs['copie_cachee_a']!='')
						$entete='Bcc: '.$this->coder_email($this->champs['copie_cachee_a']).LF.$entete;
					$desabonnement=array();
					if($this->champs['http_desabonnement']!=NULL)
						$desabonnement[]='<'.$this->champs['http_desabonnement'].'>';
					if($this->champs['mailto_desabonnement']!=NULL)
						$desabonnement[]='<mailto:'.$this->champs['mailto_desabonnement'].'>';
					if(sizeof($desabonnement))
						$entete='List-Unsubscribe: '.implode(', ',$desabonnement).LF.$entete;
					$entete='From: '.$this->coder_email($this->champs['de']).LF.$entete;

					//print(nl2br(ma_htmlentities($entete.LF.LF.$corps)));
					
					if($this->champs['retour_a']!='')
						$retour[0]=$this->champs['retour_a'];
					else
						preg_match('/'.STRING_TROUVE_EMAIL.'/',$this->champs['de'],$retour);
					
					return mail($this->coder_email($this->champs['a']),$this->coder($this->champs['sujet']),$corps,$entete,'-f '.$retour[0]);
					//return imap_mail($this->coder_email($this->champs['a']),$this->coder($this->champs['sujet']),$corps,$entete,'','',$retour[0]);
				}
				else
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