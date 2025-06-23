<?php
$con = new mysqli('localhost', 'root', 'root', 'school');
$con->set_charset("utf8");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
