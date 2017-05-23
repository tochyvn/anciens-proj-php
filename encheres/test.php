<?php

// setup the autoloading
require_once 'vendor/autoload.php';
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass('SITEWEB', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn'      => 'mysql:host=localhost;dbname=SITEWEB',
  'user'     => 'root',
  'password' => 'root',
));
$serviceContainer->setConnectionManager('SITEWEB', $manager);


/*try{
$a=new Jeton();
$a->setCoefficient(8);
echo $a;

//$list=AuthorQuery::create()->filterByFirstName("toto")->filterByLastName('titi')->find();
$a->save();
}
catch (Exception $e){
    echo $e;  
}*/

try {
    /*  
     * -------------------INSERTION NOTE-------------------------------
     * 
    $b = new Article();
    $b->setNomArt("NOKIA_LUMIA_925");
    $b->setPrixU(400);
    //echo $b;
    $b->save();
    
   echo $b->getIdArt().'<br/>';
   echo $b->getNomArt().'<br/>';
   echo $b->getPrixU().'<br/>';
   echo $b->getPrimaryKey().'<br/>';
     * 
     */
    
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}

/* -------------------RECUPERATION D'UN ARTICLE PAR SA PRIMARY KEY----------

$t = new ArticleQuery();
$firstArticle = $t->findPk(4);
echo $firstArticle;

*/


/* --------------ASTUCE RECUPERATION D'UN ARTICLE PAR SA PRIMARY KEY-----

//Importation et renommage du namespace

use Base\ArticleQuery as ArtQuery ;

$firstArticle = ArtQuery::create()->findPk(5);
echo $firstArticle;

*/


/*--------------- RECUPERATION DE PLUSIEURS ARTICLE PAR PRIMARY KEY-----

$selectedArticles = \Base\ArticleQuery::create()->findPks(array(1,2,3,4,5));

foreach ($selectedArticles as $value) {
    echo $value."<br/>";
}

*/

/*------------RECUPERATION DE PLUSIEURS ARTICLE------------------------

use Base\ArticleQuery as ArtQuery;

$articles  = ArtQuery::create()->find(); 
// $ auteurs contient une collection d'objets d'Auteur 
// un objet pour chaque ligne de la table author 
foreach ( $articles  as $article )  { 
  echo $article->getNomArt().'<br/>';
}*/

/*---------------RECHERCHE PAR NOM ----------------------

use Base\ArticleQuery as ArtQuery;

$article = ArtQuery::create()->filterByNomArt('MAC_BOOK_PRO')->findOne();
echo $article;

*/


/*--------MISE A JOUR DES DONNEES DE LA BASE DE DONNÉES---------------------

$article = \Base\ArticleQuery::create()->findOneByIdArt(5);
$article->setNomArt(NOKIA_LUMIA_930);
$article->setPrixU(670);
$article->save();

echo $article;
 
 */


/*---------SUPPRESSION DES DONNÉES ----------------------*/

$article = \Base\ArticleQuery::create()->filterByNomArt('NOKIA_LUMIA_925');
$article->delete();


