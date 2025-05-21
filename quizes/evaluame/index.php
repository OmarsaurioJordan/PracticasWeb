<?php
include "Global.php";

$msj = isset($_POST['msj']) ? $_POST['msj'] : "";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php encabezado(); ?>
    </head>
    <body>
        <main class="superior">
            <h1>Evalúame</h1>
            <p class="subtitulo">Haga exámenes de conocimiento variopintos</p>
            <form class="contenedor" action="PreLogin.php" method="post">
                <h2>Ingrese para Hacer Evaluación</h2>
                <label for="email">correo electrónico</label>
                <input type="email" id="email" name="email" required>
                <div>
                    <input type="checkbox" id="recuperar" name="recuperar">
                    <label for="recuperar">actualizar la contraseña</label>
                </div>
                <button class="boton" type="submit">Entrar</button>
            </form>
            <div class="contenedor">
                <h2>Ver Resultados Globales</h2>
                <a class="boton" href="Resultados.php">Resultados</a>
            </div>
        </main>
        <?php notaalpie(); ?>
    </body>

    <script>
        let msj = "<?php echo showMsj($msj)[1]; ?>";
        if (msj != "") {
            alert(msj);
        }
    </script>
</html>
