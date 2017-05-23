<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$tableau['first'] = 1;
$tableau['second'] = 2;
$tableau['third'] = 3;
$tableau['fourth'] = 4;
$tableau['five'] = 5;
//unset($tableau['five']);
$tableau['five'] = $tableau['five'] + 1;
var_dump($tableau);