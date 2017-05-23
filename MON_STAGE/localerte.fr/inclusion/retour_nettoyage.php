<?php
	define('STR_REPEAT',4096);
	define('MESSAGE_REPEAT',100);
	
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'hardbounce.php');
	require_once(PWD_INCLUSION.'replybounce.php');
	require_once(PWD_INCLUSION.'softbounce.php');
	
	function ecrire_div($id, $message)
	{
		print
		('
			<script language="javascript">
				document.getElementById(\''.ma_htmlentities($id).'\').innerHTML=\''.ma_htmlentities($message).'\';
			</script>
			<noscript>'.ma_htmlentities($message).'<br /></noscript>'.str_repeat(' ',STR_REPEAT).'
		');
		flush();
	}
	
	function decode($chaine)
	{
		$retour=$chaine;
		while(preg_match('/\?([^\?]+)\?(Q|B)\?([^\?]*)\?\=/i',$retour,$resultat))
		{
			$partie=$resultat[3];
			switch(strtoupper($resultat[2]))
			{
				case 'Q':
					$partie=base64_decode($partie);
					break;
				case 'B':
					$partie=quoted_printable_decode($partie);
					break;
			}
			if(strtoupper($resultat[1])!='ISO-8859-1' && $conversion=@mb_convert_encoding($partie,strtoupper($resultat[1]),'ISO-8859-1'))
				$partie=$conversion;
			$retour=str_replace($resultat[0],$partie,$retour);
		}
		return $retour;
	}
	
	ini_set('error_reporting',E_ALL-E_NOTICE);
	set_time_limit(0);
	
	$bal=array($preference->retour_email);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>

<body>
<?php
	$hardbounce=new ld_hardbounce();
	$replybounce=new ld_replybounce();
	$softbounce=new ld_softbounce();
	$boucle=0;
	
	while(1)
	{
		$preference=new ld_preference();
		
		print('<span class="important">Nettoyage du compte: '.$preference->retour_email.'</span><br />'.str_repeat(' ',STR_REPEAT));
		flush();
		
		print('Connection: '.str_repeat(' ',STR_REPEAT));
		flush();
		
		if($imap=@imap_open('{'.$preference->retour_pop_serveur.':'.$preference->retour_pop_port.'/pop3/novalidate-cert}INBOX',$preference->retour_pop_utilisateur,$preference->retour_pop_passe,OP_SILENT))
		{
			print('r&eacute;ussie<br />'.str_repeat(' ',STR_REPEAT));
			flush();
			
			print('Nombre de mails restants: '.str_repeat(' ',STR_REPEAT));
			flush();
			
			$total=imap_num_msg($imap);
			$lecture=0;
			$retour_hardbounce=0;
			$retour_replybounce=0;
			$retour_softbounce=0;
		
			print($total.'<br />'.str_repeat(' ',STR_REPEAT));
			flush();
			
			print('<div id="lecture_'.$boucle.'">Lecture: 0</div>'.str_repeat(' ',STR_REPEAT));
			print('<div id="retour_hardbounce_'.$boucle.'">Retour hardbounce: 0</div>'.str_repeat(' ',STR_REPEAT));
			print('<div id="retour_replybounce_'.$boucle.'">Retour replybounce: 0</div>'.str_repeat(' ',STR_REPEAT));
			print('<div id="retour_softbounce_'.$boucle.'">Retour softbounce: 0</div>'.str_repeat(' ',STR_REPEAT));
			flush();
			
			for($j=1;$j<=$total && $lecture<$preference->retour_nettoyage_mail_par_boucle;$j++)
			{
				$lecture++;
				
				$entete=imap_fetchheader($imap,$j);
				$structure=imap_fetchstructure($imap,$j);
				$part=array();
				
				switch($structure->type)
				{
					case 0://text
					case 2://message
						$part[0]['body']=imap_body($imap,$j);
						$part[0]['encoding']=$structure->encoding;
						$part[0]['charset']='UTF-8';
						if($structure->ifparameters)
							for($k=0;$k<sizeof($structure->parameters) && $part[0]['charset']=='';$k++)
								if($structure->parameters[$k]->attribute=='CHARSET')
									$part[0]['charset']=$structure->parameters[$k]->value;
						break;
					case 1://multipart
						$l=0;
						for($k=0;$k<sizeof($structure->parts);$k++)
							if($structure->parts[$k]->type==0 || $structure->parts[$k]->type==2)
							{
								$part[$l]['body']=imap_fetchbody($imap,$j,($k+1));
								$part[$l]['encoding']=$structure->parts[$k]->encoding;
								if($part[$l]['encoding']==='')
									$part[$l]['encoding']=$structure->encoding;
								$part[$l]['charset']='UTF-8';
								if($structure->parts[$k]->ifparameters)
								{
									for($m=0;$m<sizeof($structure->parts[$k]->parameters) && $part[$l]['charset']=='';$m++)
										if($structure->parts[$k]->parameters[$m]->attribute=='CHARSET')
											$part[$l]['charset']=$structure->parts[$k]->parameters[$m]->value;
								}
								$l++;
							}
						break;
					case 7:
						print_r($structure);
						break;
				}
				
				$email=array();
				$resultat_hardbounce=0;
				$resultat_replybounce=$replybounce->chercher(imap_fetchheader($imap,$j),array('ENTETE'));
				$resultat_softbounce=0;
				for($m=0;$m<sizeof($part) && !$resultat_hardbounce && !$resultat_softbounce;$m++)
				{
					switch($part[$m]['encoding'])
					{
						case 0;//7BIT
							break;
						case 1;//8BIT
							break;
						case 2;//BINARY
							print('BINARY<br />');
							break;
						case 3;//BASE64
							$part[$m]['body']=base64_decode($part[$m]['body']);
							break;
						case 4;//QUOTE-PRITABLE
							$part[$m]['body']=quoted_printable_decode($part[$m]['body']);
							break;
						default://OTHER
							print('OTHER<br />');
							break;
						case 5:
							break;
					}
					
					if($part[$m]['charset']!='ISO-8859-1' && $conversion=@mb_convert_encoding($part[$m]['body'],$part[$m]['charset'],'ISO-8859-1'))
						$part[$m]['body']=$conversion;
					
					
					if(preg_match_all('/'.STRING_TROUVE_EMAIL.'/',$part[$m]['body'],$resultat))
					{
						$resultat[0]=array_diff($resultat[0],$bal);
						$resultat[0]=array_unique($resultat[0]);
						$resultat[0]=array_values($resultat[0]);
						if(sizeof($resultat[0]))
						{
							for($l=0;$l<sizeof($resultat[0]);$l++)
								if(stripos($resultat[0][$l],'flwd907.serveursdns.net')===false)
									$email[]=$resultat[0][$l];
						}
					}
					
					$resultat_softbounce=$softbounce->chercher($part[$m]['body']);
					if(!$resultat_softbounce)
						$resultat_hardbounce=$hardbounce->chercher($part[$m]['body']);
					if(!$resultat_softbounce && !$resultat_hardbounce && !$resultat_replybounce)
						$resultat_replybounce=$replybounce->chercher($part[$m]['body'],array('CORPS'));
				}
				
				if($resultat_hardbounce || $resultat_softbounce || $resultat_replybounce)
				{
					$email=array_unique($email);
					$email=array_values($email);
					
					if($resultat_softbounce)
					{
						$softbounce->executer
						('
							update adherent
							set softbounce=softbounce+1
							where email in (\''.implode('\', \'',array_map('addslashes',$email)).'\')
						');
						
						$liste=new ld_liste
						('
							select identifiant
							from adherent
							where email in (\''.implode('\', \'',array_map('addslashes',$email)).'\')
						');
						if($liste->total)
						{
							$fichier=fopen(PWD_INCLUSION.'prive/log/softbounce'.date('Y').date('m').'.log','a');
							for($n=0;$n<$liste->total;$n++)
								fputs($fichier,date('Y-m-d H:i:s').TAB.$liste->occurrence[$n].CRLF);
							fclose($fichier);
						}
					}
					elseif($resultat_hardbounce)
					{
						$hardbounce->executer
						('
							update adherent
							set hardbounce=hardbounce+1
							where email in (\''.implode('\', \'',array_map('addslashes',$email)).'\')
						');
						
						$retour_hardbounce+=$hardbounce->donner_ligne_affecte();
						
						$liste=new ld_liste
						('
							select identifiant
							from adherent
							where email in (\''.implode('\', \'',array_map('addslashes',$email)).'\')
						');
						if($liste->total)
						{
							$fichier=fopen(PWD_INCLUSION.'prive/log/hardbounce'.date('Y').date('m').'.log','a');
							for($n=0;$n<$liste->total;$n++)
								fputs($fichier,date('Y-m-d H:i:s').TAB.$liste->occurrence[$n].CRLF);
							fclose($fichier);
						}
					}
					elseif($resultat_replybounce)
						$retour_replybounce++;
					
					imap_delete($imap,$j);
				}
				
				if($j==$total || $lecture==$preference->retour_nettoyage_mail_par_boucle || $j%MESSAGE_REPEAT==0)
				{
					ecrire_div('lecture_'.$boucle.'','Lecture: '.$lecture);
					ecrire_div('retour_hardbounce_'.$boucle.'','Retour hardbounce: '.$retour_hardbounce);
					ecrire_div('retour_replybounce_'.$boucle.'','Retour replybounce: '.$retour_replybounce);
					ecrire_div('retour_softbounce_'.$boucle.'','Retour softbounce: '.$retour_softbounce);
				}
			}
			
			print('Purge des mails: '.str_repeat(' ',STR_REPEAT));
			flush();
			
			if(@imap_expunge($imap))
			{
				print('r&eacute;ussie<br />'.str_repeat(' ',STR_REPEAT));
				flush();
			}
			else
			{
				print('&eacute;chou&eacute;e<br />'.str_repeat(' ',STR_REPEAT));
				flush();
			}
			
			print('D&eacute;connection: '.str_repeat(' ',STR_REPEAT));
			flush();
			
			if(@imap_close($imap))
			{
				print('r&eacute;ussie<br />'.str_repeat(' ',STR_REPEAT));
				flush();
			}
			else
			{
				print('&eacute;chou&eacute;e<br />'.str_repeat(' ',STR_REPEAT));
				flush();
			}
		}
		else
		{
			print('&eacute;chou&eacute;e<br />'.str_repeat(' ',STR_REPEAT));
			flush();
		}
		
		usleep($preference->retour_nettoyage_pause);
			
		print('<br />'.str_repeat(' ',STR_REPEAT));
		flush();
		
		$boucle++;
	}
?>
</body>
</html>