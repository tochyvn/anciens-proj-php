<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'allopass.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'socket_http.php');
	require_once(PWD_INCLUSION.'wha.php');
	
	define('LIEN_WHA','https://mps.w-ha.com/app-mps/purchase?mctId=5216&amp;pid=LA001&amp;fid=1&amp;mp_wha_desc2=current&amp;mp_securite='.$_SESSION['wha_securite'].'&amp;mp_adherent_identifiant='.urlencode($_SESSION['adherent_identifiant']).'&amp;mp_r='.urlencode(HTTP_ADHERENT.'annonce/tarif.php').'&amp;mp_acte=LA001');
	
	if(isset($_REQUEST['code_reference']))
	{
		$allopass_access=false;
		$allopass_checkcode=false;
		
		if(!isset($_SESSION['code_reference']))
		{
			$code=new ld_code();
			if($code->identifier($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'])=='CODE_UTILISABLE')
			{
				$_SESSION['code_reference']=$_REQUEST['code_reference'];
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'CODE'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
			}
			else
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'CODE'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
		
		if(!isset($_SESSION['code_reference']))
		{
			$identifiant=array('102802','1042318','1607385');
			$socket=new ld_socket_http();
			$socket->url='http://payment.allopass.com/acte/access.apu';
			$socket->delai=30;
			$socket->methode='POST';
			$socket->corps='ids='.urlencode($identifiant[0]).'&'.'idd='.urlencode($identifiant[1]).'&data=&recall=1&code%5B%5D='.urlencode($_REQUEST['code_reference']);
			$socket->executer();
			if(isset($socket->resultat_entete['Location']) && strpos($socket->resultat_entete['Location'],'http://www.localerte.fr/adherent/message.php?message_submit=code_allopass')===false)
			{
				$_SESSION['allopass_reference']=$_REQUEST['code_reference'];
				$allopass_access=$identifiant;
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-270837'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
			}
			else
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-270837'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
				
		if(!isset($_SESSION['code_reference']))
		{
			$identifiant=array('102802','1042319','1607385');
			$socket=new ld_socket_http();
			$socket->url='http://payment.allopass.com/acte/access.apu';
			$socket->delai=30;
			$socket->methode='POST';
			$socket->corps='ids='.urlencode($identifiant[0]).'&'.'idd='.urlencode($identifiant[1]).'&data=&recall=1&code%5B%5D='.urlencode($_REQUEST['code_reference']);
			$socket->executer();
			if(isset($socket->resultat_entete['Location']) && strpos($socket->resultat_entete['Location'],'http://www.localerte.fr/adherent/message.php?message_submit=code_allopass')===false)
			{
				$_SESSION['allopass_reference']=$_REQUEST['code_reference'];
				$allopass_access=$identifiant;
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-481363'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
			}
			else
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-481363'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
		
		if($allopass_access!==false)
		{
			$resultat=explode(CRLF,trim(file_get_contents('http://payment.allopass.com/api/checkcode.apu?code='.urlencode($_REQUEST['code_reference']).'&auth='.urlencode(implode('/',$allopass_access)))));
			if($resultat[0]=='OK')
				if(preg_match('/<revers_palier>(.*)<\/revers_palier>/',file_get_contents('http://payment.allopass.com/api/infocode.apu?code='.urlencode($_REQUEST['code_reference']).'&auth='.urlencode(implode('/',$allopass_access))),$resultat))
				{
					$allopass=new ld_allopass();
					$allopass->reference='';
					$allopass->nouveau_reference=$_REQUEST['code_reference'];
					$allopass->palier=$allopass_access[1];
					$allopass->adherent=$_SESSION['adherent_identifiant'];
					$allopass->prix=floatval($resultat[1]);
					$allopass->ajouter();
					$allopass_checkcode=true;
					file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-CHECK'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
				}
			
			if(!$allopass_checkcode)
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-CHECK'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
	}
	
	if(isset($_SESSION['WHA_PAYE']))
	{
		$wha=new ld_wha();
		$wha->identifiant='';
		$wha->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_wha','identifiant',WHA_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		$wha->adherent=$_SESSION['adherent_identifiant'];
		$wha->prix=1.05;
		$wha->ajouter();
		
		$_SESSION['wha_identifiant']=$wha->identifiant;
		
		unset($_SESSION['WHA_PAYE']);
	}
	
	if(isset($_SESSION['allopass_reference']) || isset($_SESSION['wha_identifiant']) || isset($_SESSION['code_reference']) || $abonnement['resultat']=='ABONNEMENT_UTILISABLE')
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/detail.php'));
		die();
	}
	
	$temp='FR%0899230889%1.46%EUR%%audio'.LF.'S1%81038%3.00%EUR%CODE au 81 038 - 3,00 euros par envoi prix d\'un SMS, 1 envoi de SMS par code d\'acces%sms'.LF.'S3%72720%30.00%SEK%AP till 72 720 - 30 SEK/SMS + (ev. SMS-taxa tillkommer)%sms'.LF.'S9%2098%30.00%NOK%AP till 2098 - 30 NOK pr. SMS%sms';
	//$temp=trim(file_get_contents('http://payment.allopass.com/api/getnum.apu?format=1&idd='.urlencode('270837')));
	$ligne=explode(LF,$temp);
	$plateforme=array();
	for($i=0;$i<sizeof($ligne);$i++)
	{
		$colonne=explode('%',$ligne[$i]);
		$plateforme[$colonne[0]]=$colonne;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
</head>
<body onload="document.getElementById('code_reference').focus();">
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <p class="lien"><a class="bleu_fonce gras decale20d" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste d'annonces</a><br />
      <br />
    </p>
    <div class="tarif">
      <?php
  	if(isset($_REQUEST['formulaire1'])) print('<p class="orange_fonce gauche gras t13">Code invalide.<br />
Votre code vous sera communiqu&eacute; par SMS si vous envoyez le mot « LOC » par SMS au 81 038,<br />ou par messagerie vocale si vous choisissez d\'appeler le 0 899 23 08 89.<br /><br /></p>');
	?>
      <table cellpadding="2">
        <tr>
          <td width="460"><table cellpadding="2">
              <tr>
                <td height="45" valign="middle" width="460" class="bg_bleu_fonce blanc t18 gras" colspan="2">Consultation &agrave; la session : </td>
              </tr>
              <tr>
                <td height="60" valign="middle" class="t15 gras bleu2" colspan="2">Pour voir TOUTES les annonces du site<br />
                  le temps de votre session</td>
              </tr>
              <tr>
                <td width="40" class="bg_bleu_fonce blanc t15 gras"><span class="vText">CHOIX 1</span></td>
                <td height="230" valign="middle" class="bg_bleu_moyen"><img src="<?php print(URL_ADHERENT.'image/paiement/sms2.jpg');?>" alt="Envoyer LOC par SMS au 81 038*" /><br />
                  <b>OU</b><br />
                  <img src="<?php print(URL_ADHERENT.'image/paiement/tel2.jpg');?>" alt="Appeler 0 899 23 08 89*" /><br />
                  <br />
                  Saisissez ici le code obtenu :
                  <br />
                  <form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" class="code">
                    <table cellpadding="0" cellspacing="0"><tr><td width="220" align="center">
                      <input type="hidden" name="formulaire1" value="" />
                      <input type="text" id="code_reference" name="code_reference" value="" />
                    </td><td width="150" align="center">
                      <input type="submit" class="submit simple2" name="annonce_submit" value="Valider" />
                    </td></tr></table>
                  </form>
                  <br />
                  <p class="petit"><br />
                    * Envoyez le mot LOC par SMS au <?php print(ma_htmlentities($plateforme['S1'][1]));?> au tarif de <?php print(ma_htmlentities($plateforme['S1'][2]));?>&euro;+prix du sms.<br />
                    Appel au <?php print(ma_htmlentities(formater($plateforme['FR'][1],'telephone_espace')));?> au tarif de <?php print(ma_htmlentities($plateforme['FR'][2]));?>&euro;<br />hors surco&ucirc;t &eacute;ventuel des op&eacute;rateurs</p></td>
              </tr>
              <tr>
                <td width="40" class="bg_bleu_fonce blanc t15 gras"><span style="filter:flipH() flipV(); writing-mode:tb-rl; white-space: nowrap; -webkit-transform:rotate(270deg); -moz-transform:rotate(270deg);">CHOIX 2</span></td>
                <td height="180" valign="middle" align="center" class="bg_bleu_moyen"><script type="text/javascript">
	  <!--
	  document.write('<span class="t15 gras">Par pr&eacute;l&eacute;vement sur votre facture internet</span><br /><br /><table cellpadding="0" cellspacing="0"><tr><td width="220"><a style="text-decoration:none;" href="<?php print(LIEN_WHA);?>" id="wha"><img src="<?php print(URL_ADHERENT.'image/paiement/wha3.jpg');?>" alt="wha" /></a></td><td width="150"><a style="text-decoration:none;" href="<?php print(LIEN_WHA);?>" id="wha"><input type="submit" class="submit simple2" name="annonce_submit" value="Valider" /></a></td></tr><tr><td colspan="2" align="center"><br />Montant de 1,50 &euro; d&eacute;bit&eacute; sur votre prochaine facture Internet</td></tr></table>');
	  -->
	  </script></td>
              </tr>
            </table></td>
          <td width="460"><table cellpadding="2">
              <tr>
                <td height="45" valign="middle" width="460" class="bg_orange2 blanc t18 gras">Consultation par abonnement : </td>
              </tr>
              <tr>
                <td height="60" valign="middle" class="t15 gras bleu2">Pour voir TOUTES les annonces du site<br />
                  le temps de votre abonnement</td>
              </tr>
              <tr>
                <td height="230" valign="middle" class="bg_orange"><form action="abonnement.php" method="get">
                    <table>
                      <tr>
                        <td width="200"><table cellpadding="2" class="bg_orange2 blanc decale5" width="190">
                            <tr>
                              <td height="46"><label for="tarif_7j" style="display:block;"><b><span class="t18">7</span> jours</b><br />
                                <span class="t15"><b>24h/24</b></span></label></td>
                              <td width="95" class="bg_blanc orange2"><label for="tarif_7j" style="display:block;"><span class="t18"><b>7&euro;</b></span><br />
                                soit 1&euro;/jour</label></td>
                            </tr>
                          </table></td>
                        <td width="30"><input type="radio" name="tarif_abonnement_identifiant" value="ab0013" id="tarif_7j" /></td>
                        <td width="230"><input type="submit" class="submit simple3" name="tarif_submit" value="S'abonner" /></td>
                      </tr>
                      <tr>
                        <td width="200"><table cellpadding="2" class="bg_orange2 blanc decale5" width="190">
                            <tr>
                              <td height="46"><label for="tarif_14j" style="display:block;"><b><span class="t18">14</span> jours</b><br />
                                <span class="t15"><b>24h/24</b></span></label></td>
                              <td width="95" class="bg_blanc orange2"><label for="tarif_14j" style="display:block;"><span class="t18"><b>13&euro;</b></span><br />
                                au lieu de 14&euro;</label></td>
                            </tr>
                          </table></td>
                        <td width="30"><input type="radio" name="tarif_abonnement_identifiant" value="ab0014" id="tarif_14j" /></td>
                        <td rowspan="2" width="230"><input type="image" src="<?php print(URL_ADHERENT.'image/paiement/moyens2.jpg');?>" name="tarif_submit" /></td>
                      </tr>
                      <tr>
                        <td width="200"><table cellpadding="2" class="bg_orange2 blanc decale5" width="190">
                            <tr>
                              <td height="46"><label for="tarif_28j" style="display:block;"><b><span class="t18">28</span> jours</b><br />
                                <span class="t15"><b>24h/24</b></span></label></td>
                              <td width="95" class="bg_blanc orange2"><label for="tarif_28j" style="display:block;"><span class="t18"><b>24&euro;</b></span><br />
                                au lieu de 28&euro;</label></td>
                            </tr>
                          </table></td>
                        <td width="30"><input type="radio" name="tarif_abonnement_identifiant" value="ab0015" id="tarif_28j" checked="checked" /></td>
                      </tr>
                    </table>
                  </form></td>
              </tr>
              <tr>
                <td height="180" valign="middle"><span class="t15 bleu2 gras">Vous disposez d'un code promo ?</span><br />
                  <br />
                  <?php
  	if(isset($_REQUEST['formulaire2'])) print('<p class="orange_fonce gauche gras t13">Code invalide.<br />Merci de v&eacute;rifier le code promotionnel que vous avez re&ccedil;u.<br /><br /></p>');
	?>
                  <span class="t13 bleu2 gras">Saisisez ici le code obtenu:</span>
                  <form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" class="code">
                    <p>
                      <input type="hidden" name="formulaire2" value="" />
                      <input type="text" name="code_reference" value="" />
                      <input type="submit" class="submit simple2" name="annonce_submit" value="Valider" />
                    </p>
                  </form></td>
              </tr>
            </table></td>
        </tr>
      </table>
    </div>
    <p class="lien"><a class="bleu_fonce gras decale20d" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste d'annonces</a></p>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>