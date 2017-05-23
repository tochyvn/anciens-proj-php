<?php

// src/Controller/ArticlesController.php

namespace App\Controller;

//use App\Model\Entity\Article;

class DatesController extends AppController
{

    
    
    public function index() {
       $date = \Cake\I18n\Time::now();
       $dateFrench = $date->i18nFormat(\IntlDateFormatter::FULL, 'Europe/Paris', 'fr-FR');
       
       $dateFormat = $this->dateCheck($dateFrench);
       debug($dateFrench);
       debug($dateFormat);
    }
    
    private function dateCheck($date) {
        
        
        $array = explode(" ", $date, 5);
        $chaine = $array[0] . " " . $array[1] . " " . $array[2] . " " .$array[3];
        
        return $chaine;
    }
    
}



