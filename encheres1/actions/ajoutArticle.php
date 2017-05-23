<?php

$form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

    $zt1 = new XmlZoneTexte(array("label" => "Entrez le nom de l'article :",
            "msgErr" => "doit etre une chaine de caracteres",
            "regex" => "^[a-zA-Z0-9]+$",
            "name" => "nomArt"));            
	
    $zt2 = new XmlZoneTexte(array("label" => "Entrez le prix :",
            "msgErr" => "De la forme 000.00",
            "regex" => "^[0-9]+.[0-9]{2}$",
            "name" => "prix"));
    
    $zt3 = new XmlZoneTexte(array("label" => "Entrez le chemin de l'image :",
            "msgErr" => "Chemin Absolu",
            "name" => "image"));
    
    $submit = new XmlInput(array("value" => "Ajouter", "type" => "submit"));

    $form->addElement($zt1);
    $form->addElement($zt2);	
    $form->addElement($zt3);
    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
       
        $ar = new Article();
        $ar->setNomArt($_POST['nomArt']);
        $ar->setPrix($_POST['prix']);
        $ar->setPath($_POST['image']);
        $ar->save();
        $param ["msg"]="Article ajouté!";
    }

$param ["form"]=$form->toHTML();

