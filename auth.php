<?php
//backend/utils/auth.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**require_login() - ensure a user is logged in. If not, redirect to login page. */
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.html");
        exit();
    }
}

/** require_admin() - ensure logged-in user is an admin. */
function require_admin() {
    require_login();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        //you could redirect to user dashboard or show 403 page
        header("HTTP/1.1 403 Forbidden");
        echo "Access denied. Admins only.";
        exit();
    }
}


?>