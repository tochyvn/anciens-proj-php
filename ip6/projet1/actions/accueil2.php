
<?php

$listeArticles = ProduitQuery::create()->find();

$param['artlist'] = $listeArticles;

 $encherie = EnchereQuery::create()->find();

$param['encheri'] = $encherie;
