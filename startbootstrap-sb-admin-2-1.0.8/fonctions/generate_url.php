<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * fonction retournant l'url courante
 * @return type
 */
function site_url($str = NULL) {
    return "http://". $_SERVER['HTTP_HOST']. "/CastellaneTravel/". $str;
}

/**
 * fonction de redirection
 * @param type $str
 */
function redirect($str = NULL) {
    header("Location: ".site_url(). $str);
}