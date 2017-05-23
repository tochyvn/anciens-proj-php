<?php

//ini_set("display_errors",0);error_reporting(0);
header("content-type: text/plain; charset=UTF-8");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("SERVERNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
define("DATABASE", "POPCORN");

$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if (!$conn) {
    die("Echec de connexion ".mysqli_connect_error);
}



