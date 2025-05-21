<?php
include "Global.php";
include "DB.php";

$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : "-1";
$optns = getTipos($tipo);

$nota = isset($_POST['nota']) ? $_POST['nota'] : "0";
$optnts = "<option value='0'>Oficial</option>".
    "<option value='1'>Victoria</option>".
    "<option value='2'>Máxima</option>";
for ($i = 0; $i < 3; $i++) {
    if ($nota == $i) {
        $optnts = str_replace("$i'>", "$i' selected>", $optnts);
    }
}

if ($tipo != "-1") {
    //
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Evalúame</title>
    </head>
    <body>
        <main class="superior">
            <h1>Resultados</h1>
            <form class="barra" action="Resultados.php" method="post">
                <a class="boton" href="index.php">Volver</a>
                <select name="tipo">
                    <?php echo $optns; ?>
                </select>
                <select name="nota">
                    <?php echo $optnts; ?>
                </select>
                <button class="boton" type="submit">Filtrar</button>
            </form>
            <table class="contenedor">
                <tr>
                    <th>Pos.</th>
                    <th>Nombre (Gen. Edad)</th>
                    <th>Nota2</th>
                </tr>
            </table>
        </main>
        <footer class="piesito">
            <hr>
            <p class="subtitulo"><?php echo $piesito; ?></p>
        </footer>
    </body>
</html>
