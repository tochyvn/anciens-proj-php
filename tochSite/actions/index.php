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
           
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

     
