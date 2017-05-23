<?php
function createAction()
{
    $utilisateur = new Utilisateur();
    $utilisateur->setLogin('yoyo@site.fr');
    $utilisateur->setPassword('null');
    $utilisateur->setPseudo('null');
    $utilisateur->setRole('null');

    $utilisateur->save();
  }
  createAction();

 ?>

