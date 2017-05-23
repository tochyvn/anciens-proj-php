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
    </head>
    <body>
        <?php

        require 'controleur'.DIRECTORY_SEPARATOR.'Autoload.php';
        //require 'http://idjabou.byethost3.com/Autoload.php';
	spl_autoload_register('charge');
        
        $sommets=Manager::getManager()->getSommets();
        foreach ($sommets as $s){
            echo"<img src='graphics/upload/".$s['name']."' width='".$s['width']."' height='".$s['height']."'>";
        }
        ?>
    </body>
</html>
