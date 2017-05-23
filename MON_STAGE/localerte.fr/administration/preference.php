<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$preference=new ld_preference();
	$preference_erreur=0;
	$preference_succes=0;
	
	if(isset($_REQUEST['preference_submit']))
	{
		$preference->spool_mail_pause=$_REQUEST['preference_spool_mail_pause'];
		$preference->spool_boucle_pause=$_REQUEST['preference_spool_boucle_pause'];
		$preference->spool_boucle_mail=$_REQUEST['preference_spool_boucle_mail'];
		$preference->spool_flush_mail=$_REQUEST['preference_spool_flush_mail'];
		$preference->spool_message_interval=$_REQUEST['preference_spool_message_interval'];
		$preference->acces_bloque=$_REQUEST['preference_acces_bloque'];
		$preference->hardbounce_limite=($_REQUEST['preference_hardbounce_limite']!='')?($_REQUEST['preference_hardbounce_limite']):(NULL);
		$preference->softbounce_limite=($_REQUEST['preference_softbounce_limite']!='')?($_REQUEST['preference_softbounce_limite']):(NULL);
		$preference->plainte_limite=($_REQUEST['preference_plainte_limite']!='')?($_REQUEST['preference_plainte_limite']):(NULL);
		$preference->aide_limite=($_REQUEST['preference_aide_limite']!='')?($_REQUEST['preference_aide_limite']):(NULL);
		$preference->wha_prix=formater($_REQUEST['preference_wha_prix'],'monnaie');
		$preference->expediteur_email=$_REQUEST['preference_expediteur_email'];
		$preference->retour_email=$_REQUEST['preference_retour_email'];
		$preference->retour_pop_utilisateur=$_REQUEST['preference_retour_pop_utilisateur'];
		$preference->retour_pop_passe=$_REQUEST['preference_retour_pop_passe'];
		$preference->retour_pop_serveur=$_REQUEST['preference_retour_pop_serveur'];
		$preference->retour_pop_port=$_REQUEST['preference_retour_pop_port'];
		$preference->retour_nettoyage_mail_par_boucle=$_REQUEST['preference_retour_nettoyage_mail_par_boucle'];
		$preference->retour_nettoyage_pause=$_REQUEST['preference_retour_nettoyage_pause'];
		$preference->reponse_email=$_REQUEST['preference_reponse_email'];
		$preference->desabonnement_email=$_REQUEST['preference_desabonnement_email'];
		$preference->desabonnement_pop_utilisateur=$_REQUEST['preference_desabonnement_pop_utilisateur'];
		$preference->desabonnement_pop_passe=$_REQUEST['preference_desabonnement_pop_passe'];
		$preference->desabonnement_pop_serveur=$_REQUEST['preference_desabonnement_pop_serveur'];
		$preference->desabonnement_pop_port=$_REQUEST['preference_desabonnement_pop_port'];
		$preference->desabonnement_nettoyage_mail_par_boucle=$_REQUEST['preference_desabonnement_nettoyage_mail_par_boucle'];
		$preference->desabonnement_nettoyage_pause=$_REQUEST['preference_desabonnement_nettoyage_pause'];
		$preference->spool_rappel_interval=$_REQUEST['preference_spool_rappel_interval'];
		$preference->spool_inactivite_jour=$_REQUEST['preference_spool_inactivite_jour'];
		$preference->spool_veille_jour=$_REQUEST['preference_spool_veille_jour'];
		$preference->annonce_chemin_dossier=$_REQUEST['preference_annonce_chemin_dossier'];
		$preference->annonce_affiche_dernier_jour=$_REQUEST['preference_annonce_affiche_dernier_jour'];
		$preference->annonce_affiche_lu=$_REQUEST['preference_annonce_affiche_lu'];
		$preference->comptabilite_email=$_REQUEST['preference_comptabilite_email'];
		$preference->ip_paiement=($_REQUEST['preference_ip_paiement']!='')?($_REQUEST['preference_ip_paiement']):(NULL);
		$preference->http_exclusion=($_REQUEST['preference_http_exclusion']!='')?($_REQUEST['preference_http_exclusion']):(NULL);
		$preference->plainte_email=$_REQUEST['preference_plainte_email'];
		$preference->plainte_pop_utilisateur=$_REQUEST['preference_plainte_pop_utilisateur'];
		$preference->plainte_pop_passe=$_REQUEST['preference_plainte_pop_passe'];
		$preference->plainte_pop_serveur=$_REQUEST['preference_plainte_pop_serveur'];
		$preference->plainte_pop_port=$_REQUEST['preference_plainte_pop_port'];
		$preference->plainte_nettoyage_mail_par_boucle=$_REQUEST['preference_plainte_nettoyage_mail_par_boucle'];
		$preference->plainte_nettoyage_pause=$_REQUEST['preference_plainte_nettoyage_pause'];
		$preference->cookie_duree_vie=$_REQUEST['preference_cookie_duree_vie'];
		$preference->annonce_vue_jour=($_REQUEST['preference_annonce_vue_jour']!='')?($_REQUEST['preference_annonce_vue_jour']):(NULL);
		$preference->spool_aide_jour=$_REQUEST['preference_spool_aide_jour'];
		$preference->spool_vieux_jour=$_REQUEST['preference_spool_vieux_jour'];
		
		switch($_REQUEST['preference_submit'])
		{
			case 'Enregistrer':
				$preference_erreur=$preference->modifier();
				if(gmp_strval($preference_erreur)=='0')
					$preference_succes=FICHE_SUCCES_MODIFIER;
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('preference_retour_nettoyage_mail_par_boucle');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Pr&eacute;f&eacute;rence</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['preference_submit']))
	{
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_FILTRE))) print('La pause entre chaque mail du spool doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_MAIL_PAUSE_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_MAIL_PAUSE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_FILTRE))) print('La pause apr&egrave;s chaque boucle du spool doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_BOUCLE_PAUSE_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_BOUCLE_PAUSE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_FILTRE))) print('Le nombre de mails &agrave; chaque boucle du spool doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_BOUCLE_MAIL_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_BOUCLE_MAIL_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_FILTRE))) print('Le nombre de mails entre chaque flush doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_FLUSH_MAIL_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_FLUSH_MAIL_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_FILTRE))) print('La pause entre chaque mail du spool doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_MESSAGE_INTERVAL_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_MESSAGE_INTERVAL_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_ACCES_BLOQUE_ERREUR))) print('Choisissez de bloquer ou non l\'acc&egrave;s<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_FILTRE))) print('La valeur de hardbounce limitant l\'envoi doit &ecirc;tre un nombre entier compris entre '.ma_htmlentities(PREFERENCE_HARDBOUNCE_LIMITE_MIN).' et '.ma_htmlentities(PREFERENCE_HARDBOUNCE_LIMITE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_FILTRE))) print('La valeur de softbounce limitant l\'envoi doit &ecirc;tre un nombre entier compris entre '.ma_htmlentities(PREFERENCE_SOFTBOUNCE_LIMITE_MIN).' et '.ma_htmlentities(PREFERENCE_SOFTBOUNCE_LIMITE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_LIMITE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_LIMITE_ERREUR_FILTRE))) print('La valeur des plaintes  limitant l\'envoi doit &ecirc;tre un nombre entier compris entre '.ma_htmlentities(PREFERENCE_PLAINTE_LIMITE_MIN).' et '.ma_htmlentities(PREFERENCE_PLAINTE_LIMITE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_AIDE_LIMITE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_AIDE_LIMITE_ERREUR_FILTRE))) print('Le nombre de jours avant de recevoir l\'aide doit &ecirc;tre un nombre entier compris entre '.ma_htmlentities(PREFERENCE_AIDE_LIMITE_MIN).' et '.ma_htmlentities(PREFERENCE_AIDE_LIMITE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_WHA_PRIX_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_WHA_PRIX_ERREUR_FILTRE))) print('La valeur du prix d\'une transaction WHA doit &ecirc;tre un nombre mon&eacute;tique compris entre '.ma_htmlentities(PREFERENCE_WHA_PRIX_MIN).' et '.ma_htmlentities(PREFERENCE_WHA_PRIX_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_FILTRE))) print('L\'email de l\'expediteur n\'est pas un email valide.<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_EMAIL_ERREUR_FILTRE))) print('L\'email de retour n\'est pas un email valide.<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_UTILISATEUR_ERREUR))) print('L\'utilisateur POP de retour doit &ecirc;tre compris entre '.ma_htmlentities(PREFERENCE_RETOUR_POP_UTILISATEUR_MIN).' et '.ma_htmlentities(PREFERENCE_RETOUR_POP_UTILISATEUR_MAX).' caract&egrave;res<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_PASSE_ERREUR))) print('Le mot de passe POP de retour doit &ecirc;tre compris entre '.ma_htmlentities(PREFERENCE_RETOUR_POP_PASSE_MIN).' et '.ma_htmlentities(PREFERENCE_RETOUR_POP_PASSE_MAX).' caract&egrave;res<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_FILTRE))) print('Le serveur POP de retour n\'est pas un serveur valide<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_PORT_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_PORT_ERREUR_FILTRE))) print('Le port POP de retour n\'est pas un port valide<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE))) print('La valeur du nombre de mails de retour à nettoyer par boucle doit &ecirc;tre un nombre entier compris entre '.ma_htmlentities(PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_MIN).' et '.ma_htmlentities(PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_FILTRE))) print('La pause entre chaque boucle du nettoyage de retour doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_RETOUR_NETTOYAGE_PAUSE_MIN).' et '.ma_htmlentities(PREFERENCE_RETOUR_NETTOYAGE_PAUSE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_REPONSE_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_REPONSE_EMAIL_ERREUR_FILTRE))) print('L\'email de r&eacute;ponse n\'est pas un email valide.<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_FILTRE))) print('L\'email de d&eacute;sabonnement n\'est pas un email valide.<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_ERREUR))) print('L\'utilisateur POP de d&eacute;sabonnement doit &ecirc;tre compris entre '.ma_htmlentities(PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_MIN).' et '.ma_htmlentities(PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_MAX).' caract&egrave;res<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_PASSE_ERREUR))) print('Le mot de passe POP de d&eacute;sabonnement doit &ecirc;tre compris entre '.ma_htmlentities(PREFERENCE_DESABONNEMENT_POP_PASSE_MIN).' et '.ma_htmlentities(PREFERENCE_DESABONNEMENT_POP_PASSE_MAX).' caract&egrave;res<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_FILTRE))) print('Le serveur POP de d&eacute;sabonnement n\'est pas un serveur valide<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_FILTRE))) print('Le port POP de d&eacute;sabonnement n\'est pas un port valide<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE))) print('La valeur du nombre de mails de d&eacute;sabonnement à nettoyer par boucle doit &ecirc;tre un nombre entier compris entre '.ma_htmlentities(PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_MIN).' et '.ma_htmlentities(PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_FILTRE))) print('La pause entre chaque boucle du nettoyage de d&eacute;sabonnement doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_MIN).' et '.ma_htmlentities(PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_FILTRE))) print('L\'interval entre deux rappels doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_RAPPEL_INTERVAL_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_RAPPEL_INTERVAL_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_FILTRE))) print('Le nombre de jours avant l\'offre du code doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_INACTIVITE_JOUR_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_INACTIVITE_JOUR_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_FILTRE))) print('Le nombre de jours avant la veille doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_VEILLE_JOUR_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_VEILLE_JOUR_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_LONGUEUR))  || gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_DIR))) print('Le chemin vers de le dossier d\'annocnes n\'est pas valide<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_FILTRE))) print('Le nombre de jours des derni&egrave;res annonces &agrave; afficher doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_VEILLE_JOUR_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_VEILLE_JOUR_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_FILTRE))) print('Le nombre de jours des annonces lues &agrave; afficher comme telles doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_VEILLE_JOUR_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_VEILLE_JOUR_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_COMPTABILITE_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_COMPTABILITE_EMAIL_ERREUR_FILTRE))) print('L\'email de la comptabilit&eacute; n\'est pas un email valide.<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_IP_PAIEMENT_ERREUR))) print('L\'IP de paiement n\'est pas une IP valide.<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_HTTP_EXCLUSION_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_HTTP_EXCLUSION_ERREUR_FILTRE))) print('L\'URL pour les exclusions n\'est pas un email valide.<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_EMAIL_ERREUR_FILTRE))) print('L\'email de plainte n\'est pas un email valide.<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_UTILISATEUR_ERREUR))) print('L\'utilisateur POP des plaintes doit &ecirc;tre compris entre '.ma_htmlentities(PREFERENCE_PLAINTE_POP_UTILISATEUR_MIN).' et '.ma_htmlentities(PREFERENCE_PLAINTE_POP_UTILISATEUR_MAX).' caract&egrave;res<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_PASSE_ERREUR))) print('Le mot de passe POP des plaintes doit &ecirc;tre compris entre '.ma_htmlentities(PREFERENCE_PLAINTE_POP_PASSE_MIN).' et '.ma_htmlentities(PREFERENCE_PLAINTE_POP_PASSE_MAX).' caract&egrave;res<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_FILTRE))) print('Le serveur POP des plaintes n\'est pas un serveur valide<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_PORT_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_PORT_ERREUR_FILTRE))) print('Le port POP des plaintes n\'est pas un port valide<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE))) print('La valeur du nombre de mails des plaintes à nettoyer par boucle doit &ecirc;tre un nombre entier compris entre '.ma_htmlentities(PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_MIN).' et '.ma_htmlentities(PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_FILTRE))) print('La pause entre chaque boucle du nettoyage des plaintes doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_MIN).' et '.ma_htmlentities(PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_COOKIE_DUREE_VIE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_COOKIE_DUREE_VIE_ERREUR_FILTRE))) print('La pause entre chaque boucle du nettoyage des plaintes doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_COOKIE_DUREE_VIE_MIN).' et '.ma_htmlentities(PREFERENCE_COOKIE_DUREE_VIE_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_FILTRE))) print('La nombre autoris&eacute; d\'annonces par 24 heures doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_ANNONCE_VUE_JOUR_MIN).' et '.ma_htmlentities(PREFERENCE_ANNONCE_VUE_JOUR_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_FILTRE))) print('Le nombre de jours avant le mail d\'aide doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_AIDE_JOUR_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_AIDE_JOUR_MAX).'<br />');
		if(gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_FILTRE))) print('Le nombre de jours avant le mail de vieux doit &ecirc;tre un entier compris entre '.ma_htmlentities(PREFERENCE_SPOOL_VIEUX_JOUR_MIN).' et '.ma_htmlentities(PREFERENCE_SPOOL_VIEUX_JOUR_MAX).'<br />');
		if($preference_succes & FICHE_SUCCES_MODIFIER) print('Les pr&eacute;f&eacute;rences ont bien &eacute;t&eacute; modifi&eacute;es<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="preference.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_FILTRE)))) print(' class="important"');?>>Pause entre chaque mail du spool  : </td>
                  <td><input name="preference_spool_mail_pause" type="text" id="preference_spool_mail_pause" value="<?php print(ma_htmlentities($preference->spool_mail_pause));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_MAIL_PAUSE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_FILTRE)))) print(' class="important"');?>>Pause  apr&egrave;s chaque boucle du spool  : </td>
                  <td><input name="preference_spool_boucle_pause" type="text" id="preference_spool_boucle_pause" value="<?php print(ma_htmlentities($preference->spool_boucle_pause));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_BOUCLE_PAUSE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de mails  &agrave; chaque boucle du spool  : </td>
                  <td><input name="preference_spool_boucle_mail" type="text" id="preference_spool_boucle_mail" value="<?php print(ma_htmlentities($preference->spool_boucle_mail));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_BOUCLE_MAIL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de mails  entre chaque flush: </td>
                  <td><input name="preference_spool_flush_mail" type="text" id="preference_spool_flush_mail" value="<?php print(ma_htmlentities($preference->spool_flush_mail));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_FLUSH_MAIL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de mail avant d'afficher les messages  : </td>
                  <td><input name="preference_spool_message_interval" type="text" id="preference_spool_message_interval" value="<?php print(ma_htmlentities($preference->spool_message_interval));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_MESSAGE_INTERVAL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && gmp_strval(gmp_and($preference_erreur,PREFERENCE_ACCES_BLOQUE_ERREUR))) print(' class="important"');?>>Acc&egrave;s bloqu&eacute;: </td>
                  <td><input name="preference_acces_bloque" type="radio" id="preference_acces_bloque_oui" value="OUI"<?php if($preference->acces_bloque=='OUI') print(' checked="checked"');?> />
                    <label for="preference_acces_bloque_oui">Oui</label>
                    <br />
                    <input name="preference_acces_bloque" type="radio" id="preference_acces_bloque_non" value="NON"<?php if($preference->acces_bloque=='NON') print(' checked="checked"');?> />
                    <label for="preference_acces_bloque_non">Non</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de hardbounce limitant l'envoi: </td>
                  <td><input name="preference_hardbounce_limite" type="text" id="preference_hardbounce_limite" value="<?php print(ma_htmlentities($preference->hardbounce_limite));?>" maxlength="<?php print(strlen(PREFERENCE_HARDBOUNCE_LIMITE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de softbounce limitant l'envoi: </td>
                  <td><input name="preference_softbounce_limite" type="text" id="preference_softbounce_limite" value="<?php print(ma_htmlentities($preference->softbounce_limite));?>" maxlength="<?php print(strlen(PREFERENCE_SOFTBOUNCE_LIMITE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_LIMITE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_LIMITE_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre des plaintes limitant l'envoi: </td>
                  <td><input name="preference_plainte_limite" type="text" id="preference_plainte_limite" value="<?php print(ma_htmlentities($preference->plainte_limite));?>" maxlength="<?php print(strlen(PREFERENCE_PLAINTE_LIMITE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_LIMITE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_AIDE_LIMITE_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de jours avant de recevoir l'aide: </td>
                  <td><input name="preference_aide_limite" type="text" id="preference_aide_limite" value="<?php print(ma_htmlentities($preference->aide_limite));?>" maxlength="<?php print(strlen(PREFERENCE_AIDE_LIMITE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_WHA_PRIX_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_WHA_PRIX_ERREUR_FILTRE)))) print(' class="important"');?>>Prix d'une transaction WHA: </td>
                  <td><input name="preference_wha_prix" type="text" id="preference_wha_prix" value="<?php print(ma_htmlentities($preference->wha_prix));?>" maxlength="<?php print(strlen(PREFERENCE_WHA_PRIX_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_FILTRE)))) print(' class="important"');?>>Email de l'exp&eacute;diteur : </td>
                  <td><input name="preference_expediteur_email" type="text" id="preference_expediteur_email" value="<?php print(ma_htmlentities($preference->expediteur_email));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_EXPEDITEUR_EMAIL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_EMAIL_ERREUR_FILTRE)))) print(' class="important"');?>>Email de retour: </td>
                  <td><input name="preference_retour_email" type="text" id="preference_retour_email" value="<?php print(ma_htmlentities($preference->retour_email));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_RETOUR_EMAIL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_UTILISATEUR_ERREUR))) print(' class="important"');?>>Utilisateur POP de retour: </td>
                  <td><input name="preference_retour_pop_utilisateur" type="text" id="preference_retour_pop_utilisateur" value="<?php print(ma_htmlentities($preference->retour_pop_utilisateur));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_RETOUR_POP_UTILISATEUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_PASSE_ERREUR))) print(' class="important"');?>>Mot de passe POP de retour: </td>
                  <td><input name="preference_retour_pop_passe" type="text" id="preference_retour_pop_passe" value="<?php print(ma_htmlentities($preference->retour_pop_passe));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_RETOUR_POP_PASSE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_FILTRE)))) print(' class="important"');?>>Serveur POP de retour: </td>
                  <td><input name="preference_retour_pop_serveur" type="text" id="preference_retour_pop_serveur" value="<?php print(ma_htmlentities($preference->retour_pop_serveur));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_RETOUR_POP_SERVEUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_PORT_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_POP_PORT_ERREUR_FILTRE)))) print(' class="important"');?>>Port POP de retour: </td>
                  <td><input name="preference_retour_pop_port" type="text" id="preference_retour_pop_port" value="<?php print(ma_htmlentities($preference->retour_pop_port));?>" maxlength="<?php print(strlen(PREFERENCE_RETOUR_POP_PORT_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de mails de retour &agrave; nettoyer par boucle : </td>
                  <td><input name="preference_retour_nettoyage_mail_par_boucle" type="text" id="preference_retour_nettoyage_mail_par_boucle" value="<?php print(ma_htmlentities($preference->retour_nettoyage_mail_par_boucle));?>" maxlength="<?php print(ma_htmlentities(strlen(PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_MAX)))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_FILTRE)))) print(' class="important"');?>>Pause apr&egrave;s chaque boucle du nettoyage de retour: </td>
                  <td><input name="preference_retour_nettoyage_pause" type="text" id="preference_retour_nettoyage_pause" value="<?php print(ma_htmlentities($preference->retour_nettoyage_pause));?>" maxlength="<?php print(strlen(PREFERENCE_RETOUR_NETTOYAGE_PAUSE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_REPONSE_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_REPONSE_EMAIL_ERREUR_FILTRE)))) print(' class="important"');?>>Email de r&eacute;ponse: </td>
                  <td><input name="preference_reponse_email" type="text" id="preference_reponse_email" value="<?php print(ma_htmlentities($preference->reponse_email));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_REPONSE_EMAIL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_FILTRE)))) print(' class="important"');?>>Email de d&eacute;sabonnement: </td>
                  <td><input name="preference_desabonnement_email" type="text" id="preference_desabonnement_email" value="<?php print(ma_htmlentities($preference->desabonnement_email));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_DESABONNEMENT_EMAIL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_ERREUR))) print(' class="important"');?>>Utilisateur POP de d&eacute;sabonnement: </td>
                  <td><input name="preference_desabonnement_pop_utilisateur" type="text" id="preference_desabonnement_pop_utilisateur" value="<?php print(ma_htmlentities($preference->desabonnement_pop_utilisateur));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_PASSE_ERREUR))) print(' class="important"');?>>Mot de passe POP de d&eacute;sabonnement: </td>
                  <td><input name="preference_desabonnement_pop_passe" type="text" id="preference_desabonnement_pop_passe" value="<?php print(ma_htmlentities($preference->desabonnement_pop_passe));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_DESABONNEMENT_POP_PASSE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_FILTRE)))) print(' class="important"');?>>Serveur POP de d&eacute;sabonnement: </td>
                  <td><input name="preference_desabonnement_pop_serveur" type="text" id="preference_desabonnement_pop_serveur" value="<?php print(ma_htmlentities($preference->desabonnement_pop_serveur));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_DESABONNEMENT_POP_SERVEUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_FILTRE)))) print(' class="important"');?>>Port POP de d&eacute;sabonnement: </td>
                  <td><input name="preference_desabonnement_pop_port" type="text" id="preference_desabonnement_pop_port" value="<?php print(ma_htmlentities($preference->desabonnement_pop_port));?>" maxlength="<?php print(strlen(PREFERENCE_DESABONNEMENT_POP_PORT_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de mails de d&eacute;sabonnement &agrave; nettoyer par boucle : </td>
                  <td><input name="preference_desabonnement_nettoyage_mail_par_boucle" type="text" id="preference_desabonnement_nettoyage_mail_par_boucle" value="<?php print(ma_htmlentities($preference->desabonnement_nettoyage_mail_par_boucle));?>" maxlength="<?php print(ma_htmlentities(strlen(PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_MAX)))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_FILTRE)))) print(' class="important"');?>>Pause apr&egrave;s chaque boucle du nettoyage de d&eacute;sabonnement: </td>
                  <td><input name="preference_desabonnement_nettoyage_pause" type="text" id="preference_desabonnement_nettoyage_pause" value="<?php print(ma_htmlentities($preference->desabonnement_nettoyage_pause));?>" maxlength="<?php print(strlen(PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_FILTRE)))) print(' class="important"');?>>Interval entre deux rappels  : </td>
                  <td><input name="preference_spool_rappel_interval" type="text" id="preference_spool_rappel_interval" value="<?php print(ma_htmlentities($preference->spool_rappel_interval));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_RAPPEL_INTERVAL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de jours avant l'offre du code: </td>
                  <td><input name="preference_spool_inactivite_jour" type="text" id="preference_spool_inactivite_jour" value="<?php print(ma_htmlentities($preference->spool_inactivite_jour));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_INACTIVITE_JOUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de jours avant la veille  : </td>
                  <td><input name="preference_spool_veille_jour" type="text" id="preference_spool_veille_jour" value="<?php print(ma_htmlentities($preference->spool_veille_jour));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_VEILLE_JOUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_DIR)))) print(' class="important"');?>>Chemin vers le dossier d'annonces : </td>
                  <td><input name="preference_annonce_chemin_dossier" type="text" id="preference_annonce_chemin_dossier" value="<?php print(ma_htmlentities($preference->annonce_chemin_dossier));?>" maxlength="<?php print(PREFERENCE_ANNONCE_CHEMIN_DOSSIER_MAX)?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de jours des derni&egrave;res annonces &agrave; afficher: </td>
                  <td><input name="preference_annonce_affiche_dernier_jour" type="text" id="preference_annonce_affiche_dernier_jour" value="<?php print(ma_htmlentities($preference->annonce_affiche_dernier_jour));?>" maxlength="<?php print(strlen(PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de jours des  annonces lues &agrave; afficher comme telles: </td>
                  <td><input name="preference_annonce_affiche_lu" type="text" id="preference_annonce_affiche_lu" value="<?php print(ma_htmlentities($preference->annonce_affiche_lu));?>" maxlength="<?php print(strlen(PREFERENCE_ANNONCE_AFFICHE_LU_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_COMPTABILITE_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_COMPTABILITE_EMAIL_ERREUR_FILTRE)))) print(' class="important"');?>>Email de la comptabilit&eacute;: </td>
                  <td><input name="preference_comptabilite_email" type="text" id="preference_comptabilite_email" value="<?php print(ma_htmlentities($preference->comptabilite_email));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_COMPTABILITE_EMAIL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && gmp_strval(gmp_and($preference_erreur,PREFERENCE_IP_PAIEMENT_ERREUR))) print(' class="important"');?>>IP de paiement: </td>
                  <td><input name="preference_ip_paiement" type="text" id="preference_ip_paiement" value="<?php print(ma_htmlentities($preference->ip_paiement));?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_HTTP_EXCLUSION_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_HTTP_EXCLUSION_ERREUR_FILTRE)))) print(' class="important"');?>>URL des exclusions:</td>
                  <td><input name="preference_http_exclusion" type="text" id="preference_http_exclusion" value="<?php print(ma_htmlentities($preference->http_exclusion));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_HTTP_EXCLUSION_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_EMAIL_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_EMAIL_ERREUR_FILTRE)))) print(' class="important"');?>>Email des plaintes: </td>
                  <td><input name="preference_plainte_email" type="text" id="preference_plainte_email" value="<?php print(ma_htmlentities($preference->plainte_email));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_PLAINTE_EMAIL_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_UTILISATEUR_ERREUR))) print(' class="important"');?>>Utilisateur POP des plaintes: </td>
                  <td><input name="preference_plainte_pop_utilisateur" type="text" id="preference_plainte_pop_utilisateur" value="<?php print(ma_htmlentities($preference->plainte_pop_utilisateur));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_PLAINTE_POP_UTILISATEUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_PASSE_ERREUR))) print(' class="important"');?>>Mot de passe POP des plaintes: </td>
                  <td><input name="preference_plainte_pop_passe" type="text" id="preference_plainte_pop_passe" value="<?php print(ma_htmlentities($preference->plainte_pop_passe));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_PLAINTE_POP_PASSE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_LONGUEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_FILTRE)))) print(' class="important"');?>>Serveur POP des plaintes: </td>
                  <td><input name="preference_plainte_pop_serveur" type="text" id="preference_plainte_pop_serveur" value="<?php print(ma_htmlentities($preference->plainte_pop_serveur));?>" maxlength="<?php print(ma_htmlentities(PREFERENCE_PLAINTE_POP_SERVEUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_PORT_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_POP_PORT_ERREUR_FILTRE)))) print(' class="important"');?>>Port POP des plaintes: </td>
                  <td><input name="preference_plainte_pop_port" type="text" id="preference_plainte_pop_port" value="<?php print(ma_htmlentities($preference->plainte_pop_port));?>" maxlength="<?php print(strlen(PREFERENCE_PLAINTE_POP_PORT_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de mails des plaintes &agrave; nettoyer par boucle : </td>
                  <td><input name="preference_plainte_nettoyage_mail_par_boucle" type="text" id="preference_plainte_nettoyage_mail_par_boucle" value="<?php print(ma_htmlentities($preference->plainte_nettoyage_mail_par_boucle));?>" maxlength="<?php print(ma_htmlentities(strlen(PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_MAX)))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_FILTRE)))) print(' class="important"');?>>Pause apr&egrave;s chaque boucle du nettoyage des plaintes: </td>
                  <td><input name="preference_plainte_nettoyage_pause" type="text" id="preference_plainte_nettoyage_pause" value="<?php print(ma_htmlentities($preference->plainte_nettoyage_pause));?>" maxlength="<?php print(strlen(PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_COOKIE_DUREE_VIE_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_COOKIE_DUREE_VIE_ERREUR_FILTRE)))) print(' class="important"');?>>Dur&eacute;e de vie du cookie (en secondes): </td>
                  <td><input name="preference_cookie_duree_vie" type="text" id="preference_cookie_duree_vie" value="<?php print(ma_htmlentities($preference->cookie_duree_vie));?>" maxlength="<?php print(strlen(PREFERENCE_COOKIE_DUREE_VIE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre autoris&eacute; d'annonces par 24 heures: </td>
                  <td><input name="preference_annonce_vue_jour" type="text" id="preference_annonce_vue_jour" value="<?php print(ma_htmlentities($preference->annonce_vue_jour));?>" maxlength="<?php print(strlen(PREFERENCE_ANNONCE_VUE_JOUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de jours avant le mail d'aide  : </td>
                  <td><input name="preference_spool_aide_jour" type="text" id="preference_spool_aide_jour" value="<?php print(ma_htmlentities($preference->spool_aide_jour));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_AIDE_JOUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['preference_submit']) && (gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_VALEUR)) || gmp_strval(gmp_and($preference_erreur,PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_FILTRE)))) print(' class="important"');?>>Nombre de jours avant le mail des vieux : </td>
                  <td><input name="preference_spool_vieux_jour" type="text" id="preference_spool_vieux_jour" value="<?php print(ma_htmlentities($preference->spool_vieux_jour));?>" maxlength="<?php print(strlen(PREFERENCE_SPOOL_VIEUX_JOUR_MAX))?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="preference_submit" id="preference_submit" value="Enregistrer" /></td>
                </tr>
              </table>
          </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
