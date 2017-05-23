<?php
	define('DEFERRED_REVEIL',1800);	
	define('DEFERRED_SOMMEIL',1);	
	
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
	
	define('PWD_SPOOL_INCOMING',$_SERVER['DOCUMENT_ROOT'].'/spool/incoming');
	define('PWD_SPOOL_DEFERRED',$_SERVER['DOCUMENT_ROOT'].'/spool/deferred');
	define('PWD_LOG',$_SERVER['DOCUMENT_ROOT'].'/log/pige'.date('Y-m-d').'.log');
	
	define('TAB',"\t");
	define('CRLF',"\r\n");
	define('CR',"\r");
	define('LF',"\n");
	
	while(1)
	{
		$fichier=scandir(PWD_SPOOL_DEFERRED);
		for($i=2;$i<sizeof($fichier);$i++)
		{
			if(filemtime(PWD_SPOOL_DEFERRED.'/'.$fichier[$i])>time()-DEFERRED_REVEIL)
				sleep(filemtime(PWD_SPOOL_DEFERRED.'/'.$fichier[$i])-(time()-DEFERRED_REVEIL));
			
			copy(PWD_SPOOL_DEFERRED.'/'.$fichier[$i],PWD_SPOOL_INCOMING.'/'.$fichier[$i]);
			unlink(PWD_SPOOL_DEFERRED.'/'.$fichier[$i]);
			
			file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'remise.php'.TAB.$fichier[$i].TAB.'Notice'.TAB.'deferred -> incoming'.CRLF,FILE_APPEND);
		}
		
		if($i==2)
			sleep(DEFERRED_SOMMEIL);
	}
?>