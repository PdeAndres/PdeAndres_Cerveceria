<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
</head>

<body>
  <?php

  if ($_SESSION["usuario"]["PERFIL"] == "administrador") {
    include("../includes/headerAdmin.html");
  } else {
    include("../includes/headerUser.html");
  }
  ?>
  <h1>Home</h1>
</body>

</html>