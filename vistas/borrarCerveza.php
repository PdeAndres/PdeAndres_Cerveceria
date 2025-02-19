<?php
// Iniciamos la sesión y verificamos si el usuario está logueado
session_start();
include("../includes/conexionBbdd.php");
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.html");
}

// Verificamos si el usuario es administrador.
if ($_SESSION["usuario"]["perfil"] != "admin") {
    header("Location: home.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="./css/style.css" />

</head>

<body>
    <?php
    /* Comprobamos si se ha pasado un id por la url */
    if (!$_GET["id"]) {
        header("Location: catalogo.php");
    } else {
        /* Si se ha pasado, lo guardamos en una variable  y preparamos la consulta */
        $id_producto = $_GET['id'];

        // Preparar la consulta
        $sql = "DELETE FROM producto WHERE id_producto = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {

            /* Prepara los parámetros de la consulta y la ejecuta */
            mysqli_stmt_bind_param($stmt, "i", $id_producto);

            mysqli_stmt_execute($stmt);

            // Si la consulta tiene exito redirige al catálogo
            if (mysqli_stmt_execute($stmt)) {

                // Cierra la consulta y la conexión a la BBDD
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header('Location: catalogo.php'); // Redirigir al catálogo después de eliminar
            } else {
                echo "<p class='errorMsg'>Error al eliminar el producto: " . mysqli_stmt_error($stmt) . "</p>";
            }
        } else {
            echo "<p class='errorMsg'>Error en la preparación de la consulta: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>


</body>

</html>