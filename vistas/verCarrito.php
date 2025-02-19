<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.html");
}
include("../includes/conexionBbdd.php");
include("../includes/funcionesAuxiliares.php");
$total = 0;
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
    include("../includes/headerUser.html");
    ?>
    <main>
        <h1>Carrito</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Denominacion</th>
                    <th>Marca</th>
                    <th>Tipo</th>
                    <th>Formato</th>
                    <th>Cantidad</th>
                    <th>Foto</th>
                    <th>En el carrito</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Si existe la sesión carrito y no está vacía.
                if (isset($_SESSION["carrito"])) {
                    if (!empty($_SESSION["carrito"])) {
                        // Recorremos el carrito.
                        foreach ($_SESSION["carrito"] as $elemento) {

                            // Por cada producto en el carrito, guardamos su id y buscamos el producto en la base de datos.
                            $id_producto = $elemento["id_producto"];
                            $sql = "SELECT * FROM producto WHERE id_producto = ?";
                            $stmt = mysqli_prepare($conn, $sql);

                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "i", $id_producto);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $producto = mysqli_fetch_array($result);

                                if ($producto) {

                                    // Calculamos el total del carrito
                                    $total += $producto["precio"] * $elemento["total"];

                                    // Mostramos los datos del producto
                                    echo "<tr>";
                                    echo "<td>" . $producto["denominacion"] . "</td>";
                                    echo "<td>" . $producto["marca"] . "</td>";
                                    echo "<td>" . $producto["tipo"] . "</td>";
                                    echo "<td>" . $producto["formato"] . "</td>";
                                    echo "<td>" . $producto["cantidad"] . "</td>";
                                    echo "<td><img src='" . $producto["imagen"] . "' width='100'></td>";
                                    echo "<td>" . $elemento["total"] . "</td>";

                                    // Si el usuario es admin, puede modificar o eliminar productos del carrito.
                                    if ($_SESSION["usuario"]["perfil"] == "admin") {
                                        echo "<td><a href='modificarProducto.php?id=$id_producto'>Modificar</a> | <a href='eliminarProducto.php?id=$id_producto'>Eliminar</a></td>";
                                    } else {
                                        // Si el usuario es user, puede ver el detalle del producto.
                                        echo "<td>";
                                        echo "<a href='detalleProducto.php?id=$id_producto'>Ver detalle</a>";
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                        }
                    } else {
                        echo "<tr><td colspan='8'>No hay productos en el carrito</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <?php echo "<h2>TOTAL: " . $total . "€</h2>" ?>
        <a class="pagarBtn" href='procesarPago.php'>Pagar</a>
    </main>
    <?php include("../includes/footer.html") ?>

</body>

</html>