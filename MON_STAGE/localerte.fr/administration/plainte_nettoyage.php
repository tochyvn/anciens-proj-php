<?php
	define('STR_REPEAT',4096);
	define('MESSAGE_REPEAT',100);
	
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'string.php');
	
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
	session_write_close();
	
	function partitionner($structure,&$part,$imap,$numero,$niveau)
	{
		if(isset($structure->parts))
		{
			if($structure->subtype!='ALTERNATIVE' || !sizeof($niveau))
				$niveau[]=0;
			else
				$niveau[sizeof($niveau)-1]--;
			
			for($i=0;$i<sizeof($structure->parts);$i++)
			{
				$niveau[sizeof($niveau)-1]++;
				partitionner($structure->parts[$i],$part,$imap,$numero,$niveau);
			}
		}
		else
		{
			if($niveau[sizeof($niveau)-1]=='')
				$niveau[sizeof($niveau)-1]=1;
			
			$tableau=array();
			$tableau['body']=imap_fetchbody($imap,$numero,implode('.',$niveau));
			$tableau['encoding']=$structure->encoding;
			$tableau['charset']='UTF-8';
			
			for($i=0;isset($structure->parameters) && is_array($structure->parameters)  && $i<sizeof($structure->parameters);$i++)
				if(isset($structure->parameters[$i]->attribute) && $structure->parameters[$i]->attribute=='CHARSET')
					$tableau['charset']=$structure->parameters[$i]->value;
			
			$part[]=$tableau;
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>

<body>
<?php
	$boucle=0;
	
	//while(1)
	{
		$preference=new ld_preference();
		
		print('<span class="important">Nettoyage du compte: '.$preference->plainte_email.'</span><br />'.str_repeat(' ',STR_REPEAT));
		flush();
		
		print('Connection: '.str_repeat(' ',STR_REPEAT));
		flush();
		
		if($imap=@imap_open('{'.$preference->plainte_pop_serveur.':'.$preference->plainte_pop_port.'/pop3/novalidate-cert}INBOX',$preference->plainte_pop_utilisateur,$preference->plainte_pop_passe,OP_SILENT))
		{
			print('r&eacute;ussie<br />'.str_repeat(' ',STR_REPEAT));
			flush();
			
			print('Nombre de mails restants: '.str_repeat(' ',STR_REPEAT));
			flush();
			
			$total=imap_num_msg($imap);
			$lecture=0;
			$plainte=0;
		
			print($total.'<br />'.str_repeat(' ',STR_REPEAT));
			flush();
			
			print('<div id="plainte_lecture_'.$boucle.'">Lecture: 0</div>'.str_repeat(' ',STR_REPEAT));
			print('<div id="plainte_'.$boucle.'">Plainte: 0</div>'.str_repeat(' ',STR_REPEAT));
			flush();
			
			for($j=1;$j<=$total && $lecture<$preference->plainte_nettoyage_mail_par_boucle;$j++)
			{
				$lecture++;
				
				if(preg_match('/(scomp@aol\.net|staff@hotmail\.com|feedback@arf\.mail\.yahoo\.com)/',imap_fetchheader($imap,$j)))
				{
					$part=array();
					$structure=imap_fetchstructure($imap,$j);
					partitionner($structure,$part,$imap,$j,array());
					
					$code=array();
					
					for($m=0;$m<sizeof($part);$m++)
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
						
						if(preg_match_all('/http:\/\/[^\/]+\/d_([0-9a-zA-Z]+)(_([0-9]{8})([^\.]+))?\.html/',$part[$m]['body'],$resultat))
						{
							$resultat[1]=array_unique($resultat[1]);
							$resultat[1]=array_values($resultat[1]);
							for($l=0;$l<sizeof($resultat[1]);$l++)
								$code[]=$resultat[1][$l];
						}
					}
					
					$code=array_unique($code);
					$code=array_values($code);
					
					if(sizeof($code))
					{
						$preference->executer
						('
							update adherent
							set plainte=plainte+1
							where code in (\''.implode('\', \'',array_map('addslashes',$code)).'\')
						');
						
						$plainte+=$preference->donner_ligne_affecte();
						
						$liste=new ld_liste
						('
							select identifiant
							from adherent
							where code in (\''.implode('\', \'',array_map('addslashes',$code)).'\')
						');
						if($liste->total)
						{
							$fichier=fopen(PWD_INCLUSION.'prive/log/plainte'.date('Y').date('m').'.log','a');
							for($n=0;$n<$liste->total;$n++)
								fputs($fichier,date('Y-m-d H:i:s').TAB.$liste->occurrence[$n]['identifiant'].CRLF);
							fclose($fichier);
							imap_delete($imap,$j);
						}
					}
				}
				
				if($j==$total || $lecture==$preference->plainte_nettoyage_mail_par_boucle || $j%MESSAGE_REPEAT==0)
				{
					ecrire_div('plainte_lecture_'.$boucle.'','Lecture: '.$lecture);
					ecrire_div('plainte_'.$boucle.'','Plainte: '.$plainte);
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
		
		usleep($preference->plainte_nettoyage_pause);
			
		print('<br />'.str_repeat(' ',STR_REPEAT));
		flush();
		
		$boucle++;
	}
?>
</body>
</html>