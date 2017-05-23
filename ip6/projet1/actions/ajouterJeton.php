<?php

$form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

 

    $zt1 = new XmlZoneTexte(array("label" => "Entrez la designation du jeton:",
            "msgErr" => "doit etre une chaine de caracteres",
            "regex" => "^[a-zA-Z0-9]+$",
            "name" => "designation"));            
	
    

    $submit = new XmlInput(array("value" => "Ajouter", "type" => "submit"));

    $form->addElement($zt1);
     $form->addElement($submit);
    
    

    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
       $param ["msg"]="Jeton ajouté!";

        $article = new Jeton();
        
        $article->setDesignation($_POST['designation']);

        
    $article->setDesignation($_POST['designation']);
   
    $article->save();
       
    }

$param ["form"]=$form->toHTML();
?>