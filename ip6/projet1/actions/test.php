<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('miniprojet', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=localhost;dbname=miniprojet',
  'user' => 'root',
  'password' => 'root',
));
$manager->setName('miniprojet');
$serviceContainer->setConnectionManager('miniprojet', $manager);
$serviceContainer->setDefaultDatasource('miniprojet');


$listeArticles = ProduitQuery::create()->find();

//$param['artlist'] = $listeArticles;


//$liste = EnchereQuery::create()->find();

//$param['list'] = $liste;
var_dump($listeArticles);