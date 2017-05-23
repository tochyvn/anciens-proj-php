<?php
	define('FILE_SOMMEIL',1);
	
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
	{
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
		if(!isset($argv[1])) die();
		if(!isset($argv[2])) die();
		$_REQUEST['dossier']=$argv[1];
		$_REQUEST['pause']=$argv[2];
	}
	
	define('PWD_PHP','/usr/bin/php');
	define('PWD_BIN',$_SERVER['DOCUMENT_ROOT'].'/bin');
	define('PWD_SPOOL_ACTIVE',$_SERVER['DOCUMENT_ROOT'].'/spool/active');
	define('PWD_SPOOL_FILE',$_SERVER['DOCUMENT_ROOT'].'/spool/file');
	define('PWD_SPOOL_INCOMING',$_SERVER['DOCUMENT_ROOT'].'/spool/incoming');
	define('PWD_LOG',$_SERVER['DOCUMENT_ROOT'].'/log/pige'.date('Y-m-d').'.log');
	
	define('TAB',"\t");
	define('CRLF',"\r\n");
	define('CR',"\r");
	define('LF',"\n");
	
	if(!isset($_REQUEST['dossier']) || !is_dir(PWD_SPOOL_FILE.'/'.$_REQUEST['dossier']))
		die();
	
	if(!isset($_REQUEST['pause']) || !preg_match('/^[0-9]+$/',$_REQUEST['pause']))
		die();
	
	while(1)
	{
		$fichier=scandir(PWD_SPOOL_FILE.'/'.$_REQUEST['dossier']);
		
		for($i=2;$i<sizeof($fichier);$i++)
		{
			copy(PWD_SPOOL_FILE.'/'.$_REQUEST['dossier'].'/'.$fichier[$i],PWD_SPOOL_ACTIVE.'/'.$fichier[$i]);
			unlink(PWD_SPOOL_FILE.'/'.$_REQUEST['dossier'].'/'.$fichier[$i]);
			
			file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'traitement.php'.TAB.$fichier[$i].TAB.'Notice'.TAB.'file/'.$_REQUEST['dossier'] .' -> active::navigation'.CRLF,FILE_APPEND);
			
			//pclose(popen(PWD_PHP.' -f '.PWD_BIN.'/navigation.php '.$fichier[$i].' > /dev/null &','r'));
			exec(PWD_PHP.' -f '.PWD_BIN.'/navigation.php '.$fichier[$i]);
			
			usleep($_REQUEST['pause']);
		}
		
		if($i==2)
			sleep(FILE_SOMMEIL);
	}
?>