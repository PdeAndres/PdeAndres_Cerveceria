<!-- Destruye la sesion y redirige a index -->
<?php
session_start();
session_destroy();
header("Location: ../index.html");
?>