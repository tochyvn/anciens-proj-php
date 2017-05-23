<?php

    function load($className)
    {
        //echo $className;   
        research($className,".");
    
    }
    function research($className,$rep){
        
        //$fichier=[];
        if(is_dir($rep)){
           if($dir=opendir($rep)){
            
            while ($file=readdir($dir)) {
                
                if($file==$className.'.php'){
                   require $rep.DIRECTORY_SEPARATOR.$file;
                }
                
                $uri=$rep.DIRECTORY_SEPARATOR.$file;
                //$fichier[]=$uri;  
                if(is_dir($rep)&&!in_array($file,array(".",".."))){
                    research($className,$uri);
                }
            }
        }
        }
     
        //echo '<pre>';
        //print_r($fichier);
        //echo '</pre>';
    }