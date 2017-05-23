<?php
	define('DEFERRED_MAX',5);
	
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
	{
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
		if(!isset($argv[1])) die();
		$_REQUEST['fichier']=$argv[1];
	}
	
	define('PWD_ETC',$_SERVER['DOCUMENT_ROOT'].'/etc');
	define('PWD_SPOOL_ACTIVE',$_SERVER['DOCUMENT_ROOT'].'/spool/active');
	define('PWD_COOKIE',$_SERVER['DOCUMENT_ROOT'].'/cookie');
	define('PWD_SPOOL_CORRUPT',$_SERVER['DOCUMENT_ROOT'].'/spool/corrupt');
	define('PWD_SPOOL_DEFERRED',$_SERVER['DOCUMENT_ROOT'].'/spool/deferred');
	define('PWD_SPOOL_INCOMING',$_SERVER['DOCUMENT_ROOT'].'/spool/incoming');
	define('PWD_SPOOL_OLD',$_SERVER['DOCUMENT_ROOT'].'/spool/old');
	define('PWD_LOG',$_SERVER['DOCUMENT_ROOT'].'/log/pige'.date('Y-m-d').'.log');
	define('PWD_TMP',$_SERVER['DOCUMENT_ROOT'].'/tmp');
	
	define('TAB',"\t");
	define('CRLF',"\r\n");
	define('CR',"\r");
	define('LF',"\n");
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/bin/function.php');
	
	function decouper(&$entete,&$corps,$fichier)
	{
		list($temp,$corps)=explode('<!-- gdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdf864654654564564897 -->',preg_replace('/\r\n\r\n/','<!-- gdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdf864654654564564897 -->',file_get_contents($fichier),1));
		$temp=explode(CRLF,$temp);
		
		$entete=array();
		for($i=0;$i<sizeof($temp);$i++)
		{
			if(!preg_match('/^([^=]+)=(.+)/',$temp[$i],$resultat))
				return false;
			
			$entete[$resultat[1]]=$resultat[2];
		}
		
		if(!isset($entete['spool']) || !is_file(PWD_ETC.'/'.$entete['spool']))
			return false;
		if(!isset($entete['etape']) || $entete['etape']!='navigation')
			return false;
		if(!isset($entete['rang']))
			return false;
		if(!isset($entete['deferred']))
			return false;
		if(!isset($entete['profondeur']))
			return false;
		if(!isset($entete['location']))
			return false;
		
		return true;
	}
	
	function expressionner($xml)
	{
		$tableau=array();
		$tableau['expression']='';
		$tableau['option']='';
		$tableau['remplacement']='$1';
		$tableau['recherche']='ENFANT';
		$tableau['limite']=1;
		$tableau['filtre']=array();
		
		$noeuds=$xml->childNodes;
		for($i=0;$i<$noeuds->length;$i++)
		{
			$noeud=$noeuds->item($i);
			if(preg_match('/^(expression|option|remplacement|recherche|limite)$/',$noeud->nodeName))
				$tableau[$noeud->nodeName]=$noeud->nodeValue;
		}
		
		$noeuds=$xml->getElementsByTagName('filtre');
		for($i=0;$i<$noeuds->length;$i++)
		{
			$noeud=$noeuds->item($i);
			$tableau['filtre'][]=expressionner($noeud);
		}
		
		return $tableau;
	}
	
	if(!isset($_REQUEST['fichier']) || !is_file(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']))
		die();
	
	if(!decouper($entete,$document_html,PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']))
	{
		copy(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier'],PWD_SPOOL_CORRUPT.'/'.$_REQUEST['fichier']);
		unlink(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']);
		
		file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'navigation.php'.TAB.$_REQUEST['fichier'].TAB.'Notice'.TAB.'active::navigation -> corrupt'.CRLF,FILE_APPEND);
		
		die();
	}
	
	$document_xml=new DOMDocument();
	$document_xml->load(PWD_ETC.'/'.$entete['spool']);
	
	$navigation_xml=$document_xml->getElementsByTagName('navigation')->item(0);
	$rang_xml=$navigation_xml->getElementsByTagName('rang')->item($entete['rang']);
	
	$noeuds_xml=$navigation_xml->getElementsByTagName('user_agent');
	if($noeuds_xml->length)
		$user_agent=$noeuds_xml->item(0)->nodeValue;
	else
		$user_agent='Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.9.1.8) Gecko/20100202 Firefox/3.5.8 (.NET CLR 3.5.30729)';
	
	$socket=curl_init();
	curl_setopt($socket,CURLOPT_URL,html_entity_decode($entete['location']));
	curl_setopt($socket,CURLOPT_HTTPHEADER,array
		(
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8 ',
			'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
			'Accept-Language: fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3',
			'Connection: close',
			'User-Agent: '.$user_agent
		));
	curl_setopt($socket,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($socket,CURLOPT_HEADER,true);
	
	if(!isset($entete['cookie'])) $entete['cookie']=uniqid('',true);
	
	$noeuds_xml=$navigation_xml->getElementsByTagName('cookie');
	if(!$noeuds_xml->length || $noeuds_xml->item(0)->nodeValue!=0)
	{
		curl_setopt($socket,CURLOPT_COOKIEFILE,PWD_COOKIE.'/'.$entete['cookie']);
		curl_setopt($socket,CURLOPT_COOKIEJAR,PWD_COOKIE.'/'.$entete['cookie']);
	}
	
	$noeuds_xml=$navigation_xml->getElementsByTagName('timeout');
	if($noeuds_xml->length)
	{
		curl_setopt($socket,CURLOPT_CONNECTTIMEOUT,$noeuds_xml->item(0)->nodeValue);
		curl_setopt($socket,CURLOPT_TIMEOUT,$noeuds_xml->item(0)->nodeValue);
	}
	curl_setopt($socket,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($socket,CURLOPT_AUTOREFERER,true);
	$document_html=curl_exec($socket);
	
	if($document_html===false)
	{
		if($entete['deferred']+1<DEFERRED_MAX)
		{
			$uniqid=uniqid('',true);
			$fichier=fopen(PWD_SPOOL_DEFERRED.'/'.$uniqid,'w');
			fputs($fichier,'spool='.$entete['spool'].CRLF);
			fputs($fichier,'etape=navigation'.CRLF);
			fputs($fichier,'rang='.$entete['rang'].CRLF);
			fputs($fichier,'deferred='.($entete['deferred']+1).CRLF);
			fputs($fichier,'profondeur='.$entete['profondeur'].CRLF);
			fputs($fichier,'location='.$entete['location'].CRLF);
			fputs($fichier,'cookie='.$entete['cookie'].CRLF);
			fputs($fichier,CRLF);
			fputs($fichier,'a');
			fclose($fichier);
		
			print($uniqid.CRLF);
			
			file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'navigation.php'.TAB.$uniqid.TAB.'Notice'.TAB.'active::navigation -> deferred'.CRLF,FILE_APPEND);
		}
		else
		{
			copy(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier'],PWD_SPOOL_OLD.'/'.$_REQUEST['fichier']);
					
			file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'navigation.php'.TAB.$_REQUEST['fichier'].TAB.'Notice'.TAB.'active::navigation -> old'.CRLF,FILE_APPEND);
		}
		
		unlink(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']);
		die('NAV1');
	}
	
	//$document_html=str_replace('€','&euro;',$document_html);
	//$document_html=str_replace(utf8_encode('€'),'&euro;',$document_html);
	
	$noeuds_xml=$navigation_xml->getElementsByTagName('utf8');

	$utf8=false;
	if($noeuds_xml->length)
	{
		if($noeuds_xml->item(0)->nodeValue!='0')
			$utf8=true;
	}
	else
	{
		switch(preg_replace('/^([a-z\/-]+).+$/i','$1',strtolower(curl_getinfo($socket,CURLINFO_CONTENT_TYPE))))
		{
			case 'text/html':
				if(preg_match('/<meta[^>]+content-type/i',$document_html) && !preg_match('/<meta[^>]+content-type[^>]+(ISO-8859-1|windows-1252)/i',$document_html))
					$utf8=true;
				if(!preg_match('/<meta[^>]+content-type/i',$document_html) && !preg_match('/content-type[^\n]+(ISO-8859-1|windows-1252)/i',$document_html))
					$utf8=true;
				break;
			case 'text/xml':
				if(!preg_match('/<\?xml[^>]+encoding[^>]+(ISO-8859-1|windows-1252)/i',$document_html))
					$utf8=true;
				break;
		}
	}
	
	if($utf8)
	{
		$document_html=str_replace(chr(0xE2).chr(0x82).chr(0xAC),'&aicom_euro;',$document_html);
		$document_html=utf8_decode($document_html);
		$document_html=str_replace('&aicom_euro;',chr(0x80),$document_html);
		//print('<pre>'.htmlentities($document_html).'</pre>');
		//die();
	}
	
	$entete['location']=curl_getinfo($socket,CURLINFO_EFFECTIVE_URL);
	//echo '<pre>'.htmlentities($document_html).'</pre>aaa';
	curl_close($socket);
	
	//CONTINUER_SUR
	$continuer_surs_xml=$rang_xml->getElementsByTagName('continuer_sur');
	if($continuer_surs_xml->length)
	{
		$continuer_sur_xml=$continuer_surs_xml->item(0);
		$continuer_sur_resultat=eval($continuer_sur_xml->nodeValue);
	}
	else
		$continuer_sur_resultat=true;
	
	if($continuer_sur_resultat)
	{
		//A_CAPTURER
		$a_capturers_xml=$rang_xml->getElementsByTagName('a_capturer');
		$i=0;
		if($a_capturers_xml->length)
		//for($i=0;$i<$a_capturers_xml->length;$i++)
		{
			$a_capturer_xml=$a_capturers_xml->item($i);
			$a_capturer_expression=expressionner($a_capturer_xml);
			
			if(preg_match_all('/'.$a_capturer_expression['expression'].'/'.$a_capturer_expression['option'],$document_html,$a_capturer_html))
			{
				for($j=0;$j<sizeof($a_capturer_html[0]) && $j<$a_capturer_expression['limite'];$j++)
				{
					$bloc_html=preg_replace('/'.$a_capturer_expression['expression'].'/'.$a_capturer_expression['option'],$a_capturer_expression['remplacement'],$a_capturer_html[0][$j]);
					
					$uniqid=uniqid('',true);
					$fichier=fopen(PWD_SPOOL_INCOMING.'/'.$uniqid,'w');
					fputs($fichier,'spool='.$entete['spool'].CRLF);
					fputs($fichier,'etape=capture'.CRLF);
					fputs($fichier,'location='.$entete['location'].CRLF);
					fputs($fichier,CRLF);
					fputs($fichier,$bloc_html);
					fclose($fichier);
					
					//file_put_contents(PWD_TMP.'/'.$uniqid,$bloc_html);
			
					print($uniqid.CRLF);
					
					file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'navigation.php'.TAB.$uniqid.TAB.'Notice'.TAB.'active::navigation::a_capturer::'.$i.' -> incoming'.CRLF,FILE_APPEND);
				}
			}
		}
		
		if($entete['profondeur']+1<$navigation_xml->getElementsByTagName('profondeur')->item(0)->nodeValue)
		{
			//A_SUIVRE
			$a_suivres_xml=$rang_xml->getElementsByTagName('a_suivre');
			//$i=0;
			//if($a_suivres_xml->length)
			for($i=0;$i<$a_suivres_xml->length;$i++)
			{
				$a_suivre_xml=$a_suivres_xml->item($i);
				$a_suivre_expression=expressionner($a_suivre_xml);
				
				if(preg_match_all('/'.$a_suivre_expression['expression'].'/'.$a_suivre_expression['option'],$document_html,$a_suivre_html))
				{
					for($j=0;$j<sizeof($a_suivre_html[0]) && $j<$a_suivre_expression['limite'];$j++)
					{
						$lien_html=preg_replace('/'.$a_suivre_expression['expression'].'/'.$a_suivre_expression['option'],$a_suivre_expression['remplacement'],$a_suivre_html[0][$j]);
						
						$uniqid=uniqid('',true);
						$fichier=fopen(PWD_SPOOL_INCOMING.'/'.$uniqid,'w');
						fputs($fichier,'spool='.$entete['spool'].CRLF);
						fputs($fichier,'etape=navigation'.CRLF);
						fputs($fichier,'rang='.$a_suivre_xml->getElementsByTagName('suivant')->item(0)->nodeValue.CRLF);
						fputs($fichier,'deferred=0'.CRLF);
						fputs($fichier,'profondeur='.($entete['profondeur']+1).CRLF);
						fputs($fichier,'location='.html_entity_decode($lien_html).CRLF);
						fputs($fichier,'cookie='.$entete['cookie'].CRLF);
						fputs($fichier,CRLF);
						fputs($fichier,'a');
						fclose($fichier);
						
						print($uniqid.CRLF);
						
						file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'navigation.php'.TAB.$uniqid.TAB.'Notice'.TAB.'active::navigation::a_suivre::'.$i.'::'.$lien_html.' -> incoming'.CRLF,FILE_APPEND);
					}
				}
			}
		}
	}
	
	unlink(PWD_SPOOL_ACTIVE.'/'.$_REQUEST['fichier']);
?>