<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'enquete.php');
	
	$adherent=new ld_adherent();
	$adherent->identifiant=$_SESSION['adherent_identifiant'];
	$adherent->lire();

	if(!isset($_COOKIE['la_enquete_'.$_SESSION['adherent_identifiant'].'_1']))
		setcookie('la_enquete_'.$_SESSION['adherent_identifiant'].'_1', time(), time()+60*60*24*365, '/', '.localerte.fr', false);
	
	$enquete = new ld_enquete();
	if(isset($_SESSION['enquete']))
		$enquete = unserialize($_SESSION['enquete']);
	else {
		$enquete->adherent_identifiant = $_SESSION['adherent_identifiant'];
		$enquete->adherent_nouveau_identifiant = $_SESSION['adherent_identifiant'];
		$enquete->adherent_email = $adherent->email;
	}
	
	$erreur_msg='';

	if(!isset($_REQUEST['etape'])) $_REQUEST['etape']='0';
	
	if(isset($_REQUEST['submit'])) {
		switch($_REQUEST['etape']) {
			case '0':
				if($_REQUEST['submit']=='Répondre aux 5 questions') {
					$_REQUEST['etape'] = 'q1';
				} else header('location: '.URL_ADHERENT.'annonce/liste.php');
				break;
			case 'q1':
				if(isset($_REQUEST['q1'])) {
					$enquete->question1 = $_REQUEST['q1'];
					$_REQUEST['etape'] = 'q2';
				} else $erreur_msg = 'Merci de r&eacute;pondre &agrave; la question.';
				break;
			case 'q2':
				if($_REQUEST['submit']=='Suivant >') {
					if(isset($_REQUEST['q2'])) {
						$enquete->question2 = $_REQUEST['q2'];
						$_REQUEST['etape'] = 'q3';
					} else $erreur_msg = 'Merci de r&eacute;pondre &agrave; la question.';
				} else {
						$_REQUEST['etape'] = 'q1';
				}
				break;
			case 'q3':
				if($_REQUEST['submit']=='Suivant >') {
					if(isset($_REQUEST['q3'])) {
						$enquete->question3 = $_REQUEST['q3'];
						$_REQUEST['etape'] = 'q4';
					} else $erreur_msg = 'Merci de r&eacute;pondre &agrave; la question.';
				} else {
						$_REQUEST['etape'] = 'q2';
				}
				break;
			case 'q4':
				if($_REQUEST['submit']=='Suivant >') {
					if(isset($_REQUEST['q4'])) {
						$enquete->question4 = $_REQUEST['q4'];
						if($_REQUEST['q4']=='OUI') {
							$_REQUEST['etape'] = 'q5';
						} else {
							$_REQUEST['etape'] = 'q4b';
						}
					} else $erreur_msg = 'Merci de r&eacute;pondre &agrave; la question.';
				} else {
						$_REQUEST['etape'] = 'q3';
				}
				break;
			case 'q4b':
				$_REQUEST['etape'] = 'q5';
				break;
			case 'q5':
				if(isset($_REQUEST['q5'])) {
					$enquete->question5 = $_REQUEST['q5'];
					$_REQUEST['etape'] = 'libre';
				} else $erreur_msg = 'Merci de r&eacute;pondre &agrave; la question.';
				break;
			case 'libre':
				$enquete->libre = $_REQUEST['libre'];
				if(!$enquete->ajouter()) {
					$adherent->envoyer('enquete');
				}
				if($_REQUEST['submit']=='Je retourne à l\'ancienne version') {
					header('location: '.URL_ADHERENT.'annonce/liste.php?adherent_version=V2');
					die();
				} else {
					header('location: '.URL_ADHERENT.'annonce/liste.php?adherent_version=V2.5');
					die();
				}
				break;
		}
	}
	
	//print_r($enquete);
	$_SESSION['enquete'] = serialize($enquete);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
</head>
<body id="principal_enquete">
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="enquete">
  <form action="" method="post">
    <input type="hidden" name="etape" value="<?php print($_REQUEST['etape']);?>" />
    <?php
	if(isset($erreur_msg)) print($erreur_msg);
	switch($_REQUEST['etape']) {
		case 'q1':
	?>
    <p class="t15"><br />
      <span class="t18">ENQU&Ecirc;TE DE SATISFACTION</span><br />
      <img src="<?php print(URL_ADHERENT.'image/enquete/10s.jpg');?>" alt="" /><br />
      <b><u>Pr&eacute;sentation</u></b> - Navigation - Recherche - R&eacute;sultats<br />
      <br />
    </p>
    <p class="enquete_question"><br />
      <span class="t15 gras">Question n&deg;1 : <u>Pr&eacute;sentation g&eacute;n&eacute;rale</u></span><br />
      <br />
      "Quelle note donneriez-vous &agrave; la <b>nouvelle pr&eacute;sentation</b> de LOCALERTE ?"<br />
      <br />
      <?php if($erreur_msg!='') print('<span class="orange_fonce gras">'.$erreur_msg.'</span><br /><br />');?>
      <input type="radio" value="0" id="q1r0" name="q1"<?php if($enquete->question1=='0') print(' checked="checked"');?> />
      <label for="q1r0"> 0</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="1" id="q1r1" name="q1"<?php if($enquete->question1=='1') print(' checked="checked"');?> />
      <label for="q1r1"> 1</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="2" id="q1r2" name="q1"<?php if($enquete->question1=='2') print(' checked="checked"');?> />
      <label for="q1r2"> 2</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="3" id="q1r3" name="q1"<?php if($enquete->question1=='3') print(' checked="checked"');?> />
      <label for="q1r3"> 3</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="4" id="q1r4" name="q1"<?php if($enquete->question1=='4') print(' checked="checked"');?> />
      <label for="q1r4"> 4</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="5" id="q1r5" name="q1"<?php if($enquete->question1=='5') print(' checked="checked"');?> />
      <label for="q1r5"> 5</label>
      <br />
      <br />
      <span class="t11">0 = tr&egrave;s mauvaise / 5 = excellente</span> <br />
      <br />
    </p>
    <p aclass="enquete_submit"><br />
      <input type="submit" class="submit" name="submit" value="Suivant &gt;" />
      <br />
    </p>
    <?php 	  break;
		case 'q2':
	?>
    <p class="t15"><br />
      <span class="t18">ENQU&Ecirc;TE DE SATISFACTION</span><br />
      <img src="<?php print(URL_ADHERENT.'image/enquete/20s.jpg');?>" alt="" /><br />
      Pr&eacute;sentation - <b><u>Navigation</u></b> - Recherche - R&eacute;sultats<br />
      <br />
    </p>
    <p class="enquete_question"><br />
      <span class="t15 gras">Question n&deg;2 : <u>Navigation &amp; ergonomie</u></span><br />
      <br />
      "Quelle note donneriez-vous &agrave; la <b>prise en main</b><br />
      de cette nouvelle version ?"<br />
      <br />
      <?php if($erreur_msg!='') print('<span class="orange_fonce gras">'.$erreur_msg.'</span><br /><br />');?>
      <input type="radio" value="0" id="q2r0" name="q2"<?php if($enquete->question2=='0') print(' checked="checked"');?> />
      <label for="q2r0"> 0</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="1" id="q2r1" name="q2"<?php if($enquete->question2=='1') print(' checked="checked"');?> />
      <label for="q2r1"> 1</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="2" id="q2r2" name="q2"<?php if($enquete->question2=='2') print(' checked="checked"');?> />
      <label for="q2r2"> 2</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="3" id="q2r3" name="q2"<?php if($enquete->question2=='3') print(' checked="checked"');?> />
      <label for="q2r3"> 3</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="4" id="q2r4" name="q2"<?php if($enquete->question2=='4') print(' checked="checked"');?> />
      <label for="q2r4"> 4</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="5" id="q2r5" name="q2"<?php if($enquete->question2=='5') print(' checked="checked"');?> />
      <label for="q2r5"> 5</label>
      <br />
      <br />
      <span class="t11">0 = tr&egrave;s mauvaise / 5 = excellente</span> <br />
      <br />
    </p>
    <p class="enquete_submit"><br />
      <input type="submit" class="submit2" name="submit" value="&lt; Pr&eacute;c&eacute;dent" />
      <input type="submit" class="submit" name="submit" value="Suivant &gt;" />
    </p>
    <?php 	  break;
		case 'q3':
	?>
    <p class="t15"><br />
      <span class="t18">ENQU&Ecirc;TE DE SATISFACTION</span><br />
      <img src="<?php print(URL_ADHERENT.'image/enquete/30s.jpg');?>" alt="" /><br />
      Pr&eacute;sentation - Navigation - <b><u>Recherche</u></b> - R&eacute;sultats<br />
      <br />
    </p>
    <p class="enquete_question"><br />
      <span class="t15 gras">Question n&deg;3 : <u>Recherches d'annonces</u></span><br />
      <br />
      "Quelle note donneriez-vous &agrave; la <b>quantit&eacute;<br />
      d'annonces propos&eacute;es</b> pour votre recherche ?"<br />
      <br />
      <?php if($erreur_msg!='') print('<span class="orange_fonce gras">'.$erreur_msg.'</span><br /><br />');?>
      <input type="radio" value="0" id="q3r0" name="q3"<?php if($enquete->question3=='0') print(' checked="checked"');?> />
      <label for="q3r0"> 0</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="1" id="q3r1" name="q3"<?php if($enquete->question3=='1') print(' checked="checked"');?> />
      <label for="q3r1"> 1</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="2" id="q3r2" name="q3"<?php if($enquete->question3=='2') print(' checked="checked"');?> />
      <label for="q3r2"> 2</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="3" id="q3r3" name="q3"<?php if($enquete->question3=='3') print(' checked="checked"');?> />
      <label for="q3r3"> 3</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="4" id="q3r4" name="q3"<?php if($enquete->question3=='4') print(' checked="checked"');?> />
      <label for="q3r4"> 4</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="5" id="q3r5" name="q3"<?php if($enquete->question3=='5') print(' checked="checked"');?> />
      <label for="q3r5"> 5</label>
      <br />
      <br />
      <span class="t11">0 = tr&egrave;s mauvaise / 5 = excellente</span> <br />
      <br />
    </p>
    <p class="enquete_submit"><br />
      <input type="submit" class="submit2" name="submit" value="&lt; Pr&eacute;c&eacute;dent" />
      <input type="submit" class="submit" name="submit" value="Suivant &gt;" />
    </p>
    <?php 	  break;
		case 'q4':
	?>
    <p class="t15"><br />
      <span class="t18">ENQU&Ecirc;TE DE SATISFACTION</span><br />
      <img src="<?php print(URL_ADHERENT.'image/enquete/40s.jpg');?>" alt="" /><br />
      Pr&eacute;sentation - Navigation - Recherche - <b><u>R&eacute;sultats</u></b><br />
      <br />
    </p>
    <p class="enquete_question"><br />
      <span class="t15 gras">Question n&deg;4 : <u>D&eacute;tail des annonces</u></span><br />
      <br />
      "Avez-vous compris comment <b>acc&eacute;der<br />
      au d&eacute;tail des annonces</b> (texte, photos, t&eacute;l.) ?"<br />
      <br />
      <?php if($erreur_msg!='') print('<span class="orange_fonce gras">'.$erreur_msg.'</span><br /><br />');?>
      <input type="radio" value="OUI" id="q4r0" name="q4" />
      <label for="q4r0"> Oui</label>
      /
      <input type="radio" value="NON" id="q4r1" name="q4" />
      <label for="q4r1"> Non</label>
      <br />
      <br />
    </p>
    <p class="enquete_submit"><br />
      <input type="submit" class="submit2" name="submit" value="&lt; Pr&eacute;c&eacute;dent" />
      <input type="submit" class="submit" name="submit" value="Suivant &gt;" />
    </p>
    <?php 	  break;
		case 'q4b':
	?>
    <p class="t15"><br />
      <span class="t18">ENQU&Ecirc;TE DE SATISFACTION</span><br />
      <img src="<?php print(URL_ADHERENT.'image/enquete/40s.jpg');?>" alt="" /><br />
      Pr&eacute;sentation - Navigation - Recherche - <b><u>R&eacute;sultats</u></b><br />
      <br />
    </p>
    <p class="enquete_aide"><br />
      <i><b>Aide &agrave; la navigation</b></i><br />
      <br />
      Vous devez COCHER les annonces qui vous int&eacute;ressent<br />
      depuis la liste de r&eacute;sultats, puis CLIQUER sur<br />
      <b>"Voir les annonces coch&eacute;es"</b> (bouton orange).<br />
      <br />
    </p>
    <p class="enquete_submit"><br />
      <input type="submit" class="submit" name="submit" value="Suivant &gt;" />
    </p>
    <?php 	  break;
		case 'q5':
	?>
    <p class="t15"><br />
      <span class="t18">ENQU&Ecirc;TE DE SATISFACTION</span><br />
      <img src="<?php print(URL_ADHERENT.'image/enquete/50s.jpg');?>" alt="" /><br />
      Pr&eacute;sentation - Navigation - <b><u>Recherche</u></b> - R&eacute;sultats<br />
      <br />
    </p>
    <p class="enquete_question"><br />
      <span class="t15 gras">Question n&deg;5 : <u>Utilit&eacute; de LOCALERTE</u></span><br />
      <br />
      "Pensez-vous que LOCALERTE est un <b>service utile</b><br />
      dans votre recherche de location ?"<br />
      <br />
      <br />
      <?php if($erreur_msg!='') print('<span class="orange_fonce gras">'.$erreur_msg.'</span><br /><br />');?>
      <input type="radio" value="0" id="q5r0" name="q5"<?php if($enquete->question5=='0') print(' checked="checked"');?> />
      <label for="q5r0"> 0</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="1" id="q5r1" name="q5"<?php if($enquete->question5=='1') print(' checked="checked"');?> />
      <label for="q5r1"> 1</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="2" id="q5r2" name="q5"<?php if($enquete->question5=='2') print(' checked="checked"');?> />
      <label for="q5r2"> 2</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="3" id="q5r3" name="q5"<?php if($enquete->question5=='3') print(' checked="checked"');?> />
      <label for="q5r3"> 3</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="4" id="q5r4" name="q5"<?php if($enquete->question5=='4') print(' checked="checked"');?> />
      <label for="q5r4"> 4</label>
      &nbsp;&nbsp;&nbsp;
      <input type="radio" value="5" id="q5r5" name="q5"<?php if($enquete->question5=='5') print(' checked="checked"');?> />
      <label for="q5r5"> 5</label>
      <br />
      <br />
      <span class="t11">0 = pas du tout utile / 5 = tr&egrave;s utile</span> <br />
      <br />
    </p>
    <p class="enquete_submit"><br />
      <input type="submit" class="submit" name="submit" value="Suivant &gt;" />
    </p>
    <?php 	  break;
		case 'libre':
	?>
    <p class="t15"><br />
      <span class="t18">ENQU&Ecirc;TE DE SATISFACTION</span><br />
      <img src="<?php print(URL_ADHERENT.'image/enquete/fin.jpg');?>" alt="" /><br />
    </p>
    <p class="enquete_question"><br />
      Une id&eacute;e, un commentaire ?<br />
      <br />
      Prenez la parole :<br />
      <br />
      <textarea cols="35" rows="4" name="libre" onclick="if(this.value=='Votre message ici') this.value='';">Votre message ici</textarea>
      <br />
      <br />
    </p>
    <p><br />
      <input type="submit" class="submit3" name="submit" value="Poursuivre ma visite sur LOCALERTE.fr" />
    </p>
    <p> <br />
      <b>Merci de votre participation.<br />
      Votre code promo vous sera envoy&eacute; &agrave; votre adresse email.</b><br />
      <br />
      <br />
    </p>
    <?php 	  break;
		default:
		case 0:
	?>
    <p class="t18"> <br />
      ENQU&Ecirc;TE DE SATISFACTION<br />
      sur la nouvelle version de LOCALERTE</p>
    <p class="orange t15 gras"> <br />
      <br />
      <br />
      Accordez-nous 1 minute de votre temps<br />
      et recevez un CODE PROMO gratuit ! </p>
    <p><br />
      <br />
      <br />
      <br />
      <input type="submit" class="submit3" name="submit" value="R&eacute;pondre aux 5 questions" />
      <br />
      <br />
      <input type="submit" class="submit2" name="submit" value="Ne pas r&eacute;pondre" />
      <br />
    </p>
    <?php 	  break;
	} ?>
  </form>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>