<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'string.php');
	
	define('SMTP_ERREUR',MAIL_TOTAL_ERREUR+1);

	$mail=new ld_mail();
	$contact_erreur_classe=0;
	$contact_erreur_sujet=0;
	
	$sujet=array
	(
		'L\'annonce '.$_REQUEST['annonce_identifiant'].' est suspecte',
		'L\'annonce '.$_REQUEST['annonce_identifiant'].' se trouve dans une mauvaise rubrique',
		'L\'annonce '.$_REQUEST['annonce_identifiant'].' est expirée'
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
				$contact_erreur_classe=$mail->tester();
				if(!$contact_erreur_sujet)
				{
					$contact_erreur_classe=$mail->envoyer();
					if($contact_erreur_classe===true) $contact_erreur_classe=0;
					elseif($contact_erreur_classe===false) $contact_erreur_classe=SMTP_ERREUR;
				}
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
    <div id="pub_gauche"></div>
    <div id="abus">
      <h1>Signaler un abus</h1>
      <div class="contact">
        <?php
	if(isset($_REQUEST['contact_submit']))
	{
	  	if($contact_erreur_classe && $contact_erreur_classe&MAIL_DE_ERREUR) print('<p>L\'adresse email n\'est pas correcte.</p>');
	  	if($contact_erreur_sujet || ($contact_erreur_classe && $contact_erreur_classe&MAIL_SUJET_ERREUR)) print('<p>Merci de choisir un sujet</p>');
	  	if($contact_erreur_classe && $contact_erreur_classe&MAIL_TEXT_HTML_FICHIER_ERREUR) print('<p>Merci d\'entrer un message</p>');
	  	if($contact_erreur_classe && $contact_erreur_classe&SMTP_ERREUR) print('<p>Erreur SMTP</p>');
	  	if(!$contact_erreur_classe && !$contact_erreur_sujet) print('<p class="orange_fonce gras gauche"><img src="'.URL_ADHERENT.'image/valid.png"> Le message a bien &eacute;t&eacute; envoy&eacute;</p>');
	}
?>
        <br />
        <form action="abus.php" class="contact" method="post">
          <p>
            <input type="hidden" name="annonce_identifiant" value="<?php print(ma_htmlentities($_REQUEST['annonce_identifiant']));?>" />
            <label>Votre adresse email :</label>
            <input type="text" name="mail_de" value="<?php print(ma_htmlentities($mail->de));?>" />
          </p>
          <p>
            <label>Sujet :</label>
            <select name="mail_sujet">
              <option value="">Faites votre choix</option>
              <?php
    for($i=0;$i<sizeof($sujet);$i++)
   		print('<option value="'.ma_htmlentities($sujet[$i]).'"'.(($mail->sujet==$sujet[$i])?(' selected="selected"'):('')).'>'.ma_htmlentities($sujet[$i]).'</option>');
    ?>
            </select>
          </p>
          <p>
            <label>Message :</label>
            <textarea name="mail_text">
<?php print(ma_htmlentities($mail->text));?></textarea>
          </p>
          <p class="submit"><br />
            <input type="submit" class="submit valider" name="contact_submit" value="Envoyer" />
          </p>
          <p><a class="orange2 gras t15" href="<?php print(URL_ADHERENT.'annonce/detail.php');?>">Retour aux annonces</a><br /><br /></p>
        </form>
      </div>
    </div>
    <div id="pub_droite"></div>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>
