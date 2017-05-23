<?php

    $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

    $zt1 = new XmlZoneTexte(array("label" => "Entrez le prix :",
            "msgErr" => "De la forme 0",
            "regex" => "^[0-9]+$",
            "name" => "prix"));

$submit = new XmlInput(array("value" => "Proposer", "type" => "submit"));


$form->addElement($zt1);
$form->addElement($submit);

if ($form->donneesEnvoyees() && $form->formulaireValide()) {
       
        $m=new Proposer();
     $m->setPrix($_POST['prix']);
    $m->setDatep(date("Y/m/d"));
    $m->setEmail($_SESSION['utilisateure']['email']);
    $m->setIdenchere($_GET["idenchere"]);
    $m->save();
    
        
        //echo $art;
        $param ["msg"]="Ajout reussie";
        
    }
    
$param ["form"]=$form->toHTML();
 $uti = UtilisateureQuery::create()->find();

$param['utili'] = $uti;

/*if(isset($_POST['idenchere']))
{
    $m=new Proposer();
     $m->setPrix($_POST['prix']);
     $m->setDate();
    $m->setEmail($_SESSION['utilisateure']['email']);
    $m->setIdenchere($_SESSION['utilisateure']['idenchere']);
    $m->save();
    $param['msg']="enchere reussie";
}

$param ["form"]=$form->toHTML();*/