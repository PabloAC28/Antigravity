<?php
// auth_check.php
session_start();

/**
 * Checks if the administrator is logged in.
 * @return bool
 */
function is_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Redirects to login page if the user is not logged in.
 */
function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}
?>
