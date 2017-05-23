<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'annonce.php');
	
	$descriptif='&nbsp;';
	if(isset($_REQUEST['annonce_identifiant']))
	{
		$annonce=new ld_annonce();
		$annonce->identifiant=$_REQUEST['annonce_identifiant'];
		if($annonce->lire())
			$descriptif=$annonce->descriptif;
	}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>

<body onload="DimensionnerPopupParId('descriptif');">
<table cellspacing="0" cellpadding="4" id="descriptif">
  <tr>
    <td><?php print(ma_htmlentities($descriptif));?></td>
  </tr>
</table>
</body>
</html>