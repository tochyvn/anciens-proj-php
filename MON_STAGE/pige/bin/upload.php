<?php
	
	// 18/08/14
        // modification  
        // Afficher les erreurs et les avertissements
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        // Enregistrer les erreurs dans un fichier de log
        ini_set('log_errors', 1);
        // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
        ini_set('error_log', dirname(__file__) . '/log/log_error_php.log');	

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
	
        include_once(dirname(__FILE__).'/function.php');
        
	if(!isset($_REQUEST['fichier']) || !is_file(PWD_ETC.'/'.$_REQUEST['fichier']))
		die();
	
	$xml = new DOMDocument();
	$xml->load( PWD_ETC.'/'.$_REQUEST['fichier'] );
	
	$parents=$xml->getElementsByTagName('url');
	
	for($i=0;$i<$parents->length;$i++)
	{
		$parent=$parents->item($i);
		
		$enfants = $parent->getElementsByTagName('source');
		$source = $enfants->item(0)->nodeValue;
		
		$enfants = $parent->getElementsByTagName('destination');
                //Analyse de l'url et retour de tout ses elements sous forme de tableau associatif
		$destination = parse_url($enfants->item(0)->nodeValue);
		//S'il existe des fichier dans le dossier et
		if(file_exists(PWD_UPLOAD.'/'.$source) && $socket = ftp_connect($destination['host']) )
		{
                        //transfert des fichiers de serveur en serveur 
			$login_result = ftp_login($socket, $destination['user'], urldecode($destination['pass']));
                        
                        if($login_result == false){
                            log_ftp_error_login($destination['host']);
                            file_put_contents(PWD_LOG, date('Y-m-d H:i:s').TAB.'upload.php'.TAB.'Global'.TAB.'Warning'.TAB.'Connexion impossible sur '.$destination['host'].CRLF,FILE_APPEND);
                        }
                        
			$put_result = ftp_put($socket, $destination['path'], PWD_UPLOAD.'/'.$source, FTP_BINARY);
                        
                        if($put_result == false){
                            log_ftp_error_put($destination['path'], PWD_UPLOAD.'/'.$source, $destination['host']);
                            file_put_contents(PWD_LOG, date('Y-m-d H:i:s').TAB.'upload.php'.TAB.'Global'.TAB.'Warning'.TAB.'Upload impossible de '.$source.CRLF,FILE_APPEND);
                        }
                       
			ftp_close($socket);
			
			file_put_contents(PWD_LOG, date('Y-m-d H:i:s').TAB.'upload.php'.TAB.'Global'.TAB.'Notice'.TAB.'Upload de '.$source.CRLF,FILE_APPEND);
		}
		else{
                    file_put_contents(PWD_LOG, date('Y-m-d H:i:s').TAB.'upload.php'.TAB.'Global'.TAB.'Warning'.TAB.'Upload impossible de '.$source.CRLF,FILE_APPEND);
                }
	}
?>