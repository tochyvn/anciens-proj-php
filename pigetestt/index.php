<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $name = "fichier";
        //print_r($_SERVER);
        print_r(headers_list());
        echo $_SERVER['HTTP_USER_AGENT'].'<br/>';
        //print_r($_SERVER).'<br/><br/>';
        ?>
        <a href =<?php echo 'http://localhost/pige/bin/pigeTest.php?fichier=localerte_eurosud.xml' ?> > la pige <br/> </a>
        <?php
        
        ?>
    </body>
</html>
