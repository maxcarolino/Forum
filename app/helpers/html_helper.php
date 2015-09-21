<?php

define("DENY_URL", "../error/denied");
define("THREAD_LIST", "/thread/index" );

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

function redirect($url)
{
    if ($url === THREAD_LIST) {
        header("Location: ".THREAD_LIST);
    } else {
        header("Location: ".DENY_URL);
        die();
    }
}

function check_user_session()
{
    if (!isset($_SESSION['username'])) {
        redirect(DENY_URL);
    }
}

function get_from_url()
{
    $url = $_SERVER['REQUEST_URI'];
    return substr($url, strrpos($url, '=') + 1);
}

function isThreadOwner($user_id, $thread_id)
{
    if (!Thread::isThreadOwner($user_id, $thread_id)) {
        redirect(DENY_URL);
    }
    return true;
}