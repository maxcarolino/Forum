<?php

define("DENY_URL", "../error/denied");
define("THREAD_LIST", "/thread/index" );
define("START", 1000);
define("END", 100000);

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

function DenyUser()
{
    redirect(DENY_URL);
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
    if (!($_FILES['pic']['name'] === "")) { //check if no file was selected

        $fileType = exif_imagetype($_FILES["pic"]["tmp_name"]);
        $allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

        if (!in_array($fileType, $allowed)) { //check if file type is an image
            return $filepath = null;
        }

        $pic = rand(START,END)."-".$_FILES['pic']['name'];
        $pic_loc = $_FILES['pic']['tmp_name'];
        $folder="uploads/";
        if(move_uploaded_file($pic_loc,$folder.$pic))
        {
            return $filepath = $folder.$pic;
        }
            return $filepath = null;
    } 
}