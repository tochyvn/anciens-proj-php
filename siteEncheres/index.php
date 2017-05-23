<?php
  
//require_once 'controleur.php';

try {
    $pack = new PackJeton();
    $pack->setJetons(30);
    echo $pack;
    $pack->save();
}catch(PDOException $e) {
    echo $e->getMessage();
} 
    /*
    $article = new Article();
    $article->setNomArt("SAMSUNG");
    $article->setPrix(1000);
    $article->save();
    echo $article;
     * 
     */