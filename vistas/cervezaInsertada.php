<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.html");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Inserción de Cerveza</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include("../includes/headerAdmin.html") ?>
    <main>


        <h1>Resultado de Inserción de Cerveza</h1>
        <?php
        // Si existe la variable de sesión producto, mostramos los datos de la cerveza que se han guardado en ella
        if ($_SESSION["producto"]) {

            echo "<main>";
            echo "<a href='insertarCerveza.php'>Insertar otra cerveza</a>";
            echo "<h2>Cerveza introducida con éxito</h2>";
            echo "<p>Denominación:" . $_SESSION['producto']['denominacion'] . "</p>";
            echo "<p>Tipo:" . $_SESSION["producto"]["tipo"] . "</p>";
            echo "<p>Formato:" . $_SESSION["producto"]["formato"] . "</p>";
            echo "<p>Cantidad:" . $_SESSION["producto"]["cantidad"] . "</p>";
            echo "<p>Marca: " . $_SESSION["producto"]["marca"] . "</p>";
            echo "<p>Fecha de consumo preferente: " . $_SESSION["producto"]["fecha_consumo"] . "</p>";
            echo "<p>Precio: " . $_SESSION["producto"]["precio"] . "</p>";
            echo "<p>Alergenos: " . $_SESSION["producto"]["alergenos"] . "</p>";
            echo "<p>Observaciones: " . $_SESSION["producto"]["observaciones"] . "</p>";
            echo "<img src='" . $_SESSION["producto"]["imagen"] . "' alt='Imagen de la cerveza' style='max-width: 300px; max-height: 300px;'>";
            echo "</main>";
        } else {
            echo "<p>No se ha enviado ningún formulario.</p>";
            echo "<a href='insertarCerveza.php'>Volver</a>";
        }
        ?>
    </main>
    <?php include("../includes/footer.html") ?>

</body>

</html>