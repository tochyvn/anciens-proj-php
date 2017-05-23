<?php

//initialisation
session_start();

//Tester la presence de la variable langage dans la session
if (isset($_SESSION['langage'])) {
    echo 'le langage existe dans la session et sa valeur est: ';
    echo $_SESSION['langage'];
} else {
    echo 'langage n\'existe pas dans la session';
}
?>