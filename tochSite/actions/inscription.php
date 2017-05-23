<?php
    $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

    $zt1 = new XmlZoneTexte(array(
        "label" => "Entrez votre Pseudo :",
                "msgErr" => "Majuscule suivi de minuscules",
                "regex" => "^[A-Za-z0-9@&$%]+$",
                "name" => "pseudo"));
    
    $zt2 = new XmlZonePassword(array(
        "label" => "Entrez votre password :",
                "msgErr" => "Majuscule suivi de minuscules",
                "regex" => "^[A-Za-z0-9@&$%]{5,128}$",
                "name" => "passwd"));
    
    $zt3 = new XmlZoneTexte(array(
        "label" => "Entrez votre Nom :",
                "msgErr" => "Majuscule suivi de minuscules",
                "regex" => "^[A-Z][a-z]+$",
                "name" => "nom"));
    
    $zt4 = new XmlZoneTexte(array(
        "label" => "Entrez votre Prenom :",
                "msgErr" => "Majuscule suivi de minuscules",
                "regex" => "^[A-Z][a-z]+$",
                "name" => "prenom"));
    
    $zt5 = new XmlZoneDate(array("label" => "Entrez votre date de naissance :",
                "msgErr" => "doit être une date valide : jj-mm-aaaa",
                "regex" => "^[0-9]{2}-[0-9]{2}-[0-9]{4}$",
                "name" => "datenaissance"));
    
    $zl1 = new XmlZoneListe( array("label" => "Pays :",
                "msgErr" => "Choisir votre Pays",
                "name" => "pays",
                "options"=>array(1=>"France",2=>"Cameroun",3=>"Senegal",4=>"Algerie"),
                "min"=>1,
                "max"=>1
                ));
    
    $zt6 = new XmlZoneTexte(array(
        "label" => "Entrez votre Adresse :",
                "name" => "adresse"));
    
    $zt7 = new XmlZoneTexte(array(
        "label" => "Entrez votre Telephone :",
                "msgErr" => "Commence par 06 ou 07 et contient 10 chiffres",
                "regex" => "^0[67][0-9]{8}$",
                "name" => "telephone"));
    
    $zt8 = new XmlZoneTexte(array("label" => "Entrez votre email :",
            "msgErr" => "doit être un mail valide",
            "regex" => "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$",
            "name" => "email"));
    
    

	
    $submit = new XmlInput(array("value" => "S'inscrire", "type" => "submit"));

    	$form->addElement($zt1);
    	$form->addElement($zt2);
    	$form->addElement($zt3);
	$form->addElement($zt4);
        $form->addElement($zt5);
	$form->addElement($zl1);
	$form->addElement($zt6);
	$form->addElement($zt7);
	$form->addElement($zt8);

        $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
        
        try{
           
           
        $cl = new User();
        $cl->setPseudo($_POST['pseudo']);
        $cl->setPasswd($_POST['passwd']);
        $cl->setNom($_POST['nom']);
        $cl->setPrenom($_POST['prenom']);
        $cl->setDateNaiss($_POST['datenaissance']);
        $cl->setPays($_POST['pays'][0]);
        $cl->setAdresse($_POST['adresse']);
        $cl->setTelephone($_POST['telephone']);
        $cl->setEmail($_POST['email']);
        $cl->setRole(1);
        
        $cl->save();
        /*$u=new Utilisateur();
        $u->setNom($_POST['nom']);
        $u->setPreNom($_POST['prenom']);
        $u->setEmail($_POST['email']);
        $u->setPassword($_POST['password']);
        $u->setRole(1);
        $u->save();*/
        $param ["msg"]="Inscription réussie";
        }catch(Exception $e)
        {
            $param ["msg"]="Inscription impossible pseudo existant";
        }
        
        
    }

$param ["form"]=$form->toHTML();


