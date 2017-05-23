<?php

 $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI']));

 $zt1 = new XmlZonePassword(array("label" => "Entrez l'id du jeton:",
                "msgErr" => "Chiffres 1 à 9 ",
                "regex" => "^[0-9]+$",
                "name" => "id"));

 $zt2 = new XmlZoneTexte(array("label" => "Donnez la designation :",
                "msgErr" => "Majuscule suivi de minuscules",
                "regex" => "^[0-9][a-z]+$",
                "name" => "designation"));


 $submit = new XmlInput(array("value" => "Enregistrer", "type" => "submit"));

     $form->addElement($zt1);
     $form->addElement($zt2);


     $form->addElement($submit);


     if ($form->donneesEnvoyees() && $form->formulaireValide()) {
        $param ["msg"]="Jeton enregistrer…";


 $jeton = new Jeton();

      $jeton->setId($_POST["id"]);
      $jeton->setDesignation($_POST['designation']);


       $jeton->save();  
  }


  $param ["form"]=$form->toHTML();


  ?>