<?php

// setup the autoloading

require_once 'vendor/autoload.php';
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass('SITE_ENCHERES', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn'      => 'mysql:host=localhost;dbname=SITE_ENCHERES',
  'user'     => 'root',
  'password' => 'root',
));
$serviceContainer->setConnectionManager('SITE_ENCHERES', $manager);



        try {
           
            /*
            $pack = new Packjeton();
            $pack->setJetons(5);
            $pack->save();
            echo $pack;
            echo '<br/>';
            
            $pack = new Packjeton();
            $pack->setJetons(10);
            $pack->save();
            echo $pack;
            echo '<br/>';
            
            $article = new Article();
            $article->setNomArt("SAMSUNG GALAXY NOTE 2");
            $article->setPath("/Applications/MAMP/htdocs/tochSite/images/");
            $article->setPrix("300");
            $article->save();
            echo $article;
            echo '<br/>';
             * 
             */
            
            $enchere = new Enchere();
            $enchere->setIdArt(1);
            $enchere->setDateDebut(date('y-m-d'));
            $enchere->setDateFin('2015-04-01');
            $enchere->setHeureDebut('12:00:00');
            $enchere->setHeureFin('12:00:00');
            $enchere->save();
            echo $enchere;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            echo 'tochap@imane';
        }

     
