<?php


$articles = ProduitQuery::create()->find();
$t=array();

foreach ($articles as $art){
    
    $t[$art->getReference()]=$art->getDesignation();
}

 $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

  $zt1= new XmlZoneTexte(array("label" => "Entrez l'id de l'enchere :",
            "msgErr" => "De la forme 0",
            "regex" => "^[0-9]$",
            "name" => "idenchere"));
 

     $zt2 = new XmlZoneDate(array("label" => "Entrez la date de debut :",
                "msgErr" => "doit être une date valide : jj-mm-aaaa",
                "regex" => "^[0-9]{4}-[0-9]{2}-[0-9]{2}$",
                "name" => "datedebut"));
 
 
      $zt3 = new XmlZoneDate(array("label" => "Entrez la date de fin :",
                "msgErr" => "doit être une date valide : jj-mm-aaaa ",
                "regex" => "^[0-9]{4}-[0-9]{2}-[0-9]{2}$",
                "name" => "datefin"));
      
      
      $zt4= new XmlZoneTexte(array("label" => "Entrez la reference du produit :",
            "msgErr" => "De la forme 0",
            "regex" => "^[0-9]$",
            "name" => "reference"));
      $zl1 = new XmlZoneListe( array("label" => "Produits Disponibles :",
                "msgErr" => "Choisir un article",
                "name" => "arts",
                "options"=>$t,
                "min"=>1,
                "max"=>5
                ));
 
 
 
  $submit = new XmlInput(array("value" => "Programmer", "type" => "submit"));

    $form->addElement($zt1);    
   $form->addElement($zt2); 
    $form->addElement($zt3);
     $form->addElement($zt4);
      $form->addElement($zl1);
    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
         $id_art = $_POST['arts'][0];
        $art = ProduitQuery::create()->filterByReference($id_art)->findOne();
        $ench = new Enchere();
        $ench->setIdenchere($_POST['idenchere']);
        $ench->setDateDebut($_POST['datedebut']);
        $ench->setDateFin($_POST['datefin']);
        $ench->setReference($art->getReference());
        $ench->save();
        
        //echo $art;
        $param ["msg"]="Ajout reussie";
        
    }

$param ["form"]=$form->toHTML();