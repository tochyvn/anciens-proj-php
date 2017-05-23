<?php
	require_once(PWD_INCLUSION.'string.php');
	
	$url=parse_url($_REQUEST['url']);
	$base=$url['scheme'].'://'.$url['host'];
	
	$header=array();
	if(isset($_SERVER['HTTP_ACCEPT'])) $header[]='Accept: '.$_SERVER['HTTP_ACCEPT'];
	if(isset($_SERVER['HTTP_ACCEPT_CHARSET'])) $header[]='Accept-Charset: '.$_SERVER['HTTP_ACCEPT_CHARSET'];
	//if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])) $header[]='Accept-Encoding: '.$_SERVER['HTTP_ACCEPT_ENCODING'];
	if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) $header[]='Accept-Language: '.$_SERVER['HTTP_ACCEPT_LANGUAGE'];
	//if(isset($_SERVER['HTTP_CONNECTION'])) $header[]='Connection: '.$_SERVER['HTTP_CONNECTION'];
	$header[]='Connection: Close';
	if(isset($_SERVER['HTTP_ACCEPT'])) $header[]='User-Agent: '.$_SERVER['HTTP_ACCEPT'];
	
	$socket=curl_init();
	curl_setopt($socket,CURLOPT_URL,$_REQUEST['url']);
	curl_setopt($socket,CURLOPT_HTTPHEADER,$header);
	curl_setopt($socket,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($socket,CURLOPT_HEADER,true);
	if(!isset($entete['cookie'])) $entete['cookie']=uniqid();
	curl_setopt($socket,CURLOPT_COOKIEFILE,PWD_INCLUSION.'prive/temp/'.$entete['cookie']);
	curl_setopt($socket,CURLOPT_COOKIEJAR,PWD_INCLUSION.'prive/temp/'.$entete['cookie']);
	//curl_setopt($socket,CURLOPT_CONNECTTIMEOUT,30);
	//curl_setopt($socket,CURLOPT_TIMEOUT,30;
	curl_setopt($socket,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($socket,CURLOPT_AUTOREFERER,true);
	$resultat=curl_exec($socket);
	
	$separateur=strpos($resultat,CRLF.CRLF);
	$entete=explode(CRLF,substr($resultat,0,$separateur));
	$corps=substr($resultat,$separateur+4);
	//$corps=str_ireplace('</head>','<base href="'.$base.'">'.CRLF.'</head>',$corps);
	
	for($i=0;$i<sizeof($entete);$i++) if(stripos($entete[$i],'Content-type: ')===0) header($entete[$i]);
	echo $corps;
?>