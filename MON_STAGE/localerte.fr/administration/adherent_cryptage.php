<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	$cryptage='&nbsp;';
	if(isset($_REQUEST['adherent_identifiant']))
	{
		$adherent=new ld_adherent();
		$adherent->identifiant=$_REQUEST['adherent_identifiant'];
		if($adherent->lire())
			$cryptage=urlencode($adherent->code);
	}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>

<body onload="DimensionnerPopupParId('cryptage');">
<table cellspacing="0" cellpadding="4" id="cryptage">
  <tr>
    <td><?php print(ma_htmlentities($cryptage));?></td>
  </tr>
</table>
</body>
</html>