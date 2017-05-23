<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
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
				if($contact_erreur===true)
				{
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=contact'));
					die();
				}
				elseif($contact_erreur===false)
					$contact_erreur=SMTP_ERREUR;
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
</head>
<body onload="DonnerFocus('contact','mail_de',0);">
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="contact">Contact</h1>
  <form id="contact" action="<?php print(URL_ADHERENT_V2.'contact.php');?>" method="post">
    <div id="mail_de">
<?php
	if(isset($_REQUEST['contact_submit']) && $contact_erreur & MAIL_DE_ERREUR)
	  	print('<p><img src="'.URL_ADHERENT_V2.'image/ko.png" />Adresse email erron&eacute;</p>');
?>
      <label>Votre adresse email :</label>
      <input type="text" name="mail_de" value="<?php print(ma_htmlentities($mail->de));?>" />
    </div>
    <div id="mail_sujet">
<?php
	if(isset($_REQUEST['contact_submit']) && $contact_erreur & MAIL_SUJET_ERREUR)
	  	print('<p><img src="'.URL_ADHERENT_V2.'image/ko.png" />Sujet trop long</p>');
?>
      <label>Sujet :</label>
      <input type="text" name="mail_sujet" value="<?php print(ma_htmlentities($mail->sujet));?>" maxlength="<?php print(ma_htmlentities(MAIL_SUJET_MAX));?>" />
    </div>
    <div id="mail_text">
<?php
	if(isset($_REQUEST['contact_submit']) && $contact_erreur & MAIL_TEXT_HTML_FICHIER_ERREUR)
	  	print('<p><img src="'.URL_ADHERENT_V2.'image/ko.png" />Message vide. Veuillez y ins&eacute;rer du texte.</p>');
?>
      <label>Message :</label>
      <textarea name="mail_text">
<?php print(ma_htmlentities($mail->text));?></textarea>
    </div>
    <div id="contact_submit">
      <input id="submit" type="submit" name="contact_submit" value="Envoyer" />
    </div>
  </form>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
