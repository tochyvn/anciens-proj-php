<?php
    $jetons = PackjetonQuery::create()->find();
    $t=array();
    foreach ($jetons as $j)
        
        $t[$j->getJetons()]=$j->getIdPack();
    
    $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

                
    $zr1= new XmlZoneRadio( array("label" => "Choisissez votre pack :",
                "msgErr" => "Obligatoire",
                "name" => "pack",
                "radio"=>$t,
                "obligatoire"=>1
                ));
	
                
    $submit = new XmlInput(array("value" => "Acheter", "type" => "submit"));

    $form->addElement($zr1);	
    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
        $a=new Achat();
        $a->setDateAchat(date("YmdHis"));
        $a->setPseudo($_SESSION['user']['pseudo']);
        $a->setIdPack($_POST['pack']);
        $a->save();
        $param ["msg"]="Achat réussi";
    }

$param ["form"]=$form->toHTML();


?>

