<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'date.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	if(!isset($_REQUEST['tarif_abonnement_identifiant']) || !preg_match('/^(ab0013|ab0014|ab0015)$/i',$_REQUEST['tarif_abonnement_identifiant']))
		$_REQUEST['tarif_abonnement_identifiant']='ab0013';
	if(!isset($_REQUEST['paiement_mode']) || !preg_match('/^(CB|WHA)$/i',$_REQUEST['paiement_mode']))
		$_REQUEST['paiement_mode']='CB';
	
	$tarif_abonnement=new ld_tarif_abonnement();
	$tarif_abonnement->identifiant=$_REQUEST['tarif_abonnement_identifiant'];
	$tarif_abonnement->lire();

	if(isset($_REQUEST['annonce_submit']) && $_REQUEST['annonce_submit']!='CB_REFUS' && $_REQUEST['annonce_submit']!='CB_ANNULATION')
	{
		$tarif_abonnement=new ld_tarif_abonnement();
		$tarif_abonnement->identifiant=$_REQUEST['tarif_abonnement_identifiant'];
		if($tarif_abonnement->lire())
		{
			$facture=new ld_facture();
			$facture->identifiant='';
			$facture->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_facture','identifiant',FACTURE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
			$facture->adherent=$_SESSION['adherent_identifiant'];
			$facture->adresse=NULL;
			$facture->complement_adresse=NULL;
			$facture->code_postal=NULL;
			$facture->ville=NULL;
			$facture->raison_sociale=NULL;
			$facture->nom=NULL;
			$facture->prenom=NULL;
			$facture->domaine=$_SERVER['HTTP_HOST'];
			
			$facture_ligne=new ld_facture_ligne();
			$facture_ligne->identifiant='';
			$facture_ligne->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_facture_ligne','identifiant',FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
			$facture_ligne->facture=$facture->nouveau_identifiant;
			$facture_ligne->reference=$tarif_abonnement->identifiant;
			$facture_ligne->designation=duree($tarif_abonnement->delai,'Abonnement de %j jours');
			$facture_ligne->prix_ht=$tarif_abonnement->prix_ht;
			$facture_ligne->quantite=1;
			$facture_ligne->tva=$tarif_abonnement->tva;
			$facture->facture_ligne_ajouter($facture_ligne,'ajouter');
			
			switch($_REQUEST['paiement_mode'])
			{
				case 'CB':
					$facture->ajouter();
					
					$adherent=new ld_adherent();
					$adherent->identifiant=$facture->adherent;
					$adherent->lire();
					
					$paybox=array();
					$paybox['PBX_MODE']=1;											//1 = POST
					$paybox['PBX_SITE']='0559343';	//'1999888';//'0559343';					//donne par la banque
					$paybox['PBX_RANG']='01';		//'99';//'01';						//donne par la banque
					$paybox['PBX_TOTAL']=round($tarif_abonnement->prix_ht*(1+$tarif_abonnement->tva/100)*100,0);	//TOTAL en centimes
					$paybox['PBX_DEVISE']=978;										//978 = EUROS
					$paybox['PBX_CMD']='LA'.$facture->identifiant;					//REFERENCE
					$paybox['PBX_PORTEUR']=$adherent->email;						//EMAIL DU CLIENT
					$paybox['PBX_IDENTIFIANT']='20738281';
					$paybox['PBX_RETOUR']='ref:R;trans:T;auto:A;tarif:M';			//VALIDE LE PAIEMENT
					$paybox['PBX_EFFECTUE']=HTTP_ADHERENT.'annonce/detail.php';
					$paybox['PBX_REFUSE']=HTTP_ADHERENT.'annonce/abonnement.php?tarif_abonnement_identifiant='.$tarif_abonnement->identifiant.'&paiement_mode=CB&annonce_submit=CB_REFUS';
					$paybox['PBX_ANNULE']=HTTP_ADHERENT.'annonce/abonnement.php?tarif_abonnement_identifiant='.$tarif_abonnement->identifiant.'&paiement_mode=CB&annonce_submit=CB_ANNULATION';
					
					//print_r($paybox);
					
					if($socket=fsockopen('paiement.aicom.fr',80))
					{
						$post=array();
						foreach($paybox as $clef=>$valeur)
							$post[]=urlencode($clef).'='.urlencode($valeur);
						$query=implode('&',$post);
						
						$out='';
						$out.='POST /cgi-bin/modulev2.cgi HTTP/1.0'.CRLF;
						$out.='Host: paiement.aicom.fr'.CRLF;
						$out.='Connection: Close'.CRLF;
						$out.='Content-Type: application/x-www-form-urlencode'.CRLF;
						$out.='Content-Length: '.strlen($query).CRLF.CRLF;
						$out.=$query;
						
						fputs($socket,$out,strlen($out));
						
						$in='';
						while(!feof($socket))
							$in.=fgets($socket);
						
						list($header,$body)=explode(CRLF.CRLF,$in,2);
						
						print($body);
						
						fclose($socket);
						die();
					}
					break;
				case 'WHA':
					if(isset($_SESSION['WHA_PAYE']))
					{
						$facture->ajouter();
						$facture->payer('WHA');
						$facture->envoyer();
						unset($_SESSION['WHA_PAYE']);
						header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/detail.php'));
						die();
					}
					break;
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
<script type="text/javascript">
<!--
	function GererWHA()
	{
		if(document.getElementById('WHA').checked)
		{
			window.location='https://mps.w-ha.com/app-mps/purchase?mctId=5216&pid=<?php print(/*'test_123_test_789'*/$_REQUEST['tarif_abonnement_identifiant']);?>&fid=1&mp_wha_desc2=current&mp_securite=<?php print($_SESSION['wha_securite'])?>&mp_r=<?php print(urlencode(HTTP_ADHERENT.'annonce/abonnement.php'));?>&mp_adherent_identifiant=<?php print(urlencode($_SESSION['adherent_identifiant']));?>&mp_paiement_mode=WHA&mp_annonce_submit=WHA_ANNULATION&mp_tarif_abonnement_identifiant=<?php print($_REQUEST['tarif_abonnement_identifiant']);?>';
			return false;
		}
		
		return true;
	}
//-->
</script>
</head>
<body>
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <p class="orange2 moyen gras gauche decale15">Consultation imm&eacute;diate 24h/24, abonnement de <?php print(duree($tarif_abonnement->delai,'%j'));?> jours<br />
      <br />
    </p>
    <p class="lien"><a class="bleu_fonce gras decale20d" href="<?php print(URL_ADHERENT.'annonce/tarif.php');?>">Retour &agrave; la page pr&eacute;c&eacute;dente</a><br /><br />
    </p>
    <form action="<?php print(URL_ADHERENT.'annonce/abonnement.php');?>" method="post" onsubmit="return GererWHA();" id="form_paiement">
      <div class="tarif gauche">
        <?php //if(isset($_REQUEST['paiement_mode'])) print('<p>PAS OK</p>'); ?>
        <input type="hidden" name="tarif_abonnement_identifiant" value="<?php print($_REQUEST['tarif_abonnement_identifiant']);?>" />
        <div id="mode_paiement">
          <h3>Mode de paiement</h3>
          <br />
          <input id="paiement_mode_cb" type="radio" name="paiement_mode" value="CB"<?php if(isset($_REQUEST['paiement_mode']) && ($_REQUEST['paiement_mode']='CB')) print(' checked="checked"');?> />
          <label for="paiement_mode_cb"><img src="<?php print(URL_ADHERENT.'image/paiement/cb.jpg');?>" alt="CB" style="vertical-align:middle;" /></label>
          <br />
          <script type="text/javascript">
		  <!--
		    document.write('<input type="radio" name="paiement_mode" value="WHA" id="WHA" />');
			document.write('<label for="WHA"><img src="<?php print(URL_ADHERENT.'image/paiement/wha.jpg');?>" alt="Internet Plus" style="vertical-align:middle;" /></label>');
		  //-->
		  </script>
          <br />
          <input id="paiement_mode_paypal" type="radio" name="paiement_mode" value="Paypal" disabled="disabled" style="vertical-align:middle" />
          <label for="paiement_mode_paypal"><img src="<?php print(URL_ADHERENT.'image/paiement/paypal.jpg');?>" alt="Paypal" style="vertical-align:middle;" /></label>
        </div>
        <div id="commande">
          <h3>Votre commande</h3>
          <br />
          Consultation imm&eacute;diate<br />
          24h/24 - <?php print(duree($tarif_abonnement->delai,'%j'));?> jours<br />
          <br />
          Total TTC : <?php print(round($tarif_abonnement->prix_ht*(1+$tarif_abonnement->tva/100),0));?> &euro; </div>
        <div id="commande_aide"> En cliquant sur VALIDER, vous serez redirig&eacute;s vers notre plateforme de paiements s&eacute;curis&eacute;s.<br />
          Une fois votre r&egrave;glement op&eacute;r&eacute;, vous consulterez librement en détails toutes les annonces. </div>
        <p class="submit droite"> <br />
          <input class="simple" type="submit" name="annonce_submit" value="Valider" />
        </p>
      </div>
      <p class="lien"><a class="bleu_fonce gras decale20d" href="<?php print(URL_ADHERENT.'annonce/tarif.php');?>">Retour &agrave; la page pr&eacute;c&eacute;dente</a></p>
    </form>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>
