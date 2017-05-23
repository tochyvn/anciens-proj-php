<?php
    $jetons = JetonQuery::create()->find();
    $t=array();
    foreach ($jetons as $id)
        
        $t[$id->getId()]=$id->getId();
    
    $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

                
    $zr1= new XmlZoneListe( array("label" => "Choisissez votre pack :",
                "msgErr" => "Obligatoire",
                "name" => "pack",
                "options"=>$t,
                "min"=>1,
                "max"=>1
                ));
	
                
    $submit = new XmlInput(array("value" => "Acheter", "type" => "submit"));

    $form->addElement($zr1);	
    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
         $id = $_POST['pack'][0];
         $id_jet = JetonQuery::create()->filterById($id)->findOne();
        $a=new Achat();
        $a->setDatea(date("Y/m/d"));
        $a->setEmail($_SESSION['utilisateure']['email']);
        $a->setId($_POST['pack']);
        $a->setId($id_jet->getId());
        $a->save();
        $param ["msg"]="Achat réussi";
    }
    

$param ["form"]=$form->toHTML();


?>