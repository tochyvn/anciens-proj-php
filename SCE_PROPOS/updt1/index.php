<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SIMULATEUR DE CIRCUITS ELECTRONIQUES</title>
        <link rel="stylesheet" type="text/css" media="all" href="graphics/styles/styles.css"/>
        <script type="text/javascript" src="graphics/scripts/jquery.js"></script>
        <script type="text/javascript" src="graphics/scripts/script.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
    </head>
    <body id="content">
        <?php
        
        
        //----- Classe de chargement  ---------
        require 'controleur'.DIRECTORY_SEPARATOR.'Autoload.php';
	spl_autoload_register('charge');
        //------------
        
        //--- Chargement de l'entête -----
        $head=new Head();
        $head->getMenu();
        //------------
        
        //-- On charge le contenu Body --
        $body=new Middle();
        $body->getContents();
        //---------
        
        //--- Le footer de la page ---
        $foot=new Foot();
        $foot->getFoot();
        
        ?>
    </body>
</html>
