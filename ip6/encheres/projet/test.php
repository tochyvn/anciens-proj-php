<?php

// setup the autoloading
require_once 'vendor/autoload.php';
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass('bookstore', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn'      => 'mysql:host=localhost;dbname=my_db_name',
  'user'     => 'my_db_user',
  'password' => 's3cr3t',
));
$serviceContainer->setConnectionManager('bookstore', $manager);


try{
$a=new Author();
$a->setFirstName("Ostrowski");
echo $a;

//$list=AuthorQuery::create()->filterByFirstName("toto")->filterByLastName('titi')->find();
$a->save();
}
catch (Exception $e){
    echo $e;  
}
