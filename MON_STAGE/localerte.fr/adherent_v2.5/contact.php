<?php
	require_once(PWD_ADHERENT.'configuration.php');
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
</head>
<body>
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <div id="pub_gauche">
      <?php include(PWD_ADHERENT.'adsense_gauche.php');?>
    </div>
    <div id="contact">
      <h1>Contact</h1>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a><br />
        <br />
      </p>
      <p><br />
        Pour nous contacter, merci de remplir le formulaire ci-dessous. Toutes les demandes sont prises en compte.<br />
        Nous y r&eacute;pondrons dans les plus brefs d&eacute;lais.<br />
        <br />
      </p>
      <div class="contact">
        <h2>Par email</h2>
        <br />
        <?php
	if(isset($_REQUEST['contact_submit']))
	{
	  	if($contact_erreur && $contact_erreur&MAIL_DE_ERREUR) print('<p class="orange_fonce gras"><img src="'.URL_ADHERENT.'image/erreur.png"> Merci de renseigner votre adresse email.</p>');
	  	if($contact_erreur && $contact_erreur&MAIL_SUJET_ERREUR) print('<p class="orange_fonce gras"><img src="'.URL_ADHERENT.'image/erreur.png"> Merci de renseigner un objet.</p>');
	  	if($contact_erreur && $contact_erreur&MAIL_TEXT_HTML_FICHIER_ERREUR) print('<p class="orange_fonce gras"><img src="'.URL_ADHERENT.'image/erreur.png"> Merci de r&eacute;diger votre message.</p>');
	  	if($contact_erreur && $contact_erreur&SMTP_ERREUR) print('<p class="orange_fonce gras"><img src="'.URL_ADHERENT.'image/erreur.png"> Erreur SMTP</p>');
	  	if(!$contact_erreur) print('<p class="orange_fonce gras"><img src="'.URL_ADHERENT.'image/valid.png"> Votre message a bien &eacute;t&eacute; envoy&eacute;.</p>');
	}
?>
        <br />
        <form class="contact" action="<?php print(URL_ADHERENT.'contact.php');?>" method="post">
          <p>
            <label>Votre adresse email * :</label>
            <input type="text" name="mail_de" value="<?php print(ma_htmlentities($mail->de));?>" />
          </p>
          <p>
            <label>Sujet * :</label>
            <input type="text" name="mail_sujet" value="<?php print(ma_htmlentities($mail->sujet));?>" maxlength="<?php print(ma_htmlentities(MAIL_SUJET_MAX));?>" />
          </p>
          <p>
            <label>Message * :</label>
            <textarea name="mail_text">
<?php print(ma_htmlentities($mail->text));?></textarea>
          </p>
          <p class="petit">* champs obligatoires</p>
          <p class="submit"><br />
            <input type="submit" class="submit simple" name="contact_submit" value="Envoyer" />
          </p>
        </form>
      </div>
      <br />
      <br />
      <div class="contact">
        <h2>Par courrier postal</h2>
        <br />
        <span class="orange2 gras">AICOM - LOCALERTE</span><br />
        117 rue de la R&eacute;publique<br />
        83210 La Farl&egrave;de<br />
        RCS. 392485892<br />
      </div>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a></p>
      <?php include(PWD_ADHERENT.'adsense.php');?>
    </div>
    <div id="pub_droite">
      <?php include(PWD_ADHERENT.'adsense_droit.php');?>
    </div>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>