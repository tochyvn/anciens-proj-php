<?php
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'string.php');
	
	define('SMTP_ERREUR',MAIL_TOTAL_ERREUR+1);

	$mail=new ld_mail();
	$contact_erreur=0;

	if(isset($_REQUEST['contact_submit']))
	{
		switch($_REQUEST['contact_submit'])
		{
			case 'Envoyer':
				$mail->de=$_REQUEST['mail_de'];
				$mail->a=ini_get('sendmail_from');
				$mail->sujet=$_REQUEST['mail_sujet'];
				$mail->text=$_REQUEST['mail_text'];
				
				$contact_erreur=$mail->envoyer();
				if($contact_erreur===true) $contact_erreur=0;
				elseif($contact_erreur===false) $contact_erreur=SMTP_ERREUR;
				break;
		}
	}
	else
	{
		if(array_key_exists('adherent_identifiant',$_SESSION))
		{
			$adherent=new ld_adherent();
			$adherent->identifiant=$_SESSION['adherent_identifiant'];
			$adherent->lire();
			$_REQUEST['mail_de']=$adherent->email;
		}
	}
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Nous contacter - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-nous-contacter">
  <div class="header">
    <h1>Nous contacter</h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <form action="nous-contacter.php" method="post">
      <?php
	if(isset($_REQUEST['contact_submit']))
	{
		if($contact_erreur)
		{
			print('<ul class="erreur">');
			if($contact_erreur && $contact_erreur&MAIL_DE_ERREUR) print('<li class="erreur">Merci de renseigner votre adresse email.</li>');
			if($contact_erreur && $contact_erreur&MAIL_SUJET_ERREUR) print('<li class="erreur">Merci de renseigner un objet.</li>');
			if($contact_erreur && $contact_erreur&MAIL_TEXT_HTML_FICHIER_ERREUR) print('<li class="erreur">Merci de r&eacute;diger votre message.</li>');
			if($contact_erreur && $contact_erreur&SMTP_ERREUR) print('<li class="erreur">Erreur SMTP</li>');
			print('</ul>');
		}
	  	if(!$contact_erreur) print('<p class="succes">Votre message a bien &eacute;t&eacute; envoy&eacute;.</p>');
	}
	if(!isset($_REQUEST['contact_submit']) || $contact_erreur)
	{
?>
      <p class="champ">
        <input type="text" name="mail_de" value="<?php if(array_key_exists('mail_de',$_REQUEST)) print(ma_htmlentities($_REQUEST['mail_de']));?>" placeholder="Votre adresse e-mail" class="inputreset" autocomplete="off" autofocus>
      </p>
      <hr>
      <p class="champ">
        <input type="text" name="mail_sujet" value="<?php if(array_key_exists('mail_sujet',$_REQUEST)) print(ma_htmlentities($_REQUEST['mail_sujet']));?>" placeholder="Saisissez ici l'objet de votre demande" class="inputreset" autocomplete="off">
      </p>
      <hr>
      <p class="champ">
        <textarea name="mail_text" placeholder="Votre message" class="inputreset">
<?php if(array_key_exists('mail_text',$_REQUEST)) print(ma_htmlentities($_REQUEST['mail_text']));?>
</textarea>
      </p>
      <p class="action">
        <button class="bouton" type="submit" name="contact_submit" value="Envoyer">Envoyer</button>
        <span><span class="orange">AICOM -  LOCALERTE</span><br>
        117 rue de la R&eacute;publique<br>
        83210 La Farl&egrave;de  - RCS.  392485892</span>
      </p>
      <?php
	}
?>
    </form>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style3.footer.php');?>
  </div>
</div>
</body>
</html>
