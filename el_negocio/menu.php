<?php
    include "tool_master.php";
    sacarlo();

    include "tool_db.php";
    $roles = getList("roles");
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php setHead() ?>
    </head>
    <body>
        <?php setSesion($roles) ?>

        <?php if ($_SESSION['rol'] == 1) { // Comprador ?>

        <?php } else if ($_SESSION['rol'] == 2) { // Vendedor ?>

        <?php } else { // Administrador ?>

        <?php } ?>
    </body>
    <script src="tool_master.js" defer></script>
</html>
