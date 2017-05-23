<?php
    $form = new XmlForm(array("method" => "post", "action" => $_SERVER['REQUEST_URI'] ));

    $zt1 = new XmlZoneTexte(array("label" => "Entrez votre Pseudo:",
                "msgErr" => "Majuscule suivi de minuscules",
                "regex" => "^[A-Z][a-z]+$",
                "name" => "pseudo"));
	
	/*$zt3 = new XmlZoneDate(array("label" => "Entrez votre date de naissance :",
                "msgErr" => "doit être une date valide : aaaa-mm-jj",
                "regex" => "^[0-9]{4}-[0-9]{2}-[0-9]{2}$",
                "name" => "datenaissance"));*/
    $zt3 = new XmlZoneTexte(array("label" => "Entrez votre E-mail :",
                "msgErr" => "doit être un E-mail valide",
                "regex" => "[^@,.]+@[^@,.]+\.(fr|com)$",
                "name" => "E-mail"));

   $zt2 = new XmlZonePassword(array("label" => "Entrez votre password :",
                "msgErr" => "Majuscule Minuscules Chiffres @ & $ % de longueur au moins 5",
                "regex" => "^[A-Za-z0-9@&$%]{5,128}$",
                "name" => "password"));
                
    /* $zr1= new XmlZoneRadio( array("label" => "Entrez votre sexe :",
                "msgErr" => "Obligatoire",
                "name" => "sexe",
                "radio"=>array("Masculin"=>1,"Féminin"=>2,"Autre"=>3),
                "obligatoire"=>1
                ));
	$zc1= new XmlZoneCheckbox( array("label" => "Langues parlées :",
                "msgErr" => "Entre 1 et  3 langues",
                "name" => "langues",             			"checkbox"=>array("Arabe"=>1,"Français"=>2,"Anglais"=>3,"Espagnol"=>4,"Polonais"=>5,"Allemand"=>6,"Italien"=>7),
                "min"=>1,
                "max"=>3,
                ));
                
      $zl1=new XmlZoneListe( array("label" => "Age :",
                "msgErr" => "Choisir votre age",
                "name" => "age",
                "options"=>array(1=>"0-10",2=>"11-20",3=>"21-30",4=>"30+"),
                "min"=>1,
                "max"=>1
                ));
 $zl2=new XmlZoneListe( array("label" => "Loisirs :",
                "msgErr" => "Choisir vos loisirs",
                "name" => "loisirs",
                "options"=>array(1=>"Sport",2=>"Internet",3=>"Lecture",4=>"Autre"),
                "min"=>1,
                "max"=>3,
                "multiple"=>1
                ));*/
                
    $submit = new XmlInput(array("value" => "Enregistrer", "type" => "submit"));

    	$form->addElement($zt1);
    	$form->addElement($zt2);
    	$form->addElement($zt3);
	//$form->addElement($zr1);
	//$form->addElement($zc1);
	//$form->addElement($zl1);
	//$form->addElement($zl2);

    $form->addElement($submit);


    if ($form->donneesEnvoyees() && $form->formulaireValide()) {
        $param ["msg"]="Le formulaire est valide…";

        $u=new Utilisateure();
    $u->setEmail($_POST['E-mail']);
     $u->setPseudo($_POST['pseudo']);
    $u->setPassword($_POST['password']);
    $u->setRole(0);
    $u->setjetonParDefaut(5);
   
    $u->save();
    }




$param ["form"]=$form->toHTML();


?>
 
