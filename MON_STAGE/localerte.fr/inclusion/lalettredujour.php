<?php
	/***********************/
	/*
		ATTENTION
			
			* fichier enregistr� en iso-8859-1
			* cette fonction ne g�re que les donn�es au format francais
			* demander l'identifiant de la provenance � lalettredujour.fr
			* la function ne retourne aucun r�sultat
			* la socket ne retourne aucun r�sultat
		
		DESCRIPTION DES PARAMETRES
			
			$email: de type adresse email
			$passe: (4 � 20 caract�res)
			$genre: une des valeurs suivantes
				PARTICULIER
				PROFESSIONNEL
				chaine vide
			$raison_sociale: (200 caract�res maximum)
			$situation: une des valeurs suivantes
				CELIBATAIRE
				MARIE
				EN COUPLE
				VEUF
				DIVORCE
				chaine vide
			$civilite: une des valeurs suivantes
				MONSIEUR
				MADAME
				MADEMOISELLE
				cha�ne vide
			$nom: (200 caract�res maximum)
			$prenom: (200 caract�res maximum)
			$naissance: (unix_timestamp)
			$marketing_direct: une des valeurs suivantes
				OUI
				NON
				cha�ne vide
			$statut: une des valeur suivante
				SPAM
				OPT-OUT
				SIMPLE OPT-IN
				DOUBLE OPT-IN
			$provenance: identifiant du site pour lalettredujour.fr (� demander � lalettredujour.fr)
			$activite1: identifiant dans la base de donn�es
			$activite2: identifiant dans la base de donn�es
			$activite3: identifiant dans la base de donn�es
			$code_postal: code postal de la ville
			$ville: nom de la ville (100 caract�res maximum)
			$administration: � demander � Laurent
			$profession: identifiant dans la base de donn�es
		
		EXEMPLE
			
			lalettredujour('test@test.com','passe','PARTICULIER','societe','MARIE','MADAME','nom','prenom','0','OUI','OPT-OUT','1','','','','83200','TOULON','LLDJ03','');
		
	*/
	/***********************/
	
	
	function lalettredujour($email,$passe,$genre,$raison_sociale,$situation,$civilite,$nom,$prenom,$naissance,$marketing_direct,$statut,$provenance,$activite1,$activite2,$activite3,$code_postal,$ville,$administrateur,$profession)
	{
		$socket=@fsockopen('lalettredujour.fr',80,$errno,$errstr,30);
		if(!$socket)
			print($errno.': '.$errstr);
		else
		{
			$fichier='--------aaaaaa------
Content-Disposition: form-data; name="import_fichier"; filename="fichier.csv"
Content-Type: text/csv

"'.$email.'";"'.$passe.'";"'.$genre.'";"'.$raison_sociale.'";"'.$situation.'";"'.$civilite.'";"'.$nom.'";"'.$prenom.'";"'.$naissance.'";"'.$marketing_direct.'";"'.$statut.'";"'.$provenance.'";"'.$activite1.'";"'.$activite2.'";"'.$activite3.'";"'.$code_postal.'";"'.$ville.'";"'.$administrateur.'";"'.$profession.'"
--------aaaaaa--------';
			$requete='POST /inclusion/import.php HTTP/1.1'."\r\n";
			$requete.='Host: lalettredujour.fr'."\r\n";
			$requete.='Connection: Close'."\r\n";
			$requete.='Authorization: Basic YWljb206ZmlWdXMxOS0tNQ=='."\r\n";
			$requete.='Content-Type: multipart/form-data; boundary="------aaaaaa------"'."\r\n";
			$requete.='Content-Length: '.strlen($fichier)."\r\n";
			$requete.="\r\n";
			$requete.=$fichier;
			
			fwrite($socket,$requete);
			
			//while(!feof($socket))
			//	print(fgets($socket,128));
			
			fclose($socket);
		}
	}
	
	if(isset($_REQUEST['lalettredujour_test']))
		lalettredujour('2010080901@lalettredujour.fr','passe','PARTICULIER','','CELIBATAIRE','MONSIEUR','nom','prenom',0,'','SPAM','1','10','','','83210','BELGENTIER','LLDJ03','81');
?>