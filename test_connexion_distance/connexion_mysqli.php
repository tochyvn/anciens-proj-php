<?php

define("USERNAME", "tochyvn");
define("HOST", "mysql-tochyvn.alwaysdata.net:3306");
define("PASSWORD", "TOCHlion1991");
define("DBNAME", "tochyvn_forum");
$connexion = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

if (!$connexion) {
    echo "echec de connexion";
}else {
    var_dump($connexion);
    echo "Connexion reussie";
}

