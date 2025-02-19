<!-- Definición de funciones auxiliares que se implementarán en distintas partes del código -->
<?php


// Crea la sesion del carrito si no existe.
if ($_SESSION["usuario"]["perfil"] == "user" && !isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}


// Funcion para guardar una imagen en el servidor 
function guardarImagen($destino, $imagen)
{
    // Verificamos si se ha recibido una imagen.
    if (empty($imagen["name"])) {
        echo "<p class='errorMsg'>No se recibió ninguna imagen.</p>";
        return false;
    }

    // Verificamos si hubo un error al subir la imagen
    if ($imagen['error'] !== 0) {
        echo "<p class='errorMsg'>Error en el archivo: Código de error " . $imagen['error'] . "</p>";
        return false;
    }

    // Extraemos los datos de la imagen
    $img_tmp_name = $imagen['tmp_name']; // Nombre temporal del archivo
    $img_file = $imagen['name']; // Nombre del archivo
    $img_type = $imagen['type']; // Tipo de archivo

    // Validación del formato de la imágen
    $formatos = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];
    if (!in_array($img_type, $formatos)) {
        echo "<p class='errorMsg'>Formato de archivo no permitido ($img_type).</p>";
        return false;
    }

    // Verificamos si el directorio de destino existe, si no, lo creamos con permisos de lectura, escritura y ejecución.
    if (!file_exists($destino)) {
        if (!mkdir($destino, 0777, true)) {
            echo "<p class='errorMsg'>No se pudo crear el directorio de destino.</p>";
            return false;
        }
    }

    // Movemos la imagen a la carpeta de destino
    $ruta_destino = $destino . '/' . $img_file;
    if (move_uploaded_file($img_tmp_name, $ruta_destino)) {
        echo "<p>Imagen guardada correctamente en $ruta_destino.</p>";
        return $ruta_destino;
    } else {
        echo "<p class='errorMsg'>No se pudo mover la imagen al destino.</p>";
        return false;
    }
}

// Funcion para guardar un producto en el carrito
function guardarProductoCarrito()
{
    // Recogemos el id del producto que se quiere agregar al carrito
    $id_producto = $_POST['id_producto'];

    // Verificar si el producto ya está en el carrito y si está, incrementar la cantidad
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id_producto'] == $id_producto) {
            $encontrado = true;
            $producto['total']++;
            break;
        }
    }

    // Si no está en el carrito, lo agregamos con cantidad 1
    if (!$encontrado) {
        $_SESSION["carrito"][] = array("id_producto" => $id_producto, "total" => 1);
    }

    header("Location: catalogo.php");
    exit();
}
;

?>