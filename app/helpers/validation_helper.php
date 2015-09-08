<?php

function validate_between($check, $min, $max)
{
    $n = mb_strlen(trim($check));

    return $min <= $n && $n <= $max;
}

function compare_password($check)
{
    $password = Param::get('password');
    return $check === $password;
}

function isUsernameValid($check)
{
    return preg_match("/^[a-zA-Z0-9_]*$/",$check);
}

function isPasswordValid($check)
{
    return preg_match("/^[a-zA-Z0-9_]*$/",$check);
}