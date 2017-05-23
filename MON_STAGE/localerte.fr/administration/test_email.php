<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');

	if(isset($_REQUEST['submit'])) {
		$cpt_demande=0;
		$cpt_envoye=0;
		$adherent=new ld_adherent();
		for($i=0; $i<sizeof($_REQUEST['boite']); $i++) {
			$adherent->identifiant=$_REQUEST['boite'][$i];
			for($j=0; $j<sizeof($_REQUEST['email']); $j++) {
				if($adherent->envoyer($_REQUEST['email'][$j])) $cpt_envoye++;
				$cpt_demande++;
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<?php
	if(isset($_REQUEST['submit'])) print($cpt_envoye.' email(s) envoy&eacute;(s) sur '.$cpt_demande.' demand&eacute;s.<br />');
?>
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table cellspacing="0" cellpadding="4">
<form action="test_email.php" method="get">
Bo&icirc;tes &agrave; tester (123):<br />
<input type="checkbox" value="714398724" name="boite[]" id="caramail" /> <label for="caramail">caramail</label><br />
<input type="checkbox" value="917432945" name="boite[]" id="neuf" /> <label for="neuf">neuf</label><br />
<input type="checkbox" value="678366740" name="boite[]" id="orange" /> <label for="orange">orange</label><br />
<input type="checkbox" value="22422476" name="boite[]" id="free" /> <label for="free">free</label><br />
<input type="checkbox" value="545248050" name="boite[]" id="voila" /> <label for="voila">voila</label><br />
<input type="checkbox" value="596637444" name="boite[]" id="hotmail" /> <label for="hotmail">hotmail</label><br />
<input type="checkbox" value="613657716" name="boite[]" id="yahoo" /> <label for="yahoo">yahoo</label><br />
<input type="checkbox" value="492729733" name="boite[]" id="aol" /> <label for="aol">aol</label><br />
<input type="checkbox" value="330602889" name="boite[]" id="laposte" /> <label for="laposte">laposte</label><br />
<input type="checkbox" value="781471534" name="boite[]" id="gmail" /> <label for="gmail">gmail</label><br />

<br />
Bo&icirc;tes &agrave; tester (456):<br />
<input type="checkbox" value="82792550" name="boite[]" id="caramail2" /> <label for="caramail2">caramail</label><br />
<input type="checkbox" value="145949899" name="boite[]" id="neuf2" /> <label for="neuf2">neuf</label><br />
<input type="checkbox" value="640257517" name="boite[]" id="orange2" /> <label for="orange2">orange</label><br />
<input type="checkbox" value="904606862" name="boite[]" id="free2" /> <label for="free2">free</label><br />
<input type="checkbox" value="900737895" name="boite[]" id="voila2" /> <label for="voila2">voila</label><br />
<input type="checkbox" value="206862310" name="boite[]" id="hotmail2" /> <label for="hotmail2">hotmail</label><br />
<input type="checkbox" value="751759446" name="boite[]" id="yahoo2" /> <label for="yahoo2">yahoo</label><br />
<input type="checkbox" value="655667959" name="boite[]" id="aol" /> <label for="aol2">aol</label><br />
<input type="checkbox" value="325177462" name="boite[]" id="laposte2" /> <label for="laposte2">laposte</label><br />
<input type="checkbox" value="380053006" name="boite[]" id="gmail2" /> <label for="gmail2">gmail</label><br />
<br />
<input type="checkbox" value="848782096" name="boite[]" id="yannick" /> <label for="yannick">aicom-yannick</label><br />
<input type="checkbox" value="841094249" name="boite[]" id="laurent" /> <label for="laurent">aicom-laurent</label><br />
<br />
Emails &agrave; tester:<br />
<input type="checkbox" value="passe" name="email[]" id="passe" /> <label for="passe">passe</label><br />
<input type="checkbox" value="inscription" name="email[]" id="inscription" /> <label for="inscription">inscription</label><br />
<input type="checkbox" value="cheznous" name="email[]" id="cheznous" /> <label for="cheznous">cheznous</label><br />
<input type="checkbox" value="alerte" name="email[]" id="alerte" /> <label for="alerte">alerte</label><br />
<input type="checkbox" value="rappel" name="email[]" id="rappel" /> <label for="rappel">rappel</label><br />
<input type="checkbox" value="veille" name="email[]" id="veille" /> <label for="veille">veille</label><br />
<input type="checkbox" value="inactivite" name="email[]" id="inactivite" /> <label for="inactivite">inactivite</label><br />
<br />
<input type="submit" name="submit" value="Test" />
</form>
</table></td></tr></table></body>
</html>
