<?php

/* 
 * Ce scripte va recuperer les informations du composant
 * et les retourner à la vue
 */


//----- Classe de chargement  ---------
require 'controleur'.DIRECTORY_SEPARATOR.'Autoload.php';
spl_autoload_register('charge');
//echo $_POST['ido'];
$pro=Manager::getManager()->getSommetByName($_POST['ido']);
echo $pro['Description'].",".$pro['Etat'].",".$pro['ID'].",".$pro['Nombre entrées'].",".$pro['Nombre sorties'];



