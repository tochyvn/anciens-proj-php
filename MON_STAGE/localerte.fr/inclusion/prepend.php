<?php
	if(strrpos($_SERVER['DOCUMENT_ROOT'],'/')!=strlen($_SERVER['DOCUMENT_ROOT'])-3)
		$_SERVER['DOCUMENT_ROOT'].='/';
	
	if(!defined('PWD_ADHERENT')) define('PWD_ADHERENT',$_SERVER['DOCUMENT_ROOT'].'adherent/');
	if(!defined('PWD_ADHERENT_TEST')) define('PWD_ADHERENT_TEST',$_SERVER['DOCUMENT_ROOT'].'adherent_test/');
	if(!defined('PWD_ADHERENT_V2')) define('PWD_ADHERENT_V2',$_SERVER['DOCUMENT_ROOT'].'adherent_v2/');
	if(!defined('PWD_ADHERENT_V2_5')) define('PWD_ADHERENT_V2_5',$_SERVER['DOCUMENT_ROOT'].'adherent_v2.5/');
	if(!defined('PWD_ADMINISTRATION')) define('PWD_ADMINISTRATION',$_SERVER['DOCUMENT_ROOT'].'administration/');
	if(!defined('PWD_DOCUMENT')) define('PWD_DOCUMENT',$_SERVER['DOCUMENT_ROOT'].'document/');
	if(!defined('PWD_INCLUSION')) define('PWD_INCLUSION',$_SERVER['DOCUMENT_ROOT'].'inclusion/');
	if(!defined('PWD_PUBLIC')) define('PWD_PUBLIC',$_SERVER['DOCUMENT_ROOT'].'public/');
	if(!defined('PWD_REF')) define('PWD_REF',$_SERVER['DOCUMENT_ROOT'].'ref/');
	
	if(!defined('URL_ADHERENT')) define('URL_ADHERENT','/adherent/');
	if(!defined('URL_ADHERENT_TEST')) define('URL_ADHERENT_TEST','/adherent_test/');
	if(!defined('URL_ADHERENT_V2')) define('URL_ADHERENT_V2','/adherent_v2/');
	if(!defined('URL_ADHERENT_V2_5')) define('URL_ADHERENT_V2_5','/adherent_v2.5/');
	if(!defined('URL_ADMINISTRATION')) define('URL_ADMINISTRATION','/administration/');
	if(!defined('URL_DOCUMENT')) define('URL_DOCUMENT','/document/');
	if(!defined('URL_INCLUSION')) define('URL_INCLUSION','/inclusion/');
	if(!defined('URL_PUBLIC')) define('URL_PUBLIC','/public/');
	if(!defined('URL_REF')) define('URL_REF','/ref/');
	
	if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
		$login=$_SERVER['PHP_AUTH_USER'].':'.$_SERVER['PHP_AUTH_PW'].'@';
	else
		$login='';

	if(!defined('HTTP_ADHERENT')) define('HTTP_ADHERENT','http://'.$login.$_SERVER['HTTP_HOST'].'/adherent/');
	if(!defined('HTTP_ADHERENT_TEST')) define('HTTP_ADHERENT_TEST','http://'.$login.$_SERVER['HTTP_HOST'].'/adherent_test/');
	if(!defined('HTTP_ADHERENT_V2')) define('HTTP_ADHERENT_V2','http://'.$login.$_SERVER['HTTP_HOST'].'/adherent_v2/');
	if(!defined('HTTP_ADHERENT_V2_5')) define('HTTP_ADHERENT_V2_5','http://'.$login.$_SERVER['HTTP_HOST'].'/adherent_v2.5/');
	if(!defined('HTTP_ADMINISTRATION')) define('HTTP_ADMINISTRATION','http://'.$login.$_SERVER['HTTP_HOST'].'/administration/');
	if(!defined('HTTP_DOCUMENT')) define('HTTP_DOCUMENT','http://'.$login.$_SERVER['HTTP_HOST'].'/document/');
	if(!defined('HTTP_INCLUSION')) define('HTTP_INCLUSION','http://'.$login.$_SERVER['HTTP_HOST'].'/inclusion/');
	if(!defined('HTTP_PUBLIC')) define('HTTP_PUBLIC','http://'.$login.$_SERVER['HTTP_HOST'].'/public/');
	if(!defined('HTTP_REF')) define('HTTP_REF','http://'.$login.$_SERVER['HTTP_HOST'].'/ref/');
	
	unset($login);
	
	if(!defined('DEBUGAGE')) define('DEBUGAGE',0);
	if(!defined('CHARSET')) define('CHARSET','ISO-8859-1');
	//ATTENTION AU FLOAT
	//if(!defined('LOCAL')) define('LOCAL','\'fr_FR.ISO-8859-1\'');
	if(!defined('LOCAL')) define('LOCAL','\'fr_FR\',\'fr\'');
	if(!defined('LANGUAGE')) define('LANGUAGE','fr');
	define('MAINTENANT',time());
	
	ini_set('error_reporting',E_ALL);
	ini_set('display_startup_errors','1');
	ini_set('log_errors_max_len',0);
	ini_set('ignore_repeated_errors','0');
	ini_set('ignore_repeated_source','0');
	ini_set('report_memleaks','1');
	ini_set('track_errors','0');
	ini_set('html_errors','1');
	ini_set('error_prepend_string','');
	ini_set('error_append_string','');
	ini_set('warn_plus_overloading','1');
	if(DEBUGAGE)
	{
		ini_set('display_errors','1');
		ini_set('log_errors','0');
		ini_set('error_log','');
	}
	else
	{
		ini_set('display_errors','0');
		ini_set('log_errors','1');
		ini_set('error_log',__DIR__.'/prive/log/php_error.log');
	}
	
	//ATTENTION AU FLOAT
	//eval('setlocale(LC_ALL,'.LOCAL.');');
	eval('setlocale(LC_TIME,'.LOCAL.');');
	
	//header('Last-Modified: '.gmdate('D, d M Y H:i:s',time()).' GMT');
	//header('Expires: '.gmdate('D, d M Y H:i:s',time()).' GMT');
	header('Content-Language: '.LANGUAGE);
	header('Content-Type: text/html; charset='.CHARSET);
	
	ini_set('SMTP','localhost');
	ini_set('smtp_port','25');
	ini_set('sendmail_from','webmaster@localerte.fr');
	
	if(strpos($_SERVER['PHP_SELF'],URL_ADMINISTRATION)===false)
	{
		require_once(__DIR__.'/preference.php');
		
		$preference=new ld_preference();
		if($preference->acces_bloque=='OUI')
		{
			header('Expires: '.gmdate('D, d M Y H:i:s',time()).' GMT');
			header('location: /inclusion/maintenance.html');
			die();
		}
		unset($preference);
	}
	
	if($_SERVER['HTTP_HOST']=='www.localerte.fr')
	{
		session_start();
		setcookie(session_name(),session_id(),time()+1800,'/','www.localerte.fr',false);
	}

	function url_use_trans_sid($chaine)
	{
		if(ini_get('session.use_trans_sid') && !isset($_COOKIE[session_name()]) && !preg_match('/^https?:\/\//',$chaine) && !preg_match('/(\?|&)'.preg_quote(session_name().'=').'/',$chaine))
			return $chaine.((strpos($chaine,'?')===false)?('?'):('&')).urlencode(session_name()).'='.urlencode(session_id());
		else
			return $chaine;
	}
	
	function ma_htmlentities($string, $flags = ENT_QUOTES, $encoding = CHARSET, $double_encode = true)
	{
		return htmlentities($string, $flags, $encoding, $double_encode);
	}	
	
	function ma_htmlspecialchars($string, $flags = ENT_QUOTES, $encoding = CHARSET, $double_encode = true)
	{
		return htmlspecialchars($string, $flags, $encoding, $double_encode);
	}	
	
	function ma_html_entity_decode($string, $flags = ENT_QUOTES, $encoding = CHARSET)
	{
		return html_entity_decode($string, $flags, $encoding);
	}
	
	function unset_adherent()
	{
		if(isset($_SESSION['adherent_identifiant'])) unset($_SESSION['adherent_identifiant']);
		if(isset($_SESSION['wha_identifiant'])) unset($_SESSION['wha_identifiant']);
		if(isset($_SESSION['allopass_reference'])) unset($_SESSION['allopass_reference']);
		if(isset($_SESSION['code_reference'])) unset($_SESSION['code_reference']);
		if(isset($_SESSION['annonce_identifiant'])) unset($_SESSION['annonce_identifiant']);
		if(isset($_SESSION['adherent_debut'])) unset($_SESSION['adherent_debut']);
		if(isset($_SESSION['alerte_identifiant'])) unset($_SESSION['alerte_identifiant']);
	}
?>