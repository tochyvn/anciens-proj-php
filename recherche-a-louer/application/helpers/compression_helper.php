<?php

function uncompress($srcName, $dstName) {
    $sfp = gzopen($srcName, "rb");
    $stats = fstat( $sfp ); 
    $fp = fopen($dstName, "w");

    while (!gzeof($sfp)) {
        $string = gzread($sfp, 4096);
        fwrite($fp, $string, strlen($string));
    }
    gzclose($sfp);
    fclose($fp);
    return $stats;
}

