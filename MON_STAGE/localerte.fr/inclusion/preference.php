<?php
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$define_erreur=0;
	
	define('PREFERENCE_SPOOL_MAIL_PAUSE_MIN',0);
	define('PREFERENCE_SPOOL_MAIL_PAUSE_MAX',pow(2,32));
	define('PREFERENCE_SPOOL_MAIL_PAUSE_NULL',false);
	define('PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//1
	define('PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//2
	
	define('PREFERENCE_SPOOL_BOUCLE_PAUSE_MIN',0);
	define('PREFERENCE_SPOOL_BOUCLE_PAUSE_MAX',pow(2,32));
	define('PREFERENCE_SPOOL_BOUCLE_PAUSE_NULL',false);
	define('PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//4
	define('PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//8
	
	define('PREFERENCE_SPOOL_BOUCLE_MAIL_MIN',1);
	define('PREFERENCE_SPOOL_BOUCLE_MAIL_MAX',65535);
	define('PREFERENCE_SPOOL_BOUCLE_MAIL_NULL',false);
	define('PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//16
	define('PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//32
	
	define('PREFERENCE_SPOOL_FLUSH_MAIL_MIN',0);
	define('PREFERENCE_SPOOL_FLUSH_MAIL_MAX',pow(2,32));
	define('PREFERENCE_SPOOL_FLUSH_MAIL_NULL',false);
	define('PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//64
	define('PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//128
	
	define('PREFERENCE_SPOOL_MESSAGE_INTERVAL_MIN',1);
	define('PREFERENCE_SPOOL_MESSAGE_INTERVAL_MAX',65535);
	define('PREFERENCE_SPOOL_MESSAGE_INTERVAL_NULL',false);
	define('PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//16
	define('PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//32
	
	define('PREFERENCE_ACCES_BLOQUE_ENUM','OUI,NON');
	define('PREFERENCE_ACCES_BLOQUE_NULL',false);
	define('PREFERENCE_ACCES_BLOQUE_ERREUR',gmp_pow(2,$define_erreur++));//256
	
	define('PREFERENCE_SOFTBOUNCE_LIMITE_MIN',1);
	define('PREFERENCE_SOFTBOUNCE_LIMITE_MAX',65535);
	define('PREFERENCE_SOFTBOUNCE_LIMITE_NULL',true);
	define('PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//512
	define('PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//1024
	
	define('PREFERENCE_HARDBOUNCE_LIMITE_MIN',1);
	define('PREFERENCE_HARDBOUNCE_LIMITE_MAX',65535);
	define('PREFERENCE_HARDBOUNCE_LIMITE_NULL',true);
	define('PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//2048
	define('PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4096
	
	define('PREFERENCE_PLAINTE_LIMITE_MIN',1);
	define('PREFERENCE_PLAINTE_LIMITE_MAX',65535);
	define('PREFERENCE_PLAINTE_LIMITE_NULL',true);
	define('PREFERENCE_PLAINTE_LIMITE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//2048
	define('PREFERENCE_PLAINTE_LIMITE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4096
	
	define('PREFERENCE_AIDE_LIMITE_MIN',1);
	define('PREFERENCE_AIDE_LIMITE_MAX',65535);
	define('PREFERENCE_AIDE_LIMITE_NULL',true);
	define('PREFERENCE_AIDE_LIMITE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//2048
	define('PREFERENCE_AIDE_LIMITE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4096
	
	define('PREFERENCE_WHA_PRIX_MIN',0.01);
	define('PREFERENCE_WHA_PRIX_MAX',9999.99);
	define('PREFERENCE_WHA_PRIX_NULL',false);
	define('PREFERENCE_WHA_PRIX_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//8192
	define('PREFERENCE_WHA_PRIX_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//16384
	
	define('PREFERENCE_EXPEDITEUR_EMAIL_MIN',1);
	define('PREFERENCE_EXPEDITEUR_EMAIL_MAX',50);
	define('PREFERENCE_EXPEDITEUR_EMAIL_NULL',false);
	define('PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//32768
	define('PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//65536
	
	define('PREFERENCE_RETOUR_EMAIL_MIN',1);
	define('PREFERENCE_RETOUR_EMAIL_MAX',50);
	define('PREFERENCE_RETOUR_EMAIL_NULL',false);
	define('PREFERENCE_RETOUR_EMAIL_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//131072
	define('PREFERENCE_RETOUR_EMAIL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//262144
	
	define('PREFERENCE_RETOUR_POP_UTILISATEUR_MIN',1);
	define('PREFERENCE_RETOUR_POP_UTILISATEUR_MAX',50);
	define('PREFERENCE_RETOUR_POP_UTILISATEUR_NULL',false);
	define('PREFERENCE_RETOUR_POP_UTILISATEUR_ERREUR',gmp_pow(2,$define_erreur++));//524288
	
	define('PREFERENCE_RETOUR_POP_PASSE_MIN',1);
	define('PREFERENCE_RETOUR_POP_PASSE_MAX',50);
	define('PREFERENCE_RETOUR_POP_PASSE_NULL',false);
	define('PREFERENCE_RETOUR_POP_PASSE_ERREUR',gmp_pow(2,$define_erreur++));//1048576
	
	define('PREFERENCE_RETOUR_POP_SERVEUR_MIN',1);
	define('PREFERENCE_RETOUR_POP_SERVEUR_MAX',50);
	define('PREFERENCE_RETOUR_POP_SERVEUR_NULL',false);
	define('PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//2097152
	define('PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4194304
	
	define('PREFERENCE_RETOUR_POP_PORT_MIN',1);
	define('PREFERENCE_RETOUR_POP_PORT_MAX',65536);
	define('PREFERENCE_RETOUR_POP_PORT_NULL',false);
	define('PREFERENCE_RETOUR_POP_PORT_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//8388608
	define('PREFERENCE_RETOUR_POP_PORT_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//16777216
	
	define('PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_MIN',1);
	define('PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_MAX',65535);
	define('PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_NULL',false);
	define('PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//33554432
	define('PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//67108864
	
	define('PREFERENCE_RETOUR_NETTOYAGE_PAUSE_MIN',0);
	define('PREFERENCE_RETOUR_NETTOYAGE_PAUSE_MAX',pow(2,32));
	define('PREFERENCE_RETOUR_NETTOYAGE_PAUSE_NULL',false);
	define('PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//134217728
	define('PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//268435456
	
	define('PREFERENCE_REPONSE_EMAIL_MIN',1);
	define('PREFERENCE_REPONSE_EMAIL_MAX',50);
	define('PREFERENCE_REPONSE_EMAIL_NULL',false);
	define('PREFERENCE_REPONSE_EMAIL_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//536870912
	define('PREFERENCE_REPONSE_EMAIL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//1073741824
	
	define('PREFERENCE_DESABONNEMENT_EMAIL_MIN',1);
	define('PREFERENCE_DESABONNEMENT_EMAIL_MAX',50);
	define('PREFERENCE_DESABONNEMENT_EMAIL_NULL',false);
	define('PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//2147483648
	define('PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4294967296
	
	define('PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_MIN',1);
	define('PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_MAX',50);
	define('PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_NULL',false);
	define('PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_ERREUR',gmp_pow(2,$define_erreur++));//524288
	
	define('PREFERENCE_DESABONNEMENT_POP_PASSE_MIN',1);
	define('PREFERENCE_DESABONNEMENT_POP_PASSE_MAX',50);
	define('PREFERENCE_DESABONNEMENT_POP_PASSE_NULL',false);
	define('PREFERENCE_DESABONNEMENT_POP_PASSE_ERREUR',gmp_pow(2,$define_erreur++));//1048576
	
	define('PREFERENCE_DESABONNEMENT_POP_SERVEUR_MIN',1);
	define('PREFERENCE_DESABONNEMENT_POP_SERVEUR_MAX',50);
	define('PREFERENCE_DESABONNEMENT_POP_SERVEUR_NULL',false);
	define('PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//2097152
	define('PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4194304
	
	define('PREFERENCE_DESABONNEMENT_POP_PORT_MIN',1);
	define('PREFERENCE_DESABONNEMENT_POP_PORT_MAX',65536);
	define('PREFERENCE_DESABONNEMENT_POP_PORT_NULL',false);
	define('PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//8388608
	define('PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//16777216
	
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_MIN',1);
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_MAX',65535);
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_NULL',false);
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//33554432
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//67108864
	
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_MIN',0);
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_MAX',pow(2,32));
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_NULL',false);
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//134217728
	define('PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//268435456
	
	define('PREFERENCE_SPOOL_RAPPEL_INTERVAL_MIN',0);
	define('PREFERENCE_SPOOL_RAPPEL_INTERVAL_MAX',65535);
	define('PREFERENCE_SPOOL_RAPPEL_INTERVAL_NULL',false);
	define('PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//8589934592
	define('PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//	17179869184

	define('PREFERENCE_SPOOL_INACTIVITE_JOUR_MIN',1);
	define('PREFERENCE_SPOOL_INACTIVITE_JOUR_MAX',65535);
	define('PREFERENCE_SPOOL_INACTIVITE_JOUR_NULL',false);
	define('PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//34359738368
	define('PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//68719476736

	define('PREFERENCE_SPOOL_VEILLE_JOUR_MIN',1);
	define('PREFERENCE_SPOOL_VEILLE_JOUR_MAX',65535);
	define('PREFERENCE_SPOOL_VEILLE_JOUR_NULL',false);
	define('PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//34359738368
	define('PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//68719476736

	define('PREFERENCE_ANNONCE_CHEMIN_DOSSIER_MIN',1);
	define('PREFERENCE_ANNONCE_CHEMIN_DOSSIER_MAX',255);
	define('PREFERENCE_ANNONCE_CHEMIN_DOSSIER_NULL',false);
	define('PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//137438953472
	define('PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_DIR',gmp_pow(2,$define_erreur++));//274877906944

	define('PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_MIN',0);
	define('PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_MAX',127);
	define('PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_NULL',false);
	define('PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//549755813888
	define('PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//1099511627776

	define('PREFERENCE_ANNONCE_AFFICHE_LU_MIN',0);
	define('PREFERENCE_ANNONCE_AFFICHE_LU_MAX',400);
	define('PREFERENCE_ANNONCE_AFFICHE_LU_NULL',false);
	define('PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//549755813888
	define('PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//1099511627776
	
	define('PREFERENCE_COMPTABILITE_EMAIL_MIN',1);
	define('PREFERENCE_COMPTABILITE_EMAIL_MAX',50);
	define('PREFERENCE_COMPTABILITE_EMAIL_NULL',false);
	define('PREFERENCE_COMPTABILITE_EMAIL_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//2199023255552
	define('PREFERENCE_COMPTABILITE_EMAIL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4398046511104
	
	define('PREFERENCE_HTTP_EXCLUSION_MIN',11);
	define('PREFERENCE_HTTP_EXCLUSION_MAX',2048);
	define('PREFERENCE_HTTP_EXCLUSION_NULL',true);
	define('PREFERENCE_HTTP_EXCLUSION_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//2199023255552
	define('PREFERENCE_HTTP_EXCLUSION_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4398046511104
	
	define('PREFERENCE_IP_PAIEMENT_NULL',true);
	define('PREFERENCE_IP_PAIEMENT_ERREUR',gmp_pow(2,$define_erreur++));//17592186044416
	
	define('PREFERENCE_PLAINTE_EMAIL_MIN',1);
	define('PREFERENCE_PLAINTE_EMAIL_MAX',50);
	define('PREFERENCE_PLAINTE_EMAIL_NULL',false);
	define('PREFERENCE_PLAINTE_EMAIL_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//131072
	define('PREFERENCE_PLAINTE_EMAIL_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//262144
	
	define('PREFERENCE_PLAINTE_POP_UTILISATEUR_MIN',1);
	define('PREFERENCE_PLAINTE_POP_UTILISATEUR_MAX',50);
	define('PREFERENCE_PLAINTE_POP_UTILISATEUR_NULL',false);
	define('PREFERENCE_PLAINTE_POP_UTILISATEUR_ERREUR',gmp_pow(2,$define_erreur++));//524288
	
	define('PREFERENCE_PLAINTE_POP_PASSE_MIN',1);
	define('PREFERENCE_PLAINTE_POP_PASSE_MAX',50);
	define('PREFERENCE_PLAINTE_POP_PASSE_NULL',false);
	define('PREFERENCE_PLAINTE_POP_PASSE_ERREUR',gmp_pow(2,$define_erreur++));//1048576
	
	define('PREFERENCE_PLAINTE_POP_SERVEUR_MIN',1);
	define('PREFERENCE_PLAINTE_POP_SERVEUR_MAX',50);
	define('PREFERENCE_PLAINTE_POP_SERVEUR_NULL',false);
	define('PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_LONGUEUR',gmp_pow(2,$define_erreur++));//2097152
	define('PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//4194304
	
	define('PREFERENCE_PLAINTE_POP_PORT_MIN',1);
	define('PREFERENCE_PLAINTE_POP_PORT_MAX',65536);
	define('PREFERENCE_PLAINTE_POP_PORT_NULL',false);
	define('PREFERENCE_PLAINTE_POP_PORT_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//8388608
	define('PREFERENCE_PLAINTE_POP_PORT_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//16777216
	
	define('PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_MIN',1);
	define('PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_MAX',65535);
	define('PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_NULL',false);
	define('PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//33554432
	define('PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//67108864
	
	define('PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_MIN',0);
	define('PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_MAX',pow(2,32));
	define('PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_NULL',false);
	define('PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//134217728
	define('PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//268435456
	
	define('PREFERENCE_COOKIE_DUREE_VIE_MIN',0);
	define('PREFERENCE_COOKIE_DUREE_VIE_MAX',pow(2,32));
	define('PREFERENCE_COOKIE_DUREE_VIE_NULL',false);
	define('PREFERENCE_COOKIE_DUREE_VIE_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//134217728
	define('PREFERENCE_COOKIE_DUREE_VIE_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//268435456
	
	define('PREFERENCE_ANNONCE_VUE_JOUR_MIN',0);
	define('PREFERENCE_ANNONCE_VUE_JOUR_MAX',pow(2,32));
	define('PREFERENCE_ANNONCE_VUE_JOUR_NULL',true);
	define('PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//134217728
	define('PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//268435456

	define('PREFERENCE_SPOOL_AIDE_JOUR_MIN',1);
	define('PREFERENCE_SPOOL_AIDE_JOUR_MAX',65535);
	define('PREFERENCE_SPOOL_AIDE_JOUR_NULL',false);
	define('PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//34359738368
	define('PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//68719476736

	define('PREFERENCE_SPOOL_VIEUX_JOUR_MIN',1);
	define('PREFERENCE_SPOOL_VIEUX_JOUR_MAX',65535);
	define('PREFERENCE_SPOOL_VIEUX_JOUR_NULL',false);
	define('PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_VALEUR',gmp_pow(2,$define_erreur++));//34359738368
	define('PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_FILTRE',gmp_pow(2,$define_erreur++));//68719476736
	
	define('PREFERENCE_TOTAL_ERREUR',gmp_sub(gmp_pow(2,$define_erreur),1));
	
	unset($define_ferreur);
	
	class ld_preference extends ld_sql
	{
		private /*var*/ $erreur;
		private /*var*/ $champs;
		
		/*function ld_preference()
		{
			if(floatval(phpversion())<5)
			{
				$func_get_args=func_get_args();
				call_user_func_array(array(&$this,'__construct'),$func_get_args);
				foreach($this->champs as $clef=>$valeur)
					$this->{$clef}=&$this->champs[$clef];
			}
		}*/
		
		function __construct()
		{
			$this->champs=array();
			$this->champs['spool_mail_pause']=NULL;
			$this->champs['spool_boucle_pause']=NULL;
			$this->champs['spool_boucle_mail']=NULL;
			$this->champs['spool_flush_mail']=NULL;
			$this->champs['spool_message_interval']=NULL;
			$this->champs['acces_bloque']=NULL;
			$this->champs['hardbounce_limite']=NULL;
			$this->champs['softbounce_limite']=NULL;
			$this->champs['plainte_limite']=NULL;
			$this->champs['aide_limite']=NULL;
			$this->champs['wha_prix']=NULL;
			$this->champs['expediteur_email']=NULL;
			$this->champs['retour_email']=NULL;
			$this->champs['retour_pop_utilisateur']=NULL;
			$this->champs['retour_pop_passe']=NULL;
			$this->champs['retour_pop_serveur']=NULL;
			$this->champs['retour_pop_port']=NULL;
			$this->champs['retour_nettoyage_mail_par_boucle']=NULL;
			$this->champs['retour_nettoyage_pause']=NULL;
			$this->champs['reponse_email']=NULL;
			$this->champs['desabonnement_email']=NULL;
			$this->champs['desabonnement_pop_utilisateur']=NULL;
			$this->champs['desabonnement_pop_passe']=NULL;
			$this->champs['desabonnement_pop_serveur']=NULL;
			$this->champs['desabonnement_pop_port']=NULL;
			$this->champs['desabonnement_nettoyage_mail_par_boucle']=NULL;
			$this->champs['desabonnement_nettoyage_pause']=NULL;
			$this->champs['spool_inactivite_jour']=NULL;
			$this->champs['spool_rappel_interval']=NULL;
			$this->champs['spool_veille_jour']=NULL;
			$this->champs['annonce_chemin_dossier']=NULL;
			$this->champs['annonce_affiche_dernier_jour']=NULL;
			$this->champs['annonce_affiche_lu']=NULL;
			$this->champs['comptabilite_email']=NULL;
			$this->champs['ip_paiement']=NULL;
			$this->champs['http_exclusion']=NULL;
			$this->champs['plainte_email']=NULL;
			$this->champs['plainte_pop_utilisateur']=NULL;
			$this->champs['plainte_pop_passe']=NULL;
			$this->champs['plainte_pop_serveur']=NULL;
			$this->champs['plainte_pop_port']=NULL;
			$this->champs['plainte_nettoyage_mail_par_boucle']=NULL;
			$this->champs['plainte_nettoyage_pause']=NULL;
			$this->champs['cookie_duree_vie']=NULL;
			$this->champs['annonce_vue_jour']=NULL;
			$this->champs['spool_aide_jour']=NULL;
			$this->champs['spool_vieux_jour']=NULL;
			
			if(!$this->ouvrir())
			{
				trigger_error('Ouverture de la base de donn&eacute;es impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			if(!$this->lire())
			{
				trigger_error('Lecture de la table des pr&eacute;f&eacute;rences impossible'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
			
			$this->erreur=PREFERENCE_TOTAL_ERREUR;
		}
		
		/*function __destruct()
		{
			$this->fermer();
		}*/
		
		function __get($variable)
		{
			if(array_key_exists($variable,$this->champs))
				return $this->champs[$variable];
			else
			{
				trigger_error('Variable '.$variable.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		function __set($variable,$valeur)
		{
			if(array_key_exists($variable,$this->champs))
			{
				if(1)
					$this->champs[$variable]=$valeur;
				else
				{
					trigger_error('Variable '.$variable.' non modifiable'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
					return false;
				}
			}
			else
			{
				trigger_error('Variable '.$variable.' non d&eacute;finie'.' ---- '.$_SERVER['PHP_SELF'],E_USER_WARNING);
				return false;
			}
		}
		
		private function verifier()
		{
			//SPOOL_MAIL_PAUSE
			if((!PREFERENCE_SPOOL_MAIL_PAUSE_NULL || $this->champs['spool_mail_pause']!==NULL) && (intval($this->champs['spool_mail_pause'])<PREFERENCE_SPOOL_MAIL_PAUSE_MIN || intval($this->champs['spool_mail_pause'])>PREFERENCE_SPOOL_MAIL_PAUSE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_MAIL_PAUSE_NULL || $this->champs['spool_mail_pause']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_mail_pause']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_MAIL_PAUSE_ERREUR_FILTRE));
			//SPOOL_BOUCLE_PAUSE
			if((!PREFERENCE_SPOOL_BOUCLE_PAUSE_NULL || $this->champs['spool_boucle_pause']!==NULL) && (intval($this->champs['spool_boucle_pause'])<PREFERENCE_SPOOL_BOUCLE_PAUSE_MIN || intval($this->champs['spool_boucle_pause'])>PREFERENCE_SPOOL_BOUCLE_PAUSE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_BOUCLE_PAUSE_NULL || $this->champs['spool_boucle_pause']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_boucle_pause']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_BOUCLE_PAUSE_ERREUR_FILTRE));
			//SPOOL_BOUCLE_MAIL
			if((!PREFERENCE_SPOOL_BOUCLE_MAIL_NULL || $this->champs['spool_boucle_mail']!==NULL) && (intval($this->champs['spool_boucle_mail'])<PREFERENCE_SPOOL_BOUCLE_MAIL_MIN || intval($this->champs['spool_boucle_mail'])>PREFERENCE_SPOOL_BOUCLE_MAIL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_BOUCLE_MAIL_NULL || $this->champs['spool_boucle_mail']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_boucle_mail']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_BOUCLE_MAIL_ERREUR_FILTRE));
			//SPOOL_FLUSH_MAIL
			if((!PREFERENCE_SPOOL_FLUSH_MAIL_NULL || $this->champs['spool_flush_mail']!==NULL) && (intval($this->champs['spool_flush_mail'])<PREFERENCE_SPOOL_FLUSH_MAIL_MIN || intval($this->champs['spool_flush_mail'])>PREFERENCE_SPOOL_FLUSH_MAIL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_FLUSH_MAIL_NULL || $this->champs['spool_flush_mail']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_flush_mail']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_FLUSH_MAIL_ERREUR_FILTRE));
			//SPOOL_MESSAGE_INTERVAL
			if((!PREFERENCE_SPOOL_MESSAGE_INTERVAL_NULL || $this->champs['spool_message_interval']!==NULL) && (intval($this->champs['spool_message_interval'])<PREFERENCE_SPOOL_MESSAGE_INTERVAL_MIN || intval($this->champs['spool_message_interval'])>PREFERENCE_SPOOL_MESSAGE_INTERVAL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_MESSAGE_INTERVAL_NULL || $this->champs['spool_message_interval']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_message_interval']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_MESSAGE_INTERVAL_ERREUR_FILTRE));
			//ACCES_BLOQUE
			if((!PREFERENCE_ACCES_BLOQUE_NULL || $this->champs['acces_bloque']!==NULL) && array_search($this->champs['acces_bloque'],explode(',',PREFERENCE_ACCES_BLOQUE_ENUM))===false)
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ACCES_BLOQUE_ERREUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ACCES_BLOQUE_ERREUR));
			//SOFTBOUNCE_LIMITE
			if((!PREFERENCE_SOFTBOUNCE_LIMITE_NULL || $this->champs['softbounce_limite']!==NULL) && (intval($this->champs['softbounce_limite'])<PREFERENCE_SOFTBOUNCE_LIMITE_MIN || intval($this->champs['softbounce_limite'])>PREFERENCE_SOFTBOUNCE_LIMITE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_VALEUR));
			if((!PREFERENCE_SOFTBOUNCE_LIMITE_NULL || $this->champs['softbounce_limite']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['softbounce_limite']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SOFTBOUNCE_LIMITE_ERREUR_FILTRE));
			//HARDBOUNCE_LIMITE
			if((!PREFERENCE_HARDBOUNCE_LIMITE_NULL || $this->champs['hardbounce_limite']!==NULL) && (intval($this->champs['hardbounce_limite'])<PREFERENCE_HARDBOUNCE_LIMITE_MIN || intval($this->champs['hardbounce_limite'])>PREFERENCE_HARDBOUNCE_LIMITE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_VALEUR));
			if((!PREFERENCE_HARDBOUNCE_LIMITE_NULL || $this->champs['hardbounce_limite']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['hardbounce_limite']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_HARDBOUNCE_LIMITE_ERREUR_FILTRE));
			//PLAINTE_LIMITE
			if((!PREFERENCE_PLAINTE_LIMITE_NULL || $this->champs['plainte_limite']!==NULL) && (intval($this->champs['plainte_limite'])<PREFERENCE_PLAINTE_LIMITE_MIN || intval($this->champs['plainte_limite'])>PREFERENCE_PLAINTE_LIMITE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_LIMITE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_LIMITE_ERREUR_VALEUR));
			if((!PREFERENCE_PLAINTE_LIMITE_NULL || $this->champs['plainte_limite']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['plainte_limite']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_LIMITE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_LIMITE_ERREUR_FILTRE));
			//AIDE_LIMITE
			if((!PREFERENCE_AIDE_LIMITE_NULL || $this->champs['aide_limite']!==NULL) && (intval($this->champs['aide_limite'])<PREFERENCE_AIDE_LIMITE_MIN || intval($this->champs['aide_limite'])>PREFERENCE_AIDE_LIMITE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_AIDE_LIMITE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_AIDE_LIMITE_ERREUR_VALEUR));
			if((!PREFERENCE_AIDE_LIMITE_NULL || $this->champs['aide_limite']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['aide_limite']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_AIDE_LIMITE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_AIDE_LIMITE_ERREUR_FILTRE));
			//WHA_PRIX
			if((!PREFERENCE_WHA_PRIX_NULL || $this->champs['wha_prix']!==NULL) && (floatval($this->champs['wha_prix'])<PREFERENCE_WHA_PRIX_MIN || floatval($this->champs['wha_prix'])>PREFERENCE_WHA_PRIX_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_WHA_PRIX_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_WHA_PRIX_ERREUR_VALEUR));
			if((!PREFERENCE_WHA_PRIX_NULL || $this->champs['wha_prix']!==NULL) && !preg_match('/'.STRING_FILTRE_MONNAIE_POSITIF.'/',$this->champs['wha_prix']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_WHA_PRIX_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_WHA_PRIX_ERREUR_FILTRE));
			//EXPEDITEUR_EMAIL
			if((!PREFERENCE_EXPEDITEUR_EMAIL_NULL || $this->champs['expediteur_email']!==NULL) && (strlen($this->champs['expediteur_email'])<PREFERENCE_EXPEDITEUR_EMAIL_MIN || strlen($this->champs['expediteur_email'])>PREFERENCE_EXPEDITEUR_EMAIL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_LONGUEUR));
			if((!PREFERENCE_EXPEDITEUR_EMAIL_NULL || $this->champs['expediteur_email']!==NULL) && !preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['expediteur_email']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_EXPEDITEUR_EMAIL_ERREUR_FILTRE));
			//RETOUR_EMAIL
			if((!PREFERENCE_RETOUR_EMAIL_NULL || $this->champs['retour_email']!==NULL) && (strlen($this->champs['retour_email'])<PREFERENCE_RETOUR_EMAIL_MIN || strlen($this->champs['retour_email'])>PREFERENCE_RETOUR_EMAIL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_EMAIL_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_EMAIL_ERREUR_LONGUEUR));
			if((!PREFERENCE_RETOUR_EMAIL_NULL || $this->champs['retour_email']!==NULL) && !preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['retour_email']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_EMAIL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_EMAIL_ERREUR_FILTRE));
			//RETOUR_POP_UTILISATEUR
			if((!PREFERENCE_RETOUR_POP_UTILISATEUR_NULL || $this->champs['retour_pop_utilisateur']!==NULL) && (strlen($this->champs['retour_pop_utilisateur'])<PREFERENCE_RETOUR_POP_UTILISATEUR_MIN || strlen($this->champs['retour_pop_utilisateur'])>PREFERENCE_RETOUR_POP_UTILISATEUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_POP_UTILISATEUR_ERREUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_POP_UTILISATEUR_ERREUR));
			//RETOUR_POP_PASSE
			if((!PREFERENCE_RETOUR_POP_PASSE_NULL || $this->champs['retour_pop_passe']!==NULL) && (strlen($this->champs['retour_pop_passe'])<PREFERENCE_RETOUR_POP_PASSE_MIN || strlen($this->champs['retour_pop_passe'])>PREFERENCE_RETOUR_POP_PASSE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_POP_PASSE_ERREUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_POP_PASSE_ERREUR));
			//RETOUR_POP_SERVEUR
			if((!PREFERENCE_RETOUR_POP_SERVEUR_NULL || $this->champs['retour_pop_serveur']!==NULL) && (strlen($this->champs['retour_pop_serveur'])<PREFERENCE_RETOUR_POP_SERVEUR_MIN || strlen($this->champs['retour_pop_serveur'])>PREFERENCE_RETOUR_POP_SERVEUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_LONGUEUR));
			if((!PREFERENCE_RETOUR_POP_SERVEUR_NULL || $this->champs['retour_pop_serveur']!==NULL) && !preg_match('/'.STRING_FILTRE_IP.'|'.STRING_FILTRE_DOMAINE.'/',$this->champs['retour_pop_serveur']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_POP_SERVEUR_ERREUR_FILTRE));
			//RETOUR_POP_PORT
			if((!PREFERENCE_RETOUR_POP_PORT_NULL || $this->champs['retour_pop_port']!==NULL) && (intval($this->champs['retour_pop_port'])<PREFERENCE_RETOUR_POP_PORT_MIN || intval($this->champs['retour_pop_port'])>PREFERENCE_RETOUR_POP_PORT_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_POP_PORT_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_POP_PORT_ERREUR_VALEUR));
			if((!PREFERENCE_RETOUR_POP_PORT_NULL || $this->champs['retour_pop_port']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['retour_pop_port']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_POP_PORT_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_POP_PORT_ERREUR_FILTRE));
			//RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE
			if((!PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_NULL || $this->champs['retour_nettoyage_mail_par_boucle']!==NULL) && (intval($this->champs['retour_nettoyage_mail_par_boucle'])<PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_MIN || intval($this->champs['retour_nettoyage_mail_par_boucle'])>PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR));
			if((!PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_NULL || $this->champs['retour_nettoyage_mail_par_boucle']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['retour_nettoyage_mail_par_boucle']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE));
			//RETOUR_NETTOYAGE_PAUSE
			if((!PREFERENCE_RETOUR_NETTOYAGE_PAUSE_NULL || $this->champs['retour_nettoyage_pause']!==NULL) && (intval($this->champs['retour_nettoyage_pause'])<PREFERENCE_RETOUR_NETTOYAGE_PAUSE_MIN || intval($this->champs['retour_nettoyage_pause'])>PREFERENCE_RETOUR_NETTOYAGE_PAUSE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_VALEUR));
			if((!PREFERENCE_RETOUR_NETTOYAGE_PAUSE_NULL || $this->champs['retour_nettoyage_pause']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['retour_nettoyage_pause']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_RETOUR_NETTOYAGE_PAUSE_ERREUR_FILTRE));
			//REPONSE_EMAIL
			if((!PREFERENCE_REPONSE_EMAIL_NULL || $this->champs['reponse_email']!==NULL) && (strlen($this->champs['reponse_email'])<PREFERENCE_REPONSE_EMAIL_MIN || strlen($this->champs['reponse_email'])>PREFERENCE_REPONSE_EMAIL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_REPONSE_EMAIL_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_REPONSE_EMAIL_ERREUR_LONGUEUR));
			if((!PREFERENCE_REPONSE_EMAIL_NULL || $this->champs['reponse_email']!==NULL) && !preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['reponse_email']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_REPONSE_EMAIL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_REPONSE_EMAIL_ERREUR_FILTRE));
			//DESABONNEMENT_EMAIL
			if((!PREFERENCE_DESABONNEMENT_EMAIL_NULL || $this->champs['desabonnement_email']!==NULL) && (strlen($this->champs['desabonnement_email'])<PREFERENCE_DESABONNEMENT_EMAIL_MIN || strlen($this->champs['desabonnement_email'])>PREFERENCE_DESABONNEMENT_EMAIL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_LONGUEUR));
			if((!PREFERENCE_DESABONNEMENT_EMAIL_NULL || $this->champs['desabonnement_email']!==NULL) && !preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['desabonnement_email']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_EMAIL_ERREUR_FILTRE));
			//DESABONNEMENT_POP_UTILISATEUR
			if((!PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_NULL || $this->champs['desabonnement_pop_utilisateur']!==NULL) && (strlen($this->champs['desabonnement_pop_utilisateur'])<PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_MIN || strlen($this->champs['desabonnement_pop_utilisateur'])>PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_ERREUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_POP_UTILISATEUR_ERREUR));
			//DESABONNEMENT_POP_PASSE
			if((!PREFERENCE_DESABONNEMENT_POP_PASSE_NULL || $this->champs['desabonnement_pop_passe']!==NULL) && (strlen($this->champs['desabonnement_pop_passe'])<PREFERENCE_DESABONNEMENT_POP_PASSE_MIN || strlen($this->champs['desabonnement_pop_passe'])>PREFERENCE_DESABONNEMENT_POP_PASSE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_POP_PASSE_ERREUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_POP_PASSE_ERREUR));
			//DESABONNEMENT_POP_SERVEUR
			if((!PREFERENCE_DESABONNEMENT_POP_SERVEUR_NULL || $this->champs['desabonnement_pop_serveur']!==NULL) && (strlen($this->champs['desabonnement_pop_serveur'])<PREFERENCE_DESABONNEMENT_POP_SERVEUR_MIN || strlen($this->champs['desabonnement_pop_serveur'])>PREFERENCE_DESABONNEMENT_POP_SERVEUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_LONGUEUR));
			if((!PREFERENCE_DESABONNEMENT_POP_SERVEUR_NULL || $this->champs['desabonnement_pop_serveur']!==NULL) && !preg_match('/'.STRING_FILTRE_IP.'|'.STRING_FILTRE_DOMAINE.'/',$this->champs['desabonnement_pop_serveur']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_POP_SERVEUR_ERREUR_FILTRE));
			//DESABONNEMENT_POP_PORT
			if((!PREFERENCE_DESABONNEMENT_POP_PORT_NULL || $this->champs['desabonnement_pop_port']!==NULL) && (intval($this->champs['desabonnement_pop_port'])<PREFERENCE_DESABONNEMENT_POP_PORT_MIN || intval($this->champs['desabonnement_pop_port'])>PREFERENCE_DESABONNEMENT_POP_PORT_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_VALEUR));
			if((!PREFERENCE_DESABONNEMENT_POP_PORT_NULL || $this->champs['desabonnement_pop_port']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['desabonnement_pop_port']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_POP_PORT_ERREUR_FILTRE));
			//DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE
			if((!PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_NULL || $this->champs['desabonnement_nettoyage_mail_par_boucle']!==NULL) && (intval($this->champs['desabonnement_nettoyage_mail_par_boucle'])<PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_MIN || intval($this->champs['desabonnement_nettoyage_mail_par_boucle'])>PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR));
			if((!PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_NULL || $this->champs['desabonnement_nettoyage_mail_par_boucle']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['desabonnement_nettoyage_mail_par_boucle']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE));
			//DESABONNEMENT_NETTOYAGE_PAUSE
			if((!PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_NULL || $this->champs['desabonnement_nettoyage_pause']!==NULL) && (intval($this->champs['desabonnement_nettoyage_pause'])<PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_MIN || intval($this->champs['desabonnement_nettoyage_pause'])>PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_VALEUR));
			if((!PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_NULL || $this->champs['desabonnement_nettoyage_pause']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['desabonnement_nettoyage_pause']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_DESABONNEMENT_NETTOYAGE_PAUSE_ERREUR_FILTRE));
			//SPOOL_RAPPEL_INTERVAL
			if((!PREFERENCE_SPOOL_RAPPEL_INTERVAL_NULL || $this->champs['spool_rappel_interval']!==NULL) && (intval($this->champs['spool_rappel_interval'])<PREFERENCE_SPOOL_RAPPEL_INTERVAL_MIN || intval($this->champs['spool_rappel_interval'])>PREFERENCE_SPOOL_RAPPEL_INTERVAL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_RAPPEL_INTERVAL_NULL || $this->champs['spool_rappel_interval']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_rappel_interval']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_RAPPEL_INTERVAL_ERREUR_FILTRE));
			//SPOOL_INACTIVITE_JOUR
			if((!PREFERENCE_SPOOL_INACTIVITE_JOUR_NULL || $this->champs['spool_inactivite_jour']!==NULL) && (intval($this->champs['spool_inactivite_jour'])<PREFERENCE_SPOOL_INACTIVITE_JOUR_MIN || intval($this->champs['spool_inactivite_jour'])>PREFERENCE_SPOOL_INACTIVITE_JOUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_INACTIVITE_JOUR_NULL || $this->champs['spool_inactivite_jour']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_inactivite_jour']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_INACTIVITE_JOUR_ERREUR_FILTRE));
			//SPOOL_VEILLE_JOUR
			if((!PREFERENCE_SPOOL_VEILLE_JOUR_NULL || $this->champs['spool_veille_jour']!==NULL) && (intval($this->champs['spool_veille_jour'])<PREFERENCE_SPOOL_VEILLE_JOUR_MIN || intval($this->champs['spool_veille_jour'])>PREFERENCE_SPOOL_VEILLE_JOUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_VEILLE_JOUR_NULL || $this->champs['spool_veille_jour']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_veille_jour']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_VEILLE_JOUR_ERREUR_FILTRE));
			//ANNONCE_CHEMIN_DOSSIER
			if((!PREFERENCE_ANNONCE_CHEMIN_DOSSIER_NULL || $this->champs['annonce_chemin_dossier']!==NULL)&& (strlen($this->champs['annonce_chemin_dossier'])<PREFERENCE_ANNONCE_CHEMIN_DOSSIER_MIN || strlen($this->champs['annonce_chemin_dossier'])>PREFERENCE_ANNONCE_CHEMIN_DOSSIER_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_LONGUEUR));
			if((!PREFERENCE_ANNONCE_CHEMIN_DOSSIER_NULL || $this->champs['annonce_chemin_dossier']!==NULL) &&  !is_dir($this->champs['annonce_chemin_dossier']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_DIR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ANNONCE_CHEMIN_DOSSIER_ERREUR_DIR));
			//ANNONCE_AFFICHE_DERNIER_JOUR
			if((!PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_NULL || $this->champs['annonce_affiche_dernier_jour']!==NULL) && (intval($this->champs['annonce_affiche_dernier_jour'])<PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_MIN || intval($this->champs['annonce_affiche_dernier_jour'])>PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_VALEUR));
			if((!PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_NULL || $this->champs['annonce_affiche_dernier_jour']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['annonce_affiche_dernier_jour']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ANNONCE_AFFICHE_DERNIER_JOUR_ERREUR_FILTRE));
			//ANNONCE_AFFICHE_LU
			if((!PREFERENCE_ANNONCE_AFFICHE_LU_NULL || $this->champs['annonce_affiche_lu']!==NULL) && (intval($this->champs['annonce_affiche_lu'])<PREFERENCE_ANNONCE_AFFICHE_LU_MIN || intval($this->champs['annonce_affiche_lu'])>PREFERENCE_ANNONCE_AFFICHE_LU_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_VALEUR));
			if((!PREFERENCE_ANNONCE_AFFICHE_LU_NULL || $this->champs['annonce_affiche_lu']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['annonce_affiche_lu']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ANNONCE_AFFICHE_LU_ERREUR_FILTRE));
			//COMPTABILITE_EMAIL
			if((!PREFERENCE_COMPTABILITE_EMAIL_NULL || $this->champs['comptabilite_email']!==NULL) && (strlen($this->champs['comptabilite_email'])<PREFERENCE_COMPTABILITE_EMAIL_MIN || strlen($this->champs['comptabilite_email'])>PREFERENCE_COMPTABILITE_EMAIL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_COMPTABILITE_EMAIL_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_COMPTABILITE_EMAIL_ERREUR_LONGUEUR));
			if((!PREFERENCE_COMPTABILITE_EMAIL_NULL || $this->champs['comptabilite_email']!==NULL) && !preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['comptabilite_email']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_COMPTABILITE_EMAIL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_COMPTABILITE_EMAIL_ERREUR_FILTRE));
			//IP_PAIEMENT
			if((!PREFERENCE_IP_PAIEMENT_NULL || $this->champs['ip_paiement']!==NULL) && !preg_match('/'.STRING_FILTRE_IP.'/',$this->champs['ip_paiement']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_IP_PAIEMENT_ERREUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_IP_PAIEMENT_ERREUR));
			//HTTP_EXCLUSION
			if((!PREFERENCE_HTTP_EXCLUSION_NULL || $this->champs['http_exclusion']!==NULL) && (strlen($this->champs['http_exclusion'])<PREFERENCE_HTTP_EXCLUSION_MIN || strlen($this->champs['http_exclusion'])>PREFERENCE_HTTP_EXCLUSION_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_HTTP_EXCLUSION_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_HTTP_EXCLUSION_ERREUR_LONGUEUR));
			if((!PREFERENCE_HTTP_EXCLUSION_NULL || $this->champs['http_exclusion']!==NULL) && !preg_match('/'.STRING_FILTRE_URL.'/',$this->champs['http_exclusion']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_HTTP_EXCLUSION_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_HTTP_EXCLUSION_ERREUR_FILTRE));
			//PLAINTE_EMAIL
			if((!PREFERENCE_PLAINTE_EMAIL_NULL || $this->champs['plainte_email']!==NULL) && (strlen($this->champs['plainte_email'])<PREFERENCE_PLAINTE_EMAIL_MIN || strlen($this->champs['plainte_email'])>PREFERENCE_PLAINTE_EMAIL_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_EMAIL_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_EMAIL_ERREUR_LONGUEUR));
			if((!PREFERENCE_PLAINTE_EMAIL_NULL || $this->champs['plainte_email']!==NULL) && !preg_match('/'.STRING_FILTRE_EMAIL.'/',$this->champs['plainte_email']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_EMAIL_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_EMAIL_ERREUR_FILTRE));
			//PLAINTE_POP_UTILISATEUR
			if((!PREFERENCE_PLAINTE_POP_UTILISATEUR_NULL || $this->champs['plainte_pop_utilisateur']!==NULL) && (strlen($this->champs['plainte_pop_utilisateur'])<PREFERENCE_PLAINTE_POP_UTILISATEUR_MIN || strlen($this->champs['plainte_pop_utilisateur'])>PREFERENCE_PLAINTE_POP_UTILISATEUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_POP_UTILISATEUR_ERREUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_POP_UTILISATEUR_ERREUR));
			//PLAINTE_POP_PASSE
			if((!PREFERENCE_PLAINTE_POP_PASSE_NULL || $this->champs['plainte_pop_passe']!==NULL) && (strlen($this->champs['plainte_pop_passe'])<PREFERENCE_PLAINTE_POP_PASSE_MIN || strlen($this->champs['plainte_pop_passe'])>PREFERENCE_PLAINTE_POP_PASSE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_POP_PASSE_ERREUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_POP_PASSE_ERREUR));
			//PLAINTE_POP_SERVEUR
			if((!PREFERENCE_PLAINTE_POP_SERVEUR_NULL || $this->champs['plainte_pop_serveur']!==NULL) && (strlen($this->champs['plainte_pop_serveur'])<PREFERENCE_PLAINTE_POP_SERVEUR_MIN || strlen($this->champs['plainte_pop_serveur'])>PREFERENCE_PLAINTE_POP_SERVEUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_LONGUEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_LONGUEUR));
			if((!PREFERENCE_PLAINTE_POP_SERVEUR_NULL || $this->champs['plainte_pop_serveur']!==NULL) && !preg_match('/'.STRING_FILTRE_IP.'|'.STRING_FILTRE_DOMAINE.'/',$this->champs['plainte_pop_serveur']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_POP_SERVEUR_ERREUR_FILTRE));
			//PLAINTE_POP_PORT
			if((!PREFERENCE_PLAINTE_POP_PORT_NULL || $this->champs['plainte_pop_port']!==NULL) && (intval($this->champs['plainte_pop_port'])<PREFERENCE_PLAINTE_POP_PORT_MIN || intval($this->champs['plainte_pop_port'])>PREFERENCE_PLAINTE_POP_PORT_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_POP_PORT_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_POP_PORT_ERREUR_VALEUR));
			if((!PREFERENCE_PLAINTE_POP_PORT_NULL || $this->champs['plainte_pop_port']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['plainte_pop_port']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_POP_PORT_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_POP_PORT_ERREUR_FILTRE));
			//PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE
			if((!PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_NULL || $this->champs['plainte_nettoyage_mail_par_boucle']!==NULL) && (intval($this->champs['plainte_nettoyage_mail_par_boucle'])<PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_MIN || intval($this->champs['plainte_nettoyage_mail_par_boucle'])>PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_VALEUR));
			if((!PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_NULL || $this->champs['plainte_nettoyage_mail_par_boucle']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['plainte_nettoyage_mail_par_boucle']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_NETTOYAGE_MAIL_PAR_BOUCLE_ERREUR_FILTRE));
			//PLAINTE_NETTOYAGE_PAUSE
			if((!PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_NULL || $this->champs['plainte_nettoyage_pause']!==NULL) && (intval($this->champs['plainte_nettoyage_pause'])<PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_MIN || intval($this->champs['plainte_nettoyage_pause'])>PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_VALEUR));
			if((!PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_NULL || $this->champs['plainte_nettoyage_pause']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['plainte_nettoyage_pause']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_PLAINTE_NETTOYAGE_PAUSE_ERREUR_FILTRE));
			//COOKIE_DUREE_VIE
			if((!PREFERENCE_COOKIE_DUREE_VIE_NULL || $this->champs['cookie_duree_vie']!==NULL) && (intval($this->champs['cookie_duree_vie'])<PREFERENCE_COOKIE_DUREE_VIE_MIN || intval($this->champs['cookie_duree_vie'])>PREFERENCE_COOKIE_DUREE_VIE_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_COOKIE_DUREE_VIE_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_COOKIE_DUREE_VIE_ERREUR_VALEUR));
			if((!PREFERENCE_COOKIE_DUREE_VIE_NULL || $this->champs['cookie_duree_vie']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['cookie_duree_vie']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_COOKIE_DUREE_VIE_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_COOKIE_DUREE_VIE_ERREUR_FILTRE));
			//ANNONCE_VUE_JOUR
			if((!PREFERENCE_ANNONCE_VUE_JOUR_NULL || $this->champs['annonce_vue_jour']!==NULL) && (intval($this->champs['annonce_vue_jour'])<PREFERENCE_ANNONCE_VUE_JOUR_MIN || intval($this->champs['annonce_vue_jour'])>PREFERENCE_ANNONCE_VUE_JOUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_VALEUR));
			if((!PREFERENCE_ANNONCE_VUE_JOUR_NULL || $this->champs['annonce_vue_jour']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['annonce_vue_jour']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_ANNONCE_VUE_JOUR_ERREUR_FILTRE));
			//SPOOL_AIDE_JOUR
			if((!PREFERENCE_SPOOL_AIDE_JOUR_NULL || $this->champs['spool_aide_jour']!==NULL) && (intval($this->champs['spool_aide_jour'])<PREFERENCE_SPOOL_AIDE_JOUR_MIN || intval($this->champs['spool_aide_jour'])>PREFERENCE_SPOOL_AIDE_JOUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_AIDE_JOUR_NULL || $this->champs['spool_aide_jour']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_aide_jour']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_AIDE_JOUR_ERREUR_FILTRE));
			//SPOOL_VIEUX_JOUR
			if((!PREFERENCE_SPOOL_VIEUX_JOUR_NULL || $this->champs['spool_vieux_jour']!==NULL) && (intval($this->champs['spool_vieux_jour'])<PREFERENCE_SPOOL_VIEUX_JOUR_MIN || intval($this->champs['spool_vieux_jour'])>PREFERENCE_SPOOL_VIEUX_JOUR_MAX))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_VALEUR);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_VALEUR));
			if((!PREFERENCE_SPOOL_VIEUX_JOUR_NULL || $this->champs['spool_vieux_jour']!==NULL) && !preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$this->champs['spool_vieux_jour']))
				$this->erreur=gmp_or($this->erreur,PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_FILTRE);
			else
				$this->erreur=gmp_and($this->erreur,gmp_sub(PREFERENCE_TOTAL_ERREUR,PREFERENCE_SPOOL_VIEUX_JOUR_ERREUR_FILTRE));
		}
		
		private function lire()
		{
			$this->executer
			('
				select
					spool_mail_pause,
					spool_boucle_pause,
					spool_boucle_mail,
					spool_flush_mail,
					spool_message_interval,
					acces_bloque,
					hardbounce_limite,
					softbounce_limite,
					plainte_limite,
					aide_limite,
					wha_prix,
					expediteur_email,
					retour_email,
					retour_pop_utilisateur,
					retour_pop_passe,
					retour_pop_serveur,
					retour_pop_port,
					retour_nettoyage_mail_par_boucle,
					retour_nettoyage_pause,
					reponse_email,
					desabonnement_email,
					desabonnement_pop_utilisateur,
					desabonnement_pop_passe,
					desabonnement_pop_serveur,
					desabonnement_pop_port,
					desabonnement_nettoyage_mail_par_boucle,
					desabonnement_nettoyage_pause,
					spool_rappel_interval,
					spool_inactivite_jour,
					spool_veille_jour,
					annonce_chemin_dossier,
					annonce_affiche_dernier_jour,
					annonce_affiche_lu,
					comptabilite_email,
					ip_paiement,
					http_exclusion,
					plainte_email,
					plainte_pop_utilisateur,
					plainte_pop_passe,
					plainte_pop_serveur,
					plainte_pop_port,
					plainte_nettoyage_mail_par_boucle,
					plainte_nettoyage_pause,
					cookie_duree_vie,
					annonce_vue_jour,
					spool_aide_jour,
					spool_vieux_jour
				from preference
				limit 1
			');
			if(!$this->donner_suivant($occurrence))
				return false;
			$this->champs['spool_mail_pause']=$occurrence['spool_mail_pause'];
			$this->champs['spool_boucle_pause']=$occurrence['spool_boucle_pause'];
			$this->champs['spool_boucle_mail']=$occurrence['spool_boucle_mail'];
			$this->champs['spool_flush_mail']=$occurrence['spool_flush_mail'];
			$this->champs['spool_message_interval']=$occurrence['spool_message_interval'];
			$this->champs['acces_bloque']=$occurrence['acces_bloque'];
			$this->champs['hardbounce_limite']=$occurrence['hardbounce_limite'];
			$this->champs['softbounce_limite']=$occurrence['softbounce_limite'];
			$this->champs['plainte_limite']=$occurrence['plainte_limite'];
			$this->champs['aide_limite']=$occurrence['aide_limite'];
			$this->champs['wha_prix']=$occurrence['wha_prix'];
			$this->champs['expediteur_email']=$occurrence['expediteur_email'];
			$this->champs['retour_email']=$occurrence['retour_email'];
			$this->champs['retour_pop_utilisateur']=$occurrence['retour_pop_utilisateur'];
			$this->champs['retour_pop_passe']=$occurrence['retour_pop_passe'];
			$this->champs['retour_pop_serveur']=$occurrence['retour_pop_serveur'];
			$this->champs['retour_pop_port']=$occurrence['retour_pop_port'];
			$this->champs['retour_nettoyage_mail_par_boucle']=$occurrence['retour_nettoyage_mail_par_boucle'];
			$this->champs['retour_nettoyage_pause']=$occurrence['retour_nettoyage_pause'];
			$this->champs['reponse_email']=$occurrence['reponse_email'];
			$this->champs['desabonnement_email']=$occurrence['desabonnement_email'];
			$this->champs['desabonnement_pop_utilisateur']=$occurrence['desabonnement_pop_utilisateur'];
			$this->champs['desabonnement_pop_passe']=$occurrence['desabonnement_pop_passe'];
			$this->champs['desabonnement_pop_serveur']=$occurrence['desabonnement_pop_serveur'];
			$this->champs['desabonnement_pop_port']=$occurrence['desabonnement_pop_port'];
			$this->champs['desabonnement_nettoyage_mail_par_boucle']=$occurrence['desabonnement_nettoyage_mail_par_boucle'];
			$this->champs['desabonnement_nettoyage_pause']=$occurrence['desabonnement_nettoyage_pause'];
			$this->champs['spool_rappel_interval']=$occurrence['spool_rappel_interval'];
			$this->champs['spool_inactivite_jour']=$occurrence['spool_inactivite_jour'];
			$this->champs['spool_veille_jour']=$occurrence['spool_veille_jour'];
			$this->champs['annonce_chemin_dossier']=$occurrence['annonce_chemin_dossier'];
			$this->champs['annonce_affiche_dernier_jour']=$occurrence['annonce_affiche_dernier_jour'];
			$this->champs['annonce_affiche_lu']=$occurrence['annonce_affiche_lu'];
			$this->champs['comptabilite_email']=$occurrence['comptabilite_email'];
			$this->champs['ip_paiement']=$occurrence['ip_paiement'];
			$this->champs['http_exclusion']=$occurrence['http_exclusion'];
			$this->champs['plainte_email']=$occurrence['plainte_email'];
			$this->champs['plainte_pop_utilisateur']=$occurrence['plainte_pop_utilisateur'];
			$this->champs['plainte_pop_passe']=$occurrence['plainte_pop_passe'];
			$this->champs['plainte_pop_serveur']=$occurrence['plainte_pop_serveur'];
			$this->champs['plainte_pop_port']=$occurrence['plainte_pop_port'];
			$this->champs['plainte_nettoyage_mail_par_boucle']=$occurrence['plainte_nettoyage_mail_par_boucle'];
			$this->champs['plainte_nettoyage_pause']=$occurrence['plainte_nettoyage_pause'];
			$this->champs['cookie_duree_vie']=$occurrence['cookie_duree_vie'];
			$this->champs['annonce_vue_jour']=$occurrence['annonce_vue_jour'];
			$this->champs['spool_aide_jour']=$occurrence['spool_aide_jour'];
			$this->champs['spool_vieux_jour']=$occurrence['spool_vieux_jour'];
			return true;
		}
		
		public function modifier()
		{
			$this->verifier();
			if(gmp_strval($this->erreur)=='0')
			{
				$this->executer
				('
					update preference
					set
						spool_mail_pause='.(($this->champs['spool_mail_pause']!==NULL)?('\''.addslashes($this->champs['spool_mail_pause']).'\''):('null')).',
						spool_boucle_pause='.(($this->champs['spool_boucle_pause']!==NULL)?('\''.addslashes($this->champs['spool_boucle_pause']).'\''):('null')).',
						spool_boucle_mail='.(($this->champs['spool_boucle_mail']!==NULL)?('\''.addslashes($this->champs['spool_boucle_mail']).'\''):('null')).',
						spool_flush_mail='.(($this->champs['spool_flush_mail']!==NULL)?('\''.addslashes($this->champs['spool_flush_mail']).'\''):('null')).',
						spool_message_interval='.(($this->champs['spool_message_interval']!==NULL)?('\''.addslashes($this->champs['spool_message_interval']).'\''):('null')).',
						acces_bloque='.(($this->champs['acces_bloque']!==NULL)?('\''.addslashes($this->champs['acces_bloque']).'\''):('null')).',
						hardbounce_limite='.(($this->champs['hardbounce_limite']!==NULL)?('\''.addslashes($this->champs['hardbounce_limite']).'\''):('null')).',
						softbounce_limite='.(($this->champs['softbounce_limite']!==NULL)?('\''.addslashes($this->champs['softbounce_limite']).'\''):('null')).',
						plainte_limite='.(($this->champs['plainte_limite']!==NULL)?('\''.addslashes($this->champs['plainte_limite']).'\''):('null')).',
						aide_limite='.(($this->champs['aide_limite']!==NULL)?('\''.addslashes($this->champs['aide_limite']).'\''):('null')).',
						wha_prix='.(($this->champs['wha_prix']!==NULL)?('\''.addslashes($this->champs['wha_prix']).'\''):('null')).',
						expediteur_email='.(($this->champs['expediteur_email']!==NULL)?('\''.addslashes($this->champs['expediteur_email']).'\''):('null')).',
						retour_email='.(($this->champs['retour_email']!==NULL)?('\''.addslashes($this->champs['retour_email']).'\''):('null')).',
						retour_pop_utilisateur='.(($this->champs['retour_pop_utilisateur']!==NULL)?('\''.addslashes($this->champs['retour_pop_utilisateur']).'\''):('null')).',
						retour_pop_passe='.(($this->champs['retour_pop_passe']!==NULL)?('\''.addslashes($this->champs['retour_pop_passe']).'\''):('null')).',
						retour_pop_serveur='.(($this->champs['retour_pop_serveur']!==NULL)?('\''.addslashes($this->champs['retour_pop_serveur']).'\''):('null')).',
						retour_pop_port='.(($this->champs['retour_pop_port']!==NULL)?('\''.addslashes($this->champs['retour_pop_port']).'\''):('null')).',
						retour_nettoyage_mail_par_boucle='.(($this->champs['retour_nettoyage_mail_par_boucle']!==NULL)?('\''.addslashes($this->champs['retour_nettoyage_mail_par_boucle']).'\''):('null')).',
						retour_nettoyage_pause='.(($this->champs['retour_nettoyage_pause']!==NULL)?('\''.addslashes($this->champs['retour_nettoyage_pause']).'\''):('null')).',
						reponse_email='.(($this->champs['reponse_email']!==NULL)?('\''.addslashes($this->champs['reponse_email']).'\''):('null')).',
						desabonnement_email='.(($this->champs['desabonnement_email']!==NULL)?('\''.addslashes($this->champs['desabonnement_email']).'\''):('null')).',
						desabonnement_pop_utilisateur='.(($this->champs['desabonnement_pop_utilisateur']!==NULL)?('\''.addslashes($this->champs['desabonnement_pop_utilisateur']).'\''):('null')).',
						desabonnement_pop_passe='.(($this->champs['desabonnement_pop_passe']!==NULL)?('\''.addslashes($this->champs['desabonnement_pop_passe']).'\''):('null')).',
						desabonnement_pop_serveur='.(($this->champs['desabonnement_pop_serveur']!==NULL)?('\''.addslashes($this->champs['desabonnement_pop_serveur']).'\''):('null')).',
						desabonnement_pop_port='.(($this->champs['desabonnement_pop_port']!==NULL)?('\''.addslashes($this->champs['desabonnement_pop_port']).'\''):('null')).',
						desabonnement_nettoyage_mail_par_boucle='.(($this->champs['desabonnement_nettoyage_mail_par_boucle']!==NULL)?('\''.addslashes($this->champs['desabonnement_nettoyage_mail_par_boucle']).'\''):('null')).',
						desabonnement_nettoyage_pause='.(($this->champs['desabonnement_nettoyage_pause']!==NULL)?('\''.addslashes($this->champs['desabonnement_nettoyage_pause']).'\''):('null')).',
						spool_rappel_interval='.(($this->champs['spool_rappel_interval']!==NULL)?('\''.addslashes($this->champs['spool_rappel_interval']).'\''):('null')).',
						spool_inactivite_jour='.(($this->champs['spool_inactivite_jour']!==NULL)?('\''.addslashes($this->champs['spool_inactivite_jour']).'\''):('null')).',
						spool_veille_jour='.(($this->champs['spool_veille_jour']!==NULL)?('\''.addslashes($this->champs['spool_veille_jour']).'\''):('null')).',
						annonce_chemin_dossier='.(($this->champs['annonce_chemin_dossier']!==NULL)?('\''.addslashes($this->champs['annonce_chemin_dossier']).'\''):('null')).',
						annonce_affiche_dernier_jour='.(($this->champs['annonce_affiche_dernier_jour']!==NULL)?('\''.addslashes($this->champs['annonce_affiche_dernier_jour']).'\''):('null')).',
						annonce_affiche_lu='.(($this->champs['annonce_affiche_lu']!==NULL)?('\''.addslashes($this->champs['annonce_affiche_lu']).'\''):('null')).',
						comptabilite_email='.(($this->champs['comptabilite_email']!==NULL)?('\''.addslashes($this->champs['comptabilite_email']).'\''):('null')).',
						ip_paiement='.(($this->champs['ip_paiement']!==NULL)?('\''.addslashes($this->champs['ip_paiement']).'\''):('null')).',
						http_exclusion='.(($this->champs['http_exclusion']!==NULL)?('\''.addslashes($this->champs['http_exclusion']).'\''):('null')).',
						plainte_email='.(($this->champs['plainte_email']!==NULL)?('\''.addslashes($this->champs['plainte_email']).'\''):('null')).',
						plainte_pop_utilisateur='.(($this->champs['plainte_pop_utilisateur']!==NULL)?('\''.addslashes($this->champs['plainte_pop_utilisateur']).'\''):('null')).',
						plainte_pop_passe='.(($this->champs['plainte_pop_passe']!==NULL)?('\''.addslashes($this->champs['plainte_pop_passe']).'\''):('null')).',
						plainte_pop_serveur='.(($this->champs['plainte_pop_serveur']!==NULL)?('\''.addslashes($this->champs['plainte_pop_serveur']).'\''):('null')).',
						plainte_pop_port='.(($this->champs['plainte_pop_port']!==NULL)?('\''.addslashes($this->champs['plainte_pop_port']).'\''):('null')).',
						plainte_nettoyage_mail_par_boucle='.(($this->champs['plainte_nettoyage_mail_par_boucle']!==NULL)?('\''.addslashes($this->champs['plainte_nettoyage_mail_par_boucle']).'\''):('null')).',
						plainte_nettoyage_pause='.(($this->champs['plainte_nettoyage_pause']!==NULL)?('\''.addslashes($this->champs['plainte_nettoyage_pause']).'\''):('null')).',
						cookie_duree_vie='.(($this->champs['cookie_duree_vie']!==NULL)?('\''.addslashes($this->champs['cookie_duree_vie']).'\''):('null')).',
						annonce_vue_jour='.(($this->champs['annonce_vue_jour']!==NULL)?('\''.addslashes($this->champs['annonce_vue_jour']).'\''):('null')).',
						spool_aide_jour='.(($this->champs['spool_aide_jour']!==NULL)?('\''.addslashes($this->champs['spool_aide_jour']).'\''):('null')).',
						spool_vieux_jour='.(($this->champs['spool_vieux_jour']!==NULL)?('\''.addslashes($this->champs['spool_vieux_jour']).'\''):('null')).'
					limit 1
				');
			}
			return $this->erreur;
		}
		
		public function tester()
		{
			$this->verifier();
			return $this->erreur;
		}
	}
?>