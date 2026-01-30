<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getRole() {
    return $_SESSION['role'] ?? 'Guest';
}

function hasRole($roles) {
    if (!isLoggedIn()) return false;
    if (is_array($roles)) {
        return in_array($_SESSION['role'], $roles);
    }
    return $_SESSION['role'] === $roles;
}

function requireRole($roles) {
    if (!hasRole($roles)) {
        $path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../login.php' : 'login.php';
        session_write_close();
        header("Location: $path?error=unauthorized");
        exit();
    }
}

function logout() {
    session_unset();
    session_destroy();
    $path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../login.php' : 'login.php';
    session_write_close();
    header("Location: $path");
    exit();
}
