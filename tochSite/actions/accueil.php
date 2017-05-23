<?php

//$now = date('Y-m-d h:i:s');
//$listeEncheres = EnchereQuery::create()->filterByDateFin(array('max' => 'now'))->find();
/*
use Propel\Runtime\Propel;

$con = Propel::getWriteConnection(\Map\EnchereTableMap::DATABASE_NAME);
$sql = "SELECT * FROM ENCHERE WHERE date_fin > NOW()";

$query = $con->query($sql);

$listeEncheres = array();

while ($t = $query->fetch()) {
echo 111111111111111;
    $listeEncheres = $t; 
}
                
$param['liste']=$listeEncheres;
*/

//print_r($_POST);

$listeArticles = EnchereQuery::create()->find();

$param['artlist'] = $listeArticles;

if(isset($_POST['id']))
{
    $m=new Mise();
    $m->setPseudo($_SESSION['user']['pseudo']);
    $m->setPrix($_POST['prix']);
    $m->setIdEnch($_POST['id']);
    $m->save();
    $param['msg']="enchere reussie";
}