<?php


$articles = ArticleQuery::create()->find();
$t=array();

foreach ($articles as $art){
    
    $t[$art->getIdArt()]=$art->getNomArt();
}

 $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));
 
 
      $zt2 = new XmlZoneDate(array("label" => "Entrez la date de fin :",
                "msgErr" => "doit être une date valide : aaaa-mm-jj hh:mm:ss",
                "regex" => "^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$",
                "name" => "datefin"));
      
      
      $zl1 = new XmlZoneListe( array("label" => "Articles Disponibles :",
                "msgErr" => "Choisir un article",
                "name" => "arts",
                "options"=>$t,
                "min"=>1,
                "max"=>1
                ));
 
 
  $submit = new XmlInput(array("value" => "Programmer", "type" => "submit"));

    $form->addElement($zt2);	
    $form->addElement($zl1);	
    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
        $id_art = $_POST['arts'][0];
        $art = ArticleQuery::create()->filterByIdArt($id_art)->findOne();
        $ench = new Enchere();
        $ench->setDateDebut(date('Y-m-d h:i:s'));
        $ench->setDateFin($_POST['datefin']);
        $ench->setIdArt($art->getIdArt());
        
        $ench->save();
        
        //echo $art;
        $param ["msg"]="Ajout reussie";
        
    }

$param ["form"]=$form->toHTML();
 