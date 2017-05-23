<?php

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


$listeArticles = ProduitQuery::create()->find();

$param['artlist'] = $listeArticles;


$liste = EnchereQuery::create()->find();

$param['list'] = $liste;


/*if(isset($_POST['idenchere']))
{
    $m=new Proposer();
     $m->setPrix($_POST['prix']);
     $m->setDate();
    $m->setEmail($_SESSION['utilisateure']['email']);
    $m->setIdenchere($_SESSION['utilisateure']['idenchere']);
    $m->save();
    $param['msg']="enchere reussie";
}

$param ["form"]=$form->toHTML();*/