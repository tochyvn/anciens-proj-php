<?php
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
	{
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
		if(!isset($argv[1])) die();
		$_REQUEST['fichier']=$argv[1];
	}
	
	define('PWD_DOWNLOAD',$_SERVER['DOCUMENT_ROOT'].'/download');
	define('PWD_ETC',$_SERVER['DOCUMENT_ROOT'].'/etc');
	define('PWD_LOG',$_SERVER['DOCUMENT_ROOT'].'/log/pige'.date('Y-m-d').'.log');
	
	define('TAB',"\t");
	define('CRLF',"\r\n");
	define('CR',"\r");
	define('LF',"\n");
	
	if(!isset($_REQUEST['fichier']) || !is_file(PWD_ETC.'/'.$_REQUEST['fichier']))
		die();
	
	$xml=new DOMDocument();
	$xml->load(PWD_ETC.'/'.$_REQUEST['fichier']);
	
	$parents=$xml->getElementsByTagName('url');
	
	for($i=0;$i<$parents->length;$i++)
	{
		$parent=$parents->item($i);
		
		$enfants=$parent->getElementsByTagName('source');
		$source=$enfants->item(0)->nodeValue;
		
		$enfants=$parent->getElementsByTagName('destination');
		$destination=$enfants->item(0)->nodeValue;
		
		if(file_put_contents(PWD_DOWNLOAD.'/'.$destination,file_get_contents($source)))
			file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'download.php'.TAB.'Global'.TAB.'Notice'.TAB.'Download de '.$source.CRLF,FILE_APPEND);
		else
			file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'download.php'.TAB.'Global'.TAB.'Warning'.TAB.'Download impossible de '.$source.CRLF,FILE_APPEND);
	}
?>