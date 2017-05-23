<?php

function genPassword($length = 8, $lettre = 6, $nombre = 2){
    $char = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    $password = '';
    $nombre_lettre = 0;
    $nombre_chiffre = 0;
    for($i = 0; $i < $length; $i++ ){
        $rand = rand(0, 25);
        if($nombre_lettre < $lettre && $nombre_chiffre < $nombre){
            if($rand % 2 == 0){
                $password .= $char[$rand];
                $nombre_lettre ++;
            }else{
                $password .= rand(0,9);
                $nombre_chiffre++;
            }
        }
        elseif($nombre_lettre >= $lettre){
            $password .= rand(0,9);
            $nombre_chiffre++;
        }
        elseif($nombre_chiffre >= $nombre){
            $password .= $char[$rand];
            $nombre_lettre ++;            
        }
    }
    return $password;
}

