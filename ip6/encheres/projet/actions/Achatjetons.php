<?php
    $jeton = JetonQuery::create()->find();
    $t=array();
    foreach ($jeton as $j)
        
        $t[$j->getId()]=$j->getId();
    
    $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

                
    $zt1= new XmlZoneRadio( array("label" => "Choisissez votre pack :",


            "msgErr" => "Obligatoire",
                "name" => "pack",
                "radio"=>$t,
                "obligatoire"=>1
                ));
    
        /*
                "msgErr" => "Obligatoire",
                "name" => "id",
                "options" =>$t,
                "min"=>1,
                "max"=>1
              //  "radio"=>$t,
            //    "obligatoire"=>1
                ));

        */
	
                
    $submit = new XmlInput(array("value" => "Acheter", "type" => "submit"));

    $form->addElement($zt1);	

    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {

       /*
        $achat=new Achat();
        $achat->setDatea(date("YmdHis"));
        $achat->setEmail($_SESSION['utilisateure']['email']);
        $achat->setId($_POST['id']);
        $achat->save();
        $param ["msg"]="Achat réussi";
    }
*/
        
        $id = $_POST['pack'][0];
        $id_jet = JetonQuery::create()->filterById($id)->findOne();

        $achat=new Achat();
        $achat->setDatea(date(""));
        $achat->setEmail($_SESSION['Utilisateure']['email']);
        $achat->setId($_POST['pack']);
        $achat->setId($id_jet->getId());
        $achat->save();
        $param ["msg"]="Achat réussi";
    }


$param ["form"]=$form->toHTML();


?>