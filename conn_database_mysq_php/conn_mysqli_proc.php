<?php

header( 'content-type: text/html; charset=utf-8' );


define('SERVER_NAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD','root');
define('DBNAME', 'franc');

$conn = mysqli_connect(SERVER_NAME, USERNAME, PASSWORD, DBNAME);
//Tester si la connexion a bien ŽtŽ etablie
if ($conn) {
    echo utf8_decode("Connexion etablie avec succs").'\r\n';
} else {
    die("connexion failed: ".mysqli_connect_error());
}

var_dump(getallheaders());

$conn2 = new mysqli(SERVER_NAME, USERNAME, PASSWORD, DBNAME);
if ($conn2->connect_error) {
    die('Echec de connexion numero 2 : ('.$conn2->connect_errno.') : '.$conn2->connect_error);
}

echo '<br/>Connexion 2 Žtablie avec succs'

?>