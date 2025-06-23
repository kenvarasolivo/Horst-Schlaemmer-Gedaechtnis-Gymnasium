<?php
session_start();
function check_authentication(): void
{
    if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
        header('Location: /login.php');
        exit();
    }
}

function is_teacher() {
    $role = $_SESSION["role"] ?? NULL;

    return $role === 1;
}

function is_parent() {
    $role = $_SESSION["role"] ?? NULL;
    
    return $role === 2;
}

function is_student() {
    $role = $_SESSION["role"] ?? NULL;

    return $role === 3;
}
