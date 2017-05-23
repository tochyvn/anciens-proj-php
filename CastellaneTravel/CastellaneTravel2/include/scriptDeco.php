<?php 
    require '../class/db.class.php';
    require '../class/connect.class.php';
    $DB = new DB();
    $connect = new connect($DB);
    //var_dump($_SESSION);
    
    
    $connect->deconnect();
    header('Location: http://localhost/CastellaneTravel');
exit;
?>

