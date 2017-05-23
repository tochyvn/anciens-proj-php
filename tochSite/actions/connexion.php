<?php
$form = new XmlForm(array("method" => "post", "action" => "" . $_SERVER['REQUEST_URI'] . ""));

$zt1 = new XmlZoneTexte(array("label" => "Entrez votre pseudo :",
            "msgErr" => "Majuscule suivi de minuscules",
            "regex" => "^[a-z0-9]+$",
            "name" => "pseudo"));

$zt2 = new XmlZonePassword(array("label" => "Entrez votre password :",
            "msgErr" => "Majuscule Minuscules Chiffres @ & $ % de longueur au moins 5",
            "regex" => "^[A-Za-z0-9@&$%]{5,128}$",
            "name" => "passwd"));

$submit = new XmlInput(array("value" => "Se connecter", "type" => "submit"));

$form->addElement($zt1);
$form->addElement($zt2);
$form->addElement($submit);

if ($form->donneesEnvoyees() && $form->formulaireValide()) {
    
    $u = UserQuery::create()->filterByPseudo($_POST['pseudo'])->filterByPasswd($_POST['passwd'])->findOne();
    
    if ($u)
        
        {
            $_SESSION['user']['pseudo'] = $u->getPseudo();
            $_SESSION['user']['role'] = $u->getRole();
            $param["msg"] = "Authentification réussie ";
        }
        else $param["msg"] = "Login ou mot de passe incorrect";
}

$param ["form"] = $form->toHTML();

/*$u=UtilisateurQuery::create()->filterByEmail($_POST['email'])->filterByPassword($_POST['password'])->findOne();
}
}
}
        if ($u)
        {
            $_SESSION['user']['login'] = $u->getEmail();
            $_SESSION['user']['role'] = $u->getRole();
            $param["msg"] = "Authentification réussie ";
        }
        else $param["msg"] = "Login ou mot de passe incorrect";
}*/
