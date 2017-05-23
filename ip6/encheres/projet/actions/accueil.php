<?php

/*

$u=UtilisateurQuery::create()->find();
/*$u=new Utilisateur();
$u->setLogin('login@site.fr');
$u->setRole(1);
$u->save();


$param['liste']=$u;

*/


$ListeArticles = ProduitQuery::create()->find();

$param['artlist'] = $ListeArticles;

