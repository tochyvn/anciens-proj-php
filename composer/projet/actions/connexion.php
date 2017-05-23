<?php
$form = new XmlForm(array("method" => "post", "action" => "" . $_SERVER['REQUEST_URI'] . ""));

$zt1 = new XmlZoneTexte(array("label" => "Entrez votre login :",
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
        $result = $con->query("select * from authentification where login='$_POST[email]' and mdp='$_POST[password]'");
        if ($result->rowCount())
        {
            $_SESSION['user'] = $result->fetch(PDO::FETCH_ASSOC);
            $param["msg"] = "Authentification réussie ";
        }
        else $param["msg"] = "Login ou mot de passe incorrect";
}

$param ["form"] = $form->toHTML();
