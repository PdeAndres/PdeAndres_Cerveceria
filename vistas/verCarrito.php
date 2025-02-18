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
                if (isset($_SESSION["carrito"])) {

                    if (!empty($_SESSION["carrito"])) {
                        foreach ($_SESSION["carrito"] as $elemento) {

                            $id_producto = $elemento["id_producto"];
                            $sql = "SELECT * FROM producto WHERE id_producto=" . $id_producto;
                            $result = mysqli_query($conn, $sql);
                            $producto = mysqli_fetch_array($result);
                            $total += $producto["precio"] * $elemento["total"];

                            echo "<tr>";
                            echo "<td>" . $producto["denominacion"] . "</td>";
                            echo "<td>" . $producto["marca"] . "</td>";
                            echo "<td>" . $producto["tipo"] . "</td>";
                            echo "<td>" . $producto["formato"] . "</td>";
                            echo "<td>" . $producto["cantidad"] . "</td>";

                            // Mostramos la imagen del producto y si no tiene le asignamos una por defecto
                            if ($producto["imagen"] == "../img/uploads/") {
                                $producto["imagen"] = "../img/no-image.png";
                            }
                            echo "<td><img src='" . $producto["imagen"] . "' width='100'></td>";
                            echo "<td>" . $elemento["total"] . "</td>";

                            if ($_SESSION["usuario"]["perfil"] == "admin") {
                                echo "<td><a href='modificarProducto.php?id=$id_producto'>Modificar</a> | <a href='eliminarProducto.php?id=$id_producto'>Eliminar</a></td>";
                            } else {
                                echo "<td>";
                                echo "<a href='detalleProducto.php?id=$id_producto'>Ver detalle</a>";
                                echo "</td>";
                            }

                            echo "</tr>";
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