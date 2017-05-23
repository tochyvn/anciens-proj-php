<?php

define("USERNAME", "tochyvn");
define("HOST", "mysql-tochyvn.alwaysdata.net");
define("PASSWORD", "TOCHlion1991");
define("DBNAME", "tochyvn_forum");

define("USERNAME1", "root");
define("HOST1", "localhost");
define("PASSWORD1", "root");

$connexion = new mysqli(HOST1, USERNAME1, PASSWORD1, DBNAME);

if (!$connexion) {
    header('location:../index.php');
}else {
    //echo "connexion reussie";
}

