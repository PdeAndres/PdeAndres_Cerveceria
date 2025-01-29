<?php
session_start();
include('conexionBbdd.php');

$usuario = $_REQUEST["usuario"];

$password = $_REQUEST["password"];

echo $usuario . " " . $password;

session_destroy();
?>