<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('ENCHERES', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=localhost;dbname=ENCHERES',
  'user' => 'root',
  'password' => 'root',
));
$manager->setName('ENCHERES');
$serviceContainer->setConnectionManager('ENCHERES', $manager);
$serviceContainer->setDefaultDatasource('ENCHERES');