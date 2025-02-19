<!-- Login de usuario en la página -->
<?php
session_start();
include('../includes/conexionBbdd.php');

/* Recogida de datos del formulario y encriptación de contraseña */

$correo = $_POST["usuario"];

$password = $_POST["password"];

$md5_password = md5($password);



/* Preparar la consulta a BBDD para comprobar que existe el usuario y que los datos son correctos */

$query = "SELECT * FROM usuario WHERE correo = ? AND password = ?";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {

    /* Prepara los parámetros de la consulta y la ejecuta */
    mysqli_stmt_bind_param($stmt, "ss", $correo, $md5_password);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    /* Si ha encontrado resultados guarda al usuario encontrado en la sesión y redirige a la página home */
    if (mysqli_num_rows($resultado) == 1) {

        // Guarda el usuario en la sesión
        $_SESSION["usuario"] = mysqli_fetch_assoc($resultado);

        // Cierra la consulta y la conexión a la BBDD
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        header("Location: ../vistas/home.php"); // Redirige a la página home
        exit();
    } else {
        /* Si no ha encontrado usuarios, destrulle la sesión, cierra la consulta , la conexión. */
        session_destroy();

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo "No se ha encontrado ningun usuario";
        header("Location: ../index.html");
        exit();
    }
}
?>