<?php

function start_page($title, $css = NULL) {
echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>'.$title.'</title>'
        . '    '. fetch_css($css) .'
    </head>
    <body>';
}

function end_page() {
    echo '    </body>
</html>';
}

function fetch_css($path) {
    $link = "";
    if ($path != NULL ) {
        $link =  '<link rel="stylesheet" href="'. $path .'" />';
    }
    return $link;
}

