<!-- Define los parámetros de las variables de conexión -->
<?php
$host = 'localhost';
$puerto = '3306';
$usuario = 'root';
$pass = '';
$db = 'cervecera';

/* Conexión a la base de datos */
$conn = mysqli_connect($host, $usuario, $pass, $db, $puerto);


/* Si la conexión falla, muestra un mensaje de error */
if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>