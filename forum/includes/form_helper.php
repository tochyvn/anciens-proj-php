<?php

function setValue($name) {
    $repopulate_value = "";
    if (isset($_SESSION['populate_value'][$name])) {
        $repopulate_value = $_SESSION['populate_value'][$name];
    }
    return $repopulate_value;
}

function add_class_error($name) {
    if (isset($_SESSION['errors'][$name])) {
        echo 'class="class_error"';
    }
}