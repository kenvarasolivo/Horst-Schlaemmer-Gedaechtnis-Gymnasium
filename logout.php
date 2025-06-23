<?php
session_start();
if ($_SESSION["username"]) {
    unset($_SESSION["username"]);
}
if ($_SESSION["role"]) {
    unset($_SESSION["role"]);
}

header('Location: login.php');
