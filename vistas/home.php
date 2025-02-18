<?php
session_start();
if (!isset($_SESSION["usuario"])) {
  header("Location: ../index.html");
}
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
  if ($_SESSION["usuario"]["perfil"] == "admin") {
    include("../includes/headerAdmin.html");
  } else {
    include("../includes/headerUser.html");
  }
  ?>
  <main>


    <h1>Home</h1>


    <h2>Bienvenido <?php echo $_SESSION["usuario"]["nombre"] ?></h2>

    <h2>Has entrado como <?php echo $_SESSION["usuario"]["perfil"] ?> </h2>

  </main>
  <?php include("../includes/footer.html") ?>

</body>

</html>