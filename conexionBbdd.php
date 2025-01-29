<?php
$host = 'localhost';
$puerto = '3308';
$usuario = 'root';
$pass = '';
$db = 'Cerveceria';

$conn = mysqli_connect($host, $usuario, $pass, $db, $puerto);

if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>