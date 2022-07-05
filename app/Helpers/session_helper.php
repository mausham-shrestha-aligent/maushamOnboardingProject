<?php

$_SESSION = null;
/**
 * Starts the user session
 */
session_start();
/** Checks if the user is logged in or not */
function isLoggedIn()
{
    return isset($_SESSION['user']);
}
/** Gets the user id of the user who is logged in  */
function getCurrentUserId()
{
    if (sizeof($_SESSION) > 0) {
        if ($_SESSION['user'] != null) {
            return $_SESSION['user']['id'];
        }
    }
    return false;
}
/** Gets the email of the user who is logged in */
function getUserEmail()
{
    return $_SESSION['user']['email'];
}
/** Checks whether the user is admin or not */
function isAdmin(): bool
{
    return $_SESSION['user']['accessLevel'] == \App\Models\User::ACCESS_LEVEL_ADMIN;
}
/** helps get the username of the user who is logged in */
function getCurrentUserName()
{
    return $_SESSION['user']['name'];
}
/** Used for sending message on screen */
function getSessionMsg()
{
    $msg = $_SESSION['session_msg'] ?? '';
    unset($_SESSION['session_msg']);
    return $msg;
}