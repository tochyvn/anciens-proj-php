<?php
$form = new XmlForm(array("method" => "post", "action" => "" . $_SERVER['REQUEST_URI'] . ""));

$zt1 = new XmlZoneTexte(array("label" => "Entrez votre email :",
            "msgErr" => "L'adresse doit être valide",
                "regex" => "^[A-Za-z.0-9@&$%]{1,128}$",
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

$utilisateur = UtilisateurQuery::create()->filterByEmail($_POST['email'])->filterByPassword($_POST['password'])->findOne();

var_dump($utilisateur);

/*
$utilisateur = UtilisateurQuery::create()->findOneByEmail($_POST['email']);
var_dump($utilisateur->getEmail());

/*
$authors = UtilisateurQuery::create()->find();
foreach ($authors as $value) {
    var_dump($value->getEmail());
}
*/

//var_dump($utilisateur);
if ($utilisateur)

        {
            $_SESSION['Utilisateur']['email'] = $utilisateur->getEmail();
            $_SESSION['Utilisateur']['role'] = $utilisateur->getRole();
            $param["msg"] = "Authentification réussie ";
        }
        else $param["msg"] = "Login ou mot de passe incorrect";
}
    /*

        $result = $con->query("select * from authentification where login='$_POST[email]' and mdp='$_POST[password]'");
        if ($result->rowCount())
        {
            $_SESSION['user'] = $result->fetch(PDO::FETCH_ASSOC);
            $param["msg"] = "Authentification réussie ";
        }
        else $param["msg"] = "Login ou mot de passe incorrect";
}

*/

$param ["form"] = $form->toHTML();
