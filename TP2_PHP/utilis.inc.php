<?php

function start_page($title)
    {
        echo '<!DOCTYPE html>
        <html><head><title>' . "\n" . $title . '</title></head><body>' . "\n";
    };
    
function end_page() {
    echo '</body>' . "\n"
    . '</html>';
}