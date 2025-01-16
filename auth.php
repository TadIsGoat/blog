<?php

session_start();

function isAuth() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isAuth() && $_SESSION['user']['role'] === 'admin';
}

function hasPerm() {
    return isAuth() && $_SESSION['user']['can_edit'];
}

?>