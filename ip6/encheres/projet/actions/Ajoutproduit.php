


<?php

$form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

 $zt1= new XmlZoneTexte(array("label" => "Entrez la reference du produit :",
            "msgErr" => "De la forme 0",
            "regex" => "^[0-9]$",
            "name" => "reference"));

    $zt2 = new XmlZoneTexte(array("label" => "Entrez la designation du produit :",
            "msgErr" => "doit etre une chaine de caracteres",
            "regex" => "^[a-zA-Z0-9]+$",
            "name" => "designation"));            
    
    
    $zt4 = new XmlZoneTexte(array("label" => "Entrez le prix :",
            "msgErr" => "De la forme 000.00",
            "regex" => "^[0-9]+.[0-9]{2}$",
            "name" => "prix"));
    $zt5=new XmlInput(array("label"=>"image:","ACTION"=>"insertion.php","method"=>"POST","ENCTYPE"=>"multipart/form-data","input TYPE"=>"file","NAME"=>"image"));
   $submit = new XmlInput(array("value" => "Ajouter", "type" => "submit"));

    $form->addElement($zt1);
    $form->addElement($zt2);    
     $form->addElement($zt4);
      $form->addElement($zt5);
    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
       $param ["msg"]="Produit ajouté!";

        $article = new Produit();
        $article->setReference($_POST['reference']);
        $article->setDesignation($_POST['designation']);
        $article->setImage($_POST['image']);
        $article->setPrix($_POST['prix']);
        $article->save();
        
    }

$param ["form"]=$form->toHTML();
?>