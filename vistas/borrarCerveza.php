<?php
session_start();
include("../includes/conexionBbdd.php");
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.html");
}

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
    if (!$_GET["id"]) {
        header("Location: catalogo.php");
    } else {
        $id_producto = $_GET['id'];
        $sql = "DELETE FROM producto WHERE id_producto = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            echo "<p class='errorMsg'>Error en la preparación de la consulta: " . mysqli_error($conn) . "</p>";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $id_producto);

            if (mysqli_stmt_execute($stmt)) {

                header('Location: catalogo.php'); // Redirigir al catálogo después de eliminar
            } else {
                echo "<p class='errorMsg'>Error al eliminar el producto: " . mysqli_stmt_error($stmt) . "</p>";
            }
        }
    }
    ?>


</body>

</html>