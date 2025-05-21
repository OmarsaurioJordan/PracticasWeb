<?php
    require "avatar.php";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>User Exam</title>
    </head>
    <body>
        <h1>Crear Usuario</h1>

        <button onClick="location.href='index.php'">Volver</button>
        
        <form class="cajon" action="logic.php" method="post">
            <input type='hidden' name='accion' value='C'>
            <select class='avatar' name="avatar">
                <?php
                    for ($i = 0; $i < count($avatar); $i++) {
                        echo "<option class='avatar' value=$i>".
                            getAvatar($i). "</option>";
                    }
                ?>
            </select>
            <input type="text" name="nombre" maxlength="255"
                placeholder="Nombre" required>
            <input type="mail" name="correo" maxlength="255"
                placeholder="Correo" required>
            <select name="genero">
                <?php
                    for ($i = 0; $i < count($generos); $i++) {
                        echo "<option value=$i>".
                            getGenero($i). "</option>";
                    }
                ?>
            </select>
            <input type="url" name="link" maxlength="255"
                placeholder="Link (opcional)">
            <button type="submit">Crear</button>
        </form>
    </body>
</html>
