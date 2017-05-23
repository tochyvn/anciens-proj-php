<?php
try{

if ($_GET['more']=='modifier'||$_GET['more']=='supprimer')
{
	$u=UtilisateureQuery::create()->filterByEmail($_GET['id'])->findOne();
	if($u)
		{
	if (empty($_POST))
		{
	$_REQUEST['email']=$u->getEmail();
	$_REQUEST['pseudo']=$u->getPseudo();
	$_REQUEST['password']=$u->getPassword();
	$_REQUEST['role']=$u->getRole();
		}

		}

}

    $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

    $zt1 = new XmlZoneTexte(array("label" => "Entrez votre email :",
            "msgErr" => "doit être un mail valide",
            "regex" => "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$",
            "name" => "email"));
    $zt3 = new XmlZoneTexte(array("label" => "Entrez votre pseudo :",
                "msgErr" => "Majuscule suivi de minuscules",
                "regex" => "^[A-Z][a-z]+$",
                "name" => "pseudo"));
    $zt2 = new XmlZoneTexte(array("label" => "Entrez votre password :",
                "msgErr" => "Majuscule Minuscules Chiffres @ & $ % de longueur au moins 5",
                "regex" => "^[A-Za-z0-9@&$%]{5,128}$",
                "name" => "password"));	

   $zt4 = new XmlZoneTexte(array("label" => "Entrez votre role :",
                "msgErr" => "1 2 3 ou 4",
                "regex" => "^[1234]$",
                "name" => "role"));		
                       
    $submit = new XmlInput(array("value" => $_GET['more'], "type" => "submit"));

    	$form->addElement($zt1);
    	$form->addElement($zt2);
    	$form->addElement($zt3);
	$form->addElement($zt4);

    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {

	switch($_GET['more'])
{
case 'inserer':
	$u=new Utilisateure();
	$u->setEmail($_POST['email']);
	$u->setPassword($_POST['password']);
	$u->setRole($_POST['role']);
	$u->setPseudo($_POST['pseudo']);
	$u->save();
        $param ["msg"]="enregistrement effectué";
break;
case 'modifier':
	//$u->setEmail($_POST['email']);
	$u->setPassword($_POST['password']);
	$u->setRole($_POST['role']);
	$u->setPseudo($_POST['pseudo']);
	$u->save();
        $param ["msg"]="modification effectuée";
break;
case 'supprimer':
	$u->delete();
        $param ["msg"]="enregistrement supprimé";
break;

}
    }


}catch (Exception $e)
{
	$param ["msg"]="enregistrement impossible";
}

$param ["form"]=$form->toHTML();
?>
