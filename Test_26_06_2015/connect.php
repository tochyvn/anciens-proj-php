<?php

$link = mysql_connect('localhost', 'root', 'root');

if ($link) {
    echo 'Connexion Žtablie avec succs';
}else {
    echo 'Echec de connexion';
}


//Connection ˆ base de socket linux
$link2 = mysql_connect(':/Applications/MAMP/tmp/mysql/mysql.sock', 'root', 'root');
if ($link2) {
    echo 'Connexion via socket Žtablie avec succs';
}else {
    echo 'Echec de connexion via socket';
}

?>