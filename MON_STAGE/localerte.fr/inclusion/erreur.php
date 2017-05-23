<?php
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$erreur['400']['titre']='HTTP_BAD_REQUEST';
	$erreur['400']['description']='HTTP_BAD_REQUEST';
	$erreur['401']['titre']='HTTP_UNAUTHORIZED';
	$erreur['401']['description']='HTTP_UNAUTHORIZED';
	$erreur['403']['titre']='Acc&egrave;s interdit';
	$erreur['403']['description']='Vous n\'avez pas le droit d\'acc&eacute;der &agrave; l\'objet demand&eacute;. Soit celui-ci est prot&eacute;g&eacute;, soit il ne peut &ecirc;tre lu par le serveur.';
	$erreur['404']['titre']='Objet non trouv&eacute;';
	$erreur['404']['description']='L\'URL requise n\'a pu &ecirc;tre trouv&eacute;e sur ce serveur.';
	$erreur['405']['titre']='HTTP_METHOD_NOT_ALLOWED';
	$erreur['405']['description']='HTTP_METHOD_NOT_ALLOWED';
	$erreur['408']['titre']='HTTP_REQUEST_TIME_OUT';
	$erreur['408']['description']='HTTP_REQUEST_TIME_OUT';
	$erreur['410']['titre']='HTTP_GONE';
	$erreur['410']['description']='HTTP_GONE';
	$erreur['411']['titre']='HTTP_LENGTH_REQUIRED';
	$erreur['411']['description']='HTTP_LENGTH_REQUIRED';
	$erreur['412']['titre']='HTTP_PRECONDITION_FAILED';
	$erreur['412']['description']='HTTP_PRECONDITION_FAILED';
	$erreur['413']['titre']='HTTP_REQUEST_ENTITY_TOO_LARGE';
	$erreur['413']['description']='HTTP_REQUEST_ENTITY_TOO_LARGE';
	$erreur['414']['titre']='HTTP_REQUEST_URI_TOO_LARGE';
	$erreur['414']['description']='HTTP_REQUEST_URI_TOO_LARGE';
	$erreur['415']['description']='HTTP_UNSUPPORTED_MEDIA_TYPE';
	$erreur['415']['description']='HTTP_UNSUPPORTED_MEDIA_TYPE';
	$erreur['500']['titre']='Erreur du serveur';
	$erreur['500']['description']='Le serveur a &egrave;t&eacute; victime d\'une erreur interne et n\'a pas &eacute;t&eacute; capable de faire aboutir votre requ&ecirc;te.';
	$erreur['501']['titre']='HTTP_NOT_IMPLEMENTED';
	$erreur['501']['description']='HTTP_NOT_IMPLEMENTED';
	$erreur['502']['titre']='HTTP_BAD_GATEWAY';
	$erreur['502']['description']='HTTP_BAD_GATEWAY';
	$erreur['503']['titre']='HTTP_SERVICE_UNAVAILABLE';
	$erreur['503']['description']='HTTP_SERVICE_UNAVAILABLE';
	$erreur['506']['titre']='HTTP_VARIANT_ALSO_VARIES';
	$erreur['506']['description']='HTTP_VARIANT_ALSO_VARIES';
	$erreur['Inconnu']['titre']='Erreur inconnue';
	$erreur['Inconnu']['description']='Erreur inconnue';
	
	if(!isset($_REQUEST['e']) || !isset($erreur[$_REQUEST['e']]))
		$_REQUEST['e']='Inconnu';
	
	if(!preg_match('/(\.dll|\.asp|apple-touch-icon)/i',$_SERVER['REQUEST_URI']))
	{
		$fichier=fopen(PWD_INCLUSION.'prive/log/erreur.php.log','a');
		fputs($fichier,date('Y-m-d H:i:s').' '.$_REQUEST['e'].' '.((isset($_SERVER['REMOTE_ADDR']))?($_SERVER['REMOTE_ADDR']):('')).' '.((isset($_SERVER['HTTP_USER_AGENT']))?($_SERVER['HTTP_USER_AGENT']):('')).' '.((isset($_SERVER['HTTP_REFERER']))?($_SERVER['HTTP_REFERER']):('')).' '.((isset($_SERVER['REQUEST_URI']))?($_SERVER['REQUEST_URI']):('')).CRLF);
		fclose($fichier);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Localerte - <?php print($_REQUEST['e'].': '.$erreur[$_REQUEST['e']]['titre']);?></title>
<link rel="SHORTCUT ICON" href="/inclusion/favicon.ico">
<style type="text/css">
body {
	margin:0px;
	text-align:center;
	font-family:Arial, Helvetica, sans-serif;
	font-size:small;
}
p, h1, h2, ul, li {
	margin:0px;
	padding:0px;
}
div#conteneur {
	position:relative;
	text-align:left;
	margin-left:auto;
	margin-right:auto;
	width:760px;
}
a#logo {
	position:absolute;
	left:10px;
}
a#logo img {
	border:none;
}
h1#titre {
	position:relative;
	font-size:xx-large;
	color:#999999;
	left:213px;
	height:54px;
	width:547px;
	padding-top:20px;
	text-align:center;
}
h2{
	position:relative;
	padding-top:10px;
	padding-left:10px;
	padding-right:10px;
}
h2#erreur_numero{
	position:relative;
	margin-top:20px;
	border-top:solid 1px #999999;
	padding-top:30px;
}
p#erreur_message{
	position:relative;
	padding-top:30px;
	padding-left:10px;
	padding-right:10px;
	padding-bottom:30px;
	text-align:justify;
}
ul{
	position:relative;
	padding-top:10px;
	padding-left:50px;
}
p#copyright {
	position:relative;
	margin-top:30px;
	position:relative;
	font-size:x-small;
	color:#999999;
	border-top:solid 1px #999999;
}
</style>
</head>
<body>
<div id="conteneur"> <a href="<?php print(URL_PUBLIC);?>" id="logo"><img src="<?php print(URL_INCLUSION.'logo.jpg');?>" alt="Localerte - On cherche pour vous" title="Localerte - On cherche pour vous" /></a>
  <h1 id="titre"><?php print($_REQUEST['e'].': '.$erreur[$_REQUEST['e']]['titre']);?></h1>
  <h2 id="erreur_numero">Le serveur a retourn&eacute; l'erreur: <?php print(nl2br(ma_htmlentities($_REQUEST['e'])));?></h2>
  <h2 id="erreur_titre"> Titre de l'erreur: <?php print($erreur[$_REQUEST['e']]['titre']);?> </h2>
  <h2 id="erreur_description"> Description de l'erreur: <?php print($erreur[$_REQUEST['e']]['description']);?> </h2>
  <p id="erreur_message">Nous vous invitons &agrave; repartir depuis l'<a href="<?php print(URL_PUBLIC);?>">accueil</a> du site. L'erreur vient d'&ecirc;tre enregistr&eacute;e dans nos fichiers pour v&eacute;rification. Pour toutes questions, n'h&eacute;sitez pas &agrave; nous joindre &agrave; l'adresse: <a href="mailto:<?php print(urlencode(ini_get('sendmail_from')));?>"><?php print(ma_htmlentities(ini_get('sendmail_from')));?></a>.</p>
  <h2 id="erreur_session">Informations sur la session:</h2>
  <ul id="erreur_session">
    <li id="erreur_ip">IP du client:
      <?php if(isset($_SERVER['REMOTE_ADDR'])) print($_SERVER['REMOTE_ADDR']);?>
    </li>
    <li id="erreur_navigateur">Navigateur:
      <?php if(isset($_SERVER['HTTP_USER_AGENT'])) print(ma_htmlentities($_SERVER['HTTP_USER_AGENT']));?>
    </li>
    <li id="erreur_referer">Referer:
      <?php if(isset($_SERVER['HTTP_REFERER'])) print(ma_htmlentities($_SERVER['HTTP_REFERER']));?>
    </li>
    <li id="erreur_uri">URI:
      <?php if(isset($_SERVER['REQUEST_URI'])) print(ma_htmlentities($_SERVER['REQUEST_URI']));?>
    </li>
  </ul>
  <p id="copyright">2005 - 2008 &copy; AICOM - Tous droits r&eacute;serv&eacute;s</p>
</div>
</body>
</html>
