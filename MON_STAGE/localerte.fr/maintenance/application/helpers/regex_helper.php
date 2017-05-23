<?php

/**
 * retourne true si l'email est valide, false sinon
 * @param type $email
 * @return boolean
 */
function isEmailValid($email){
    $regex = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
    if(preg_match($regex, $email)){
        return true;
    }
    return false;
}