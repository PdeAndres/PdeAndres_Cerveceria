<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.html");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagado</title>
</head>

<body>

    <?php
    // Se elimina el carrito de la sesión.
    unset($_SESSION["carrito"]);
    ?>
    <script>
        /* Se redirige a home */
        alert("Pago realizado con éxito");
        window.location.href = "home.php";
    </script>


</body>

</html>