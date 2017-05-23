<?php

	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
	{
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
		if(!isset($argv[1])) die();
		$_REQUEST['fichier']=$argv[1];
	}
	
	define('PWD_ETC',$_SERVER['DOCUMENT_ROOT'].'/etc');
	define('PWD_SPOOL_INCOMING',$_SERVER['DOCUMENT_ROOT'].'/spool/incoming');
	define('PWD_LOG',$_SERVER['DOCUMENT_ROOT'].'/log/pige'.date('Y-m-d').'.log');
	define('PWD_UPLOAD',$_SERVER['DOCUMENT_ROOT'].'/upload');
	
	define('TAB',"\t");
	define('CRLF',"\r\n");
	define('CR',"\r");
	define('LF',"\n");
	
	if(!isset($_REQUEST['fichier']) || !is_file(PWD_ETC.'/'.$_REQUEST['fichier']))
		die();
	
	$document=new DOMDocument();
	$document->load(PWD_ETC.'/'.$_REQUEST['fichier']);
	
	$capture=$document->getElementsByTagName('capture')->item(0);
	$destination=$capture->getElementsByTagName('destination')->item(0)->nodeValue;
	
	$fichier=fopen(PWD_UPLOAD.'/'.$destination,'a');
	fputs($fichier,'');
	fclose($fichier);
	
	$initialisation=$document->getElementsByTagName('initialisation')->item(0);
	$url=$initialisation->getElementsByTagName('url')->item(0)->nodeValue;
	$parametres=$initialisation->getElementsByTagName('parametre');
	
	$urls[0][0]=$url;
	for($i=0;$i<$parametres->length;$i++)
	{
		$parametre=$parametres->item($i);
		$valeurs=$parametre->getElementsByTagName('valeur');
		for($j=0,$l=sizeof($urls)-1;$j<$valeurs->length;$j++)
		{
			$valeur=$valeurs->item($j)->nodeValue;
			for($k=0;$k<sizeof($urls[$l]);$k++)
				$urls[$l+1][]=str_replace(':parametre'.($l+1).':',$valeur,$urls[$l][$k]);
		}
	}
	
	for($i=0,$j=sizeof($urls)-1;$i<sizeof($urls[$j]);$i++)
	{
		$uniqid=uniqid('',true);
		$fichier=fopen(PWD_SPOOL_INCOMING.'/'.$uniqid,'w');
		fputs($fichier,'spool='.$_REQUEST['fichier'].CRLF);
		fputs($fichier,'etape=navigation'.CRLF);
		fputs($fichier,'rang=0'.CRLF);
		fputs($fichier,'deferred=0'.CRLF);
		fputs($fichier,'profondeur=0'.CRLF);
		fputs($fichier,'location='.$urls[$j][$i].CRLF);
		fputs($fichier,CRLF);
		fputs($fichier,'a');
		fclose($fichier);
		
		print($uniqid.CRLF);
		
		file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'initialisation.php'.TAB.$uniqid.TAB.'Notice'.TAB.'initialisation::'.$urls[$j][$i].' -> incoming'.CRLF,FILE_APPEND);
	}
?>