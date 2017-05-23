<?php
$listeEncheres=  EnchereQuery::create()->filterByEncours(1)->find();
$param['liste']=$listeEncheres;
