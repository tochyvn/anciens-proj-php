<?php
setlocale(LC_TIME, "fr" );
define('STRING_FILTRE_TELEPHONE_LAXISTE_FR','/(0[1-6789][^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[0-9]{2}([^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[0-9]{3}){2}|0[1-6789]([^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[0-9]{2}){4}|0[^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[1-6789][0-9]{2}([^0-9a-zA-ZÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]?[0-9]{3}){2})/');

function decouper($chaine,$longueur) {
	$delimiteur='<!-- '.uniqid('abcdefgh',true).' -->';
	$retour=$chaine;
	$retour=wordwrap($retour,$longueur,$delimiteur,false);
	$retour.=$delimiteur;
	$retour=substr($retour,0,strpos($retour,$delimiteur));
	
	return $retour;
}

$date_debut=mktime(0, 0, 0, date('m'), date('d')-1, date('Y'));;
$date_fin=time();
$cpt=0;

if(isset($_REQUEST['mode'])) {
	switch($_REQUEST['mode']) {
		case 'suppr':
			if(isset($_REQUEST['fic']) && is_file('./capture/'.$_REQUEST['fic'])) unlink('./capture/'.$_REQUEST['fic']);
			break;
	}
}
if(isset($_REQUEST['submit'])) {
	switch($_REQUEST['submit']) {
		case 'Valider':
			ini_set('memory_limit','-1');
			if(is_string($_REQUEST['date_debut']) && $_REQUEST['date_debut']!='' && preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/',$_REQUEST['date_debut'],$resultat)) {
				$date_debut=mktime(0,0,0,$resultat[2],$resultat[1],$resultat[3]);
			} else $date_debut=time();
			
			if(is_string($_REQUEST['date_fin']) && $_REQUEST['date_fin']!='' && preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/',$_REQUEST['date_fin'],$resultat)) {
				$date_fin=mktime(0,0,0,$resultat[2],$resultat[1],$resultat[3]);
			} else $date_fin=time();
			
			$continue=true;
			$i=1;
			$f=fopen("../../upload/cheznous_topannonces.csv", "r");
			$dest=fopen("./capture/captureTA_".date('Ymd')."_".date('His').".txt", "w");
			while(!feof($f)) {
				$ligne = fgetcsv($f, 4096, ';');
				$j=sizeof($ligne);
				$t = split('/', $ligne[0]);
				$ligne_dest='';
				if(sizeof($t)==3 && mktime(0,0,0,$t[1],$t[0],$t[2])>=$date_debut && mktime(0,0,0,$t[1],$t[0],$t[2])<=$date_fin) {
					for($i=0; $i<$j; $i++) {
						switch($i) {
							case 1: //CP
									$ligne_dest.='"'.substr($ligne[$i], 0, 2).'";';
								break;
							case 2: //Ville
									$ligne[$i]=str_replace('&#39:point virgule:', '\'', $ligne[$i]);
									if($ligne[$i]=='PARIS' || $ligne[$i]=='MARSEILLE' || $ligne[$i]=='LYON')
										$ligne_dest.='"'.$ligne[$i].' '.substr($ligne[1], 3, 2).'";';
									elseif($ligne[$i]=='AIX-EN-PROVENCE')
										$ligne_dest.='"'.$ligne[$i].' '.$ligne[1].'";';
									else
										$ligne_dest.='"'.$ligne[$i].'";';
								break;
							case 3: //Type
								if(preg_match('/(T1|T2|T3|T4|T5|T6|studio|chambre|chambre de bonne|maison|villa|garage|parking|box|cave|colocation|parking|duplex|triplex|loft|local|bateau)/', $ligne[$i]))
									$ligne_dest.='"'.$ligne[$i].'";';
								else {
									$ligne[$i]='';
									$ligne_dest.='"";';
								}
								break;
							case 4: //Meublé
								if($ligne[$i]=='MBLE' && $ligne[3]!='')
									$ligne_dest=substr($ligne_dest, 0, -2).' MBLE";';
								break;
							case 6: //Tél
								if($ligne[$i]=='') {
									preg_match(STRING_FILTRE_TELEPHONE_LAXISTE_FR, $ligne[7], $matches);
									if(isset($matches[0])) $ligne[$i]=preg_replace('/[^0-9]/e', '', $matches[0]);
								}
								$ligne_dest.='"'.$ligne[$i].'";';
								break;
							case 7: //Descriptif
								$ligne[$i]=str_replace('&#39:point virgule:', '\'', $ligne[$i]);
								$array_search=array(':saut ligne:', ':saut paragraphe:', "\t", ":point virgule:", ":guillemet:");
								$array_replace=array(' ', ' ', ' ', ';', '\'');
								$ligne[$i]=str_replace($array_search, $array_replace, $ligne[$i]);
								$ligne[$i]=str_replace('  ', ' ', $ligne[$i]);
								$ligne[$i]=htmlspecialchars_decode($ligne[$i]);
								$ligne[$i]=str_replace(';', ',', $ligne[$i]);
								$decouper_retour='';
								$a_decouper=$ligne[$i];
								for($decouper_i=0; $decouper_i<10; $decouper_i++) {
									$decouper_retour = decouper($a_decouper,40);
									$ligne_dest.='"'.$decouper_retour.'";';
									$a_decouper = substr($a_decouper, strlen($decouper_retour));
								}
								break;
							default:
								$ligne[$i]=str_replace('&#39:point virgule:', '\'', $ligne[$i]);
								$ligne_dest.='"'.$ligne[$i].'";';
								break;
						}
					}
				fwrite($dest, substr($ligne_dest, 0, -1)."\r\n");
				$cpt++;
				}
			}
			fclose($dest);
			fclose($f);
			break;
		case 'Supprimer le fichier de pige':
			if(is_file('../../upload/cheznous_topannonces.csv')) unlink('../../upload/cheznous_topannonces.csv');
			break;
	}
}
$_REQUEST['date_debut']=array();
$_REQUEST['date_debut'][0]=date('d',$date_debut);
$_REQUEST['date_debut'][1]=date('m',$date_debut);
$_REQUEST['date_debut'][2]=date('Y',$date_debut);
$_REQUEST['date_fin']=array();
$_REQUEST['date_fin'][0]=date('d',$date_fin);
$_REQUEST['date_fin'][1]=date('m',$date_fin);
$_REQUEST['date_fin'][2]=date('Y',$date_fin);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestion CaptureTA</title>
<script src="calendrier.js" type="text/javascript"></script>
<style type="text/css">
input {
	margin-top:10px;
	display:inline-block;
	border:solid 1px #999;
	padding:4px;
}
label {
	display:inline-block;
	width:50px;
	text-align:right;
	margin:2px 10px;
}
input[type='submit'] {
	margin-left:70px;
	padding:4px;
	border:solid 1px #999;
}
table td {
	padding:5px;
	border:solid 1px #CCC;
	color:#333;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
a {
	color:#333;
	text-decoration:none;
}
a:hover {
	text-decoration:underline;
}
h1 {
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	margin-left:50px;
}
img {
	border:none;
}
</style>
</head>
<body>
<?php if(is_file('../../upload/cheznous_topannonces.csv')) { ?>
<form action="" method="post">
  <h1>Annonces Topannonces</h1>
  <p>
    <label>du </label>
    <script type="text/javascript">
      <!--
		var calendrier_debut=new CalendrierDefaut('date_debut','<?php print($_REQUEST['date_debut'][0].'/'.$_REQUEST['date_debut'][1].'/'.$_REQUEST['date_debut'][2]);?>',new Date(<?php print($_REQUEST['date_debut'][2].','.($_REQUEST['date_debut'][1]-1).','.$_REQUEST['date_debut'][0]);?>),'calendrier_debut',false);
      //-->
</script>
  </p>
  <p>
    <label>jusqu'au </label>
    <script type="text/javascript">
      <!--
		var calendrier_fin=new CalendrierDefaut('date_fin','<?php print($_REQUEST['date_fin'][0].'/'.$_REQUEST['date_fin'][1].'/'.$_REQUEST['date_fin'][2]);?>',new Date(<?php print($_REQUEST['date_fin'][2].','.($_REQUEST['date_fin'][1]-1).','.$_REQUEST['date_fin'][0]);?>),'calendrier_fin',false);
      //-->
</script>
  </p>
  <p>
    <input type="submit" name="submit" value="Valider" />
  </p>
</form>
<?php if($cpt!=0) print('<b>'.$cpt.' annonces extraites.</b>'); ?>
<?php } ?>
<br />
<br />
<?php
if($h = opendir('./capture')) {
	print('<table border="1">');
	$files = array();
    while(false !== ($file=readdir($h))) {
        if(preg_match('/^captureTA.+$/e', $file)) {
			$files[] = $file;
		}
	}
	sort($files);
	for($i=count($files)-1; $i>=0; $i--) {
		$f=$files[$i];
		$poids = filesize('./capture/'.$f);
		$recup_date = explode('_', $f);
		print('<tr'.(($i==count($files)-1)?(' bgcolor="#EDD38C"'):('')).'><td><a target="_blank" href="download.php?f='.$f.'">'.$f.'</a></td><td>'.preg_replace('/([0-9]{4})([0-9]{2})([0-9]{2})/','\3/\2/\1', $recup_date[1]).' '.preg_replace('/([0-9]{2})([0-9]{2}).+/','\1:\2', $recup_date[2]).'</td><td align="right">'.
			  (
			   ($poids<1024)
					?($poids.' o')
					:(
					  ($poids/1024<1024)
						?(round($poids/1024,2).' Ko')
						:(round(($poids/1024)/1024,2).' Mo')
					  )
			  )
			.'</td><td><a href="?mode=suppr&fic='.$f.'" onclick="return confirm(\'&Ecirc;tes-vous s&ucirc;r de vouloir supprimer ce fichier ?\');"><img src="suppr.jpg" alt="X" /></a></td></tr>'."\r\n");
	}
	print('</table><br /><br />');
    closedir($h);
}
?>
<?php if(is_file('../../upload/cheznous_topannonces.csv')) { ?>
<form action="">
  <input type="submit" name="submit" value="Supprimer le fichier de pige" onclick="return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir supprimer ce fichier ?');" />
</form>
<?php } else print('Pas de fichier de pige'); ?>
</body>
</html>