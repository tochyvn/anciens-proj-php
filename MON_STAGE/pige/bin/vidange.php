<?php
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
	{
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
		if(!isset($argv[1])) die();
		$_REQUEST['mode']=$argv[1];
	}
	
	define('PWD_SPOOL_ACTIVE',$_SERVER['DOCUMENT_ROOT'].'/spool/active');
	define('PWD_COOKIE',$_SERVER['DOCUMENT_ROOT'].'/cookie');
	define('PWD_SPOOL_CORRUPT',$_SERVER['DOCUMENT_ROOT'].'/spool/corrupt');
	define('PWD_SPOOL_DEFERRED',$_SERVER['DOCUMENT_ROOT'].'/spool/deferred');
	define('PWD_SPOOL_FILE',$_SERVER['DOCUMENT_ROOT'].'/spool/file');
	define('PWD_SPOOL_INCOMING',$_SERVER['DOCUMENT_ROOT'].'/spool/incoming');
	define('PWD_SPOOL_OLD',$_SERVER['DOCUMENT_ROOT'].'/spool/old');
	define('PWD_LOG',$_SERVER['DOCUMENT_ROOT'].'/log/pige'.date('Y-m-d').'.log');
	
	define('TAB',"\t");
	define('CRLF',"\r\n");
	define('CR',"\r");
	define('LF',"\n");
	
	$valeur=explode(',',$_REQUEST['mode']);
	if(array_search('active',$valeur)!==false || array_search('ALL',$valeur)!==false){exec('rm -Rf '.PWD_SPOOL_ACTIVE.'/*'); file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'vidange.php'.TAB.'Global'.TAB.'Notice'.TAB.'Vidange de active'.CRLF,FILE_APPEND);}
	if(array_search('cookie',$valeur)!==false || array_search('ALL',$valeur)!==false){exec('rm -Rf '.PWD_COOKIE.'/*'); file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'vidange.php'.TAB.'Global'.TAB.'Notice'.TAB.'Vidange des cookies'.CRLF,FILE_APPEND);}
	if(array_search('corrupt',$valeur)!==false || array_search('ALL',$valeur)!==false){exec('rm -Rf '.PWD_SPOOL_CORRUPT.'/*'); file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'vidange.php'.TAB.'Global'.TAB.'Notice'.TAB.'Vidange de corrupt'.CRLF,FILE_APPEND);}
	if(array_search('deferred',$valeur)!==false || array_search('ALL',$valeur)!==false){exec('rm -Rf '.PWD_SPOOL_DEFERRED.'/*'); file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'vidange.php'.TAB.'Global'.TAB.'Notice'.TAB.'Vidange de deferred'.CRLF,FILE_APPEND);}
	if(array_search('file',$valeur)!==false || array_search('ALL',$valeur)!==false){exec('rm -Rf '.PWD_SPOOL_FILE.'/*'); file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'vidange.php'.TAB.'Global'.TAB.'Notice'.TAB.'Vidange de file'.CRLF,FILE_APPEND);}
	if(array_search('incoming',$valeur) || array_search('ALL',$valeur)!==false){exec('rm -Rf '.PWD_SPOOL_INCOMING.'/*'); file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'vidange.php'.TAB.'Global'.TAB.'Notice'.TAB.'Vidange de incoming'.CRLF,FILE_APPEND);}
	if(array_search('old',$valeur)!==false || array_search('ALL',$valeur)!==false){exec('rm -Rf '.PWD_SPOOL_OLD.'/*'); file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'vidange.php'.TAB.'Global'.TAB.'Notice'.TAB.'Vidange de old'.CRLF,FILE_APPEND);}
?>