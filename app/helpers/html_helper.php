<?php

define("DENY_URL", "error/denied");
define("THREAD_LIST", "thread/index" );
define("COMMENT_VIEW", "comment/view?thread_id=");
define("START", 1000);
define("END", 100000);
define("DEFAULT_PIC", "profile/default.jpg");
define("UPLOADS_DIR", "uploads/");
define("PROFILE_PIC_DIR", "profile/");

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

function redirect_to($url)
{
    header("Location: ".$url);
}

function check_user_session()
{
    if (!isset($_SESSION['username'])) {
        redirect_to(url(DENY_URL));
    }
}

function deny_user()
{
    redirect_to(url(DENY_URL));
}

function compare($a, $b)
{
    return $b->likes - $a->likes;
}

function upload()
{
    if (!($_FILES['pic']['name'] === "")) { //check if no file was selected

        $fileType = exif_imagetype($_FILES["pic"]["tmp_name"]);
        $allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

        if (!in_array($fileType, $allowed)) {
            throw new FileTypeException('Unknown File Type'); //check if file type is an image
        }

        $pic = rand(START,END)."-".$_FILES['pic']['name'];
        $pic_loc = $_FILES['pic']['tmp_name'];
        if (move_uploaded_file($pic_loc, UPLOADS_DIR.$pic)) {
            return $filepath = UPLOADS_DIR.$pic;
        }
    }
}

function upload_profile_pic()
{
    if (!($_FILES['pic']['name'] === "")) { //check if no file was selected

        $fileType = exif_imagetype($_FILES["pic"]["tmp_name"]);
        $allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

        if (!in_array($fileType, $allowed)) { //check if file type is an image
            throw new FileTypeException('Unknown File Type');
        }

        $pic = rand(START,END)."-".$_FILES['pic']['name'];
        $pic_loc = $_FILES['pic']['tmp_name'];
        if (move_uploaded_file($pic_loc, PROFILE_PIC_DIR.$pic)) {
            return $filepath = PROFILE_PIC_DIR.$pic;
        }
    } else {
        return $filepath = DEFAULT_PIC;
    }
}