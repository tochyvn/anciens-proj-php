<?php

$articles = EnchereQuery::create()->find();
$t=array();

foreach ($articles as $art){
    
    $t[$art->getIdenchere()]=$art->getIdenchere();
}

 $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

  $zt1= new XmlZoneTexte(array("label" => "Entrez votre prix :",
            "msgErr" => "De la forme 000.00",
             "regex" => "^[0-9]+.[0-9]{2}$",
            "name" => "prix"));
 

  
 $zl1 = new XmlZoneListe( array("label" => "Encheres disponibles :",
                "msgErr" => "Choisir un Produit",
                "name" => "arts",
                "options"=>$t,
                "min"=>1,
                "max"=>5
                ));
 
 
 
  $submit = new XmlInput(array("value" => " Proposer", "type" => "submit"));

    $form->addElement($zt1);	
      $form->addElement($zl1);
    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
         $id_art = $_POST['arts'][0];
        $art = EnchereQuery::create()->filterByReference($id_art)->findOne();
        $proposer = new Proposer();
        $proposer->setPrix($_POST['prix']);
        $proposer->setDatep(date(""));
        $proposer->setEmail($_SESSION['Utilisateure']['email']);
         $proposer->setIdenchere($art->getIdenchere());
    $proposer->save();
    $param['msg']="proposition enchere reussie";
        $proposer->save();
        
       
    }

$param ["form"]=$form->toHTML();