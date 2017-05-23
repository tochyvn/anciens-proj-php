<?php
//phpinfo();
$filename = htmlspecialchars($_GET['fichier']);
//echo $filename.'<br/>';
$path = __DIR__;
//echo $path.'<br/>';
//echo $_SERVER['DOCUMENT_ROOT'];
echo urlencode($_GET['fichier'])."<br>";

if (isset($filename)) {
    /*
    $domObject=new DOMDocument();
    $domObject->load($_SERVER['DOCUMENT_ROOT'].'/pige/etc/'.$filename);
    $parent = $domObject->documentElement;
    echo $parent->nodeName;  
    //parcours($parent);
    */
    
    
    $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/pige/etc/'.$filename);
    parcours($xml);
    echo $xml->initialisation."<br>";
}        
    
    function parcours($noeud) {
        
        echo "\t\r\n"."   TAG  :  ".$noeud->getName()."<br>";
        foreach ($noeud->children() as $children) {
            
            if ($children->count() != 0) {
                $str = "\t\r\n"."   TAG  :  ".$children->getName()." : <br/>";
                echo '--------------voici la liste de ses enfants------------------------<br/>';
                parcours($children);
                echo '--------------Fin de la liste de ses enfants------------------------<br/>';
            } else {
                $str = "\t\r\n"."   TAG  :  ".$children->getName()." = ".$children."<br/>";
            }
            
            if ($children->getName() !== "expression") {
                echo $str;
            } else {
                //$str = preg_replace('#<br/>#', '***', $str); 
                echo strip_tags($str);
            }
            
        }
    }
    
    /*
    //ANCIENNE
    function parcours($noeud) {
        
        foreach ($noeud->childNodes as $child) {
            $str = $child->nodeName . " = " . $child->nodeValue ;
            //$str = preg_replace('#(<br/>|<a>)#', '', $str);
            if ($child->nodeName !== "expression") {
                echo $str. "<br/>";
            } else {
                echo strip_tags($str). "<br/>";
            }
            
            if (count($child->childNodes) !== 0) {
                echo 'A des enfants<br/>';
                parcours($child);
            }
            
        }
    }
    */
   

 

 



