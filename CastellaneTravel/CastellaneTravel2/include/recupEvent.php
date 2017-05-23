<?php 
    require '../class/db.class.php';
    $DB = new DB();
    
    $event= $DB->query("SELECT * FROM articlenews WHERE dateDebArticleNews or`dateFinArticleNews` != null");
    if(empty($event)){
        //$json['message']="Ce produit n'existe pas";
    }
