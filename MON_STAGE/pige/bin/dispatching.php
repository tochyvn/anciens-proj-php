<?php
        // 14/08/14 
        // ajout du set_time_limit suite plantage de la pige
        set_time_limit(0);
        
        // 18/08/14
        // modification  
        // Afficher les erreurs et les avertissements
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        // Enregistrer les erreurs dans un fichier de log
        ini_set('log_errors', 1);
        // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
        ini_set('error_log', dirname(__file__) . '/log/log_error_php.log');
	
	define('INCOMING_SOMMEIL',1);
	
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT']=='')
		$_SERVER['DOCUMENT_ROOT']='/var/www/vhost/aicom/pige.aicom.fr';
	
	define('PWD_PHP','/usr/bin/php');
	define('PWD_BIN',$_SERVER['DOCUMENT_ROOT'].'/bin');
	define('PWD_ETC',$_SERVER['DOCUMENT_ROOT'].'/etc');
	define('PWD_SPOOL_ACTIVE',$_SERVER['DOCUMENT_ROOT'].'/spool/active');
	define('PWD_SPOOL_CORRUPT',$_SERVER['DOCUMENT_ROOT'].'/spool/corrupt');
	define('PWD_SPOOL_INCOMING',$_SERVER['DOCUMENT_ROOT'].'/spool/incoming');
	define('PWD_SPOOL_FILE',$_SERVER['DOCUMENT_ROOT'].'/spool/file');
	define('PWD_LOG',$_SERVER['DOCUMENT_ROOT'].'/log/pige'.date('Y-m-d').'.log');
	
	define('TAB',"\t");
	define('CRLF',"\r\n");
	define('CR',"\r");
	define('LF',"\n");
	
	// fonction de decoupage des fichiers temporaires de navigation ? 
	// envoi true ou false
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
		if(!isset($entete['etape']))
			return false;
		
		return true;
	}
	
	// lancement de remise remise.php avant d'entrer dans la boucle infini
	pclose(popen(PWD_PHP.' -f '.PWD_BIN.'/remise.php > /dev/null &','r'));
	$spool_exec=array();
	
	file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'dispatching.php'.TAB.'Global'.TAB.'Notice'.TAB.'Lancement de remise.php'.CRLF,FILE_APPEND);
	
	while(1)
	{
		// on lit tout les fichiers du dossier incoming
		$fichier=scandir(PWD_SPOOL_INCOMING);
		// sauf . et .. ( $i = 2 )
		for($i=2;$i<sizeof($fichier);$i++) 
		{
			if(!decouper($entete,$document_spool,PWD_SPOOL_INCOMING.'/'.$fichier[$i]))
			{
				// les fichiers sont corropus ? 
				// suppression des fichiers et copies dans le dossiers corrupt
				copy(PWD_SPOOL_INCOMING.'/'.$fichier[$i],PWD_SPOOL_CORRUPT.'/'.$fichier[$i]);
				unlink(PWD_SPOOL_INCOMING.'/'.$fichier[$i]);
				
				file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'navigation.php'.TAB.$fichier[$i].TAB.'Notice'.TAB.'incoming -> corrupt'.CRLF,FILE_APPEND);
			}
			else
			{
				if($entete['etape']=='capture')
				{
					copy(PWD_SPOOL_INCOMING.'/'.$fichier[$i],PWD_SPOOL_ACTIVE.'/'.$fichier[$i]);
					unlink(PWD_SPOOL_INCOMING.'/'.$fichier[$i]);
					
					file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'dispatching.php'.TAB.$fichier[$i].TAB.'Notice'.TAB.'incoming -> active::capture'.CRLF,FILE_APPEND);
					
					pclose(popen(PWD_PHP.' -f '.PWD_BIN.'/capture.php '.$fichier[$i].' > /dev/null &','r'));
				}
				
				if($entete['etape']=='navigation')
				{
					if(!array_key_exists($entete['spool'],$spool_exec))
					{
						$document_xml=new DOMDocument();
						$document_xml->load(PWD_ETC.'/'.$entete['spool']);
						
						$navigation_xml=$document_xml->getElementsByTagName('navigation')->item(0);
						
						$pause=$navigation_xml->getElementsByTagName('pause')->item(0)->nodeValue;
						$thread=$navigation_xml->getElementsByTagName('thread')->item(0)->nodeValue;
						
						for($j=0;$j<$thread;$j++)
						{
							if(!is_dir(PWD_SPOOL_FILE.'/'.$entete['spool']))
								mkdir(PWD_SPOOL_FILE.'/'.$entete['spool']);
							
							if(!is_dir(PWD_SPOOL_FILE.'/'.$entete['spool'].'/'.$j))
								mkdir(PWD_SPOOL_FILE.'/'.$entete['spool'].'/'.$j);
							
							pclose(popen(PWD_PHP.' -f '.PWD_BIN.'/traitement.php '.$entete['spool'].'/'.$j.' '.$pause.' > /dev/null &','r'));
						}
						
						$spool_exec[$entete['spool']]['nombre']=0;
						$spool_exec[$entete['spool']]['thread']=$thread;
					}
					
					copy(PWD_SPOOL_INCOMING.'/'.$fichier[$i],PWD_SPOOL_FILE.'/'.$entete['spool'].'/'.($spool_exec[$entete['spool']]['nombre']%$spool_exec[$entete['spool']]['thread']).'/'.$fichier[$i]);
					unlink(PWD_SPOOL_INCOMING.'/'.$fichier[$i]);
	
					file_put_contents(PWD_LOG,date('Y-m-d H:i:s').TAB.'dispatching.php'.TAB.$fichier[$i].TAB.'Notice'.TAB.'incoming -> file/'.$entete['spool'].'/'.($spool_exec[$entete['spool']]['nombre']%$spool_exec[$entete['spool']]['thread']).CRLF,FILE_APPEND);
					
					$spool_exec[$entete['spool']]['nombre']++;
				}
			}
		}
		// si aucun fichiers à traiter dans le dossier incomong il fait dodo
		if($i==2)
			sleep(INCOMING_SOMMEIL);
	}
?>