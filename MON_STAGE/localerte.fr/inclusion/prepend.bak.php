<?php
	if(strrpos($_SERVER['DOCUMENT_ROOT'],'/')!=strlen($_SERVER['DOCUMENT_ROOT'])-3)
		$_SERVER['DOCUMENT_ROOT'].='/';
	
	define('PWD_ADHERENT',$_SERVER['DOCUMENT_ROOT'].'adherent/');
	define('PWD_ADHERENT_TEST',$_SERVER['DOCUMENT_ROOT'].'adherent_test/');
	define('PWD_ADHERENT_V2',$_SERVER['DOCUMENT_ROOT'].'adherent_v2/');
	define('PWD_ADHERENT_V2_5',$_SERVER['DOCUMENT_ROOT'].'adherent_v2.5/');
	define('PWD_ADMINISTRATION',$_SERVER['DOCUMENT_ROOT'].'administration/');
	define('PWD_DOCUMENT',$_SERVER['DOCUMENT_ROOT'].'document/');
	define('PWD_INCLUSION',$_SERVER['DOCUMENT_ROOT'].'inclusion/');
	define('PWD_PUBLIC',$_SERVER['DOCUMENT_ROOT'].'public/');
	define('PWD_REF',$_SERVER['DOCUMENT_ROOT'].'ref/');
	
	define('URL_ADHERENT','/adherent/');
	define('URL_ADHERENT_TEST','/adherent_test/');
	define('URL_ADHERENT_V2','/adherent_v2/');
	define('URL_ADHERENT_V2_5','/adherent_v2.5/');
	define('URL_ADMINISTRATION','/administration/');
	define('URL_DOCUMENT','/document/');
	define('URL_INCLUSION','/inclusion/');
	define('URL_PUBLIC','/public/');
	define('URL_REF','/ref/');
	
	if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
		$login=$_SERVER['PHP_AUTH_USER'].':'.$_SERVER['PHP_AUTH_PW'].'@';
	else
		$login='';

	define('HTTP_ADHERENT','http://'.$login.$_SERVER['HTTP_HOST'].'/adherent/');
	define('HTTP_ADHERENT_TEST','http://'.$login.$_SERVER['HTTP_HOST'].'/adherent_test/');
	define('HTTP_ADHERENT_V2','http://'.$login.$_SERVER['HTTP_HOST'].'/adherent_v2/');
	define('HTTP_ADHERENT_V2_5','http://'.$login.$_SERVER['HTTP_HOST'].'/adherent_v2.5/');
	define('HTTP_ADMINISTRATION','http://'.$login.$_SERVER['HTTP_HOST'].'/administration/');
	define('HTTP_DOCUMENT','http://'.$login.$_SERVER['HTTP_HOST'].'/document/');
	define('HTTP_INCLUSION','http://'.$login.$_SERVER['HTTP_HOST'].'/inclusion/');
	define('HTTP_PUBLIC','http://'.$login.$_SERVER['HTTP_HOST'].'/public/');
	define('HTTP_REF','http://'.$login.$_SERVER['HTTP_HOST'].'/ref/');
	
	unset($login);
	
	if(!defined('UPLOAD_ERR_CANT_WRITE'))
		define('UPLOAD_ERR_CANT_WRITE',7);
	if(!defined('UPLOAD_ERR_EXTENSION'))
		define('UPLOAD_ERR_EXTENSION',8);
	
	if(preg_match('/^test\./',$_SERVER['HTTP_HOST']))
	{
		ini_set('SMTP','smtp.wanadoo.fr');
		ini_set('smtp_port','25');
		ini_set('sendmail_from','cheznous9@wanadoo.fr');
	}
	else
	{
		ini_set('SMTP','localerte.fr');
		ini_set('smtp_port','25');
		ini_set('sendmail_from','webmaster@localerte.fr');
		
	}
	
	if(strpos($_SERVER['PHP_SELF'],URL_ADMINISTRATION)===false)
	{
		require_once(PWD_INCLUSION.'preference.php');
		
		$preference=new ld_preference();
		if($preference->acces_bloque=='OUI')
		{
			header('location: '.URL_INCLUSION.'maintenance.html');
			die();
		}
		unset($preference);
	}
	
	function ma_htmlentities($string, $flags = ENT_QUOTES, $encoding = 'ISO-8859-1', $double_encode = true)
	{
		return htmlentities($string, $flags, $encoding, $double_encode);
	}	
		
	function ma_html_entity_decode($string, $flags = ENT_QUOTES, $encoding = 'ISO-8859-1')
	{
		return html_entity_decode($string, $flags, $encoding);
	}	
?>