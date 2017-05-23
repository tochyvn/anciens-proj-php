<?php
function creerAction()
{
	$user = new User();
	$user ->setId_user('01');
	$user ->setNom ('Reddy');
	$user ->setPrenom ('Ntie');
	$user ->setVille ('Marseille');
	$user ->setRole (1);

$user->save();
}
creerAction();