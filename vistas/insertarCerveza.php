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
                // Insertar en la BBDD
                $sql = "INSERT INTO producto 
                (denominacion, marca, tipo, formato, cantidad, alergenos, fecha_consumo, imagen, precio, observaciones) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $alergias = mysqli_real_escape_string($conn, implode(",", $_POST['alergenos']));

                $stmt = mysqli_prepare($conn, $sql);


                mysqli_stmt_bind_param(
                    $stmt,
                    "ssssssssds",
                    $_POST['denominacion'],
                    $_POST['marca'],
                    $_POST['tipo'],
                    $_POST['formato'],
                    $_POST['cantidad'],
                    $alergias,
                    $_POST['fecha_consumo'],
                    $ruta_imagen,
                    $_POST['precio'],
                    $_POST['observaciones']
                );

                if (mysqli_stmt_execute($stmt)) {
                    // Guardar los datos en la sesión para mostrarlos en la página cervezaInsertada.php
                    $_SESSION["producto"] = array(
                        "denominacion" => $_POST['denominacion'],
                        "tipo" => $_POST['tipo'],
                        "formato" => $_POST['formato'],
                        "cantidad" => $_POST['cantidad'],
                        "marca" => $_POST['marca'],
                        "fecha_consumo" => $_POST['fecha_consumo'],
                        "precio" => $_POST['precio'],
                        "alergenos" => $alergias,
                        "observaciones" => $_POST['observaciones'],
                        "imagen" => $ruta_imagen
                    );


                    header("Location: cervezaInsertada.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <?php include("../includes/headerAdmin.html") ?>
    <main>


        <h1>INSERTAR CERVEZA</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="par">
                <label>Denominación Cerveza:</label>
                <input type="text" name="denominacion" />
            </div>
            <?php if ($denominacionErr) {
                echo $denominacionErrMsg;
            } ?>

            <div class="par">
                <label>Marca:</label>
                <select name="marca">
                    <option value="Heineken">Heineken</option>
                    <option value="Mahou">Mahou</option>
                    <option value="DAM">DAM</option>
                    <option value="Estrella">Estrella Galicia</option>
                    <option value="Alhambra">Alhambra</option>
                    <option value="Cruzcampo">Cruzcampo</option>
                    <option value="Artesana">Artesana</option>
                </select>
            </div>

            <div class="par">
                <label class="tipoCerveza">Tipo de Cerveza:</label>
                <div class="checks">
                    <label for="">Lager</label>
                    <input type="radio" name="tipo" value="lager" />
                    <label for="">Pale Ale</label>
                    <input type="radio" name="tipo" value="pale" />
                    <label for="">Negra</label>
                    <input type="radio" name="tipo" value="negra" />
                    <label for="">Abadia</label>
                    <input type="radio" name="tipo" value="abadia" />
                    <label for="">Rubia</label>
                    <input type="radio" name="tipo" value="rubia" />
                </div>
            </div>
            <?php if ($tipoErr) {
                echo $tipoErrMsg;
            } ?>
            <div class="par"><label>Formato:</label>
                <select name="formato">
                    <option value="lata">Lata</option>
                    <option value="botella">Botella</option>
                    <option value="pack">Pack</option>
                </select>
            </div>

            <div class="par">
                <label>Tamaño:</label>
                <select name="cantidad">
                    <option value="botellin">Botellín</option>
                    <option value="tercio">Tercio</option>
                    <option value="media">Media</option>
                    <option value="litro">Litrona</option>
                    <option value="pack">Pack</option>
                </select>
            </div>

            <div class="par">
                <label>Alérgenos:</label>
                <div class="checks">
                    <label for="">Gluten</label>
                    <input type="checkbox" name="alergenos[]" value="Gluten" />
                    <label for="">Huevo</label>
                    <input type="checkbox" name="alergenos[]" value="Huevo" />
                    <label for="">Cacahuete</label>
                    <input type="checkbox" name="alergenos[]" value="Cacahuete" />
                    <label for="">Soja</label>
                    <input type="checkbox" name="alergenos[]" value="Soja" />
                    <label for=""> Lácteo</label>
                    <input type="checkbox" name="alergenos[]" value="Lacteo" />
                    <label for="">Sulfitos</label>
                    <input type="checkbox" name="alergenos[]" value="Sulfitos" />
                    <label for="">Sin alérgenos</label>
                    <input type="checkbox" name="alergenos[]" value="SinAlergenos" />
                </div>
            </div>
            <?php if ($alergenosErr) {
                echo $alergenosErrMsg;
            } ?>
            <div class="par">
                <label>Fecha Consumo:</label>
                <input type="date" name="fecha_consumo" />
            </div>
            <?php if ($fechaConsumoErr) {
                echo $fechaConsumoErrMsg;
            } ?>
            <div class="par">
                <label>Foto:</label>
                <input type="file" name="imagen" accept="image/*" />
            </div>

            <div class="par">
                <label>Precio (€):</label>
                <input type="number" id="precio" name="precio" step="0.01" />
            </div>
            <?php if ($PrecioErr) {
                echo $PrecioErrMsg;
            } ?>
            <div class="par">
                <label>Observaciones:</label>
                <textarea name="observaciones"></textarea>
            </div>

            <input type="submit" value="Insertar Cerveza" name="botonEnviar" />
        </form>
    </main>
    <?php include("../includes/footer.html") ?>

</body>

</html>