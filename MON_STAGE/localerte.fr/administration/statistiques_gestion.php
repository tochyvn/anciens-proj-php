<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'spool_alerte.php');
	require_once(PWD_INCLUSION.'spool_rappel.php');
	require_once(PWD_INCLUSION.'spool_veille.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$spool_alerte=new ld_spool_alerte();
	$spool_rappel=new ld_spool_rappel();
	$spool_veille=new ld_spool_veille();
	
	if(isset($_REQUEST['submit']))
	{
		switch($_REQUEST['submit'])
		{
			case 'charger':
				${$_REQUEST['spool']}->charger();
				break;
			case 'stopper':
				${$_REQUEST['spool']}->stopper();
				break;
			case 'vider':
				${$_REQUEST['spool']}->vider();
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>

<body>
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php');?></td>
    <td valign="top"><ul>
      <li><a href="statistiques_simples.php" target="_blank">Statistiques horaires simples</a></li>
      <li><a href="statistiques_croisees.php" target="_blank">Statistiques horaires crois&eacute;es</a></li>
    </ul></td>
  </tr>
</table>
</body>
</html>