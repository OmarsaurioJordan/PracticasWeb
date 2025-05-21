<?php
include "Global.php";
include "DB.php";

$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$genero = isset($_POST['genero']) ? $_POST['genero'] : "";
$edad = isset($_POST['edad']) ? $_POST['edad'] : "";
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
$accion = isset($_POST['accion']) ? $_POST['accion'] : false;

$msj = "";
if ($password != "") {
    $res = doQuery("SELECT id FROM login WHERE email=? AND password=?",
        [$email, $password]);
    if (!$res[0]) {
        $msj = "error_db";
    }
    else if (count($res[1]) == 0) (
        $msj = "mal_password";
    )
    else {
        if ($accion) {
            $ress = doQuery("UPDATE ", []);
        }
        else {
            $ress = doQuery("INSERT ", []);
        }
    }
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
            <?php echo showMsj($msj); ?>
            <h1>Evalúame</h1>
            <div class="contenedor">
            <h2><?php echo $nombre; ?></h2>
            <label></label>
            <p><?php echo $descripcion; ?></p>
            </div>
        </main>
        <footer class="piesito">
            <hr>
            <p class="subtitulo"><?php echo $piesito; ?></p>
        </footer>
    </body>
</html>
