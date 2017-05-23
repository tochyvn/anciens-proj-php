<?php
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'string.php');
	
	define('SMTP_ERREUR',MAIL_TOTAL_ERREUR+1);
	
	$mail=new ld_mail();
	$contact_erreur_classe=0;
	$contact_erreur_sujet=0;
	
	$sujet=array
	(
		'L\'annonce suspecte ('.$_REQUEST['annonce_identifiant'].')',
		'L\'annonce dans une mauvaise rubrique ('.$_REQUEST['annonce_identifiant'].')',
		'L\'annonce expirée ('.$_REQUEST['annonce_identifiant'].')'
	);

	if(isset($_REQUEST['contact_submit']))
	{
		switch($_REQUEST['contact_submit'])
		{
			case 'Envoyer':
				$mail->de=$_REQUEST['mail_de'];
				$mail->a=ini_get('sendmail_from');
				$mail->sujet=$_REQUEST['mail_sujet'];
				$mail->text=$_REQUEST['mail_text'];
				
				$contact_erreur_sujet=!strlen($mail->sujet);
				$contact_erreur_classe=$mail->envoyer();
				if($contact_erreur_classe===true) $contact_erreur_classe=0;
				elseif($contact_erreur_classe===false) $contact_erreur_classe=SMTP_ERREUR;
				break;
		}
	}
	else
	{
		$adherent=new ld_adherent();
		$adherent->identifiant=$_SESSION['adherent_identifiant'];
		$adherent->lire();
		$_REQUEST['mail_de']=$adherent->email;
	}
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Signaler une erreur - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-signaler-une-erreur">
  <div class="header">
    <h1>Signaler une erreur</h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <form action="signaler-une-erreur.php" method="post">
      <?php
	if(isset($_REQUEST['contact_submit']))
	{
		if($contact_erreur_classe)
		{
			print('<ul class="erreur">');
			if($contact_erreur_classe && $contact_erreur_classe&MAIL_DE_ERREUR) print('<li class="erreur">Merci de renseigner votre adresse email.</li>');
			if($contact_erreur_classe && $contact_erreur_classe&MAIL_SUJET_ERREUR) print('<li class="erreur">Merci de renseigner un objet.</li>');
			if($contact_erreur_classe && $contact_erreur_classe&MAIL_TEXT_HTML_FICHIER_ERREUR) print('<li class="erreur">Merci de r&eacute;diger votre message.</li>');
			if($contact_erreur_classe && $contact_erreur_classe&SMTP_ERREUR) print('<li class="erreur">Erreur SMTP</li>');
			print('</ul>');
		}
	  	if(!$contact_erreur_classe) print('<p class="succes">Votre message a bien &eacute;t&eacute; envoy&eacute;.</p>');
	}
	if(!isset($_REQUEST['contact_submit']) || $contact_erreur_classe)
	{
?>
      <p class="champ">
        <input type="text" name="mail_de" value="<?php if(array_key_exists('mail_de',$_REQUEST)) print(ma_htmlentities($_REQUEST['mail_de']));?>" placeholder="Votre adresse e-mail" class="inputrester" autocomplete="off" autofocus>
      </p>
      <hr>
      <p class="champ">
        <select name="mail_sujet" class="selectdefault">
          <option value="">Choisir un motif d'erreur ou d'abus</option>
          <?php
    for($i=0;$i<sizeof($sujet);$i++)
   		print('<option value="'.ma_htmlentities($sujet[$i]).'"'.(($mail->sujet==$sujet[$i])?(' selected="selected"'):('')).'>'.ma_htmlentities($sujet[$i]).'</option>');
?>
        </select>
      </p>
      <hr>
      <p class="champ">
        <textarea name="mail_text" placeholder="Votre message">
<?php if(array_key_exists('mail_text',$_REQUEST)) print(ma_htmlentities($_REQUEST['mail_text']));?>
</textarea>
      </p>
      <p class="action">
        <button class="bouton" type="submit" name="contact_submit" value="Envoyer">Envoyer</button>
      </p>
<?php
	}
?>
      <p class="cache">
        <input type="hidden" name="annonce_identifiant" value="<?php print(ma_htmlentities($_REQUEST['annonce_identifiant']));?>">
      </p>
    </form>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style3.footer.php');?>
  </div>
</div>
</body>
</html>
