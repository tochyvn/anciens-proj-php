<?php
	define('STR_REPEAT',4096);
	define('MESSAGE_REPEAT',100);
	
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'unscribebounce.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
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
	
	$bal=array($preference->desabonnement_email);
	
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
	
	function trouver(&$email,$chaine,$bal)
	{
		$resultat=array();
		
		if(preg_match_all('/'.STRING_TROUVE_EMAIL.'/',$chaine,$resultat))
		{
			$resultat[0]=array_diff($resultat[0],$bal);
			$resultat[0]=array_unique($resultat[0]);
			$resultat[0]=array_values($resultat[0]);
			
			if(sizeof($resultat[0]))
			{
				for($l=0;$l<sizeof($resultat[0]);$l++)
					if(stripos($resultat[0][$l],'flwd853.serveursdns.net')===false && stripos($resultat[0][$l],'flwd906.serveursdns.net')===false && stripos($resultat[0][$l],'flwe104.serveursdns.net')===false && array_search($resultat[0][$l],$email)===false)
						$email[]=$resultat[0][$l];
			}
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
	$unscribebounce=new ld_unscribebounce();
	$boucle=0;
	
	//while(1)
	{
		$preference=new ld_preference();
		
		print('<span class="important">Nettoyage du compte: '.$preference->desabonnement_email.'</span><br />'.str_repeat(' ',STR_REPEAT));
		flush();
		
		print('Connection: '.str_repeat(' ',STR_REPEAT));
		flush();
		
		if($imap=@imap_open('{'.$preference->desabonnement_pop_serveur.':'.$preference->desabonnement_pop_port.'/pop3/novalidate-cert}INBOX',$preference->desabonnement_pop_utilisateur,$preference->desabonnement_pop_passe,OP_SILENT))
		{
			print('r&eacute;ussie<br />'.str_repeat(' ',STR_REPEAT));
			flush();
			
			print('Nombre de mails restants: '.str_repeat(' ',STR_REPEAT));
			flush();
			
			$total=imap_num_msg($imap);
			$lecture=0;
			$desabonnement=0;
		
			print($total.'<br />'.str_repeat(' ',STR_REPEAT));
			flush();
			
			print('<div id="desabonnement_lecture_'.$boucle.'">Lecture: 0</div>'.str_repeat(' ',STR_REPEAT));
			print('<div id="desabonnement_'.$boucle.'">D&eacute;sabonnement: 0</div>'.str_repeat(' ',STR_REPEAT));
			flush();
			
			for($j=1;$j<=$total && $lecture<$preference->desabonnement_nettoyage_mail_par_boucle;$j++)
			{
				$lecture++;
				
				$part=array();
				$structure=imap_fetchstructure($imap,$j);
				partitionner($structure,$part,$imap,$j,array());
				
				$email=array();
				trouver($email,mb_decode_mimeheader(imap_fetchheader($imap,$j)).CRLF.CRLF.imap_body($imap,$j),$bal);
				
				$resultat_unscribebounce=$unscribebounce->chercher(mb_decode_mimeheader(imap_fetchheader($imap,$j)),array('ENTETE'));
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
					
					trouver($email,$part[$m]['body'],$bal);
					
					if(!$resultat_unscribebounce)
						$resultat_unscribebounce+=$unscribebounce->chercher($part[$m]['body'],array('CORPS'));
				}
				
				if($resultat_unscribebounce)
				{
					$email=array_unique($email);
					$email=array_values($email);
					
					for($i=0;$i<sizeof($email);$i++)
					{
						$objet=new ld_adherent();
						$objet->email=$email[$i];
						if($objet->lire('email'))
						{
							$objet->abonne='NON';
							$objet->modifier();
							
							$desabonnement++;
							
							imap_delete($imap,$j);
						}
					}
				}
				
				if($j==$total || $lecture==$preference->desabonnement_nettoyage_mail_par_boucle || $j%MESSAGE_REPEAT==0)
				{
					ecrire_div('desabonnement_lecture_'.$boucle.'','Lecture: '.$lecture);
					ecrire_div('desabonnement_'.$boucle.'','Désabonnement: '.$desabonnement);
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
		
		usleep($preference->desabonnement_nettoyage_pause);
			
		print('<br />'.str_repeat(' ',STR_REPEAT));
		flush();
		
		$boucle++;
	}
?>
</body>
</html>