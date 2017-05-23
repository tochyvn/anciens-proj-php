<?php
$form = new XmlForm(array("method" => "post", "action" => "" . $_SERVER['REQUEST_URI'] . ""));

$zt1 = new XmlZoneTexte(array("label" => "Entrez votre email :",
            "msgErr" => "doit être un mail valide",
            "regex" => "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$",
            "name" => "email"));

$zt2 = new XmlZonePassword(array("label" => "Entrez votre password :",
            "msgErr" => "Majuscule Minuscules Chiffres @ & $ % de longueur au moins 5",
            "regex" => "^[A-Za-z0-9@&$%]{5,128}$",
            "name" => "password"));



$submit = new XmlInput(array("value" => "Se connecter", "type" => "submit"));

$form->addElement($zt1);
$form->addElement($zt2);

$form->addElement($submit);

if ($form->donneesEnvoyees() && $form->formulaireValide()) {
	$u=UtilisateurQuery::create()->filterByEmail($_POST["email"])->filterByPassword($_POST["password"])->findOne();
    
    //var_dump($u);

        if ($u)
        {
            $_SESSION['user']['nom'] = $u->getPseudo() ;
	    $_SESSION['user']['role'] = $u->getRole() ;
            $param["msg"] = "Authentification réussie " ;

            $enchere = EnchereQuery::create()->find();
            foreach ($enchere as $value) {
                echo $value->getId()."<br/>";
                echo $value->getDesignation();

            }
            //$param['enchere'] = $enchere;
            //header("location:accueil");
        }
        else $param["msg"] = "Login ou mot de passe incorrect";
        
}else{
    echo "string";
}

$param ["form"] = $form->toHTML();
