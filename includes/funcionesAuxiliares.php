<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Crea la sesion del carrito si no existe. Esto ocurre en todos los archivos que incluyen este archivo.
if ($_SESSION["usuario"]["perfil"] == "user" && !isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}


// Funcion para guardar una imagen en el servidor 
function guardarImagen($destino, $imagen)
{
    // Verificamos si se ha recibido una imagen
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
    $img_tmp_name = $imagen['tmp_name'];
    $img_file = $imagen['name'];
    $img_type = $imagen['type'];

    // Validar tipo de archivo
    $formatos = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];
    if (!in_array($img_type, $formatos)) {
        echo "<p class='errorMsg'>Formato de archivo no permitido ($img_type).</p>";
        return false;
    }

    // Aseguramos que el directorio de destino exista, si no, lo creamos
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
        return $ruta_destino; // Retorna la ruta de la imagen
    } else {
        echo "<p class='errorMsg'>No se pudo mover la imagen al destino.</p>";
        return false;
    }
}

// Funcion para guardar un producto en el carrito
function guardarProductoCarrito()
{
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