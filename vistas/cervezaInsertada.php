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


        if ($_SESSION["producto"]) {

            // Imprimir los datos de la cerveza
        
            $denominacion = $_SESSION["producto"]["denominacion"];
            $tipo = $_SESSION["producto"]["tipo"];
            $formato = $_SESSION["producto"]["formato"];
            $cantidad = $_SESSION["producto"]["cantidad"];
            $marca = $_SESSION["producto"]["marca"];
            $fecha_consumo = $_SESSION["producto"]["fecha_consumo"];
            $precio = $_SESSION["producto"]["precio"];
            $alergenos = $_SESSION["producto"]["alergenos"];
            $observaciones = $_SESSION["producto"]["observaciones"];
            $imagen = $_SESSION["producto"]["imagen"];
            print ("<main>");
            print ("<a href='insertarCerveza.php'>Insertar otra cerveza</a>");

            print ("<h2>Cerveza introducida con éxito</h2>");
            print ("<p>Denominación: $denominacion</p>");
            print ("<p>Tipo: $tipo</p>");
            print ("<p>Formato: $formato</p>");
            print ("<p>Cantidad: $cantidad</p>");
            print ("<p>Marca: $marca</p>");
            print ("<p>Fecha de consumo preferente: $fecha_consumo</p>");
            print ("<p>Precio: $precio</p>");
            print ("<p>Alergenos: $alergenos</p>");
            print ("<p>Observaciones: $observaciones</p>");
            print ("<img src='$imagen' alt='Imagen de la cerveza' style='max-width: 300px; max-height: 300px;'>");
            print ("</main>");
        } else {
            echo "<p>No se ha enviado ningún formulario.</p>";
            echo "<a href='insertarCerveza.php'>Volver</a>";
        }
        ?>
    </main>
    <?php include("../includes/footer.html") ?>

</body>

</html>