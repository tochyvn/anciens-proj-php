<?php

/*$u=new Utilisateur();
$u->setEmail('titi@toto.fr');
$u->setPassword('totovelo');
$u->setRole(2);
$u->setPseudo('theTiti');
$u->save();
$u->setRole(3);
$u->save();
*/

$param['liste']=UtilisateurQuery::create()->find();
