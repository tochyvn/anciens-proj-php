<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of article
 *
 * @author thomas
 */
class article {
    private $DB;
    //put your code here
    private $idArticle = 'idArticle';
    private $titreArticleFR = 'titreArticleFR';
    private $titreArticleENG = 'titreArticleENG';
    private $txtArticleFR = 'txtArticleFR';
    private $txtArticleENG = 'txtArticleENG';
    private $dateDebArticleNews = 'dateDebArticleNews';
    private $dateFinArticleNews = 'dateFinArticleNews';
    private $titreArtPhotoFR = 'titreArtPhotoFR';
    private $titreArtPhotoENG = 'titreArtPhotoENG';
    private $altArtPhoto = 'altArtPhoto';
    private $lienArtPhoto = 'lienArtPhoto';
    private $idLieu = 'idLieu';
    
            
    public function __construct($DB){
        $this->DB = $DB;
    }
    
    public function recupevent(){
        $events = $this->DB->query("SELECT * FROM articlenews WHERE dateDebArticleNews or`dateFinArticleNews` != null");
        //$events = str_replace(,'../imgbdd/event/'.$events["lienArtPhoto"]);
        //var_dump($events);
        return $events;
    }
    

}


