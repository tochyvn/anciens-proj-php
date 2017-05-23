<?php
function createAction()
{
    $utilisateure = new Utilisateure();
    //$utilisateure->setIdUtilisateure('001');
    $utilisateure->setNom('Ntikala');
    $utilisateure->setPrenom('Christian');
    $utilisateure->setVille('Paris');
    $utilisateure->setRole('');


    $utilisateure->save();
  }
  
  createAction();

 ?>
