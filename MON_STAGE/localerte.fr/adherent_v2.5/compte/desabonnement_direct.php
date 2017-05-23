<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'string.php');
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
      <h1>D&eacute;sabonnement</h1>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a><br />
        <br />
      </p>
      <p><br />
        Pour vous d&eacute;sabonner, merci de renseigner votre adresse email ci-dessous.<br />
        Votre d&eacute;sabonnement sera effectif imm&eacute;diatement.<br />
        <br />
      </p>
      <div class="contact">
        <?php
	if(isset($_REQUEST['desabonnement_submit']))
	{
	  	if($desabonnement_erreur) print('<p class="orange_fonce gras"><img src="'.URL_ADHERENT.'image/erreur.png" alt="" />Nous ne retrouvons pas cette adresse.<br />V&eacute;rifiez que vous &ecirc;tes bien inscrit &agrave; notre service et que vous avez correctement entr&eacute; votre adresse.</p>');
	  	if(!$desabonnement_erreur) print('<p class="orange_fonce gras"><br /><br /><img src="'.URL_ADHERENT.'image/valid.png" alt="" />Votre d&eacute;sabonnement a &eacute;t&eacute; effectu&eacute;.<br />Si vous vous &ecirc;tes d&eacute;sabonn&eacute; par erreur, <a href="/a_'.$desabonnement->code.'_'.date('Ymd').'reinscription.html" style="font-color:#195292;">cliquez ici</a> pour vous abonner &agrave; nouveau.</p>');
	}
?>
        <br /><form class="contact" action="" method="post">
          <p>
            <label>Votre adresse email:</label>
            <input type="text" name="adherent_email" value="<?php print(ma_htmlentities($desabonnement->email));?>" />
          </p>
          <p class="submit"><br />
            <input type="submit" class="submit simple" name="desabonnement_submit" value="Valider" />
          </p>
        </form>
      </div>
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