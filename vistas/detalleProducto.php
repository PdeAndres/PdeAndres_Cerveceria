<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.html");
}
include("../includes/conexionBbdd.php");
include("../includes/funcionesAuxiliares.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    // Incluye el header en función del perfil del usuario
    if ($_SESSION["usuario"]["perfil"] == "admin") {
        include("../includes/headerAdmin.html");
    } else {
        include("../includes/headerUser.html");
    }
    ?>
    <main>

        <h1>Detalles</h1>

        <?php


        // Si se ha pasado un id por GET, se muestra el detalle del producto
        if (!$_GET["id"]) {
            header("Location: catalogo.php");
        } else {

            $id_producto = $_GET["id"];

            if ($_SESSION["usuario"]["perfil"] == "admin") {
                echo "<a href='modificarCerveza.php?id=$id_producto'>Modificar</a>";
                echo "<a href='borrarCerveza.php?id=$id_producto'>Eliminar</a>";
            }
            echo "<a href='catalogo.php'>Volver al catálogo</a>";

            // Prepara la consulta
            $sql = "SELECT * FROM producto WHERE id_producto = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {

                // Prepara los parámetros de la consulta y la ejecuta
                mysqli_stmt_bind_param($stmt, "i", $id_producto);
                mysqli_stmt_execute($stmt);

                // Obtiene el resultado de la consulta
                $result = mysqli_stmt_get_result($stmt);
                $producto = mysqli_fetch_array($result);

                // Si la consulta tiene éxito, muestra los datos del producto
                if ($producto) {


                    echo "<h2>" . $producto["denominacion"] . "</h2>";
                    echo "<p>Marca: " . $producto["marca"] . "</p>";
                    echo "<p>Tipo: " . $producto["tipo"] . "</p>";
                    echo "<p>Formato: " . $producto["formato"] . "</p>";
                    echo "<p>Cantidad: " . $producto["cantidad"] . "</p>";
                    echo "<p>Alergénos: " . $producto["alergenos"] . "</p>";
                    echo "<p>Fecha Consumo: " . $producto["fecha_consumo"] . "</p>";
                    echo "<p>Precio: " . $producto["precio"] . "€</p>";
                    echo "<p>Observaciones: " . $producto["observaciones"] . "</p>";
                    echo "<img src='" . $producto["imagen"] . "' alt='Foto del producto' width='200'>";
                } else {
                    echo "<p> No se ha encontrado el producto <p>";
                }
            } else {
                echo "<p class='errorMsg'>Error en la preparación de la consulta: " . mysqli_error($conn) . "</p>";

                // Cierra la consulta y la conexión a la BBDD
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            }



        }
        ?>
    </main>

    <?php include("../includes/footer.html") ?>

</body>

</html>