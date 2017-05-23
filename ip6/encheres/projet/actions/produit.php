<?php

 $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI']));

 $zt1 = new XmlZoneTexte(array("label" => "Entrez reference produit:",
                "msgErr" => "chifre de 0 à 9",
                "regex" => "^[0-9]$",
                "name" => "reference"));

 $zt2 = new XmlZoneTexte(array("label" => "Donnez le nom du produit:",
                "msgErr" => "Majuscule suivi de minuscules",
                "regex" => "^[A-Z][a-z]+$",
                "name" => "designation"));



 $zt3 = new XmlZoneTexte(array("label" => "Donnez le prix du produit:",
                "msgErr" => "De la forme OOO.OO",
                "regex" => "^[0-9]+.[0-9]{2}$",
                "name" => "prix"));

 $zt4 = new XmlZoneTexte(array("label" => "Donnez l'image:",
                "msgErr" => "chemin",
                "name" => "image"));



$submit = new XmlInput(array("value" => "Enregistrer", "type" => "submit"));

   
     $form->addElement($zt1);
     $form->addElement($zt2);
     $form->addElement($zt3);
     $form->addElement($zt4);


     $form->addElement($submit);


  if ($form->donneesEnvoyees() && $form->formulaireValide()) {
        $param ["msg"]="Produit ajouté…";
 
     $produit = new Produit();

     $produit->setReference($_POST["reference"]);
      $produit->setDesignation($_POST['designation']);
      $produit->setPrix($_POST['prix']);
      $produit->setImage($_POST['image']);


  $produit->save();  

  }

  $param ["form"]=$form->toHTML();

  ?>

