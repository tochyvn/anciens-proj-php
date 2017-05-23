<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function to_us( $date ){
    setlocale (LC_TIME, 'fr_FR','fra');
    //Définit le décalage horaire par défaut de toutes les fonctions date/heure  
    date_default_timezone_set("Europe/Paris");
    //Definit l'encodage interne
    mb_internal_encoding("UTF-8");
    //Convertir une date US en françcais
    return strftime('%Y-%m-%d', strtotime($date) );       
}

function getTimeFromUs( $date ){
    setlocale (LC_TIME, 'fr_FR','fra');
    //Définit le décalage horaire par défaut de toutes les fonctions date/heure  
    date_default_timezone_set("Europe/Paris");
    //Definit l'encodage interne
    mb_internal_encoding("UTF-8");
    //Convertir une date US en françcais
    return strtotime( $date ) ;    
}

function to_beautiful_fr( $date ){
    setlocale (LC_TIME, 'fr_FR','fra');
    //Définit le décalage horaire par défaut de toutes les fonctions date/heure  
    date_default_timezone_set("Europe/Paris");
    //Definit l'encodage interne
    mb_internal_encoding("UTF-8");
    //Convertir une date US en françcais
    return strftime('%A %d %B %Y', strtotime($date) );       
}