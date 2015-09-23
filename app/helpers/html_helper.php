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

function get_thread_id_from_url()
{
    $url = $_SERVER['REQUEST_URI'];
    return substr($url, strpos($url, '=') + 1, 3); //magic number
}

function get_comment_id_from_url()
{
    $url = $_SERVER['REQUEST_URI'];
    return substr($url, strrpos($url, '=') + 1); //magic number
}

function get_user_id_from_url()
{
    $url = $_SERVER['REQUEST_URI'];
    return substr($url, strrpos($url, '=') + 1);
}

function isThreadOwner($user_id, $thread_id)
{
    if (!Thread::isOwner($user_id, $thread_id)) {
        redirect(DENY_URL);
    }
    return true;
}

function isCommentOwner($user_id, $comment_id)
{
    if (!Comment::isOwner($user_id, $comment_id)) {
        redirect(DENY_URL);
    }
    return true;
}

function cmp($a, $b)
{
    if ($b->likes === $a->likes) {
        return 0;
    }
    return $b->likes - $a->likes;
}

function upload()
{
    if (!$_FILES['pic']['name'] === "") { //check if no file was selected

        $fileType = exif_imagetype($_FILES["pic"]["tmp_name"]);
        $allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

        if (!in_array($fileType, $allowed)) { //check if file type is an image
            return $filepath = null;
        }

        $pic = rand(1000,100000)."-".$_FILES['pic']['name'];
        $pic_loc = $_FILES['pic']['tmp_name'];
        $folder="uploads/";
        if(move_uploaded_file($pic_loc,$folder.$pic))
        {
            return $filepath = $folder.$pic;
        }
            return $filepath = null;
    }

    return $filepath = null;
}