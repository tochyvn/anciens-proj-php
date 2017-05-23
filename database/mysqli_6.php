<?php

//inclure le fichiers des fonctions
require('fonctions.inc');
//Requete a traiter
$sql = 'SELECT * FROM ARTICLES';
$articles = db_read_all_line($sql);
if ($articles) {
    echo count($articles)." articles<br/><br/>";
    affiche($articles);
}

?>