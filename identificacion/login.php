<?php
session_start();
include('../includes/conexionBbdd.php');

$correo = $_POST["usuario"];

$password = $_POST["password"];

$md5_password = md5($password);

$query = "SELECT * FROM usuario WHERE correo = ? AND password = ?";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $correo, $md5_password);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 1) {

        $usuario = mysqli_fetch_assoc($resultado);

        $_SESSION["usuario"] = $usuario;
        header("Location: ../vistas/home.php");
    } else {
        session_destroy();
        echo "No se ha encontrado ningun usuario";
    }
}
?>