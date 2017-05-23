<?php

function validate_email($email) {
    return preg_match('/^[A-Za-z0-9-_.]+@[a-z]+\.[a-z]{2,6}/', $email);
}

function validate_password($password) {
    $count = strlen($password);
    if ($count < 6) {
        return FALSE;
    }else {
        return TRUE;
    }
}

function test_input($input) {
    $input = htmlspecialchars($input);
    $input = addslashes($input);
    $input = stripslashes($input);
    
    return $input;
}

function isEquals($passwd, $passwd_conf) {
    return ($_POST[$passwd] == $_POST[$passwd_conf]);
}

function sendMail($to , $subject, $message) {
    return mail($to, $subject, $message);
}
