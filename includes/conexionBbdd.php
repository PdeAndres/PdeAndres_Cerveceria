<?php
$host = 'localhost';
$puerto = '3306';
$usuario = 'root';
$pass = '';
$db = 'cervecera';

$conn = mysqli_connect($host, $usuario, $pass, $db, $puerto);

if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>