<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'date.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'prolongation':
				$tarif_abonnement=new ld_tarif_abonnement();
				$tarif_abonnement->identifiant=$_REQUEST['tarif_prolongation_identifiant'];
				if(!$tarif_abonnement->lire())
				{
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=tarif_prolongation'));
					die();
				}
				
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
						$paybox['PBX_EFFECTUE']=HTTP_ADHERENT_V2.'annonce/liste.php';
						$paybox['PBX_REFUSE']=HTTP_ADHERENT_V2.'annonce/prolongation.php';
						$paybox['PBX_ANNULE']=HTTP_ADHERENT_V2.'annonce/prolongation.php';
						
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
					case 'CHEQUE':
						$facture->ajouter();
						$facture->envoyer();
						header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=prolongation_cheque&facture_identifiant='.urlencode($facture->identifiant)));
						die();
						break;
					case 'WHA':
						if(isset($_SESSION['WHA_PAYE']))
						{
							$facture->ajouter();
							$facture->payer();
							$facture->envoyer();
							unset($_SESSION['WHA_PAYE']);
						}
						else
						{
							header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=abonnement_wha'));
							die();
						}
						break;
				}
			
				header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/detail.php'));
				die();
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
<script language="javascript">
	function GererWHA()
	{
		if(document.getElementById('paiement_mode2').checked)
		{
			for(i=0;i<document.getElementsByName('tarif_prolongation_identifiant').length;i++)
				if(document.getElementsByName('tarif_prolongation_identifiant')[i].checked)
					OuvrirPopup('https://mps.w-ha.com/app-mps/purchase?mctId=5216&pid='+encodeURIComponent(document.getElementsByName('tarif_prolongation_identifiant')[i].value)+'&fid=1&mp_wha_desc2=current&mp_securite=<?php print($_SESSION['wha_securite'])?>&mp_r=<?php print(urlencode(HTTP_ADHERENT_V2.'annonce/prolongation.php'));?>&mp_adherent_identifiant=<?php print(urlencode($_SESSION['adherent_identifiant']));?>&mp_paiement_mode=WHA&mp_annonce_submit=prolongation&mp_tarif_prolongation_identifiant='+encodeURIComponent(document.getElementsByName('tarif_prolongation_identifiant')[i].value),true,'_self','width=640,height=480');
					//OuvrirPopup('<?php print('http://212.43.196.170/bundle/pos_init?action=authorize&wha_desc2=current&pid=');?>'+encodeURIComponent(document.getElementsByName('tarif_prolongation_identifiant')[i].value)+'&DATAS=&rand=<?php print(urlencode(strrnd(64,4)).'&'.urlencode(session_name()).'='.urlencode(session_id()));?>&r=<?php print(urlencode(HTTP_ADHERENT_V2.'annonce/prolongation.php'));?>&adherent_identifiant=<?php print(urlencode($_SESSION['adherent_identifiant']));?>&paiement_mode=WHA&annonce_submit=prolongation&tarif_prolongation_identifiant='+encodeURIComponent(document.getElementsByName('tarif_prolongation_identifiant')[i].value),true,'_self','width=640,height=480');
			return false;
		}
		
		return true;
	}
</script>
</head>
<body onload="DonnerFocus('annonce_identification','code_reference',0);">
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="annonce_prolongation">Nos annonces du jours - Prolongation</h1>
  <h2 id="prolongation">Abonnement</h2>
  <p id="prolongation"><img src="<?php print(URL_ADHERENT_V2.'image/aide.png');?>" alt="Aide" title="Aide" />Abonnez-vous &agrave; des tarifs pr&eacute;f&eacute;rentiels et acc&eacute;dez 24/24h &agrave; toutes les annonces d&eacute;taill&eacute;es</p>
  <form id="annonce_prolongation" action="<?php print(URL_ADHERENT_V2.'annonce/prolongation.php');?>" method="post" onsubmit="return GererWHA();">
    <input type="hidden" name="annonce_submit" value="prolongation" />
    <div id="tarif_prolongation">
      <label id="champ">Choix de l'abonnement:</label>
      <input type="radio" name="tarif_prolongation_identifiant" value="ab0009" id="tarif_prolongation_identifiant1" />
      <label for="tarif_prolongation_identifiant1" id="position1">7 jours<span id="prix">7&euro;</span></label>
      <input type="radio" name="tarif_prolongation_identifiant" value="ab0010" id="tarif_prolongation_identifiant2" />
      <label for="tarif_prolongation_identifiant2" id="position2">14 jours<span id="prix">13&euro;</span></label>
      <input type="radio" name="tarif_prolongation_identifiant" value="ab0011" id="tarif_prolongation_identifiant3" />
      <label for="tarif_prolongation_identifiant3" id="position3">21 jours<span id="prix">19&euro;</span></label>
      <input type="radio" name="tarif_prolongation_identifiant" value="ab0012" id="tarif_prolongation_identifiant4" checked="checked" />
      <label for="tarif_prolongation_identifiant4" id="position4">28 jours<span id="prix">24&euro;</span></label>
    </div>
    <div id="paiement_mode">
      <label id="champ">Mode de paiement:</label>
      <input type="radio" name="paiement_mode" value="CB" id="paiement_mode1" checked="checked" />
      <label for="paiement_mode1" id="position1"><img src="<?php print(URL_ADHERENT_V2.'image/cb.jpg');?>" alt="Carte bleue" title="Carte bleue" onclick="document.getElementById('paiement_mode1').checked=true;" /></label>
      <script language="javascript">
	    document.write('<input type="radio" name="paiement_mode" value="WHA" id="paiement_mode2" />');
        document.write('<label for="paiement_mode2" id="position2"><img src="<?php print(URL_ADHERENT_V2.'image/internetplus.jpg');?>" alt="Internet Plus" title="Internet Plus" onclick="document.getElementById(\'paiement_mode2\').checked=true;" /></label>');
      </script>
      <input type="radio" name="paiement_mode" value="CHEQUE" id="paiement_mode3" />
      <label for="paiement_mode3" id="position3"><img src="<?php print(URL_ADHERENT_V2.'image/cheque.jpg');?>" alt="Ch&egrave;ques" title="Ch&egrave;ques" onclick="document.getElementById('paiement_mode3').checked=true;" /></label>
    </div>
    <div id="annonce_submit">
      <input type="image" src="<?php print(URL_ADHERENT_V2.'image/bouton_suivant.jpg');?>" />
    </div>
  </form>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
