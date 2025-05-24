<?php
    include "tool_master.php";
    meterlo();

    include "tool_db.php";
    $roles = getList("roles");
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>El Negocio</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="cajon grangap">
            <h1>El Negocio</h1>
            
            <form class="cajon claro" action="logic_login.php" method="post">
                <h2>Login</h2>
                <input type="mail" name="mail" placeholder="Mail" required>
                <input type="password" name="clave" placeholder="Clave" required>
                <button type="submit">Entrar</button>
            </form>

            <form class="cajon claro" action="logic_crear.php" method="post">
                <h2>Registro</h2>
                <input type="mail" name="mail" placeholder="Mail" required>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="password" name="clave" placeholder="Clave" required>
                <select name="rol">
                    <?php
                        for ($i = 0; $i < count($roles); $i++) {
                            echo "<option value=". ($i + 1) .">". $roles[$i]. "</option>";
                        }
                    ?>
                </select>
                <button type="submit">Crear</button>
            </form>
        </div>
    </body>
    <script src="tool_master.js" defer></script>
</html>
