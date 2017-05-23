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
        
        // put your code here
        $prenom = "lionel";
        echo 'tochap '. $prenom;
        ?>
        <br/>
        <?php
        //1ere boucle for
        echo 'TABLEAU NUMEROTE <br/>';
        $tableau1 = array("imane","bey","tochap","ngassam","lionel");
        for($i = 0; $i<count($tableau1); $i++) {
            echo $tableau1[$i]."<br/>";
        }
        
        $tableau2 = array("nom_fem"=>"bey", "pren_fem"=>"imane", 
                          "nom_mari"=>"tochap ngassam", "pren_mari"=>"lionel", "age"=>1);
          
        echo 'TABLEAU ASSOCIATIF <br/>';
        foreach ($tableau2 as $key => $value) {  
            include_once '../test_php/fonctions.inc';
            echo $key." => ".$value. "<br/>";        
        }
        
        ////---------------------VARIABLES $GLOBALS-----------------------
        echo '<br/><br/>';
        $x = 75;
        $y = 25;
 
        function addition() {
            $GLOBALS['z'] = $GLOBALS['x'] + $GLOBALS['y'];
        }
 
        addition();
        echo $x."+".$y."=".$z."<br/><br/>"; 
        
        ////---------------------VARIABLES $_SERVER-----------------------
        //echo $_SERVER['PHP_SELF'];
        affiche($_SERVER);
        
        ?>
    </body>
</html>
