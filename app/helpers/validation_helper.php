<?php

function validate_between($check, $min, $max)
{
    $check = trim($check);
    $n = mb_strlen($check);

    return $min <= $n && $n <= $max;
}

function compare_password($check)
{
    $password = trim(Param::get('password'));
    return $check === $password;
}

function is_username_valid($check)
{
    return preg_match("/^[a-zA-Z0-9_]*$/", $check);
}

function is_password_valid($check)
{
    return preg_match("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).)/", $check);
    /* password should contain at least 1 lowercase and uppercase character,
    0-9 digit, any of these @#$% characters */
}

function is_email_valid($check)
{
    return preg_match("/^([a-z0-9_\.-]+\@[\da-z\.-]+\.[a-z\.]{2,6})$/", $check);
}

function is_valid($check)
{
    return preg_match("/^[a-zA-Z]+(?:[\s][A-Za-z]+)*$/", $check); 
    //Name should only contain letters and one or more non consecutive space
}