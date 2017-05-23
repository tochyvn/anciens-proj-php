<?php

// setup the autoloading
require_once 'vendor/autoload.php';
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass('ENCHERES', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn'      => 'mysql:host=localhost;port=8889;dbname=ENCHERES',
  'user'     => 'root',
  'password' => 'root',
));
$serviceContainer->setConnectionManager('ENCHERES', $manager);

var_dump($serviceContainer);

try{
echo '<strong>tochhhhhhhhhhh</strong>';  
$user= new User();
$user->setIdUser('ABX23');
$user->setNom('TOCHAP');
$user->setPrenom('LIONEL');
$user->setVille('Marseille');
$user->setRole(1);

//Sauvegarder le user
$user->save();

echo '<strong>'.$user.'</strong>';

//$list=AuthorQuery::create()->filterByFirstName("toto")->filterByLastName('titi')->find();
//$a->save();

}
catch (Exception $e) {
    echo $e;  
}
