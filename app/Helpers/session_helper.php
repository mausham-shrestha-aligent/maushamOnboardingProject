<?php
$_SESSION= null;
session_start();
function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function getUserId()
{
    if(sizeof($_SESSION)>0) {
        if($_SESSION['user'] != null) {
            return $_SESSION['user']['id'];
        }
    }

    return false;

}

function getUserEmail()
{
    return $_SESSION['user']['email'];
}

/**
 * TODO: REFACTOR THIS IN THE FUTURE NOT GOOD : )
 */
function isAdmin(): bool
{
    return $_SESSION['user']['accessLevel'] == \App\Models\User::ACCESS_LEVEL_ADMIN;
}

function getUserName()
{
    return $_SESSION['user']['name'];
}

function getSessionMsg()
{
    $msg = $_SESSION['session_msg'] ?? '';
    unset($_SESSION['session_msg']);
    return $msg;
}