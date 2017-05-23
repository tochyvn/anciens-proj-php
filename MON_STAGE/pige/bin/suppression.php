<?php
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
	{
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
		if(!isset($argv[1])) die();
		$_REQUEST['fichier']=$argv[1];
	}
	
	define('PWD_UPLOAD',$_SERVER['DOCUMENT_ROOT'].'/upload');
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
	
	$noeuds=$xml->getElementsByTagName('fichier');
	
	for($i=0;$i<$noeuds->length;$i++)
	{
		if(file_exists(PWD_UPLOAD.'/'.$noeuds->item($i)->nodeValue))
		{
			unlink(PWD_UPLOAD.'/'.$noeuds->item($i)->nodeValue);
			
			file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'suppression.php'.TAB.'Global'.TAB.'Notice'.TAB.'Suppression de '.$noeuds->item($i)->nodeValue.CRLF,FILE_APPEND);
		}
		else
			file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'suppression.php'.TAB.'Global'.TAB.'Warning'.TAB.'Suppression impossible de '.$noeuds->item($i)->nodeValue.CRLF,FILE_APPEND);
	}
?>