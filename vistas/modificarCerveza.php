<?php

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.html");
}

if ($_SESSION["usuario"]["perfil"] != "admin") {
    header("Location: home.php");
}

include("../includes/funcionesAuxiliares.php");
include("../includes/conexionBbdd.php");

$denominacionErr = $tipoErr = $alergenosErr = $fechaConsumoErr = $PrecioErr = $formError = false;

$denominacionErrMsg = $tipoErrMsg = $alergenosErrMsg = $fechaConsumoErrMsg = $PrecioErrMsg = '';

// Validación de los campos.
if (isset($_POST['botonEnviar'])) {
    if (empty(trim($_POST["denominacion"]))) {
        $denominacionErr = true;
        $formError = true;
        $denominacionErrMsg = "<p class='errorMsg'>¡Se requiere el nombre de la Cerveza!</p>";
    }

    if (!isset($_POST["tipo"])) {
        $tipoErr = true;
        $formError = true;
        $tipoErrMsg = "<p class='errorMsg'>¡Has de elegir un tipo de cerveza!</p>";
    }

    if (!isset($_POST["alergenos"])) {
        $alergenosErr = true;
        $formError = true;
        $alergenosErrMsg = "<p class='errorMsg'>¡Has de elegir alérgenos!</p>";
    }

    if (empty(trim($_POST["fecha_consumo"]))) {
        $fechaConsumoErr = true;
        $formError = true;
        $fechaConsumoErrMsg = "<p class='errorMsg'>¡Has de tener una fecha de consumo máxima!</p>";
    }

    if (!is_numeric($_POST['precio']) || $_POST['precio'] <= 0) {
        $PrecioErr = true;
        $formError = true;
        $PrecioErrMsg = "<p class='errorMsg'>¡El precio debe ser un valor numérico!</p>";
    }

    // Si no hay errores se procesa la imagen y se insertan los datos en la BBDD.
    if (!$formError) {
        $destino_imagen = "../img/uploads";
        $isImagenSubida = guardarImagen($destino_imagen, $_FILES["imagen"]);

        // Si la imagen se subió correctamente, obtenemos la ruta
        if ($isImagenSubida) {
            $ruta_imagen = "../img/uploads/" . $_FILES["imagen"]["name"];
        } else {
            // Si la imagen no se sube, asignamos una imagen por defecto
            $ruta_imagen = "../img/no-image.png";
        }

        if ($isImagenSubida) {

            // Actualizar en la BBDD
            $sql = "UPDATE producto SET 
        denominacion = ?, 
        marca = ?, 
        tipo = ?, 
        formato = ?, 
        cantidad = ?, 
        alergenos = ?, 
        fecha_consumo = ?, 
        imagen = ?, 
        precio = ?, 
        observaciones = ? 
        WHERE id_producto = ?";

            $alergias = mysqli_real_escape_string($conn, implode(",", $_POST['alergenos']));
            $id_producto = $_POST['id_producto'];
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                // Asignar valores a los parámetros de la consulta
                mysqli_stmt_bind_param(
                    $stmt,
                    "ssssssssdsd",
                    $_POST['denominacion'],
                    $_POST['marca'],
                    $_POST['tipo'],
                    $_POST['formato'],
                    $_POST['cantidad'],
                    $alergias,
                    $_POST['fecha_consumo'],
                    $ruta_imagen,
                    $_POST['precio'],
                    $_POST['observaciones'],
                    $id_producto
                );
                if (mysqli_stmt_execute($stmt)) {
                    // Cierra la consulta y la conexión a la BBDD
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);

                    header("Location: detalleProducto.php?id=$id_producto");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "<p class='errorMsg'>Error en la preparación de la consulta: " . mysqli_error($conn) . "</p>";
            }
        }
    }
    // Cierra la consulta y la conexión a la BBDD
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cerveza</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <?php include("../includes/headerAdmin.html") ?>
    <main>

        <h1>MODIFICAR CERVEZA</h1>

        <?php if (isset($_GET["id"])) {

            $sql = "SELECT * FROM producto WHERE id_producto =" . $_GET["id"];
            $result = mysqli_query($conn, $sql);
            $producto = mysqli_fetch_array($result);
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="par">
                    <label>Denominación Cerveza:</label>
                    <input type="text" name="denominacion" value="<?php echo $producto["denominacion"]; ?>" />
                </div>
                <?php if ($denominacionErr) {
                    echo $denominacionErrMsg;
                } ?>

                <div class="par">
                    <label>Marca:</label>
                    <select name="marca">
                        <option <?php if ($producto["marca"] == "Heineken")
                            echo "selected"; ?> value="Heineken">Heineken
                        </option>
                        <option <?php if ($producto["marca"] == "Mahou")
                            echo "selected"; ?> value="Mahou">Mahou</option>
                        <option <?php if ($producto["marca"] == "DAM")
                            echo "selected"; ?> value="DAM">DAM</option>
                        <option <?php if ($producto["marca"] == "Estrella")
                            echo "selected"; ?> value="Estrella">Estrella
                            Galicia
                        </option>
                        <option <?php if ($producto["marca"] == "Alhambra")
                            echo "selected"; ?> value="Alhambra">Alhambra
                        </option>
                        <option <?php if ($producto["marca"] == "Cruzcampo")
                            echo "selected"; ?> value="Cruzcampo">Cruzcampo
                        </option>
                        <option <?php if ($producto["marca"] == "Artesana")
                            echo "selected"; ?> value="Artesana">Artesana
                        </option>
                    </select>
                </div>

                <div class="par">
                    <label>Tipo de Cerveza:</label>
                    <div class="checks">
                        <input <?php if ($producto["tipo"] == "lager")
                            echo "checked"; ?> type="radio" name="tipo"
                            value="lager" /> LAGER
                        <input <?php if ($producto["tipo"] == "pale")
                            echo "checked"; ?> type="radio" name="tipo"
                            value="pale" />
                        PALE ALE
                        <input <?php if ($producto["tipo"] == "negra")
                            echo "checked"; ?> type="radio" name="tipo"
                            value="negra" /> CERVEZA NEGRA
                        <input <?php if ($producto["tipo"] == "abadia")
                            echo "checked"; ?> type="radio" name="tipo"
                            value="abadia" /> ABADIA
                        <input <?php if ($producto["tipo"] == "rubia")
                            echo "checked"; ?> type="radio" name="tipo"
                            value="rubia" /> RUBIA
                    </div>
                </div>
                <?php if ($tipoErr) {
                    echo $tipoErrMsg;
                } ?>
                <div class="par"><label>Formato:</label>
                    <select name="formato">
                        <option <?php if ($producto["formato"] == "lata")
                            echo "selected"; ?> value="lata">Lata</option>
                        <option <?php if ($producto["formato"] == "botella")
                            echo "selected"; ?> value="botella">Botella
                        </option>
                        <option <?php if ($producto["formato"] == "pack")
                            echo "selected"; ?> value="pack">Pack</option>
                    </select>
                </div>

                <div class="par">
                    <label>Tamaño:</label>
                    <select name="cantidad">
                        <option <?php if ($producto["cantidad"] == "botellin")
                            echo "selected"; ?> value="botellin">Botellín
                        </option>
                        <option <?php if ($producto["cantidad"] == "tercio")
                            echo "selected"; ?> value="tercio">Tercio
                        </option>
                        <option <?php if ($producto["cantidad"] == "media")
                            echo "selected"; ?> value="media">Media</option>
                        <option <?php if ($producto["cantidad"] == "litro")
                            echo "selected"; ?> value="litro">Litrona</option>
                        <option <?php if ($producto["cantidad"] == "pack")
                            echo "selected"; ?> value="pack">Pack</option>
                    </select>
                </div>

                <div class="par">
                    <label>Alérgenos:</label>
                    <div class="checks">
                        <label for="">Gluten</label>
                        <input <?php if (in_array("Gluten", explode(",", $producto["alergenos"])))
                            echo "checked"; ?>
                            type="checkbox" name="alergenos[]" value="Gluten" />
                        <label for="">Huevo</label>
                        <input <?php if (in_array("Huevo", explode(",", $producto["alergenos"])))
                            echo "checked"; ?>
                            type="checkbox" name="alergenos[]" value="Huevo" />
                        <label for="">Cacahuete</label>
                        <input <?php if (in_array("Cacahuete", explode(",", $producto["alergenos"])))
                            echo "checked"; ?>
                            type="checkbox" name="alergenos[]" value="Cacahuete" />
                        <label for="">Soja</label>
                        <input <?php if (in_array("Soja", explode(",", $producto["alergenos"])))
                            echo "checked"; ?>
                            type="checkbox" name="alergenos[]" value="Soja" />
                        <label for="">Lácteo</label>
                        <input <?php if (in_array("Lacteo", explode(",", $producto["alergenos"])))
                            echo "checked"; ?>
                            type="checkbox" name="alergenos[]" value="Lacteo" />
                        <label for="">Sulfitos</label>
                        <input <?php if (in_array("Sulfitos", explode(",", $producto["alergenos"])))
                            echo "checked"; ?>
                            type="checkbox" name="alergenos[]" value="Sulfitos" />
                        <label for="">Sin alérgenos</label>
                        <input <?php if (in_array("SinAlergenos", explode(",", $producto["alergenos"])))
                            echo "checked"; ?>
                            type="checkbox" name="alergenos[]" value="SinAlergenos" />
                    </div>
                </div>
                <?php if ($alergenosErr) {
                    echo $alergenosErrMsg;
                } ?>
                <div class="par">
                    <label>Fecha Consumo:</label>
                    <input value="<?php echo $producto["fecha_consumo"]; ?>" type="date" name="fecha_consumo" />
                </div>
                <?php if ($fechaConsumoErr) {
                    echo $fechaConsumoErrMsg;
                } ?>
                <div class="par">
                    <label>Foto:</label>
                    <?php if (!empty($producto["imagen"])): ?>
                        <img src="<?php echo htmlspecialchars($producto["imagen"]); ?>" alt="Imagen del producto" width="100">
                    <?php endif; ?>
                    <input type="file" name="imagen" accept="image/*" />
                </div>

                <div class="par">
                    <label>Precio (€):</label>
                    <input value="<?php echo $producto["precio"]; ?>" type="number" id="precio" name="precio" />
                </div>
                <?php if ($PrecioErr) {
                    echo $PrecioErrMsg;
                } ?>
                <div class="par">
                    <label>Observaciones:</label>
                    <textarea name="observaciones"><?php echo $producto["observaciones"]; ?></textarea>
                </div>

                <input type='hidden' name='id_producto' value="<?php echo $producto["id_producto"] ?>" />
                <input type="submit" value="Modificar Cerveza" name="botonEnviar" />
            </form>

        <?php } ?>

    </main>

    <?php include("../includes/footer.html") ?>

</body>

</html>