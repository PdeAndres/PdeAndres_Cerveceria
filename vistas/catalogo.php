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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <?php
    if ($_SESSION["usuario"]["perfil"] == "admin") {
        include("../includes/headerAdmin.html");
    } else {
        include("../includes/headerUser.html");
    }
    ?>
    <main>
        <form action="" method="POST">
            <label for="campo">Buscar por:</label>
            <select name="campo" id="campo">
                <option value="denominacion">Denominación</option>
                <option value="marca">Marca</option>
                <option value="tipo">Tipo</option>
                <option value="formato">Formato</option>
                <option value="cantidad">Cantidad</option>
            </select>
            <input type="text" name="valor">
            <input type="submit" name="buscar" value="Buscar">
            <input type="submit" name="verTodo" value="Ver todo">

        </form>
        <h1>Catálogo</h1>

        <table border="1">
            <thead>
                <tr>
                    <th>Denominacion</th>
                    <th>Marca</th>
                    <th>Tipo</th>
                    <th>Formato</th>
                    <th>Cantidad</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (isset($_POST['agregar'])) {
                    guardarProductoCarrito();
                }

                if (isset($_POST['buscar']) && !empty($_POST['valor'])) {
                    $campo = $_POST['campo'];
                    $valor = "%" . $_POST['valor'] . "%";
                    $sql = "SELECT * FROM producto WHERE $campo LIKE ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $valor);
                    mysqli_stmt_execute($stmt);
                    $productos = mysqli_stmt_get_result($stmt);
                } else {
                    $sql = "SELECT * FROM producto";
                    $productos = mysqli_query($conn, $sql);
                }

                if (mysqli_num_rows($productos) > 0) {
                    while ($producto = mysqli_fetch_assoc($productos)) {

                        $id_producto = $producto["id_producto"];
                        echo "<tr>";
                        echo "<td>" . $producto["denominacion"] . "</td>";
                        echo "<td>" . $producto["marca"] . "</td>";
                        echo "<td>" . $producto["tipo"] . "</td>";
                        echo "<td>" . $producto["formato"] . "</td>";
                        echo "<td>" . $producto["cantidad"] . "</td>";
                        echo "<td><img src='" . $producto["imagen"] . "' width='100'></td>";

                        if ($_SESSION["usuario"]["perfil"] == "admin") {
                            echo "<td><a href='modificarCerveza.php?id=$id_producto'>Modificar</a> | <a href='detalleProducto.php?id=$id_producto'>Eliminar</a></td>";
                        } else {
                            echo "<td>";
                            echo "<a  href='detalleProducto.php?id=$id_producto'>Ver detalle</a>";
                            echo "<form class='agregarCarrito' action='' method='POST'>";
                            echo "<input type='hidden' name='id_producto' value='$id_producto'>";
                            echo "<input class='submitBtn' type='submit' name='agregar' value='Añadir al carrito'>";
                            echo "</form>";
                            echo "</td>";
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay productos en el Catálogo</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <?php include("../includes/footer.html") ?>
</body>

</html>