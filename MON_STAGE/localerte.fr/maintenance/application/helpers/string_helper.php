<?php

function stripAccents($string){
	return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function arrayTostring($array, $delimeter){
    $compteur = false;
    $string = '';
    foreach($array as $data){
        if($compteur == false){
            $string = $data;
        }
        else{
            $string = $string.$delimeter.$data;
        }
        $compteur = true;
    }
    return $string;
}