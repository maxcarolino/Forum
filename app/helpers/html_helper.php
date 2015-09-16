<?php

define("DENY_URL", "../error/denied");

function char_to_html($string)
{
    if (!isset($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function readable_text($s)                    
{
    $s = htmlspecialchars($s, ENT_QUOTES);
    $s = nl2br($s);
    return $s;                    
} 

function redirect()
{
    header("Location: ".DENY_URL);
    die();
}

function check_user_session()
{
    if (!isset($_SESSION['username'])) {
        redirect();
    }
}

function unset_user_details()
{
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
}