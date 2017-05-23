<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	$preference=new ld_preference();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
</head>
<body>
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
 <?php include(PWD_ADHERENT_V2.'tete.php');?>
 <?php
 	if(isset($_REQUEST['message_submit']))
	{
		switch($_REQUEST['message_submit'])
		{
			case 'ajouter':
			case 'modifier':
			case 'action':
				print('<h1 id="message">Validation</h1>');
				print('<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Merci de votre confiance. Vous recevrez tr&egrave;s prochainement nos mails correspondants &agrave; vos crit&egrave;res de recherche.<br /><br />Vous pouvez aussi d&egrave;s maintenant consulter nos annonces en <a href="'.URL_ADHERENT_V2.'annonce/liste.php">cliquant ici</a>.<br /><br />Vous pouvez aussi modifier vos crit&egrave;res de recherche en <a href="'.URL_ADHERENT_V2.'compte/fiche.php">cliquant ici</a>.</p>');
				break;
			case 'contact':
				print('<h1 id="message">Validation</h1>');
				print('<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Mail envoy&eacute; avec succ&egrave;s</p>');
				break;
			case 'desabonnement':
				print('<h1 id="message">Validation</h1>');
				print('<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Vous avez bien &eacute;t&eacute; d&eacute;sabonn&eacute; de nos services. Vous ne recevrez plus de mails de notre part.</p>');
				break;
			case 'passe':
				print('<h1 id="message">Validation</h1>');
				print('<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Un e-mail contenant vos identifiants a &eacute;t&eacute; envoy&eacute; &agrave; votre adresse.</p>');
				break;
			case 'code_allopass':
			case 'code_audiotel':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />Votre code est non valable ou vous l\'avez d&eacute;j&agrave; utlis&eacute; (votre code est valable 1 seule fois)<br />
					<br />
					Si vous utilisiez un code promotionnel, v&eacute;rifiez bien sa date de validit&eacute;.<br />
					<br />
					Pour obtenir un code valide, appellez le num&eacute;ro de t&eacute;l&eacute;phone qui vous a &eacute;t&eacute; communiqu&eacute; pr&eacute;c&eacute;demment.<br />
					<br />
					Vous obtiendrez ainsi, de mani&egrave;re rapide, votre code d\'acc&egrave;s.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/identification.php">Cliquez ici</a> pour entrer votre code &agrave; nouveau.</p>
				');
				break;
			case 'code_wha':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />Votre acc&egrave;s aux d&eacute;tails des annonces par Internet+ a &eacute;t&eacute; annul&eacute;e.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/identification.php">Cliquez ici</a> pour retourner &agrave; la page de paiement.</p>
				');
				break;
			case 'tarif_abonnement':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />L\'abonnement que vous souhaitez souscrire n\'existe pas. Merci de choisir un abonnement existant.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/identification.php">Cliquez ici</a> pour retourner &agrave; la page de paiement.</p>
				');
				break;
			case 'abonnement_cheque':
				print('<h1 id="message">Validation</h1>');
				print
				('
					<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Votre nouvel abonnement a bien &eacute;t&eacute; pris en compte. Une facture a &eacute;t&eacute; &eacute;mise du montant demand&eacute;. Veuillez envoyer un ch&egrave;que &agrave; l\'ordre de SARL AICOM &agrave; l\'adresse :<br /><br />AICOM - '.$_SERVER['HTTP_HOST'].'<br />117, rue de la R&eacute;publique<br />83210 La Farl&egrave;de<br />&nbsp;<br />N\'oubliez pas d\'indiquer derri&egrave;re le ch&eacute;que la r&eacute;f&eacute;rence: '.$_SESSION['adherent_identifiant'].'_'.$_REQUEST['facture_identifiant'].'.<br /><br />Vous serez averti par mail de la validation de votre abonnement d&egrave;s la r&eacute;ception de votre ch&egrave;que.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/identification.php">Cliquez ici</a> pour retourner &agrave; la page de paiement.</p>
				');
				break;
			case 'abonnement_wha':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />La souscription de votre abonnement par Internet+ a &eacute;t&eacute; annul&eacute;e.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/identification.php">Cliquez ici</a> pour retourner &agrave; la page de paiement.</p>
				');
				break;
			case 'abus':
				print('<h1 id="message">Validation</h1>');
				print
				('
					<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Mail envoy&eacute; avec succ&egrave;s<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/detail.php">Cliquez ici</a> pour retourner au d&eacute;tail des annonces.</p>
				');
				break;
			case 'tarif_prolongation':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />L\'abonnement que vous souhaitez souscrire n\'existe pas. Merci de choisir un abonnement existant.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/prolongation.php">Cliquez ici</a> pour retourner &agrave; la page de prolongation d\'abonnement.</p>
				');
				break;
			case 'prolongation_cheque':
				print('<h1 id="message">Validation</h1>');
				print
				('
					<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Votre nouvel abonnement a bien &eacute;t&eacute; pris en compte. Une facture a &eacute;t&eacute; &eacute;mise du montant demand&eacute;. Veuillez envoyer un ch&egrave;que &agrave; l\'ordre de SARL AICOM &agrave; l\'adresse :<br /><br />AICOM - '.$_SERVER['HTTP_HOST'].'<br />117, rue de la R&eacute;publique<br />83210 La Farl&egrave;de<br />&nbsp;<br />N\'oubliez pas d\'indiquer derri&egrave;re le ch&eacute;que la r&eacute;f&eacute;rence: '.$_SESSION['adherent_identifiant'].'_'.$_REQUEST['facture_identifiant'].'.<br /><br />Vous serez averti par mail de la validation de votre abonnement d&egrave;s la r&eacute;ception de votre ch&egrave;que.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/prolongation.php">Cliquez ici</a> pour retourner &agrave; la page de prolongation d\'abonnement.</p>
				');
				break;
			case 'prolongation_wha':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />La souscription de votre abonnement par Internet+ a &eacute;t&eacute; annul&eacute;e.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/prolongation.php">Cliquez ici</a> pour retourner &agrave; la page de prolongation d\'abonnement.</p>
				');
				break;
			case 'tarif_forfait':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />Le forfait de codes que vous souhaitez choisi n\'existe pas. Merci de choisir un forfait existant.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/forfait.php">Cliquez ici</a> pour retourner &agrave; la page des forfaits.</p>
				');
				break;
			case 'forfait_cb_refus':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />Votre centre de paiement a refus&eacute; votre forfait.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/forfait.php">Cliquez ici</a> pour retourner &agrave; la page des forfaits.</p>
				');
				break;
			case 'forfait_cb_annulation':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />La souscription de votre forfait par carte bleue a &eacute;t&eacute; annul&eacute;e.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/forfait.php">Cliquez ici</a> pour retourner &agrave; la page des forfaits.</p>
				');
				break;
			case 'forfait_wha_annulation':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />La souscription de votre forfait par Internet+ a &eacute;t&eacute; annul&eacute;e.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/forfait.php">Cliquez ici</a> pour retourner &agrave; la page des forfaits.</p>
				');
				break;
			case 'forfait_cheque':
				print('<h1 id="message">Validation</h1>');
				print
				('
					<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Votre nouveau forfait a bien &eacute;t&eacute; pris en compte. Une facture a &eacute;t&eacute; &eacute;mise du montant demand&eacute;. Veuillez envoyer un ch&egrave;que &agrave; l\'ordre de SARL AICOM &agrave; l\'adresse :<br /><br />AICOM - '.$_SERVER['HTTP_HOST'].'<br />117, rue de la R&eacute;publique<br />83210 La Farl&egrave;de<br />&nbsp;<br />N\'oubliez pas d\'indiquer derri&egrave;re le ch&eacute;que la r&eacute;f&eacute;rence: '.$_SESSION['adherent_identifiant'].'_'.$_REQUEST['facture_identifiant'].'.<br /><br />Vous serez averti par mail des codes d\'acc&egrave;s correspondant &agrave; votre forfait d&egrave;s la r&eacute;ception de votre ch&egrave;que.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/liste.php">Cliquez ici</a> pour retourner &agrave; la liste des annonces.</p>
				');
				break;
			case 'forfait_cb_paiement':
			case 'forfait_wha_paiement':
				$liste=new ld_liste
				('
					select facture_code.code as code
					from facture_code
						inner join facture on facture.identifiant=facture_code.facture
					where facture=\''.addslashes($_REQUEST['facture_identifiant']).'\'
						and adherent=\''.addslashes($_SESSION['adherent_identifiant']).'\'
				');
				
				print('<h1 id="message">Validation</h1>');
				print
				('
					<p id="message_ok"><img src="'.URL_ADHERENT_V2.'image/ok.png" />Votre paiement a &eacute;t&eacute; accept&eacute;. Vos codes d\'acc&egrave;s sont: <br />
				');
				for($i=0;$i<$liste->total;$i++)
					print(ma_htmlentities($liste->occurrence[$i]['code']).'<br />');
				print
				('
					<br />
					Ces codes sont utilisables &agrave; votre gr&eacute; pendant 1 an.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/liste.php">Cliquez ici</a> pour retourner &agrave; la liste des annonces.</p>
				');
				break;
			case 'annonce_vue_jour':
				print('<h1 id="message">Echec</h1>');
				print
				('
					<p id="message_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />La limite des '.$preference->annonce_vue_jour.' annonces lues en 24 heures vient d\'&ecirc;tre atteinte.<br />
					<br />
					Nous vous conseillons de r&eacute;duire votre nombre d\'annonces en ajustant au mieux vos crit&egrave;res de recherche.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'compte/fiche.php">Cliquez ici</a> pour modifier vos crit&egrave;res.<br />
					<br />
					<a href="'.URL_ADHERENT_V2.'annonce/liste.php">Cliquez ici</a> pour retourner &agrave; la liste des annonces.</p>
				');
				break;
		}
	}
 ?>
 <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
