<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'date.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'tarif_forfait.php');
	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'forfait':
				$tarif_forfait=new ld_tarif_forfait();
				$tarif_forfait->identifiant=$_REQUEST['tarif_forfait_identifiant'];
				if(!$tarif_forfait->lire())
				{
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=tarif_forfait'));
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
				$facture_ligne->reference=$tarif_forfait->identifiant;
				$facture_ligne->designation='Forfait de '.$tarif_forfait->nombre.' codes';
				$facture_ligne->prix_ht=$tarif_forfait->prix_ht;
				$facture_ligne->quantite=1;
				$facture_ligne->tva=$tarif_forfait->tva;
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
						$paybox['PBX_TOTAL']=round($tarif_forfait->prix_ht*(1+$tarif_forfait->tva/100)*100,0);	//TOTAL en centimes
						$paybox['PBX_DEVISE']=978;										//978 = EUROS
						$paybox['PBX_CMD']='LA'.$facture->identifiant;					//REFERENCE
						$paybox['PBX_PORTEUR']=$adherent->email;						//EMAIL DU CLIENT
						$paybox['PBX_IDENTIFIANT']='20738281';
						$paybox['PBX_RETOUR']='ref:R;trans:T;auto:A;tarif:M';			//VALIDE LE PAIEMENT
						$paybox['PBX_EFFECTUE']=HTTP_ADHERENT_V2.'message.php?message_submit=forfait_cb_paiement&facture_identifiant='.urlencode($facture->identifiant);
						$paybox['PBX_REFUSE']=HTTP_ADHERENT_V2.'message.php?message_submit=forfait_cb_refus';
						$paybox['PBX_ANNULE']=HTTP_ADHERENT_V2.'message.php?message_submit=forfait_cb_annulation';
						
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
						header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=forfait_cheque&facture_identifiant='.urlencode($facture->identifiant)));
						die();
						break;
					case 'WHA':
						if(isset($_SESSION['WHA_PAYE']))
						{
							$facture->ajouter();
							$facture->payer();
							$facture->envoyer();
							$facture->envoyer('forfait');
							
							unset($_SESSION['WHA_PAYE']);
							
							header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=forfait_wha_paiement&facture_identifiant='.urlencode($facture->identifiant)));
							die();
						}
						else
						{
							header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=forfait_wha_annulation'));
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
			for(i=0;i<document.getElementsByName('tarif_forfait_identifiant').length;i++)
				if(document.getElementsByName('tarif_forfait_identifiant')[i].checked)
					OuvrirPopup('<?php print('http://212.43.196.170/bundle/pos_init?action=authorize&wha_desc2=current&pid=');?>'+encodeURIComponent(document.getElementsByName('tarif_forfait_identifiant')[i].value)+'&DATAS=&rand=<?php print(urlencode(strrnd(64,4)).'&'.urlencode(session_name()).'='.urlencode(session_id()));?>&r=<?php print(urlencode(HTTP_ADHERENT_V2.'annonce/forfait.php'));?>&adherent_identifiant=<?php print(urlencode($_SESSION['adherent_identifiant']));?>&paiement_mode=WHA&annonce_submit=forfait&tarif_forfait_identifiant='+encodeURIComponent(document.getElementsByName('tarif_forfait_identifiant')[i].value),true,'_self','width=640,height=480');
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
  <h1 id="annonce_forfait">Nos annonces du jours - Forfaits</h1>
  <h2 id="forfait">Forfait de codes</h2>
  <p id="forfait"><img src="<?php print(URL_ADHERENT_V2.'image/aide.png');?>" alt="Aide" title="Aide" />Les 5 ou 10 codes sont utilisables &agrave; votre gr&eacute; pendant 1 an. Apr&egrave;s paiement, n'oubliez de noter les codes qui vous seront aussi communiqu&eacute;s par mail.</p>
  <form id="annonce_forfait" action="<?php print(URL_ADHERENT_V2.'annonce/forfait.php');?>" method="post" onsubmit="return GererWHA();">
    <input type="hidden" name="annonce_submit" value="forfait" />
    <div id="tarif_forfait">
      <label id="champ">Choix du forfait:</label>
      <input type="radio" name="tarif_forfait_identifiant" value="fo0001" id="tarif_forfait_identifiant1" />
      <label for="tarif_forfait_identifiant1" id="position1">5 codes<span id="prix">6&euro;</span></label>
      <input type="radio" name="tarif_forfait_identifiant" value="fo0002" id="tarif_forfait_identifiant2" checked="checked" />
      <label for="tarif_forfait_identifiant2" id="position2">10 codes<span id="prix">11&euro;</span></label>
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
      <input type="image" src="<?php print(URL_ADHERENT_V2.'image/bouton_valider.jpg');?>" />
    </div>
  </form>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
