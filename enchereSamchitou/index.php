<?php

// setup the autoloading
require_once 'vendor/autoload.php';
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass('ENCHERES', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn'      => 'mysql:host=localhost;dbname=ENCHERES',
  'user'     => 'root',
  'password' => 'root',
));
$serviceContainer->setConnectionManager('ENCHERES', $manager);

try{
    
$user= new User();
$user->setIdUser(2);
$user->setNom('TOCHAP');
$user->setPrenom('LIONEL');
$user->setVille('Marseille');
$user->setRole(1);

//Sauvegarder le user
$user->save();


//$list=AuthorQuery::create()->filterByFirstName("toto")->filterByLastName('titi')->find();
//$a->save();

}
catch (Exception $e){
    echo $e;  
}
