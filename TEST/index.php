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
        echo 'tochap';
        print_r($_SERVER['PHP_AUTH_USER']); echo '<br/>';
        print_r($_SERVER['PHP_AUTH_PW']);
        echo '<br/>';
        print_r($_ENV);
        
        ?>
    </body>
</html>
